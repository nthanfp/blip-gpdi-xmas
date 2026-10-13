<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seating_Model extends CI_Model
{
    private $_seat = 'act_seating_seat';
    private $_attendee = 'act_xmas_attendee';
    private $_registration = 'act_xmas_registration';

    public function search_registrations($q)
    {
        $q = trim((string) $q);
        if ($q === '') {
            return ['success' => true, 'message' => 'OK', 'data' => []];
        }

        $like = '%' . $q . '%';
        $rows = $this->db->query(
            "SELECT r.registrationid, r.ref_code, r.phone, r.floor, r.status,
                    f.name AS floor_name,
                    (SELECT COUNT(*) FROM {$this->_attendee} a
                      WHERE a.registrationid = r.registrationid AND a.status = 1) AS confirmed_count,
                    (SELECT COUNT(*) FROM {$this->_attendee} a
                      WHERE a.registrationid = r.registrationid AND a.status = 0) AS pending_count,
                    (SELECT COUNT(*) FROM {$this->_attendee} a
                      JOIN {$this->_seat} s ON s.attendeeid = a.attendeeid
                      WHERE a.registrationid = r.registrationid AND a.status = 1) AS seated_count
             FROM {$this->_registration} r
             LEFT JOIN set_xmas_floor f ON f.floor = r.floor
             WHERE r.status <> 2
               AND (
                    r.ref_code LIKE ?
                 OR r.phone LIKE ?
                 OR EXISTS (SELECT 1 FROM {$this->_attendee} a2
                            WHERE a2.registrationid = r.registrationid
                              AND a2.name LIKE ?)
               )
             ORDER BY (SELECT COUNT(*) FROM {$this->_attendee} a3
                       WHERE a3.registrationid = r.registrationid AND a3.status = 1) DESC,
                      r.created_date DESC
             LIMIT 12",
            [$like, $like, $like]
        )->result_array();

        return ['success' => true, 'message' => 'OK', 'data' => $rows];
    }

    public function registration_attendees($registrationid)
    {
        $registrationid = (int) $registrationid;
        if (!$registrationid) {
            return ['success' => false, 'message' => 'Registration ID is required'];
        }

        $reg = $this->db->query(
            "SELECT r.registrationid, r.ref_code, r.phone, r.floor, r.status,
                    f.name AS floor_name
             FROM {$this->_registration} r
             LEFT JOIN set_xmas_floor f ON f.floor = r.floor
             WHERE r.registrationid = ?",
            [$registrationid]
        )->row_array();

        if (!$reg) {
            return ['success' => false, 'message' => 'Registration not found'];
        }

        $attendees = $this->db->query(
            "SELECT a.attendeeid, a.name, a.status, s.seat_number
             FROM {$this->_attendee} a
             LEFT JOIN {$this->_seat} s ON s.attendeeid = a.attendeeid
             WHERE a.registrationid = ?
             ORDER BY a.is_primary DESC, a.attendeeid ASC",
            [$registrationid]
        )->result_array();

        $reg['attendees'] = $attendees;
        return ['success' => true, 'message' => 'OK', 'data' => $reg];
    }

    public function assign_seats($registrationid, $attendee_ids, $seat_numbers, $floor_id, $admin_id = null)
    {
        $registrationid = (int) $registrationid;
        $floor_id = (int) $floor_id;

        if (!$registrationid || !$floor_id) {
            return ['success' => false, 'message' => 'Registration and floor are required'];
        }

        $attendees = array_values(array_unique(array_filter(array_map('intval', (array) $attendee_ids))));
        $seats = array_values(array_unique(array_filter(array_map('intval', (array) $seat_numbers))));

        if (!$attendees || !$seats) {
            return ['success' => false, 'message' => 'Select attendees and seats'];
        }

        if (count($attendees) !== count($seats)) {
            return ['success' => false, 'message' => 'Attendee count (' . count($attendees) . ') must match seat count (' . count($seats) . ')'];
        }

        sort($seats);

        $reg = $this->db->get_where($this->_registration, ['registrationid' => $registrationid])->row_array();
        if (!$reg) {
            return ['success' => false, 'message' => 'Registration not found'];
        }
        if ((int) $reg['floor'] !== $floor_id) {
            return ['success' => false, 'message' => 'Floor mismatch with registration'];
        }

        $this->db->trans_begin();

        $seat_in = implode(',', array_fill(0, count($seats), '?'));
        $seat_rows = $this->db->query(
            "SELECT seat_number, attendeeid FROM {$this->_seat}
             WHERE floor_id = ? AND seat_number IN ({$seat_in})
             ORDER BY seat_number FOR UPDATE",
            array_merge([$floor_id], $seats)
        )->result_array();

        if (count($seat_rows) !== count($seats)) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Some seats do not exist on this floor'];
        }

        foreach ($seat_rows as $sr) {
            if ($sr['attendeeid'] !== null) {
                $this->db->trans_rollback();
                return ['success' => false, 'message' => 'Seat ' . $sr['seat_number'] . ' is already assigned'];
            }
        }

        $att_in = implode(',', array_fill(0, count($attendees), '?'));
        $att_rows = $this->db->query(
            "SELECT attendeeid FROM {$this->_attendee}
             WHERE attendeeid IN ({$att_in}) AND registrationid = ? AND status = 1
             FOR UPDATE",
            array_merge($attendees, [$registrationid])
        )->result_array();

        if (count($att_rows) !== count($attendees)) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Invalid attendees (must belong to this registration and be confirmed)'];
        }

        /* Pindah kursi: lepas dulu kursi lama attendee ini */
        $this->db->query(
            "UPDATE {$this->_seat}
             SET attendeeid = NULL, registrationid = NULL, assigned_by = NULL, assigned_date = NULL
             WHERE attendeeid IN ({$att_in})",
            $attendees
        );

        $now = date('Y-m-d H:i:s');
        foreach ($attendees as $idx => $aid) {
            $upd = $this->db->where('floor_id', $floor_id)
                ->where('seat_number', $seats[$idx])
                ->update($this->_seat, [
                    'attendeeid' => $aid,
                    'registrationid' => $registrationid,
                    'assigned_by' => $admin_id !== null ? (int) $admin_id : null,
                    'assigned_date' => $now,
                ]);
            if (!$upd) {
                $this->db->trans_rollback();
                return ['success' => false, 'message' => 'Failed to assign seat ' . $seats[$idx]];
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Failed to assign seats. Please try again.'];
        }

        $this->db->trans_commit();
        return [
            'success' => true,
            'message' => count($attendees) . ' seat(s) assigned',
            'data' => ['pairs' => array_combine($attendees, $seats)],
        ];
    }

    public function release_seats($floor_id, $seat_numbers, $registrationid = null)
    {
        $floor_id = (int) $floor_id;
        $seats = array_values(array_unique(array_filter(array_map('intval', (array) $seat_numbers))));

        if (!$floor_id || !$seats) {
            return ['success' => false, 'message' => 'Floor and seats are required'];
        }

        $this->db->where('floor_id', $floor_id);
        $this->db->where_in('seat_number', $seats);
        if ($registrationid !== null) {
            $this->db->where('registrationid', (int) $registrationid);
        }
        $this->db->where('attendeeid IS NOT NULL', null, false);
        $this->db->update($this->_seat, [
            'attendeeid' => null,
            'registrationid' => null,
            'assigned_by' => null,
            'assigned_date' => null,
        ]);
        $affected = $this->db->affected_rows();

        return [
            'success' => true,
            'message' => $affected . ' seat(s) released',
            'data' => ['released' => (int) $affected],
        ];
    }

    public function release_attendee_seats($attendee_ids)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $attendee_ids))));
        if (!$ids) {
            return ['success' => true, 'message' => 'OK', 'data' => ['released' => 0]];
        }

        $in = implode(',', array_fill(0, count($ids), '?'));
        $this->db->query(
            "UPDATE {$this->_seat}
             SET attendeeid = NULL, registrationid = NULL, assigned_by = NULL, assigned_date = NULL
             WHERE attendeeid IN ({$in})",
            $ids
        );

        return ['success' => true, 'message' => 'OK', 'data' => ['released' => (int) $this->db->affected_rows()]];
    }
}

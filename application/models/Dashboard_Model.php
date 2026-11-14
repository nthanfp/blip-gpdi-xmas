<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_Model extends CI_Model
{
    private $_registration = 'act_xmas_registration';
    private $_attendee = 'act_xmas_attendee';
    private $_booking = 'act_xmas_booking';
    private $_seat = 'act_seating_seat';

    public function data_summary()
    {
        $this->load->model('Registration_Model');
        $stats = $this->Registration_Model->data_stats();
        $floors = $stats['data']['floors'];
        $totals = $stats['data']['totals'];

        $people_active = 0;
        foreach ($floors as $f) {
            $people_active += (int) $f['registered'];
        }

        /* Booking & Invitation (status aktif saja) */
        $booking = null;
        if ($this->db->table_exists($this->_booking)) {
            $has_confirmed = $this->db->field_exists('confirmed_count', $this->_booking);
            $row = $this->db->query(
                'SELECT COUNT(*) AS bookings,
                        COALESCE(SUM(seats), 0) AS seats,
                        ' . ($has_confirmed ? 'COALESCE(SUM(confirmed_count), 0)' : '0') . ' AS confirmed
                 FROM ' . $this->_booking . '
                 WHERE status = 0'
            )->row();
            $booking = [
                'bookings' => (int) $row->bookings,
                'seats' => (int) $row->seats,
                'confirmed' => (int) $row->confirmed,
            ];
        }

        /* Occupancy per lantai dari peta kursi fisik */
        $seating = [];
        if ($this->db->table_exists($this->_seat)) {
            $has_booking_col = $this->db->field_exists('bookingid', $this->_seat);
            $rows = $this->db->query(
                'SELECT floor_id, COUNT(*) AS seats,
                        COALESCE(SUM(attendeeid IS NOT NULL), 0) AS assigned,
                        ' . ($has_booking_col ? 'COALESCE(SUM(bookingid IS NOT NULL), 0)' : '0') . ' AS reserved
                 FROM ' . $this->_seat . '
                 GROUP BY floor_id'
            )->result();
            foreach ($rows as $r) {
                $seating[(int) $r->floor_id] = [
                    'floor_id' => (int) $r->floor_id,
                    'seats' => (int) $r->seats,
                    'assigned' => (int) $r->assigned,
                    'reserved' => (int) $r->reserved,
                ];
            }
        }

        /* Pendaftaran harian 30 hari terakhir (dibulatkan ke hari oleh PHP) */
        $daily = [];
        $rows = $this->db->query(
            'SELECT DATE(created_date) AS d, COUNT(*) AS c
             FROM ' . $this->_registration . '
             WHERE status <> 2
               AND created_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
             GROUP BY d
             ORDER BY d'
        )->result();
        foreach ($rows as $r) {
            $daily[$r->d] = (int) $r->c;
        }

        /*10 pendaftar terbaru */
        $latest = $this->db->query(
            'SELECT r.registrationid, r.ref_code, r.floor, r.status, r.created_date,
                    (SELECT a.name FROM ' . $this->_attendee . ' a
                      WHERE a.registrationid = r.registrationid AND a.status <> 2
                      ORDER BY a.is_primary DESC, a.attendeeid ASC
                      LIMIT 1) AS name,
                    (SELECT COUNT(*) FROM ' . $this->_attendee . ' a
                      WHERE a.registrationid = r.registrationid AND a.status <> 2) AS people
             FROM ' . $this->_registration . ' r
             WHERE r.status <> 2
             ORDER BY r.created_date DESC, r.registrationid DESC
             LIMIT 10'
        )->result();

        $latest_out = [];
        foreach ($latest as $r) {
            $latest_out[] = [
                'ref_code' => $r->ref_code,
                'name' => $r->name !== null ? trim(preg_replace('/\s+/', ' ', $r->name)) : null,
                'people' => (int) $r->people,
                'floor' => (int) $r->floor,
                'status' => (int) $r->status,
                'created_date' => $r->created_date,
            ];
        }

        /* Jumlah grup duplikat (phone + nama sama, >=2 kode) */
        $dupes = 0;
        $rows = $this->db->query(
            'SELECT r.registrationid, r.phone, a.name
             FROM ' . $this->_registration . ' r
             JOIN ' . $this->_attendee . ' a ON a.registrationid = r.registrationid
             WHERE r.phone <> \'\' AND r.status <> 2 AND a.status <> 2'
        )->result();
        $groups = [];
        foreach ($rows as $r) {
            $norm = strtolower(trim(preg_replace('/\s+/', ' ', (string) $r->name)));
            if ($norm === '') {
                continue;
            }
            $key = $r->phone . '|' . $norm;
            $groups[$key][(int) $r->registrationid] = true;
        }
        foreach ($groups as $rids) {
            if (count($rids) >= 2) {
                $dupes++;
            }
        }

        return [
            'success' => true,
            'message' => 'OK',
            'data' => [
                'floors' => $floors,
                'totals' => [
                    'people' => $people_active,
                    'registration' => (int) $totals['registration'],
                    'pending' => (int) $totals['pending'],
                    'confirmed' => (int) $totals['confirmed'],
                ],
                'booking' => $booking,
                'seating' => array_values($seating),
                'daily' => $daily,
                'latest' => $latest_out,
                'dupes' => $dupes,
            ],
        ];
    }
}

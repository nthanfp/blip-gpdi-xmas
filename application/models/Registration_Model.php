<?php

class Registration_Model extends CI_Model
{
    private $_table = 'act_xmas_registration';
    private $_attendee = 'act_xmas_attendee';

    public function data_list($page = 1, $per_page = 10, $search = '', $floor = '', $status = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;
        $search = trim((string) $search);

        $where = [];
        $binds = [];

        if ($search !== '') {
            $like = '%' . $search . '%';
            $where[] = '(r.phone LIKE ? OR r.ref_code LIKE ? OR EXISTS (SELECT 1 FROM ' . $this->_attendee . ' ax WHERE ax.registrationid = r.registrationid AND ax.name LIKE ?))';
            $binds[] = $like;
            $binds[] = $like;
            $binds[] = $like;
        }
        if ($floor !== '' && $floor !== null) {
            $where[] = 'r.floor = ?';
            $binds[] = (int) $floor;
        }
        if ($status !== '' && $status !== null) {
            $where[] = 'r.status = ?';
            $binds[] = (int) $status;
        }

        $whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';

        $total = $this->db->query(
            'SELECT COUNT(*) AS total FROM ' . $this->_table . ' r' . $whereSql,
            $binds
        )->row()->total;

        $sql = 'SELECT r.registrationid, r.phone, r.floor, r.status, r.ref_code, r.created_date,
                       f.name AS floor_name,
                       COUNT(a.attendeeid) AS attendee_count,
                       GROUP_CONCAT(a.name ORDER BY a.is_primary DESC, a.attendeeid ASC SEPARATOR ", ") AS attendee_names
                FROM ' . $this->_table . ' r
                LEFT JOIN set_xmas_floor f ON f.floor = r.floor
                LEFT JOIN ' . $this->_attendee . ' a ON a.registrationid = r.registrationid'
            . $whereSql . '
                GROUP BY r.registrationid
                ORDER BY r.registrationid DESC
                LIMIT ' . $per_page . ' OFFSET ' . $offset;

        $rows = $this->db->query($sql, $binds)->result();

        return [
            'success' => true,
            'message' => 'Registration data retrieved successfully',
            'data' => $rows,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => (int) $total,
                'total_pages' => (int) ceil($total / $per_page),
                'has_prev' => $page > 1,
                'has_next' => ($page * $per_page) < $total
            ]
        ];
    }

    public function data_detail($id)
    {
        $id = (int) $id;

        $row = $this->db->query(
            'SELECT r.registrationid, r.phone, r.floor, r.status, r.ref_code, r.ip_address, r.ua, r.created_date,
                    f.name AS floor_name, f.capacity
             FROM ' . $this->_table . ' r
             LEFT JOIN set_xmas_floor f ON f.floor = r.floor
             WHERE r.registrationid = ?',
            [$id]
        )->row();

        if (!$row) {
            return ['success' => false, 'message' => 'Registration not found'];
        }

        $row->attendees = $this->db->query(
            'SELECT attendeeid, name, age, is_primary
             FROM ' . $this->_attendee . '
             WHERE registrationid = ?
             ORDER BY is_primary DESC, attendeeid ASC',
            [$id]
        )->result();

        return ['success' => true, 'message' => 'OK', 'data' => $row];
    }

    public function data_status($id, $status)
    {
        $id = (int) $id;
        $status = (int) $status;

        if (!$id) {
            return ['success' => false, 'message' => 'Registration ID is required'];
        }
        if (!in_array($status, [0, 1, 2], true)) {
            return ['success' => false, 'message' => 'Invalid status'];
        }

        $exists = $this->db->where('registrationid', $id)->count_all_results($this->_table);
        if (!$exists) {
            return ['success' => false, 'message' => 'Registration not found'];
        }

        $this->db->where('registrationid', $id);
        $this->db->update($this->_table, ['status' => $status]);

        $labels = [0 => 'pending', 1 => 'confirmed', 2 => 'cancelled'];
        return ['success' => true, 'message' => 'Registration marked as ' . $labels[$status]];
    }

    public function data_delete($id)
    {
        $id = (int) $id;

        if (!$id) {
            return ['success' => false, 'message' => 'Registration ID is required'];
        }

        $exists = $this->db->where('registrationid', $id)->count_all_results($this->_table);
        if (!$exists) {
            return ['success' => false, 'message' => 'Registration not found'];
        }

        // attendee ikut terhapus via ON DELETE CASCADE
        $this->db->where('registrationid', $id);
        $this->db->delete($this->_table);

        return ['success' => true, 'message' => 'Registration deleted successfully'];
    }

    public function data_stats()
    {
        $floors = $this->db->order_by('floor', 'ASC')->get('set_xmas_floor')->result();

        $peopleByFloor = $this->db->query(
            'SELECT r.floor, COUNT(a.attendeeid) AS people
             FROM ' . $this->_table . ' r
             JOIN ' . $this->_attendee . ' a ON a.registrationid = r.registrationid
             WHERE r.status <> 2
             GROUP BY r.floor'
        )->result();

        $map = [];
        foreach ($peopleByFloor as $p) {
            $map[(int) $p->floor] = (int) $p->people;
        }

        $floor_stats = [];
        foreach ($floors as $f) {
            $registered = isset($map[(int) $f->floor]) ? $map[(int) $f->floor] : 0;
            $floor_stats[] = [
                'floor' => (int) $f->floor,
                'name' => $f->name,
                'capacity' => (int) $f->capacity,
                'registered' => $registered,
                'remaining' => max(0, (int) $f->capacity - $registered)
            ];
        }

        $totals = $this->db->query(
            'SELECT COUNT(*) AS total_registration,
                    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS total_pending,
                    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS total_confirmed,
                    SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) AS total_cancelled
             FROM ' . $this->_table
        )->row();

        $total_people = $this->db->query(
            'SELECT COUNT(*) AS total_people FROM ' . $this->_attendee
        )->row();

        return [
            'success' => true,
            'message' => 'OK',
            'data' => [
                'floors' => $floor_stats,
                'totals' => [
                    'registration' => (int) $totals->total_registration,
                    'pending' => (int) $totals->total_pending,
                    'confirmed' => (int) $totals->total_confirmed,
                    'cancelled' => (int) $totals->total_cancelled,
                    'people' => (int) $total_people->total_people
                ]
            ]
        ];
    }
}

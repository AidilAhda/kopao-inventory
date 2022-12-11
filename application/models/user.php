<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Model
{

    public function cek($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row_array();
    }

    public function muatSemuaUser()
    {
        return $this->db->get_where('user', ['role_id' => 2])->result_array();
    }

    public function simpanUser($data)
    {
        return $this->db->insert('user', $data);
    }

    public function muatUser($id)
    {
        return $this->db->get_where('user', ['id_user' => $id])->row_array();
    }

    public function hapusUser($id)
    {
        return $this->db->delete('user', ['id_user' => $id]);
    }
    public function updateUser($id, $data)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('user', $data);
    }
    public function aktivasiUser($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }
}

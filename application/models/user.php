<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Model
{
    public function cek_username($username)
    {
        $query = $this->db->get_where('user', ['username' => $username]);
        return $query->num_rows();
    }
    public function get_password($username)
    {
        $data = $this->db->get_where('user', ['username' => $username])->row_array();
        return $data['password'];
    }
    public function cek($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row_array();
    }
    public function tambahUser($data)
    {
        return $this->db->insert('user', $data);
    }
}

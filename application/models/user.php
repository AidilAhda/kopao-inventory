<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Model
{

    public function cek($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row_array();
    }
    public function tambahUser($data)
    {
        return $this->db->insert('user', $data);
    }
}

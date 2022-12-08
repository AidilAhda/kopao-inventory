<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanUbahCabang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Cabang', 'cabang');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        // cek siapa yang login dan ingin masuk ke page admin
        isAdmin();
    }
    public function edit($getId)
    {

        $id = encode_php_tags($getId);
        $data['title'] = "Data Cabang";
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $data['cabang'] = $this->cabang->muatCabang($id);
        $this->template->load('admin/HalamanDashboard', 'admin/datacabang/HalamanUbahCabang', $data);
    }
}

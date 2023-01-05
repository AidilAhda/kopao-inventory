<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriKategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();

        // cek siapa yang login dan ingin masuk ke page admin
        isAdmin();
    }

    public function index()
    {
        $data['title'] = 'Kategori';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanEntriKategori', $data);
    }
}

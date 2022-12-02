<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanKategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');
    }
    public function index()
    {
        $data['title'] = 'Kategori';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $data['kategori'] = $this->kategori->muatSemuaKategori();

        $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanKategori', $data);
    }
}

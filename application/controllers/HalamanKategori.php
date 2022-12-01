<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanKategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
    }
    public function index()
    {
        $data['title'] = 'Kategori Barang';
        $data['user'] = $this->User->muatSemuaUser($this->session->userdata('username'));
        $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanKategori', $data);
    }
}

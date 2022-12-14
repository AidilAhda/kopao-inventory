<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanNamaCabang extends CI_Controller
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
    }
    public function index()
    {
        isAdmin();
        $data['title'] = 'Pesanan';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['cabang'] = $this->User->muatSemuaUser();
        $this->template->load('admin/HalamanDashboard', 'admin/HalamanNamaCabang', $data);
    }
    public function namaCabang()
    {
        isAdmin();
        $data['title'] = 'Barang Cabang';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['cabang'] = $this->User->muatSemuaUser();
        $this->template->load('admin/HalamanDashboard', 'admin/barangcabang/HalamanNamaCabang', $data);
    }
    public function admin()
    {
        isAdmin();
        $data['title'] = 'Laporan';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['cabang'] = $this->User->muatSemuaUser();
        $this->template->load('admin/HalamanDashboard', 'admin/laporan/HalamanNamaCabang', $data);
    }
    public function owner()
    {
        isOwner();
        $data['title'] = 'Laporan';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['cabang'] = $this->User->muatSemuaUser();
        $this->template->load('owner/HalamanDashboard', 'owner/laporan/HalamanNamaCabang', $data);
    }
}

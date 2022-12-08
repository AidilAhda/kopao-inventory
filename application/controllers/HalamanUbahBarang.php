<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanUbahBarang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        // cek siapa yang login dan ingin masuk ke page admin
        isAdmin();
    }
    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $data['title'] = "Data Barang";
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatBarang($id);
        $this->template->load('admin/HalamanDashboard', 'admin/databarang/HalamanUbahBarang', $data);
    }
}

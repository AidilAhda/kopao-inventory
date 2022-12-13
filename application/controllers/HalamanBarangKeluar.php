<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanBarangKeluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('StokCabang', 'sc');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        isCabang();
    }

    public function index()
    {
        $data['title'] = 'Barang Keluar';
        $data['user'] = $this->User->cek($this->session->userdata('username'));



        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $user_db = $this->User->cek($this->session->userdata('username'));
        $data['barangkeluar'] = $this->sc->muatStok($user_db['nama']);

        $this->template->load('cabang/HalamanDashboard', 'cabang/barangkeluar/Halamanbarangkeluar', $data);
    }
}

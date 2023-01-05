<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriBarangKeluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('BarangKeluar', 'bk');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        isCabang();
    }
    public function index()
    {
        $data['title'] = 'Barang Keluar';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));

        $today = date('ymd');
        $prefix = 'BK' . $today;
        $lastKode = $this->bk->idBarangKeluarTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);

        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idBarangKeluar'] = $newKode;
        $this->template->load('cabang/HalamanDashboard', 'cabang/barangkeluar/HalamanEntriBarangKeluar', $data);
    }
}

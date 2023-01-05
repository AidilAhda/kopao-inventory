<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriBarangMasuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('BarangMasuk', 'bm');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        isCabang();
    }
    public function index()
    {
        $data['title'] = 'Barang Masuk';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));

        $today = date('ymd');
        $prefix = 'BM' . $today;
        $lastKode = $this->bm->idBarangMasukTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);

        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idBarangMasuk'] = $newKode;
        $this->template->load('cabang/HalamanDashboard', 'cabang/barangmasuk/HalamanEntriBarangMasuk', $data);
    }
}

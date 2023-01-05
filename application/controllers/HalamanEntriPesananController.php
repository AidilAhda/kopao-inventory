<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriPesananController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('Pesanan', 'pesanan');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        // cek siapa yang login dan ingin masuk ke page cabang
        isCabang();
    }
    public function index()
    {
        $data['title'] = 'Pesanan';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));

        $today = date('ymd');
        $prefix = 'PC' . $today;
        $lastKode = $this->pesanan->idPesananTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);


        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idPesanan'] = $newKode;
        $this->template->load('cabang/HalamanDashboard', 'cabang/pesanan/HalamanEntriPesanan', $data);
    }
    public function simpanPesanan()
    {
        is_logged_in();
        isCabang();
        $data['title'] = 'Pesanan';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
            'required' => 'Nama Barang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]', array(
            'required' => 'Jumlah tidak boleh kosong',
            'greater_than' => 'Jumlah tidak boleh kecil dari 0'
        ));
        $this->form_validation->set_rules('id_kategori', 'Kategori ', 'required', array(
            'required' => 'Kategori tidak boleh kosong'
        ));
        $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
            'required' => 'Satuan tidak boleh kosong'
        ));

        $today = date('ymd');
        $prefix = 'PC' . $today;
        $lastKode = $this->pesanan->idPesananTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);


        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idPesanan'] = $newKode;
        if ($this->form_validation->run() == false) {
            $this->template->load('cabang/HalamanDashboard', 'cabang/pesanan/HalamanEntriPesanan', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_pesanan ' => $input['id_pesanan'],
                'satuan ' => $input['satuan'],
                'kategori_id ' => $input['id_kategori'],
                'jumlah_barang' => $input['jumlah'],
                'tanggal_pesanan' => $input['tanggal'],
                'nama_cabang' => $input['nama_cabang'],
                'status' => 'Pending',
                'barang_id' => $input['nama_barang'],
                'id_user' => $input['id_user']
            ];
            $query =  $this->pesanan->simpanPesanan($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Pesanan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanPesanan');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Pesanan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriPesananController');
            }
        }
    }
}

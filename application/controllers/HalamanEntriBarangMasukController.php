<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriBarangMasukController extends CI_Controller
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
    public function simpanBarangMasuk()
    {
        is_logged_in();
        isCabang();
        $data['title'] = 'Barang Masuk';
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
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[5]|max_length[20]', array(
            'min_length' => 'Minimal 5 huruf',
            'max_length' => 'Maksimal 20 huruf'
        ));

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
        if ($this->form_validation->run() == false) {
            $this->template->load('cabang/HalamanDashboard', 'cabang/barangmasuk/HalamanEntriBarangMasuk', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_barang_masuk ' => $input['id_barang_masuk'],
                'kategori_id ' => $input['id_kategori'],
                'barang_id' => $input['nama_barang'],
                'jumlah_masuk' => $input['jumlah'],
                'tanggal_masuk' => $input['tanggal'],
                'nama_cabang' => $input['nama_cabang'],
                'satuan ' => $input['satuan'],
                'keterangan' => $input['keterangan'],
                'id_user' => $input['id_user']

            ];
            $query =  $this->bm->simpanBarangMasuk($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Barang Masuk<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarangMasuk');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Barang Masuk<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriBarangMasukController');
            }
        }
    }
}

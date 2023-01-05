<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriBarangKeluarController extends CI_Controller
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
    public function simpanBarangKeluar()
    {
        is_logged_in();
        isCabang();
        $data['title'] = 'Barang Keluar';
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
        $prefix = 'BK' . $today;
        $lastKode = $this->bk->idBarangKeluarTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);

        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idBarangKeluar'] = $newKode;
        if ($this->form_validation->run() == false) {
            $this->template->load('cabang/HalamanDashboard', 'cabang/barangkeluar/HalamanEntriBarangKeluar', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_barang_keluar ' => $input['id_barang_keluar'],
                'kategori_id ' => $input['id_kategori'],
                'barang_id' => $input['nama_barang'],
                'jumlah_keluar' => $input['jumlah'],
                'tanggal_keluar' => $input['tanggal'],
                'nama_cabang' => $input['nama_cabang'],
                'satuan ' => $input['satuan'],
                'id_user' => $input['id_user'],
                'keterangan' => $input['keterangan'],

            ];
            $query =  $this->bk->simpanBarangKeluar($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Barang Keluar<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarangKeluar');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Barang Keluar<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriBarangKeluarController');
            }
        }
    }
}

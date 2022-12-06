<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanTambahDataBarang extends CI_Controller
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
    public function index()
    {
        $data['title'] = 'Data Barang';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('id_kategori', 'Jenis', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $lastKode = $this->barang->idBarangTerbesar();

        //mengambail 6 char dari belakang
        $noUrut = (int) substr($lastKode, -6, 6);
        $noUrut++;
        $newKode = 'B' . sprintf("%06s", $noUrut);

        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['idBarang'] = $newKode;
        if ($this->form_validation->run() == false) {
            $this->template->load('admin/HalamanDashboard', 'admin/databarang/HalamanTambahDataBarang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_barang ' => $input['id_barang'],
                'nama_barang ' => $input['nama_barang'],
                'kategori_id ' => $input['id_kategori'],
                'satuan ' => $input['satuan']
            ];
            $query =  $this->barang->simpanDataBarang($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Data<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanDataBarang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Data<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanTambahDataBarang');
            }
        }
    }
}

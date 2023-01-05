<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanUbahBarangController extends CI_Controller
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
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatBarang($id);
        $this->template->load('admin/HalamanDashboard', 'admin/databarang/HalamanUbahBarang', $data);
    }
    public function updateBarang($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
            'required' => 'Nama Barang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('id_kategori', 'Jenis', 'required', array(
            'required' => 'Kategori tidak boleh kosong'
        ));
        $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
            'required' => 'Satuan tidak boleh kosong'
        ));
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Barang";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['kategori'] = $this->kategori->muatSemuaKategori();
            $data['barang'] = $this->barang->muatBarang($id);
            $this->template->load('admin/HalamanDashboard', 'admin/databarang/HalamanUbahBarang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_barang' => $input['nama_barang'],
                'kategori_id' => $input['id_kategori'],
                'satuan' => $input['satuan']
            ];
            $query = $this->barang->updateBarang($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahBarangController/edit');
            }
        }
    }
}

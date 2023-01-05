<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriBarangCabangController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('BarangCabang', 'sc');


        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        // cek siapa yang login dan ingin masuk ke page cabang
        isAdmin();
    }
    public function simpanBarangCabang($getId)
    {

        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
            'required' => 'Nama barang tidak boleh kosong',

        ));
        $this->form_validation->set_rules('id_kategori', 'Kategori ID', 'required', array(
            'required' => 'Kategori tidak boleh kosong',

        ));
        $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
            'required' => 'Satuan tidak boleh kosong',

        ));
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Cabang";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['kategori'] = $this->kategori->muatSemuaKategori();
            $data['barang'] = $this->barang->muatSemuaBarang();
            $data['cabang'] = $this->User->muatUser($id);
            $this->template->load('admin/HalamanDashboard', 'admin/barangcabang/HalamanEntriBarangCabang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'barang_id' => $input['nama_barang'],
                'kategori_id' => $input['id_kategori'],
                'nama_cabang' => $input['nama_cabang'],
                'total' => 0,
                'satuan' => $input['satuan'],
                'id_user' => $input['id_user']
            ];
            $query = $this->sc->simpanStokCabang($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarangCabang/barangCabang/' . $id);
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarangCabang/barangCabang/' . $id);
            }
        }
    }
}

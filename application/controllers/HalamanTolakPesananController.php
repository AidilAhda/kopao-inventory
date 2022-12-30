<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanTolakPesananController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('User', 'cabang');
        $this->load->model('Pesanan', 'pesanan');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        isAdmin();
    }

    public function tolakPesanan($getId, $getUser)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $idUser = encode_php_tags($getUser);

        $data = [
            'status' => 'Ditolak'
        ];
        $query = $this->pesanan->updatePesanan($id, $data);
        if ($query) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil ditolak<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('HalamanKonfirmasiPesananController/pesananCabang/' . $idUser);
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal ditolak<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

            redirect('HalamanKonfirHalamanKonfirmasiPesananControllermasiPesanan/pesananCabang/' . $idUser);
        }
    }
}

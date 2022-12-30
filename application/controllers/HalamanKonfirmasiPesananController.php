<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanKonfirmasiPesananController extends CI_Controller
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

    public function pesananCabang($id)
    {
        $cabang = encode_php_tags($id);
        $data['title'] = 'Pesanan';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['pesanan'] = $this->pesanan->muatPesanan(true, $cabang);
        $data['cabang'] = $this->cabang->muatUser($cabang);
        $this->template->load('admin/HalamanDashboard', 'admin/pesanan/HalamanKonfirmasiPesanan', $data);
    }
    public function konfirmasiPesanan($getId, $getUser)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $idUser = encode_php_tags($getUser);

        $data = [
            'status' => 'Disetujui'
        ];

        $query = $this->pesanan->updatePesanan($id, $data);
        if ($query) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil dikonfirmasi<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('HalamanKonfirmasiPesananController/pesananCabang/' . $idUser);
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal dikonfirmasi<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

            redirect('HalamanKonfirmasiPesananController/pesananCabang/' . $idUser);
        }
    }
}

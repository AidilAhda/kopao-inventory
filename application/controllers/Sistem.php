<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sistem extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // load model
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('Cabang', 'cabang');
        $this->load->model('Pesanan', 'pesanan');
        $this->load->model('barangmasuk', 'bm');
        $this->load->model('BarangKeluar', 'bk');
        $this->load->model('BarangCabang', 'sc');
    }

    // LOGIN
    public function tampilHalamanLogin()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required', array(
            'required' => 'Username tidak boleh kosong'
        ));
        $this->form_validation->set_rules('password', 'Password', 'trim|required', array(
            'required' => 'Password tidak boleh kosong'
        ));

        //jika gagal
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasi sukses
            $username = $this->input->post('username');
            $pw = $this->input->post('password');
            $result = $this->User->cek($username, $pw);
            var_dump($result);
            // //jika usernya ada
            if ($result) {
                $this->session->set_userdata($result);
                if ($result['role_id'] == 1) {
                    redirect('HalamanDashboard/admin');
                } elseif ($result['role_id'] == 2) {
                    redirect('HalamanDashboard/cabang');
                } else {
                    redirect('HalamanDashboard/owner');
                }
            }
        }
    }


    // // BARANG CABANG
    // public function simpanBarangCabang($getId)
    // {
    //     is_logged_in();
    //     isAdmin();
    //     $id = encode_php_tags($getId);
    //     $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
    //         'required' => 'Nama barang tidak boleh kosong',

    //     ));
    //     $this->form_validation->set_rules('id_kategori', 'Kategori ID', 'required', array(
    //         'required' => 'Kategori tidak boleh kosong',

    //     ));
    //     $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
    //         'required' => 'Satuan tidak boleh kosong',

    //     ));
    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = "Barang Cabang";
    //         $data['user'] = $this->User->cek($this->session->userdata('username'));
    //         $data['kategori'] = $this->kategori->muatSemuaKategori();
    //         $data['barang'] = $this->barang->muatSemuaBarang();
    //         $data['cabang'] = $this->User->muatUser($id);
    //         $this->template->load('cabang/HalamanDashboard', 'admin/barangcabang/HalamanEntriBarangCabang', $data);
    //     } else {
    //         $input = $this->input->post(null, true);
    //         $data = [
    //             'barang_id' => $input['nama_barang'],
    //             'kategori_id' => $input['id_kategori'],
    //             'nama_cabang' => $input['nama_cabang'],
    //             'total' => 0,
    //             'satuan' => $input['satuan'],
    //             'id_user' => $input['id_user']
    //         ];
    //         $query = $this->sc->simpanStokCabang($data);
    //         if ($query) {
    //             $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    //             redirect('HalamanBarangCabang/barangCabang/' . $id);
    //         } else {
    //             $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    //             redirect('HalamanBarangCabang/barangCabang/' . $id);
    //         }
    //     }
    // }
}

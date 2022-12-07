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
    }

    // LOGIN
    public function tampilHalamanLogin()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        //jika gagal
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasi sukses
            $this->cek();
        }
    }
    public function cek()
    {
        $input = $this->input->post(null, true);
        // $username = $this->input->post('username');
        $password = $this->input->post('password');

        // $user = $this->db->get_where('user', ['username' => $username])->row_array();
        $user_db = $this->User->cek($input['username']);


        //jika usernya ada
        if ($user_db) {
            // jika usernya aktif
            if ($user_db['is_active'] == 1) {
                //cek password
                if (password_verify($password, $user_db['password'])) {
                    $data = [
                        'username' => $user_db['username'],
                        'role_id' => $user_db['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user_db['role_id'] == 1) {
                        redirect('HalamanDashboard/admin');
                    } elseif ($user_db['role_id'] == 2) {
                        redirect('HalamanDashboard/cabang');
                    } else {
                        redirect('HalamanDashboard/owner');
                    }
                } else {


                    $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Password Anda Salah<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    redirect('HalamanLogin/tampilHalamanLogin');
                }
            } else {
                //jika tidak aktif
                redirect('HalamanLogin/tampilHalamanLogin');
            }
        } else {
            //jika tidak ada
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>username belum terdaftar <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('HalamanLogin/tampilHalamanLogin');
        }
    }



    // MENU KATEGORI
    public function tambahDataKategori()
    {
        $data['title'] = 'Kategori';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->form_validation->set_rules('nama_kategori', 'Nama kategori', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanTambahKategori', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_kategori' => $input['nama_kategori'],
            ];
            $query =  $this->kategori->simpanData($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanKategori');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanTambahKategori');
            }
        }
    }

    public function updateDataKategori($getId)
    {
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_kategori', 'Nama kategori', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Kategori";
            $data['user'] = $this->User->cek($this->session->userdata('username'));
            $data['kategori'] = $this->kategori->muatKategori($id);
            $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanUbahKategori', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_kategori' => $input['nama_kategori']
            ];
            $query = $this->kategori->updateData($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('halamankategori');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahKategori/edit');
            }
        }
    }

    public function hapusDataKategori($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->kategori->hapusData($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanKategori');
    }

    // MENU DATA BARANG
    public function tambahDataBarang()
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

    public function updateDataBarang($getId)
    {
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('id_kategori', 'kategori', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Barang";
            $data['user'] = $this->User->cek($this->session->userdata('username'));
            $data['kategori'] = $this->kategori->muatSemuaKategori();
            $data['barang'] = $this->barang->muatDataBarang($id);
            $this->template->load('admin/HalamanDashboard', 'admin/databarang/HalamanUbahBarang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_barang' => $input['nama_barang'],
                'kategori_id' => $input['id_kategori'],
                'satuan' => $input['satuan']
            ];
            $query = $this->barang->updateDataBarang($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanDataBarang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahDataBarang/edit');
            }
        }
    }
    public function hapusDataBarang($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->barang->hapusDataBarang($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanDataBarang');
    }


    public function tambahUser()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]', [
            'min_length' => 'password terlalu pendek'
        ]);
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim');
        //jika gagal
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah User';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/auth_footer');
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama' => $input['name'],
                'username' => $input['username'],
                'email' => $input['email'],
                'no_telp' => $input['no_telp'],
                'role_id' => 2,
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'created_at' => time(),
                'is_active' => 1
            ];
            $query =  $this->User->tambahUser($data);
            if ($query) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Berhasil Tambah Akun</div>');
                redirect('HalamanLogin/tampilHalamanLogin');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Gagal Tambah Akun</div>');
                redirect('Sistem/tambahUser');
            }
        }
    }
}

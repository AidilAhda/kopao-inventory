<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
    }

    public function index()
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
        $user_db = $this->User->muatSemuaUser($input['username']);


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
                        redirect('admin');
                    } elseif ($user_db['role_id'] == 2) {

                        redirect('cabang');
                    } else {
                        redirect('owner');
                    }
                } else {

                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">password salah</div>');
                    redirect('auth');
                }
            } else {
                //jika tidak aktif
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">akun anda belum aktif/dinonaktifkan. Silahkan hubungi admin.</div>');
                redirect('auth');
            }
        } else {
            //jika tidak ada
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">username belum terdaftar</div>');
            redirect('auth');
        }
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
                'role_id' => 1,
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'created_at' => time(),
                'is_active' => 1
            ];
            $query =  $this->User->tambahUser($data);
            if ($query) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Berhasil Tambah Akun</div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Gagal Tambah Akun</div>');
                redirect('auth/tambahUser');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Telah berhasil log out</div>');
        redirect('auth');
    }
}

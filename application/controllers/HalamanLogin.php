<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanLogin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
    }


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


    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Telah berhasil log out <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        redirect('HalamanLogin/tampilHalamanLogin');
    }
}

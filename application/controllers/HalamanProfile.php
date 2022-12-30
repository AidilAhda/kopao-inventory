<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanProfile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        is_logged_in();
    }
    public function admin()
    {
        isAdmin();
        $data['title'] = 'Profile';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $user_db = $this->User->cek($this->session->userdata('username'));
        $data['profile'] = $this->User->muatUser($user_db['id_user']);
        $this->template->load('admin/HalamanDashboard', 'HalamanProfile', $data);
    }
    public function cabang()
    {
        isCabang();
        $data['title'] = 'Profile';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $user_db = $this->User->cek($this->session->userdata('username'));
        $data['profile'] = $this->User->muatUser($user_db['id_user']);
        $this->template->load('cabang/HalamanDashboard', 'HalamanProfile', $data);
    }
    public function owner()
    {
        isOwner();
        $data['title'] = 'Profile';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $user_db = $this->User->cek($this->session->userdata('username'));
        $data['profile'] = $this->User->muatUser($user_db['id_user']);
        $this->template->load('owner/HalamanDashboard', 'HalamanProfile', $data);
    }
}

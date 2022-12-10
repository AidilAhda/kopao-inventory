<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
    }
    public function admin()
    {
        isAdmin();
        $data['title'] = "Dashboard";
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->template->load('admin/HalamanDashboard', 'dashboard', $data);
    }

    public function cabang()
    {
        isCabang();
        $data['title'] = "Dashboard";
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->template->load('cabang/HalamanDashboard', 'dashboard', $data);
    }
    public function owner()
    {
        isOwner();
        $data['title'] = "Dashboard";
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->template->load('owner/HalamanDashboard', 'dashboard', $data);
    }
    public function blok()
    {
        $data['title'] = "BLOCKED";
        $this->load->view('error', $data);
    }
}

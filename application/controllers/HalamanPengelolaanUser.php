<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanPengelolaanUser extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
    }
    public function index()
    {
        $data['title'] = 'Kelola User';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $data['akun'] = $this->User->muatSemuaUser();

        $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanPengelolaanUser', $data);
    }
}

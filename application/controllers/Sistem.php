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



    // MENU KATEGORI
    public function tambahKategori()
    {
        is_logged_in();
        isAdmin();
        $data['title'] = 'Kategori';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('nama_kategori', 'Nama kategori', 'required', array(
            'required' => 'Nama Kategori tidak boleh kosong'
        ));
        if ($this->form_validation->run() == false) {
            $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanEntriKategori', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_kategori' => $input['nama_kategori'],
            ];
            $query =  $this->kategori->simpanKategori($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanKategori');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriKategori');
            }
        }
    }

    public function updateKategori($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_kategori', 'Nama kategori', 'required|trim', array(
            'required' => 'Nama Kategori tidak boleh kosong'
        ));
        if ($this->form_validation->run() == false) {
            $data['title'] = "Kategori";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['kategori'] = $this->kategori->muatKategori($id);
            $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanUbahKategori', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_kategori' => $input['nama_kategori']
            ];
            $query = $this->kategori->updateKategori($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('halamankategori');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahKategori/edit');
            }
        }
    }


    public function hapusKategori($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        if ($this->kategori->hapusKategori($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanKategori');
    }

    // MENU DATA BARANG
    public function tambahBarang()
    {
        is_logged_in();
        isAdmin();
        $data['title'] = 'Data Barang';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
            'required' => 'Nama Barang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('id_kategori', 'Jenis', 'required', array(
            'required' => 'Kategori tidak boleh kosong'
        ));
        $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
            'required' => 'Satuan tidak boleh kosong'
        ));
        $lastKode = $this->barang->idBarangTerbesar();

        //mengambail 6 char dari belakang
        $noUrut = (int) substr($lastKode, -6, 6);
        $noUrut++;
        $newKode = 'B' . sprintf("%06s", $noUrut);

        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['idBarang'] = $newKode;
        if ($this->form_validation->run() == false) {
            $this->template->load('admin/HalamanDashboard', 'admin/databarang/HalamanEntriBarang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_barang ' => $input['id_barang'],
                'nama_barang ' => $input['nama_barang'],
                'kategori_id ' => $input['id_kategori'],
                'satuan ' => $input['satuan']
            ];
            $query =  $this->barang->simpanBarang($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriBarang');
            }
        }
    }

    public function updateBarang($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
            'required' => 'Nama Barang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('id_kategori', 'Jenis', 'required', array(
            'required' => 'Kategori tidak boleh kosong'
        ));
        $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
            'required' => 'Satuan tidak boleh kosong'
        ));
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Barang";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['kategori'] = $this->kategori->muatSemuaKategori();
            $data['barang'] = $this->barang->muatBarang($id);
            $this->template->load('admin/HalamanDashboard', 'admin/databarang/HalamanUbahBarang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_barang' => $input['nama_barang'],
                'kategori_id' => $input['id_kategori'],
                'satuan' => $input['satuan']
            ];
            $query = $this->barang->updateBarang($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahDataBarang/edit');
            }
        }
    }

    public function hapusBarang($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        if ($this->barang->hapusBarang($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanBarang');
    }

    // MENU DATA CABANG
    public function updateCabang($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('alamat_cabang', 'Alamat Cabang', 'required', array(
            'required' => 'Alamat tidak boleh kosong'
        ));
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Cabang";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['cabang'] = $this->cabang->muatCabang($id);
            $this->template->load('admin/HalamanDashboard', 'admin/datacabang/HalamanUbahCabang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'alamat_cabang' => $input['alamat_cabang']
            ];
            $query = $this->cabang->updateCabang($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanCabang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanUbahCabang/edit');
            }
        }
    }

    public function simpanCabang()
    {
        is_logged_in();
        isAdmin();
        $data['title'] = 'Data Cabang ';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('nama_cabang', 'Nama Cabang', 'required', array(
            'required' => 'Nama Cabang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('alamat_cabang', 'Alanat ', 'required', array(
            'required' => 'Alamat tidak boleh kosong'
        ));
        $idTerbesar = $this->cabang->idCabangTerbesar();
        $idTerbesar++;


        if ($this->form_validation->run() == false) {
            $this->template->load('admin/HalamanDashboard', 'admin/datacabang/HalamanEntriCabang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_cabang' => $idTerbesar,
                'nama_cabang' => strtoupper($input['nama_cabang']),
                'alamat_cabang' => $input['alamat_cabang']
            ];
            $query =  $this->cabang->simpanCabang($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanCabang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriKategori');
            }
        }
    }

    public function hapusCabang($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        if ($this->cabang->hapusCabang($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanCabang');
    }


    // MENU PESANAN
    public function simpanPesanan()
    {
        is_logged_in();
        isCabang();
        $data['title'] = 'Pesanan';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
            'required' => 'Nama Barang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]', array(
            'required' => 'Jumlah tidak boleh kosong',
            'greater_than' => 'Jumlah tidak boleh kecil dari 0'
        ));
        $this->form_validation->set_rules('id_kategori', 'Kategori ', 'required', array(
            'required' => 'Kategori tidak boleh kosong'
        ));
        $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
            'required' => 'Satuan tidak boleh kosong'
        ));

        $today = date('ymd');
        $prefix = 'PC' . $today;
        $lastKode = $this->pesanan->idPesananTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);


        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idPesanan'] = $newKode;
        if ($this->form_validation->run() == false) {
            $this->template->load('cabang/HalamanDashboard', 'cabang/pesanan/HalamanEntriPesanan', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_pesanan ' => $input['id_pesanan'],
                'satuan ' => $input['satuan'],
                'kategori_id ' => $input['id_kategori'],
                'jumlah_barang' => $input['jumlah'],
                'tanggal_pesanan' => $input['tanggal'],
                'nama_cabang' => $input['nama_cabang'],
                'status' => 'Pending',
                'barang_id' => $input['nama_barang'],
                'id_user' => $input['id_user']
            ];
            $query =  $this->pesanan->simpanPesanan($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Pesanan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanPesanan');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Pesanan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriPesanan');
            }
        }
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
            redirect('HalamanKonfirmasiPesanan/pesananCabang/' . $idUser);
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal dikonfirmasi<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

            redirect('HalamanKonfirmasiPesanan/pesananCabang/' . $idUser);
        }
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
            redirect('HalamanKonfirmasiPesanan/pesananCabang/' . $idUser);
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal ditolak<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

            redirect('HalamanKonfirmasiPesanan/pesananCabang/' . $idUser);
        }
    }


    //MENU BARANG MASUK/KELUAR
    public function simpanBarangMasuk()
    {
        is_logged_in();
        isCabang();
        $data['title'] = 'Barang Masuk';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
            'required' => 'Nama Barang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]', array(
            'required' => 'Jumlah tidak boleh kosong',
            'greater_than' => 'Jumlah tidak boleh kecil dari 0'
        ));
        $this->form_validation->set_rules('id_kategori', 'Kategori ', 'required', array(
            'required' => 'Kategori tidak boleh kosong'
        ));
        $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
            'required' => 'Satuan tidak boleh kosong'
        ));
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[5]|max_length[20]', array(
            'min_length' => 'Minimal 5 huruf',
            'max_length' => 'Maksimal 20 huruf'
        ));

        $today = date('ymd');
        $prefix = 'BM' . $today;
        $lastKode = $this->bm->idBarangMasukTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);

        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idBarangMasuk'] = $newKode;
        if ($this->form_validation->run() == false) {
            $this->template->load('cabang/HalamanDashboard', 'cabang/barangmasuk/HalamanEntriBarangMasuk', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_barang_masuk ' => $input['id_barang_masuk'],
                'kategori_id ' => $input['id_kategori'],
                'barang_id' => $input['nama_barang'],
                'jumlah_masuk' => $input['jumlah'],
                'tanggal_masuk' => $input['tanggal'],
                'nama_cabang' => $input['nama_cabang'],
                'satuan ' => $input['satuan'],
                'keterangan' => $input['keterangan'],
                'id_user' => $input['id_user']

            ];
            $query =  $this->bm->simpanBarangMasuk($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Barang Masuk<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarangMasuk');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Barang Masuk<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriBarangMasuk');
            }
        }
    }

    public function simpanBarangKeluar()
    {
        is_logged_in();
        isCabang();
        $data['title'] = 'Barang Keluar';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required', array(
            'required' => 'Nama Barang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]', array(
            'required' => 'Jumlah tidak boleh kosong',
            'greater_than' => 'Jumlah tidak boleh kecil dari 0'
        ));
        $this->form_validation->set_rules('id_kategori', 'Kategori ', 'required', array(
            'required' => 'Kategori tidak boleh kosong'
        ));
        $this->form_validation->set_rules('satuan', 'Satuan', 'required', array(
            'required' => 'Satuan tidak boleh kosong'
        ));
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[5]|max_length[20]', array(
            'min_length' => 'Minimal 5 huruf',
            'max_length' => 'Maksimal 20 huruf'
        ));

        $today = date('ymd');
        $prefix = 'BK' . $today;
        $lastKode = $this->bk->idBarangKeluarTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);

        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idBarangKeluar'] = $newKode;
        if ($this->form_validation->run() == false) {
            $this->template->load('cabang/HalamanDashboard', 'cabang/barangkeluar/HalamanEntriBarangKeluar', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_barang_keluar ' => $input['id_barang_keluar'],
                'kategori_id ' => $input['id_kategori'],
                'barang_id' => $input['nama_barang'],
                'jumlah_keluar' => $input['jumlah'],
                'tanggal_keluar' => $input['tanggal'],
                'nama_cabang' => $input['nama_cabang'],
                'satuan ' => $input['satuan'],
                'id_user' => $input['id_user'],
                'keterangan' => $input['keterangan'],

            ];
            $query =  $this->bk->simpanBarangKeluar($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Barang Keluar<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarangKeluar');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Barang Keluar<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriBarangKeluar');
            }
        }
    }



    // MENU KELOLA USER
    public function simpanUser()
    {
        is_logged_in();
        isAdmin();
        //jika gagal
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|alpha_numeric', array(
            'required' => 'Username tidak boleh kosong',
            'is_unique' => 'Username Sudah ada terdaftar',
            'alpha_numeric' => 'Harus mengandung abjad/angka'
        ));
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]', array(
            'required' => 'Pasword tidak boleh kosong',
            'min_length' => 'Minimal 3 huruf'
        ));
        $this->form_validation->set_rules('nama', 'Name', 'trim|required', array(
            'required' => 'Nama tidak boleh kosong',

        ));
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim', array(
            'required' => 'No Telepon tidak boleh kosong',

        ));
        if ($this->form_validation->run() == false) {

            $data['title'] = 'Tambah User';
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanEntriUser', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama' => strtoupper($input['nama']),
                'username' => $input['username'],
                'no_telp' => $input['no_telp'],
                'role_id' => 2,
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'created_at' => time(),
                'is_active' => 0
            ];
            $query =  $this->User->simpanUser($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah User<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanPengelolaanUser');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah User<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriUser');
            }
        }
    }

    public function aktifkanUser($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $status = $this->User->muatUser($id)['is_active'];
        $toggle = $status ? 0 : 1; //Jika user aktif maka nonaktifkan, begitu pula sebaliknya
        $query = $this->User->aktivasiUser('user', 'id_user', $id, ['is_active' => $toggle]);
        if ($query) {
            if ($toggle == 1) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>User Berhasil diaktifkan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>User Berhasil dinonaktifkan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            }
        }
        redirect('HalamanPengelolaanUser');
    }
    public function updateUser($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|alpha_numeric', array(
            'required' => 'Username tidak boleh kosong',
            'is_unique' => 'Username Sudah ada terdaftar',
            'alpha_numeric' => 'Harus mengandung abjad/angka'
        ));

        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim', array(
            'required' => 'No Telepon tidak boleh kosong',

        ));
        if ($this->form_validation->run() == false) {

            $data['title'] = "Kelola User";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['akun'] = $this->User->muatUser($id);
            $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanUbahUser', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'username' => $input['username'],

                'no_telp' => $input['no_telp']
            ];
            $query = $this->User->updateUser($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah User<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanPengelolaanUser');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahUser/edit');
            }
        }
    }

    public function hapusUser($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        if ($this->User->hapusUser($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus User<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanPengelolaanUser');
    }

    // BARANG CABANG
    public function simpanBarangCabang($getId)
    {
        is_logged_in();
        isAdmin();
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
            $this->template->load('cabang/HalamanDashboard', 'admin/barangcabang/HalamanEntriBarangCabang', $data);
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
            $query = $this->sc->simpanBarangCabang($data);
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

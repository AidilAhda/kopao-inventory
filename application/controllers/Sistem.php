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
        $this->load->model('StokCabang', 'sc');
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
                        'role_id' => $user_db['role_id'],
                        'nama' => $user_db['nama']
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
                    redirect('HalamanLogin');
                }
            } else {
                //jika tidak aktif
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Akun anda belum aktif. Silahkan hubungi admin untuk mengaktifkan akun<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanLogin');
            }
        } else {
            //jika tidak ada
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>username belum terdaftar <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('HalamanLogin');
        }
    }

    // MENU KATEGORI
    public function tambahKategori()
    {
        $data['title'] = 'Kategori';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->form_validation->set_rules('nama_kategori', 'Nama kategori', 'required');
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
        $id = encode_php_tags($getId);
        if ($this->kategori->hapusKategori($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanKategori');
    }

    // MENU DATA BARANG
    public function tambahBarang()
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
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Data<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Data<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriBarang');
            }
        }
    }

    public function updateBarang($getId)
    {
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('id_kategori', 'kategori', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Barang";
            $data['user'] = $this->User->cek($this->session->userdata('username'));
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
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanBarang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahDataBarang/edit');
            }
        }
    }

    public function hapusBarang($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->barang->hapusBarang($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanBarang');
    }

    // MENU DATA CABANG
    public function updateCabang($getId)
    {
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('alamat_cabang', 'Alamat Cabang', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Cabang";
            $data['user'] = $this->User->cek($this->session->userdata('username'));
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
        $data['title'] = 'Data Cabang ';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->form_validation->set_rules('nama_cabang', 'Nama Cabang', 'required');
        $this->form_validation->set_rules('alamat_cabang', 'Alanat ', 'required');
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
        $id = encode_php_tags($getId);
        if ($this->cabang->hapusCabang($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanCabang');
    }


    // MENU PESANAN
    public function simpanPesanan()
    {
        $data['title'] = 'Pesanan';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_rules('id_kategori', 'Kategori ', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

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

    public function konfirmasiPesanan($getId)
    {
        $id = encode_php_tags($getId);

        $data = [
            'status' => 'Disetujui'
        ];

        $query = $this->pesanan->updatePesanan($id, $data);
        if ($query) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil dikonfirmasi<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('HalamanNamaCabang');
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal dikonfirmasi<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

            redirect('HalamanNamaCabang');
        }
    }
    public function tolakPesanan($getId)
    {
        $id = encode_php_tags($getId);

        $data = [
            'status' => 'Ditolak'
        ];
        $query = $this->pesanan->updatePesanan($id, $data);
        if ($query) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil ditolak<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('HalamanNamaCabang');
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal ditolak<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

            redirect('HalamanNamaCabang');
        }
    }


    //MENU BARANG MASUK/KELUAR
    public function simpanBarangMasuk()
    {
        $data['title'] = 'Barang Masuk';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_rules('id_kategori', 'Kategori ', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

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
        $data['title'] = 'Barang Keluar';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_rules('id_kategori', 'Kategori ', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');


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
        //jika gagal
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]', [
            'min_length' => 'password terlalu pendek'
        ]);
        $this->form_validation->set_rules('nama', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim');
        if ($this->form_validation->run() == false) {

            $data['title'] = 'Tambah User';
            $data['user'] = $this->User->cek($this->session->userdata('username'));
            $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanEntriUser', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama' => strtoupper($input['nama']),
                'username' => $input['username'],
                'email' => $input['email'],
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
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('no_telp', 'No Telp', 'required');
        if ($this->form_validation->run() == false) {

            $data['title'] = "Kelola User";
            $data['user'] = $this->User->cek($this->session->userdata('username'));
            $data['akun'] = $this->User->muatUser($id);
            $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanUbahUser', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'username' => $input['username'],
                'email' => $input['email'],
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
        $id = encode_php_tags($getId);
        if ($this->User->hapusUser($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus User<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanPengelolaanUser');
    }

    // BARANG CABANG
    public function updateBarangCabang($getId)
    {
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('id_kategori', 'Kategori ID', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Cabang";
            $data['user'] = $this->User->cek($this->session->userdata('username'));
            $data['kategori'] = $this->kategori->muatSemuaKategori();
            $data['barang'] = $this->barang->muatSemuaBarang();
            $data['cabang'] = $this->sc->muatCabang($id);
            $this->template->load('cabang/HalamanDashboard', 'admin/barangcabang/HalamanEntriBarangCabang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'barang_id' => $input['nama_barang'],
                'kategori_id' => $input['id_kategori'],
                'nama_cabang' => $input['nama_cabang'],
                'nama_cabang' => $input['nama_cabang'],
                'total' => 0,
                'satuan' => $input['satuan']
            ];
            $query = $this->sc->updateStokCabang($id, $data);
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

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanLaporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('CustomPDF');
        $this->load->model('user', 'User');
        $this->load->model('Pesanan', 'pesanan');
        $this->load->model('BarangMasuk', 'bm');
        $this->load->model('BarangKeluar', 'bk');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        // cek siapa yang login dan ingin masuk ke page admin
    }
    public function admin($getId)
    {
        isAdmin();
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barangmasuk,barangkeluar]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');
        $id = encode_php_tags($getId);
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Laporan';
            $data['cabang'] = $this->User->muatUser($id);
            $this->template->load('admin/HalamanDashboard', 'admin/laporan/HalamanLaporanAdmin', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barangmasuk') {
                $query = $this->bm->muatSemuaBarangMasuk(null, $id, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->bk->muatSemuaBarangKeluar(null, $id, ['mulai' => $mulai, 'akhir' => $akhir]);
            }
            $this->_cetak($query, $table, $tanggal);
        }
    }

    public function cabang()
    {
        isCabang();
        $user_db = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barangmasuk,barangkeluar]', [
            'required' => 'Traksaksi harus diisi'
        ]);
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');
        $id = $user_db['id_user'];
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Laporan';
            $data['cabang'] = $this->User->muatUser($id);
            $this->template->load('cabang/HalamanDashboard', 'cabang/laporan/HalamanLaporanCabang', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barangmasuk') {
                $query = $this->bm->muatSemuaBarangMasuk(null, $id, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->bk->muatSemuaBarangKeluar(null, $id, ['mulai' => $mulai, 'akhir' => $akhir]);
            }
            $this->_cetak($query, $table, $tanggal);
        }
    }


    public function owner($getId)
    {
        isOwner();
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barangmasuk,barangkeluar]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');
        $id = encode_php_tags($getId);
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Laporan';
            $data['cabang'] = $this->User->muatUser($id);
            $this->template->load('owner/HalamanDashboard', 'owner/laporan/HalamanLaporanOwner', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barangmasuk') {
                $query = $this->bm->muatSemuaBarangMasuk(null, $id, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->bk->muatSemuaBarangKeluar(null, $id, ['mulai' => $mulai, 'akhir' => $akhir]);
            }
            $this->_cetak($query, $table, $tanggal);
        }
    }

    public function pesanan($getCabang)
    {
        isAdmin();
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required', [
            'required' => 'Periode tanggal tidak boleh kosong'
        ]);
        $idCabang = encode_php_tags($getCabang);
        $input = $this->input->post(null, true);

        $tanggal = $input['tanggal'];
        $pecah = explode(' - ', $tanggal);
        $mulai = date('Y-m-d', strtotime($pecah[0]));
        $akhir = date('Y-m-d', strtotime(end($pecah)));
        $data = $this->pesanan->muatSemuaPesanan(null, $idCabang, ['mulai' => $mulai, 'akhir' => $akhir]);
        $this->_cetakPesanan($data, $tanggal);
    }

    private function _cetak($data, $table_, $tanggal)
    {

        $table = $table_ == 'barangmasuk' ? 'Barang Masuk' : 'Barang Keluar';

        $pdf = new FPDF();
        $pdf->AddPage('L', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Image('./assets/img/logo-kopao2.png', 10, 8, 17, 15);
        $pdf->Image('./assets/img/2.png', 255, 8, 15, 14);
        $pdf->Cell(260, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(260, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Line(10, 25, 275, 25);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'barangmasuk') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(40, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Tgl Masuk', 1, 0, 'C');
            $pdf->Cell(42, 7, 'Nama Cabang', 1, 0, 'C');
            $pdf->Cell(42, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Masuk', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Kategori', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(40, 7, $d['id_barang_masuk'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['tanggal_masuk'], 1, 0, 'C');
                $pdf->Cell(42, 7, $d['nama_cabang'], 1, 0, 'C');
                $pdf->Cell(42, 7, $d['nama_barang'], 1, 0, 'C');
                $pdf->Cell(30, 7, $d['jumlah_masuk'] . ' ' . $d['satuan'], 1, 0, 'C');
                $pdf->Cell(30, 7, $d['nama_kategori'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['keterangan'], 1, 0, 'L');
                $pdf->Ln();
            }

            $pdf->Ln();
            $pdf->Cell(79);
            $pdf->Cell(259, 7, 'Pekanbaru, ' . date('d F Y'), 0, 1, 'C');
            $pdf->Cell(75);
            $pdf->Cell(270, 7, 'Administrator Pusat,', 0, 1, 'C');
            $pdf->Ln(20);
            $pdf->Cell(75);
            $pdf->SetFont('Times', 'B', 15);
            $pdf->Cell(270, 7, 'Britney', 0, 1, 'C');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(75);
            $pdf->Cell(270, 7, 'NIP. 19601113 198603 1 003,', 0, 1, 'C');

        else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(40, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Tanggal Keluar', 1, 0, 'C');
            $pdf->Cell(47, 7, 'Nama Cabang', 1, 0, 'C');
            $pdf->Cell(42, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Keluar', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Kategori', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(40, 7, $d['id_barang_keluar'], 1, 0, 'C');
                $pdf->Cell(30, 7, $d['tanggal_keluar'], 1, 0, 'C');
                $pdf->Cell(47, 7, $d['nama_cabang'], 1, 0, 'C');
                $pdf->Cell(42, 7, $d['nama_barang'], 1, 0, 'C');
                $pdf->Cell(30, 7, $d['jumlah_keluar'] . ' ' . $d['satuan'], 1, 0, 'C');
                $pdf->Cell(30, 7, $d['nama_kategori'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['keterangan'], 1, 0, 'L');
                $pdf->Ln();
            }
            $pdf->Ln();
            $pdf->Cell(79);
            $pdf->Cell(259, 7, 'Pekanbaru, ' . date('d F Y'), 0, 1, 'C');
            $pdf->Cell(75);
            $pdf->Cell(270, 7, 'Administrator Pusat,', 0, 1, 'C');
            $pdf->Ln(20);
            $pdf->Cell(75);
            $pdf->SetFont('Times', 'B', 15);
            $pdf->Cell(270, 7, 'Britney', 0, 1, 'C');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(75);
            $pdf->Cell(270, 7, 'NIP. 19601113 198603 1 003,', 0, 1, 'C');



        endif;
        ob_end_clean();
        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }
    private function _cetakPesanan($data, $tanggal)
    {
        $pdf = new FPDF();
        $pdf->AddPage('L', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Image('./assets/img/logo-kopao2.png', 10, 8, 17, 15);
        $pdf->Image('./assets/img/2.png', 255, 8, 15, 14);
        $pdf->Cell(260, 7, 'Laporan Pesanan', 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(260, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');

        $pdf->Line(10, 25, 270, 25);
        $pdf->Ln(10);

        $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
        $pdf->Cell(35, 7, 'ID Pesanan', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Tanggal Pesanan', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Nama Cabang', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Jumlah Barang', 1, 0, 'C');
        $pdf->Cell(42, 7, 'Kategori', 1, 0, 'C');


        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 10);

        $no = 1;
        foreach ($data as $d) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
            $pdf->Cell(35, 7, $d['id_pesanan'], 1, 0, 'C');
            $pdf->Cell(40, 7, $d['tanggal_pesanan'], 1, 0, 'C');
            $pdf->Cell(40, 7, $d['nama_cabang'], 1, 0, 'L');
            $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'L');
            $pdf->Cell(35, 7, $d['jumlah_barang'] . ' ' . $d['satuan'], 1, 0, 'C');
            $pdf->Cell(42, 7, $d['nama_kategori'], 1, 0, 'C');

            $pdf->Ln();
        }
        $pdf->Ln();
        $pdf->Cell(79);
        $pdf->Cell(259, 7, 'Pekanbaru, ' . date('d F Y'), 0, 1, 'C');
        $pdf->Cell(75);
        $pdf->Cell(270, 7, 'Administrator Pusat,', 0, 1, 'C');
        $pdf->Ln(20);
        $pdf->Cell(75);
        $pdf->SetFont('Times', 'B', 15);
        $pdf->Cell(270, 7, 'Britney', 0, 1, 'C');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(75);
        $pdf->Cell(270, 7, 'NIP. 19601113 198603 1 003,', 0, 1, 'C');
        ob_end_clean();
        $file_name = 'Laporan Pesanan';
        $pdf->Output('I', $file_name);
    }
}

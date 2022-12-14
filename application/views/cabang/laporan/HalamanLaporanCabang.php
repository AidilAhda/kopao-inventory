<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Laporan <?= $cabang['nama'] ?>
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('HalamanNamaCabang/admin') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <form class="user" method="post" action="<?= base_url('HalamanLaporan/cabang/' . $cabang['id_user']) ?>">
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="transaksi">Laporan Transaksi</label>
                        <div class="col-md-9">
                            <div class="custom-control custom-radio">
                                <input value="barangmasuk" type="radio" id="barangmasuk" name="transaksi" class="custom-control-input">
                                <label class="custom-control-label" for="barangmasuk">Barang Masuk</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input value="barangkeluar" type="radio" id="barangkeluar" name="transaksi" class="custom-control-input">
                                <label class="custom-control-label" for="barangkeluar">Barang Keluar</label>
                            </div>
                            <?= form_error('transaksi', '<span class="text-danger small">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-3 text-lg-right" for="tanggal">Tanggal</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input value="<?= set_value('tanggal'); ?>" name="tanggal" id="tanggal" type="text" class="date form-control" placeholder="Tanggal">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                                </div>
                            </div>
                            <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-9 offset-lg-3">
                            <button type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon">
                                    <i class="fa fa-print"></i>
                                </span>
                                <span class="text">
                                    Cetak
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?= $this->session->flashdata('pesan'); ?>

<div class="card shadow-sm border-bottom-primary">

    <div class="card-header bg-white py-3">

        <div class="row">

            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Pesanan
                </h4>

            </div>
            <div class="col">
            </div>
            <div class="col-auto">
                <a href="<?= base_url('HalamanNamaCabang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    <span class="text">
                        Back
                    </span>
                </a>

            </div>
        </div>
        <div class="row">

            <div class="col">
                <form class="user" method="post" action="<?= base_url('HalamanLaporan/pesanan/' . $cabang['id_user'])  ?>">
                    <div class="row form-group">
                        <label class="col-lg-3 text-lg-right" for="tanggal">Tanggal Pesanan</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input value="<?= set_value('tanggal'); ?>" name="tanggal" id="tgl_pesanan" type="text" class="date form-control" placeholder="Tanggal">
                                <div class="input-group-append">
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
                            <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped dt-responsive nowrap " id="dataTable">
            <thead>
                <tr>

                    <th>ID </th>
                    <th>Tanggal</th>
                    <th>Nama Cabang</th>
                    <th>Barang</th>
                    <th>Kategori Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($pesanan) :
                    foreach ($pesanan as $p) :
                ?>
                        <tr>


                            <td><?= $p['id_pesanan']; ?></td>
                            </td>
                            <td><?= $p['tanggal_pesanan']; ?></td>
                            <td><?= $p['nama_cabang']; ?></td>
                            <td><?= $p['nama_barang']; ?></td>
                            <td><?= $p['nama_kategori']; ?></td>
                            <td><?= $p['jumlah_barang']; ?></td>
                            <td><?= $p['satuan']; ?></td>
                            <td><?= $p['status']; ?></td>
                            <td>
                                <a href=" <?= base_url('Sistem/konfirmasiPesanan/') . $p['id_pesanan'] . '/' . $p['id_user'] ?>" class="btn btn-success btn-circle btn-sm"><i class="fa fa-check"></i></a>
                                <a href=" <?= base_url('Sistem/tolakPesanan/') . $p['id_pesanan'] . '/' . $p['id_user'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
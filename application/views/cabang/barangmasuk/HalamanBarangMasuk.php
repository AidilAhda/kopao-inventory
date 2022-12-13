<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Barang Masuk
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('HalamanEntriBarangMasuk') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Barang masuk
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive " id="dataTable">
            <thead>
                <tr>
                    <th>Nama Cabang</th>
                    <th>Nama Barang</th>
                    <th>Kategori Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($barangmasuk) :
                    foreach ($barangmasuk as $bm) :
                ?>
                        <tr>
                            </td>
                            <td><?= $bm['nama_cabang']; ?></td>
                            <td><?= $bm['nama_barang']; ?></td>
                            <td><?= $bm['nama_kategori']; ?></td>
                            <td><?= $bm['total']; ?></td>
                            <td><?= $bm['satuan']; ?></td>
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
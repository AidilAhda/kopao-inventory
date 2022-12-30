<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Barang Cabang
                </h4>
            </div>
            <?php
            if ($cabang) :

            ?>
                <div class="col-auto">
                    <a href="<?= base_url('HalamanEntriBarangCabangController/simpanBarangCabang/') . $cabang['id_user'] ?>" class="btn btn-sm btn-primary btn-icon-split">
                        <span class="icon">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">
                            Tambah Barang Cabang
                        </span>
                    </a>
                </div>


        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped dt-responsive nowrap " id="dataTable">
            <thead>
                <tr>
                    <th>Nama Cabang</th>
                    <th>Nama Barang</th>
                    <th>Kategori Barang</th>
                    <th>Satuan</th>
            </thead>
            <tbody>
                <?php
                if ($stok) :
                    foreach ($stok as $s) :
                ?>
                        <tr>
                            </td>
                            <td><?= $s['nama_cabang']; ?></td>
                            <td><?= $s['nama_barang']; ?></td>
                            <td><?= $s['nama_kategori']; ?></td>
                            <td><?= $s['satuan']; ?></td>
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
<?php endif; ?>
</div>
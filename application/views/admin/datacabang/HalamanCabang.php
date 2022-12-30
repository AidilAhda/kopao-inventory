<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Data Cabang
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('HalamanEntriCabangController') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Cabang
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped " id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama Cabang</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($cabang) :
                    foreach ($cabang as $c) :
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $c['nama_cabang']; ?></td>
                            <td><?= $c['alamat_cabang']; ?></td>
                            <td>
                                <a href="<?= base_url('HalamanUbahCabangController/edit/') . $c['id_cabang'] ?> " class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('HalamanHapusCabangController/hapusCabang/') . $c['id_cabang'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
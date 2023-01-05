<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm mb-4 border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Data User
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('HalamanEntriUserController') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-user-plus"></i>
                    </span>
                    <span class="text">
                        Tambah User
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped dt-responsive nowrap " id="dataTable">
            <thead>
                <tr>
                    <th width="30">No.</th>

                    <th>Nama</th>
                    <th>Username</th>
                    <th>No. telp</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($akun) :
                    foreach ($akun as $a) :
                ?>
                        <tr>
                            <td><?= $no++; ?></td>

                            <td><?= $a['nama']; ?></td>
                            <td><?= $a['username']; ?></td>
                            <td><?= $a['no_telp']; ?></td>
                            <td><?= $a['role_id']; ?></td>
                            <td>
                                <a href="<?= base_url('HalamanAktivasiUserController/aktifkanUser/') . $a['id_user'] ?>" class="btn btn-circle btn-sm <?= $a['is_active'] ? 'btn-secondary' : 'btn-success' ?>" title="<?= $a['is_active'] ? 'Nonaktifkan User' : 'Aktifkan User' ?>"><i class="fa fa-fw fa-power-off"></i></a>
                                <a href="<?= base_url('HalamanUbahUserController/edit/') . $a['id_user'] ?>" class="btn btn-circle btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin menghapus data?')" href="<?= base_url('HalamanHapusUserController/hapusUser/') . $a['id_user'] ?>" class="btn btn-circle btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="8" class="text-center">Silahkan tambahkan user baru</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
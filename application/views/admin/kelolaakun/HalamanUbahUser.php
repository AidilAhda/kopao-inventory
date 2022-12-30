<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('HalamanPengelolaanAkun') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <form class="user" method="post" action="<?= base_url('HalamanUbahuserController/updateUser/') . $akun['id_user']   ?>">
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="nama">Nama</label>
                        <div class="col-md-9">
                            <input readonly value="<?= set_value('nama', $akun['nama']); ?>" name="nama" id="nama" type="text" class="form-control" placeholder="Nama kategori...">
                            <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="username">Username</label>
                        <div class="col-md-9">
                            <input value="<?= set_value('username', $akun['username']); ?>" name="username" id="username" type="text" class="form-control" placeholder="username ...">
                            <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="no_telp">no telp</label>
                        <div class="col-md-9">
                            <input value="<?= set_value('no_telp', $akun['no_telp']); ?>" name="no_telp" id="no_telp" type="number" class="form-control" placeholder="no_telp ...">
                            <?= form_error('no_telp', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            <?= $profile['nama'] ?>
                        </h4>
                    </div>

                </div>
            </div>
            <div class="card-body">

                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="username">Username</label>
                    <div class="col-md-9">
                        <input readonly value="<?= set_value('username', $profile['username']); ?>" name="username" id="username" type="text" class="form-control" placeholder="Nama Cabang...">
                        <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="nama">Nama</label>
                    <div class="col-md-9">
                        <input readonly value="<?= set_value('nama', $profile['nama']); ?>" name="nama" id="nama" type="text" class="form-control" placeholder="Nama Cabang...">
                        <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="no_telp">No Telp</label>
                    <div class="col-md-9">
                        <input readonly value="<?= set_value('no_telp', $profile['no_telp']); ?>" name="no_telp" id="no_telp" type="text" class="form-control" placeholder="Nama Cabang...">
                        <?= form_error('no_telp', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="created_at">Created At</label>
                    <div class="col-md-9">
                        <input readonly value="<?= set_value('created_at', date('d F Y', $profile['created_at'])); ?>" name="created_at" id="created_at" type="text" class="form-control" placeholder="Nama Cabang...">
                        <?= form_error('created_at', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
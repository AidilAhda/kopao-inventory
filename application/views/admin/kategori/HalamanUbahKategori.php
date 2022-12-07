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
                        <a href="<?= base_url('HalamanKategori') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Back
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <form class="user" method="post" action="<?= base_url('Sistem/updateDataKategori/') . $kategori['id_kategori']   ?>">
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="nama_kategori">Nama Kategori</label>
                        <div class="col-md-9">
                            <input value="<?= set_value('nama_kategori', $kategori['nama_kategori']); ?>" name="nama_kategori" id="nama_kategori" type="text" class="form-control" placeholder="Nama kategori...">
                            <?= form_error('nama_kategori', '<small class="text-danger">', '</small>'); ?>
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
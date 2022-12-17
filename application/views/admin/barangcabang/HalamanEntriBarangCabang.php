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
                        <a href="<?= base_url('HalamanNamaCabang/namaCabang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <form class="user" method="post" action="<?= base_url('Sistem/simpanBarangCabang/' . $cabang['id_user']) ?>">
                    <input value="<?= set_value('id_user', $cabang['id_user']); ?>" name="id_user" id="id_user" type="hidden" class="form-control" placeholder="Nama Cabang...">
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="nama_cabang">Nama Cabang</label>
                        <div class="col-md-9">
                            <input readonly value="<?= set_value('nama_cabang', $cabang['nama']); ?>" name="nama_cabang" id="nama_cabang" type="text" class="form-control" placeholder="Nama Cabang...">
                            <?= form_error('nama_cabang', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="nama_barang">Nama Barang</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="nama_barang" id="nama_barang" class="custom-select">
                                    <option value="" selected disabled>Pilih Nama Barang</option>
                                    <?php foreach ($barang as $b) : ?>
                                        <option <?= set_select('nama_barang', $b['nama_barang']) ?> value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?= form_error('nama_barang', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="id_kategori">Kategori Barang</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="id_kategori" id="id_kategori" class="custom-select">
                                    <option value="" selected disabled>Pilih Jenis Barang</option>
                                    <?php foreach ($kategori as $k) : ?>
                                        <option <?= set_select('id_kategori', $k['id_kategori']) ?> value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <?= form_error('id_kategori', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="satuan">Satuan Barang</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="satuan" id="satuan" class="custom-select">
                                    <option value="" selected disabled>Pilih Satuan Barang</option>
                                    <option value="Kilogram">Kilogram</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Lusin">Lusin</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Botol">Botol</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Liter">Liter</option>
                                </select>

                            </div>
                            <?= form_error('satuan', '<small class="text-danger">', '</small>'); ?>
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
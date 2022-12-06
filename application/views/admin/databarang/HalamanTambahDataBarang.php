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
                        <a href="<?= base_url('HalamanDataBarang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <form class="user" method="post" action="<?= base_url('HalamanTambahDataBarang') ?>">
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="id_barang">ID Barang</label>
                        <div class="col-md-9">
                            <input readonly value="<?= set_value('id_barang'); ?>" name="id_barang" id="id_barang" type="text" class="form-control" placeholder="ID Barang...">
                            <?= form_error('id_barang', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="nama_barang">Nama Barang</label>
                        <div class="col-md-9">
                            <input value="<?= set_value('nama_barang'); ?>" name="nama_barang" id="nama_barang" type="text" class="form-control" placeholder="Nama Barang...">
                            <?= form_error('nama_barang', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="jenis_id">Jenis Barang</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="jenis_id" id="jenis_id" class="custom-select">
                                    <option value="" selected disabled>Pilih Jenis Barang</option>
                                    <?php foreach ($jenis as $j) : ?>
                                        <option <?= set_select('jenis_id', $j['id_jenis']) ?> value="<?= $j['id_jenis'] ?>"><?= $j['nama_jenis'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <a class="btn btn-primary" href="<?= base_url('HalamanTambahKategori'); ?>"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <?= form_error('jenis_id', '<small class="text-danger">', '</small>'); ?>
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
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-secondary">Reset</bu>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
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
                        <a href="<?= base_url('HalamanBarang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <form class="user" method="post" action="<?= base_url('Sistem/updateBarang/') . $barang['id_barang'] ?>/">

                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="nama_barang">Nama Barang</label>
                        <div class="col-md-9">
                            <input value="<?= set_value('nama_barang', $barang['nama_barang']); ?>" name="nama_barang" id="nama_barang" type="text" class="form-control" placeholder="Nama Barang...">
                            <?= form_error('nama_barang', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="id_kategori">Jenis Barang</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="id_kategori" id="id_kategori" class="custom-select">
                                    <option value="" selected disabled>Pilih Jenis Barang</option>
                                    <?php foreach ($kategori as $k) : ?>
                                        <option <?= set_select('id_kategori', $k['id_kategori']) ?> value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <a class="btn btn-primary" href="<?= base_url('HalamanTambahKategori'); ?>"><i class="fa fa-plus"></i></a>
                                </div>
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
                            <button type="reset" class="btn btn-secondary">Reset</bu>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Barang Cabang
                </h4>
            </div>

        </div>

        <?php

        $no = 1;
        if ($cabang) :
            foreach ($cabang as $c) :
        ?>
                <div class="row">
                    <div class="col">
                        <div class="card-body ">
                            <div class="row no-gutters align-items-center bg-warning ">
                                <div class="col mr-2 bg-warning w-15 p-3">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 d-flex flex-row">
                                        <a href="<?= base_url('HalamanBarangCabang/barangCabang/') . $c['id_user'] ?> " style="text-decoration:none;color:black;font-size:18px;font-family:sans-serif">
                                            <img src="<?= base_url('assets/img/logo-kopao2.png') ?>" style="width: 93px;">
                                            <?= $no++ ?>.
                                            <?= $c['nama'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</div>
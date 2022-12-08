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
                <a href="<?= base_url('HalamanEntriCabang') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Cabang
                    </span>
                </a>
            </div>
        </div>

        <?php


        if ($cabang) :
            foreach ($cabang as $c) :

        ?>
                <div class="row">
                    <div class="col">
                        <div class="card-body ">
                            <div class="row no-gutters align-items-center bg-warning ">
                                <div class="col mr-2 bg-warning w-15 p-3">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 d-flex flex-row">
                                        <a href="<?= base_url('HalamanUbahCabang/edit/') . $c['id_cabang'] ?> " style="text-decoration:none;color:black;font-size:18px;font-family:sans-serif">
                                            <img src="<?= base_url('assets/img/logo-kopao2.png') ?>" style="width: 93px;">
                                            <?= $c['nama_cabang'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <?php
            $no = 1;

            if ($cabang) :
                foreach ($cabang as $c) :
                    if ($c['id_cabang'] % 2 == 0) :
            ?>


                    <?php endif; ?>

                <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>

</div>

</div>
<style>
    .cabang {
        cursor: pointer;
        margin-bottom: 23px;
        background-color: #D4A550;
        width: 333px;
        height: 133px;
    }

    .cabang span {
        font-size: 15px;
        color: black;
        margin-top: 45px;

    }

    .nama {
        color: black;
        font-size: 45px;
        font-weight: bold;
        font-family: sans-serif;
    }
</style>
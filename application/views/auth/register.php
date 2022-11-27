<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">

                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <?= $this->session->flashdata('pesan'); ?>
                        <form class="user" method="post" action="<?= base_url('auth/tambahUser') ?>">

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" placeholder="Username" name="username" id="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" placeholder="Nama" name="name" id="name">
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control form-control-user" placeholder="Email">
                                        <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" name="no_telp" class="form-control form-control-user" placeholder="Telepon">
                                        <?= form_error('no_telp', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class=" btn btn-primary btn-user btn-block">
                                Register Account
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
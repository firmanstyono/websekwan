<?= $this->section('content') ?>
<?= $this->extend('backend/' . $folder . '/' . 'script') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box ">

        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="card m-b-20">

                <div class="card-header font-18 bg-light">
                    <h6 class="modal-title mt-0">
                        <i class="mdi mdi-palette"></i> Pilih Jenis Template
                    </h6>
                </div>

                <div class="card-body">
                    <br>
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="card bg-danger mini-stat position-relative shadow-lg">
                                <div class="card-body p-2">
                                    <a class="mini-stat-desc" href="template/front" title="Kelola template">
                                        <h6 class="text-uppercase verti-label text-white-50">Tema</h6>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mt-0 text-white-50">Template Website</h6>
                                            <h3 class="mb-3 mt-0"> <?= $jtemafront ?></h3>
                                            <div class="">
                                                <span class="">Template yang tersedia</span>
                                            </div>
                                        </div>
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-checkbox-multiple-blank-circle-outline display-1"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card bg-info mini-stat position-relative shadow-lg">
                                <div class="card-body p-2">
                                    <a class="mini-stat-desc" href="template/back" title="Kelola template dashboard admin">
                                        <h6 class="text-uppercase verti-label text-white-50">Tema</h6>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mt-0 text-white-50">Template Dashboard Admin</h6>
                                            <h3 class="mb-3 mt-0"> <?= $jtemaback ?></h3>
                                            <div class="">
                                                <span class="">Template yang tersedia</span>
                                            </div>
                                        </div>
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-checkbox-multiple-blank-circle-outline display-1"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>


<?= $this->endSection() ?>
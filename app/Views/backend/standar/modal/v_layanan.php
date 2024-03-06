<?php

use App\Models\ModelTemplate;

$this->template = new ModelTemplate();

$template = $this->template->tempaktif();
?>
<div class="modal fade" id="modalview">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- <div class="card-header ">
                <h6 class="modal-title mt-0"><?= $title  ?>

                </h6>
            </div> -->
            <div class="modal-header">
                <h5 class="modal-title"><?= $title ?></h5>
                <?php if ($template['verbost'] == 0) { ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <?php } else { ?>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <?php } ?>
            </div>
            <div class="modal-body">
                <!-- <div class="form-group row"> -->
                <img id='img_load' width='100%' src='<?= base_url('public/img/informasi/layanan/' . $gambar) ?>'>
                <!-- </div> -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <tbody>
                            <tr>
                                <td colspan="2"><strong><?= $nama ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"><?= $isi_informasi ?></td>
                            </tr>
                            <?php if ($fileunduh != '') { ?>
                                <tr>
                                    <td colspan="2" class="text-center p-1">
                                        <a href="<?= base_url('public/unduh/layanan/'  . $fileunduh) ?>" target="_blank" class="ml-3 btn btn-success" type="button">Download File</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="p-1 mb-1">
                <?php if ($template['verbost'] == 0) { ?>
                    <a class="ml-3 btn btn-danger" type="button" data-dismiss="modal">Tutup</a>
                <?php } else { ?>
                    <a class="ml-3 btn btn-danger" data-bs-dismiss="modal">Tutup</a>
                <?php } ?>
            </p>
        </div>
    </div>

</div>
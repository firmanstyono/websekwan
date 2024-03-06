<?php

use App\Models\ModelTemplate;

$this->template = new ModelTemplate();

$template = $this->template->tempaktif();
?>
<div class="modal fade" id="modalview">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $judul  ?>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </h6>
            </div>
            <div class="modal-body">
                <!-- <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" /> -->

                <!-- <div class="form-group row"> -->
                <img width='100%' src='<?= base_url('public/img/galeri/foto/' . $gambar) ?>'>
                <!-- </div> -->
                <table class="table table-bordered table-hover table-striped">
                    <tbody>
                        <tr>
                            <td colspan="2"><strong><?= $kategorifoto ?> | <?= $judul ?></strong></td>
                        </tr>
                    </tbody>
                </table>
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
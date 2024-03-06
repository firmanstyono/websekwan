<?php

use App\Models\ModelTemplate;

$this->template = new ModelTemplate();

$template = $this->template->tempaktif();
?>
<div class="modal fade" id="modalview">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <!-- <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $ket ?>
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

                <img width='100%' src='<?= base_url('public/img/informasi/infografis/' . $banner) ?>'>

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
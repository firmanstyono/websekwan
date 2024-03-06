<!-- =======================================================
      * CMS DATAGOE
      * Content Management System.
      *
      * @author			Vian Taum <viantaum17@gmail.com>
      * @website		www.datagoe.com
      * @copyright		(c) 2023 - Datagoe Software
 ======================================================== -->

<?php
$folder = $konfigurasi['folder'];

if ($folder == 'plus1' || $folder == 'plus2' || $folder == 'desaku') { ?>
    <style>
        ol {
            padding: 20px;
        }

        ul {
            list-style-type: disc;
            margin-left: 10px;
        }

        ol li {
            list-style-type: number;
            margin-left: 15px;
        }

        ul li {
            /* list-style-type: square; */
            /* margin-left: 15px; */
            list-style-type: disc;
            margin-left: 10px;
        }
    </style>
<?php } ?>

<div class="modal fade" id="modalview" tabindex="-1" aria-labelledby="modalviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalviewLabel"><?= $list['judultawaran'] ?></h6>
            </div>
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />

            <div class="modal-body">
                <?php

                if (file_exists('public/img/informasi/' . $list['gbrtawaran'])) {
                    $gbr = base_url('public/img/informasi/' . $list['gbrtawaran']);
                } else {
                    $gbr = base_url('public/img/konfigurasi/pimpinan/default.png');
                }

                ?>
                <center>
                    <img class="img-fluid" src="<?= $gbr ?>" alt="">
                </center>
                <?= $list['isitawaran'] ?>
            </div>

            <div class="modal-footer p-1">
                <?php if ($list['sts_tombol'] != 0) { ?>
                    <a class="btn btn-info" href="<?= $list['linktawaran'] ?>" style="padding: 5px;"><?= $list['namatombol'] ?></a>
                <?php  } ?>
                <?php if ($konfigurasi['verbost'] == 0) { ?>
                    <a class="btn btn-danger text-light" style="padding: 5px;" data-dismiss="modal" onclick="nonaktifpenawaran()">Jangan Tampilkan lagi</a>

                <?php } else { ?>
                    <a class="btn btn-danger text-light" style="padding: 5px;" data-bs-dismiss="modal" onclick="nonaktifpenawaran()">Jangan Tampilkan lagi</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    function nonaktifpenawaran() {
        $.ajax({
            url: "<?= site_url('home/nonaktiftawaran') ?>",
            dataType: "json",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
            },
            success: function(response) {
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            },
            // error: function(xhr, ajaxOptions, thrownerror) {
            //     alert(xhr.status + "\n" + xhr.responseText + "\n" +
            //         thrownerror);
            // }
        });
    }
</script>
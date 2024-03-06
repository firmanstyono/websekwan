<?= $this->section('content') ?>
<?= $this->extend('backend/' . $folder . '/' . 'script'); ?>

<div id="formsub">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box ">

            </div>
        </div>
    </div>

    <div class="page-content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">

                    <div class="card-header font-18 bg-light">
                        <h6 class="modal-title mt-0">
                            <i class="fas fa-align-center"></i> DETAIL
                            <input type="hidden" name="kathukum_id" value="<?= $kathukum_id ?>" id="kathukum_id" name="kathukum_id">
                            <!-- <div class="float-right">
                                <button type="button" class="btn btn-block btn-primary btn-sm tambah"><i class="fas fa fa-plus-circle"></i> TAMBAH DATA</button>
                            </div> -->
                            <?php
                            if ($list) {
                                foreach ($list as $data) :
                                endforeach
                            ?>

                                <a class="text-info"><?= $data['nama_kathukum'] ?></a>
                            <?php } ?>

                        </h6>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="viewdata"></div>
                    </div>
                    <div class="viewmodal"></div>
                    <!-- /.card-body -->
                </div>

            </div>

        </div>

    </div>
</div>
<script>
    function listsubsubproduk() {

        subproduk = $("#kathukum_id").val();
        // alert(subproduk)
        $.ajax({

            url: "<?= site_url('produkhukum/subsubprodukajx') ?>",
            data: {
                subproduk: subproduk,
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                });

            }
        });
    }

    $(document).ready(function() {
        listsubsubproduk();

    });
</script>
<?= $this->endSection() ?>
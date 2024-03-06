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
        <div class="col-12">
            <div class="card m-b-20">

                <div class="card-header font-18 bg-light">
                    <h6 class="modal-title mt-0">
                        <i class="far fa-clone"></i> <?= $subtitle ?>

                    </h6>
                    <input type="hidden" class="form-control" id="req" value="<?= $reqs ?>" name="req" readonly>
                    <input type="hidden" class="form-control" id="jns" value="<?= $jns ?>" name="jns" readonly>

                </div>
                <div class="card-body">
                    <div class="viewdata"></div>
                </div>
                <div class="viewmodal"></div>

            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>

<script>
    function listmaster() {
        req = $("#req").val();
        jns = $("#jns").val();
        $.ajax({
            url: "<?= site_url('masterdata/getdata') ?>",
            data: {
                req: req,
                jns: jns,
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);

                if (response.noakses) {

                    Swal.fire({
                        title: "Gagal Akses!",
                        html: `Anda tidak berhak mengakses <strong>Modul ini</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '<?= base_url('/') ?>';
                    })
                }
                if (response.blmakses) {

                    Swal.fire({
                        title: "Maaf gagal load Modul!",
                        html: `Modul ini belum atau tidak didaftarkan `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '<?= base_url('/') ?>';
                    })
                }
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
        listmaster();
    });
</script>



<?= $this->endSection() ?>
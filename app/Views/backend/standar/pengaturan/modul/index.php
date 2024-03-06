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
                        <i class="mdi mdi-compare"></i> GRUP MENU <?= strtoupper($gm) ?>
                    </h6>
                    <input type="hidden" id="gm" name="gm" value="<?= $gm ?>" class="form-control form-control-sm">
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
    function listmodul() {
        gm = $("#gm").val();
        $.ajax({
            type: "post",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                type: "post",
                gm: gm,
            },
            url: "<?= site_url('modul/getdata') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                if (response.noakses) {

                    Swal.fire({
                        title: "Gagal Akses!",
                        html: `Anda tidak berhak mengakses <strong>Modul ini</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = './';
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
                        window.location = './dashboard';
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
        listmodul();
    });
</script>

<?= $this->endSection() ?>
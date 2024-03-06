<?= $this->extend('backend/' . $folder . '/' . 'script'); ?>

<?= $this->section('content') ?>
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
                        <i class="far fa-clone"></i> Pengaturan Sub Menu <a class="text-primary"> <b><?= $submenu ?></b></a>
                    </h6>
                    <input type="hidden" name="submenu_id" value="<?= $submenu_id ?>" id="submenu_id" name="submenu_id">

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
    function listsubsubmenu() {
        submenu_id = $("#submenu_id").val();

        $.ajax({
            type: "post",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                submenu_id: submenu_id,
            },
            url: "<?= site_url('menu/getsubsubmenu') ?>",
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
                        window.location = '../dashboard';
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
        listsubsubmenu();

    });
</script>


<?= $this->endSection() ?>
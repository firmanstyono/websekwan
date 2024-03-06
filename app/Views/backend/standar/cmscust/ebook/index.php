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
                        <i class="fas fa-book"></i> <?= $subtitle ?>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="viewdata"></div>
                </div>

                <div class="viewmodal"></div>

            </div>

        </div>

    </div>

    <script>
        function listebook() {
            $.ajax({
                url: "<?= site_url('ebook/getdata') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.noakses) {

                        Swal.fire({
                            title: "Gagal Akses!",
                            html: `Anda tidak berhak mengakses <strong>Modul ini</strong> `,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3100
                        }).then(function() {
                            window.location = '../';
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

                    $('.viewdata').html(response.data);
                    $(kembali).hide();
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
            listebook();

        });
    </script>

    <?= $this->endSection() ?>
<?= $this->extend('backend/' . $folder . '/' . 'template-backend');
$this->extend('backend/' . $folder . '/' . 'menu');

$this->section('script') ?>

<script>
    // let csrfToken = '<?= csrf_token() ?>';
    // let csrfHash = '<?= csrf_hash() ?>';

    $('a#logout').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin ingin keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('login/logout') ?>",
                    type: 'post',
                    data: {
                        // [csrfToken]: csrfHash,
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                    },
                    dataType: 'json',
                    success: function(response) {

                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe); //dataSrc untuk random request token char (wajib)
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Anda berhasil keluar!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1250
                        }).then(function() {
                            window.location = '<?= base_url('') ?>';
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        Swal.fire({
                            title: "Maaf gagal logout!",
                            html: `Token terdeteksi <strong>tidak valid</strong> `,
                            icon: "error",
                            // showConfirmButton: false,
                            // timer: 3100
                        }).then(function() {
                            window.location = '<?= base_url('dashboard') ?>';
                        });

                    }
                });
            }
        })
    })
</script>

<?= $this->endSection('script') ?>
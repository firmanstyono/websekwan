<a href="<?= base_url('bukutamu/list') ?>" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>
<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahbidang">
        <i class="fas fa fa-plus-circle"></i> Tambah Bidang Baru
    </button>
<?php } ?>
<hr>
<div class="table-responsive b-0 ">
    <table id="listbidang" class="table table-hover table-striped table-bordered">
        <thead class="">
            <tr>
                <th width="40" class="p-1 text-center"><b>#</b></th>
                <th class="p-1"><b>Bidang</b></th>
                <th width="60" class="p-1 text-center"><b>Aksi</b></th>
            </tr>
        </thead>

        <tbody>

            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>

                    <td class="p-1"><?= esc($data['nama_bidang']) ?></td>

                    <td class="text-center p-1">

                        <?php if ($ubah == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['bidang_id'] ?>')">
                                <i class="icon fas fa-edit text-info"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>
                        <?php if ($hapus == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['bidang_id'] ?>')">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="far fa-trash-alt text-secondary"></i>
                            </button>
                        <?php } ?>
                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>

        <tfoot>
            <tr>
                <th class="text-center p-1"><b>#<b></th>

                <th class="p-1"><b>Bidang</b></th>
                <!-- <th><b>Link</b></th> -->
                <th class="text-center p-1"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>

</div>
<script>
    $(document).ready(function() {
        $('#listbidang').DataTable({
            'ordering': false,
        });

        $('.tambahbidang').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('bukutamu/formbidang') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambah').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modaltambah').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal load data!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
        });
    });

    function edit(bidang_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('bukutamu/formeditbidang') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                bidang_id: bidang_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modaledit').modal('show');
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function hapus(bidang_id) {
        Swal.fire({
            width: '400px',

            title: 'Hapus data?',
            text: `Apakah anda yakin hapus data?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('bukutamu/hapusbidang') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        bidang_id: bidang_id
                    },

                    success: function(response) {
                        if (response.sukses) {

                            toastr["success"](response.sukses)
                            toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                },
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            listbidang();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        Swal.fire({
                            title: "Maaf gagal hapus data!",
                            html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3100
                        }).then(function() {
                            window.location = '';
                        })
                    }
                });
            }
        })
    }
</script>
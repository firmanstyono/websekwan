<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahpoling">
        <i class="fas fa fa-plus-circle"></i> Tambah Jawaban Baru
    </button>
<?php } ?>
<small class="text-secondary"> Untuk <strong class="text-danger">Tutup Polling/Jajak Pendapat </strong> silahkan Non aktifkan pada pertanyaan..! </small>
<hr>
<div class="table-responsive p-0 ">
    <table id="listpoling" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <!-- <th width="40" class="text-center"><b>#</b></th> -->
                <th><b>Pilihan</b></th>
                <th width="80"><b>Jenis</b></th>
                <th class="text-center"><b>Status</b></th>
                <th width="90" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>

        <tbody>

            <?php $nomor = 0;

            foreach ($list as $data) :
                $prosentase = sprintf("%2.1f", (($data['rating'] / $jumpol) * 100));
                $nomor++; ?>
                <tr>

                    <td>
                        <?= esc($data['pilihan']) ?>
                        <?php if ($data['type'] == 'Jawaban') { ?>
                            <strong><a class="text-danger font-size-13">(<?= esc($data['rating']) ?>)</a></strong>
                            <div class="progress p-0" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar p-0" role="progressbar" style="width: <?= $prosentase ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?= $prosentase ?>%</div>
                            </div>
                        <?php } else { ?>
                            <strong><a class="text-success font-size-13" title="Total Responden">(<?= esc($jumpol) ?>)</a></strong>
                        <?php } ?>
                    </td>
                    <td><?= esc($data['type']) ?></td>
                    <td class="text-center p-0">

                        <?php if ($data['status'] == 'Y') { ?>
                            <h6>
                                <span class="badge badge-success">Aktif</span>
                            </h6>
                        <?php } else { ?>
                            <h6>
                                <span class="badge badge-danger">Tidak Aktif</span>
                            </h6>
                        <?php } ?>
                    </td>

                    <td class="text-center p-0">
                        <?php if ($ubah == 1) { ?>
                            <?php if ($data['status'] == 'Y') { ?>
                                <button type="button" onclick="toggle('<?= $data['poling_id'] ?>')" class="btn btn-circle btn-sm <?= $data['status'] ? 'btn-light text-secondary' : 'btn-success' ?>" title="<?= $data['status'] ? 'Nonaktifkan' : 'Aktifkan' ?>"><i class="fas fa-eye-slash"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $data['poling_id'] ?>')" class="btn btn-circle btn-sm <?= $data['status'] ? 'btn-light text-success' : 'btn-success' ?>" title="<?= $data['status'] ? 'Aktifkan' : 'Nonaktifkan' ?>"><i class="fas fa-eye"></i>
                                </button>
                            <?php } ?>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-eye text-secondary"></i>
                            </button>
                        <?php } ?>
                        <?php if ($ubah == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm" onclick="edit('<?= $data['poling_id'] ?>')">
                                <i class="icon fas fa-edit text-primary"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>
                        <?php if ($hapus == 1) { ?>
                            <?php if ($data['type'] == 'Jawaban') { ?>
                                <button type="button" class="btn btn-light btn-sm" onclick="hapus('<?= $data['poling_id'] ?>')">
                                    <i class="far fa-trash-alt text-danger"></i>
                                </button>
                            <?php } ?>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon far fa-trash-alt text-secondary"></i>
                            </button>
                        <?php } ?>

                    </td>

                </tr>
            <?php endforeach; ?>


        </tbody>

        <tfoot>

            <tr>
                <th><b>Pilihan</b></th>
                <th><b>Jenis</b></th>
                <th class="text-center"><b>Status</b></th>

                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $(document).ready(function() {

        $('.tambahpoling').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('poling/formtambah') ?>",
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


        var table = $('#listpoling').DataTable({
            "lengthChange": false,
            "ordering": false,
            "paging": false,
            "info": false,
            "searching": false,
            // "pagingType": "numbers",
        });
    });

    function edit(poling_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('poling/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                poling_id: poling_id
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

    function hapus(poling_id) {
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
                    url: "<?= site_url('poling/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        poling_id: poling_id
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
                            listpoling();
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

    //aktifnonaktif

    function toggle(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('poling/toggle') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    listpoling();
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
</script>
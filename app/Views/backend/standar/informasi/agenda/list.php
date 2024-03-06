<?= form_open('agenda/hapusall', ['class' => 'formhapus']) ?>
<?php if ($tambah == 1) { ?>
    <button type="button" class="btn btn-primary btn-sm tambahagenda">
        <i class="fas fa fa-plus-circle"></i> Tambah Data
    </button>
<?php } ?>
<?php if ($hapus == 1) { ?>
    <button type="submit" class="btn btn-danger btn-sm tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang diceklist
    </button>
<?php } ?>
<hr>
<div class="table-responsive b-0 ">
    <table id="listagenda" class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th width="5">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th>Tema</th>
                <th>Tempat</th>
                <th width="40" class="text-center">Cover</th>
                <th width="50" class="text-center">Aksi </th>

            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($list as $data) :
                $hriini = date("Y-m-d");

            ?>
                <tr>
                    <td>
                        <input type="checkbox" name="agenda_id[]" class="centang_id" value="<?= $data['agenda_id'] ?>">
                    </td>
                    <td>
                        <?php if ($hriini <= $data['tgl_mulai'] and $hriini <= $data['tgl_selesai']) { ?>
                            <a><i class="fas fa-calendar-check text-warning" title="Belum / Sedang berlangsung"></i>
                            </a>
                            <?= esc($data['tema']) ?>
                            <br>
                            <i class="fab fa-algolia text-warning" title="Belum / Sedang berlangsung"></i> Mulai : <?= mediumdate_indo($data['tgl_mulai']) ?> Sampai : <?= mediumdate_indo($data['tgl_selesai']) ?> Jam : <small><?= esc($data['jam']) ?> </small>

                        <?php } else { ?>
                            <a><i class="fas fa-calendar-check text-success" title="Sudah Terlaksana"></i>
                            </a>
                            <?= esc($data['tema']) ?>
                            <br>
                            <i class="fab fa-algolia text-success" title="Sudah terlaksana"></i> Mulai : <i><?= mediumdate_indo($data['tgl_mulai']) ?> </i> Sampai : <i><?= mediumdate_indo($data['tgl_selesai']) ?></i> Jam : <small><?= esc($data['jam']) ?> </small>
                        <?php  } ?>

                    </td>
                    <td><?= esc($data['tempat']) ?></td>

                    <td class="text-center p-0">
                        <?php if ($data['gambar'] == 'default.png') { ?>
                            <span class="badge badge-info pointer" style="font-size:12px" onclick="gantifoto(' <?= $data['agenda_id'] ?> ')" title="Tambahkan Cover">No Cover </span>
                        <?php } else { ?>
                            <img class="img-circle elevation-2 pointer" title="Ganti Gambar" onclick="gantifoto('<?= $data['agenda_id'] ?>')" src="<?= base_url('public/img/informasi/agenda/' . $data['gambar']) ?>" height="100%" width="55px">
                        <?php } ?>
                    </td>
                    <td class="text-center p-0">



                        <?php if ($ubah == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['agenda_id'] ?>')">
                                <i class="fa fa-edit text-primary"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>
                        <?php if ($hapus == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['agenda_id'] ?>','<?= $data['tema'] ?>')">
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
                <th>
                    <input type="checkbox" class="text-center" disabled>
                </th>
                <th>Tema</th>
                <th>Tempat</th>
                <th class="text-center">Cover</th>
                <th class="text-center">Aksi </th>
            </tr>
        </tfoot>
    </table>
</div>

<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#listagenda').DataTable({
            'ordering': false,
        });

        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centang_id').prop('checked', true);
            } else {
                $('.centang_id').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centang_id:checked');
            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: 'Silahkan pilih data!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                Swal.fire({
                    title: `Apakah anda yakin menghapus ${jmldata.length} data ini?`,
                    text: 'Semua data yang terpilih akan terhapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json",
                            beforeSend: function() {
                                $('.tblhapus').attr('disable', 'disable');
                                $('.tblhapus').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                            },
                            complete: function() {
                                $('.tblhapus').removeAttr('disable', 'disable');
                                $('.tblhapus').html('<i class="far fa-trash-alt text-light"></i>  Hapus yang diceklist');
                            },
                            success: function(response) {
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
                                    toastr["success"](response.sukses)
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                                listagenda();
                            },
                            error: function(xhr, ajaxOptions, thrownerror) {
                                toastr["error"]("Maaf gagal hapus Kode Error:  " + (xhr.status + "\n"), )
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            }
                        });
                    }
                })
            }
        });
    });

    function edit(agenda_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('agenda/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                agenda_id: agenda_id

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
                    text: "Silahkan Cek kembali Kode Error:  " + (xhr.status + "\n"),
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function hapus(agenda_id, tema) {
        Swal.fire({

            html: `Apakah anda yakin menghapus <strong>${tema}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('agenda/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        agenda_id: agenda_id
                    },
                    success: function(response) {
                        if (response.sukses) {
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
                                toastr["success"](response.sukses)
                            $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            listagenda();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        toastr["error"]("Maaf gagal hapus Kode Error:  " + (xhr.status + "\n"), )
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    }
                });
            }
        })
    }

    //tambah data
    $(document).ready(function() {

        $('.tambahagenda').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('agenda/formtambah') ?>",
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
                        timer: 2100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
        });
    });

    function gantifoto(agenda_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('agenda/formgantifoto') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                agenda_id: agenda_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalupload').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalupload').modal('show');
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
</script>
<?= form_open('kritiksaran/hapusall', ['class' => 'formhapus']) ?>
<?php if ($hapus == 1) { ?>
    <button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>
    <hr>
<?php } ?>
<div class="table-responsive b-0 ">
    <table id="listkritiksaran" class="table table-hover table-striped table-bordered">

        <thead>
            <tr>
                <th width="2">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>

                <th width="140"><b>NAMA</b></th>
                <th><b>ISI PESAN</b></th>
                <th width="100"><b>TGL PESAN</b></th>
                <th width="100"><b>TOPIK</b></th>
                <th width="80" class="text-center"><b>AKSI</b> </th>

            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $value) :
                $nomor++; ?>
                <tr>
                    <td class="p-1 text-center">
                        <input type="checkbox" name="kritiksaran_id[]" class="centangid" value="<?= $value['kritiksaran_id'] ?>">
                    </td>

                    <td class="p-1">
                        <?php if ($ubah == 1) { ?>
                            <?php if ($value['status'] == '1') { ?>

                                <?php if ($value['status'] == '2') { ?>
                                <?php } elseif ($value['status'] == '1') { ?>
                                    <a class="pointer" onclick="toggle('<?= $value['kritiksaran_id'] ?>')" class="btn btn-circle btn-sm <?= $value['status'] ? 'btn-success' : 'btn-success' ?>" title="<?= $value['status'] ? 'Tampilkan Pesan ini' : '' ?>"><i class="fas fa-eye text-primary"></i>
                                    </a>
                                <?php } ?>

                                <?= esc($value['nama']) ?>


                            <?php } elseif ($value['status'] == '0') { ?>

                                <a><i class="mdi mdi-message-settings-variant text-warning font-18 p-0" title="<?= $value['judul'] ?>"></i></a>
                                <b><?= esc($value['nama']) ?></b>

                            <?php } else { ?>

                                <a class="pointer" onclick="toggle('<?= $value['kritiksaran_id'] ?>')" class="btn btn-circle btn-sm <?= $value['status'] ? 'btn-danger' : 'btn-success' ?>" title="<?= $value['status'] ? 'Jangan Tampilkan' : 'Aktifkan' ?>"><i class="fas fa-eye-slash text-danger"></i>
                                </a>
                                <?= esc($value['nama']) ?>
                            <?php } ?>

                        <?php } else { ?>
                            <?php if ($value['status'] == '1') { ?>

                                <?php if ($value['status'] == '2') { ?>
                                <?php } elseif ($value['status'] == '1') { ?>
                                    <a class="pointer" class="btn btn-circle btn-sm <?= $value['status'] ? 'btn-success' : 'btn-success' ?>" title="<?= $value['status'] ? 'Tidak Tampil di Suara Anda' : 'Sembunyikan' ?>"><i class="fas fa-eye text-info"></i>
                                    </a>
                                <?php } ?>
                                <?= esc($value['nama']) ?>


                            <?php } elseif ($value['status'] == '0') { ?>

                                <a><i class="mdi mdi-message-settings-variant text-warning font-18 p-0" title="<?= $value['judul'] ?>"></i></a>
                                <b><?= esc($value['nama']) ?></b>

                            <?php } else { ?>

                                <a class="pointer" class="btn btn-circle btn-sm <?= $value['status'] ? 'btn-danger' : 'btn-success' ?>" title="<?= $value['status'] ? 'Telah Tampil di Suara Anda' : 'Aktifkan' ?>"><i class="fas fa-eye-slash text-secondary"></i>
                                </a>
                                <?= esc($value['nama']) ?>
                            <?php } ?>

                        <?php } ?>
                    </td>
                    <td class="p-1">
                        <?php if ($value['status'] == '0') { ?>
                            <b><?= esc($value['isi_kritik']) ?></b>
                        <?php } else { ?>
                            <?= esc($value['isi_kritik']) ?>

                        <?php } ?>
                    </td>

                    <td class="p-1">
                        <?php if ($value['status'] == '0') { ?>
                            <b> <?= date_indo($value['tanggal']) ?></b>
                        <?php } else { ?>
                            <?= date_indo($value['tanggal']) ?>
                        <?php } ?>

                    </td>

                    <td class="p-1">
                        <?php if ($value['status'] == '0') { ?>
                            <b>
                                <?= esc($value['judul']) ?>
                            </b>
                        <?php } else { ?>
                            <?= esc($value['judul']) ?>
                        <?php } ?>
                    </td>

                    <td class="text-center p-1">

                        <?php if ($ubah == 1) { ?>
                            <?php if ($value['status'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $value['kritiksaran_id'] ?>')" class="btn btn-circle btn-sm p-1 btn-light" title="Telah ditanggapi"><i class="fas fa-check-circle text-info font-14"></i>
                                </button>
                            <?php } else if ($value['status'] == '2') { ?>
                                <button type="button" onclick="toggle('<?= $value['kritiksaran_id'] ?>')" class="btn btn-circle btn-sm p-1 btn-light" title="Telah ditanggapi dan ditampilkan"><i class="far fa-check-circle font-14 text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-circle btn-sm p-1 btn-light" title="Belum ditanggapi"><i class="fas fa-arrow-circle-right font-14 text-warning"></i>
                                </button>
                            <?php } ?>

                        <?php } else { ?>
                            <?php if ($value['status'] == '1') { ?>
                                <button type="button" class="btn btn-circle btn-sm p-1 btn-light" title="Telah ditanggapi"><i class="fas fa-check-circle font-14 text-info"></i>
                                </button>
                            <?php } else if ($value['status'] == '2') { ?>
                                <button type="button" class="btn btn-circle btn-sm p-1 btn-light" title="Telah ditanggapi dan ditampilkan"><i class="far fa-check-circle font-14 text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-circle btn-sm p-1 btn-light" title="Belum ditanggapi"><i class="fas fa-arrow-circle-right font-14 text-warning"></i>
                                </button>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($ubah == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= esc($value['kritiksaran_id']) ?>')">
                                <i class="fas fa-reply-all text-primary" title="Baca dan Balas Masukan saran ini."></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-reply-all text-secondary"></i>
                            </button>
                        <?php } ?>

                        <?php if ($hapus == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm" onclick="hapus('<?= $value['kritiksaran_id'] ?>','<?= esc($value['judul']) ?>')">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
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
                <th>
                    <input type="checkbox" class="text-center" disabled>
                </th>
                <th><b>NAMA</b></th>
                <th><b>ISI PESAN</b></th>
                <th><b>TGL PESAN</b></th>
                <th><b>TOPIK</b></th>
                <th class="text-center"><b>AKSI</b></th>

            </tr>
        </tfoot>
    </table>
</div>

<?= form_close() ?>

<script>
    $(document).ready(function() {

        var table = $('#listkritiksaran').DataTable({
            // "lengthChange": false,
            "ordering": false,

        });
        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangid').prop('checked', true);
            } else {
                $('.centangid').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangid:checked');
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
                    title: `Apakah anda yakin ingin menghapus ${jmldata.length} data ini?`,
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
                                listkritiksaran();
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
        });
    });

    function edit(kritiksaran_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kritiksaran/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                kritiksaran_id: kritiksaran_id
            },
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
                        // window.location = '../';
                    })
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
                if (response.blmakses) {

                    Swal.fire({
                        title: "Maaf gagal load Modul!",
                        html: `Modul ini belum atau tidak didaftarkan `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        // window.location = '../admin';
                    })
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
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

    function hapus(kritiksaran_id, ket) {

        Swal.fire({
            html: `Apakah anda yakin menghapus <strong>${ket}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('kritiksaran/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        kritiksaran_id: kritiksaran_id
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
                            listkritiksaran();
                            $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
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

    function toggle(kritiksaran_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kritiksaran/toggle') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                kritiksaran_id: kritiksaran_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1600
                    })
                    listkritiksaran();
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
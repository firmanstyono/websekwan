<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambah">
        <i class="fas fa fa-plus-circle"></i> Tambah Fasilitas Baru
    </button>
    <hr>
<?php } ?>

<div class="table-responsive b-0 ">
    <table id="listfasilitas" class="table table-hover table-striped table-bordered">
        <thead class="">
            <tr>
                <th width="30" class="text-center"><b>#</b></th>
                <th width="50" class="text-center"><b>Cover</b></th>
                <th><b>Fasilitas</b></th>
                <th><b>Keterangan</b></th>

                <th width="65" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>
                    <td class="text-center p-1">
                        <?php if ($ubah == 1) { ?>
                            <img class="img-circle elevation-2 pointer p-0" onclick="gantifoto('<?= $data['fasilitas_id'] ?>')" src="<?= base_url('public/img/informasi/fasilitas/' . $data['cover_foto']) ?>" title="Ganti Cover" width="70px">
                        <?php } else { ?>
                            <img class="img-circle elevation-2 p-0" src="<?= base_url('public/img/informasi/fasilitas/' . $data['cover_foto']) ?>" width="70px">
                        <?php } ?>

                    </td>

                    <td class="p-1">
                        <a class="text-primary" href="<?= base_url('fasilitas/detail/' . $data['fasilitas_id']) ?>" title="Detail fasilitas"> <?= esc($data['fasilitas']) ?></a>
                    </td>

                    <td class="p-1"><?= $data['ket'] ?></td>

                    <td class="text-center p-1">
                        <?php if ($ubah == 1) { ?>
                            <?php if ($data['sts'] == '1') { ?>
                                <button type="button" onclick="toggledef('<?= $data['fasilitas_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['sts'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['sts'] ? 'Non aktifkan default halaman' : 'Jadikan Default Tampilan Awal' ?>"><i class="nav-icon fas fa-star text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggledef('<?= $data['fasilitas_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['sts'] ? 'btn-light' : 'btn-light' ?>" title="<?= $data['sts'] ? 'Nonaktifkan' : 'Jadikan Default Tampilan Awal' ?>"><i class="nav-icon fas fa-star text-danger"></i>
                                </button>
                            <?php } ?>
                        <?php } else { ?>
                            <button type="button" class="btn btn-circle btn-sm p-1 "><i class="nav-icon fas fa-star text-secondary"></i>
                            </button>
                        <?php } ?>

                        <?php if ($ubah == 1) { ?>
                            <button type="button" title="Edit Data" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['fasilitas_id'] ?>')">
                                <i class="fa fa-edit text-primary"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>

                        <?php if ($hapus == 1) { ?>
                            <button type="button" title="Hapus Data" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['fasilitas_id'] ?>','<?= $data['fasilitas'] ?>')">
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
                <th class="text-center"><b>#<b></th>
                <th class="text-center"><b>Cover</b></th>
                <th><b>Fasilitas</b></th>
                <th><b>Keterangan</b></th>

                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('#listfasilitas').DataTable({
            'ordering': false,
        });

        $('.tambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('fasilitas/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
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

    function edit(fasilitas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('fasilitas/formeditfasilitas') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                fasilitas_id: fasilitas_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
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


    function hapus(fasilitas_id, nama) {
        Swal.fire({
            width: '400px',
            title: 'Hapus data?',
            // text: `Apakah anda yakin hapus data?`,
            html: `Apakah anda yakin menghapus <strong>${nama}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('fasilitas/hapusfasilitas') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        fasilitas_id: fasilitas_id
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
                            listfasilitas();
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
                        // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    }
                });
            }
        })
    }

    function gantifoto(fasilitas_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('fasilitas/ganticoverfas') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                fasilitas_id: fasilitas_id,
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
                    title: "Maaf gagal update Foto!",
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

    // defaultkan tampilan

    function toggledef(fasilitas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('fasilitas/toggledef') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                fasilitas_id: fasilitas_id
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
                    listfasilitas();
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
                // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }
</script>
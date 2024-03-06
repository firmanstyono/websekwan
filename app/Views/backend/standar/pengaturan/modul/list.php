<!-- <div class="media border-bottom"> -->
<a href="<?= base_url('modul/') ?>" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>
<?php if ($akses == 1) { ?>
    <button type="button" class="btn btn-success btn-sm tambah">
        <i class="fas fa fa-plus-circle"></i> Tambah Modul
    </button>
<?php } ?>

<hr>
<div class="table-responsive b-0 ">
    <table id="listmodul" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>SUB MENU (MODUL)</b></th>
                <th class="text-center" width="80"><b>URUTAN</b></th>
                <th width="190"><b>LINK</b></th>
                <th width="90" class="text-center"><b>AKSI</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++;
                $urlmenu = $data['urlmenu'];
            ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>
                    <td class="p-1">&nbsp; &nbsp;<i class="<?= $data['ikonmn'] ?>"></i> <?= esc($data['modul']) ?></td>
                    <td class="text-center p-1"><?= esc($data['urut']) ?></td>
                    <td class="p-1">
                        &nbsp; &nbsp;<?= esc($urlmenu) ?>
                    </td>

                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>
                            <?php if ($data['aktif'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $data['id_modul'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['aktif'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle font-13 text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $data['id_modul'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['aktif'] ? 'btn-light' : 'btn-light' ?>" title="<?= $data['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>

                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['id_modul'] ?>')">
                                <i class="icon fas fa-edit text-info"></i>
                            </button>


                            <button type="button" class="btn btn-light btn-sm p-1" title="Kelola Hak Akses" onclick="setakses('<?= $data['id_modul'] ?>','<?= $urlmenu ?>')">
                                <i class="icon fas fa-user-lock text-primary"></i>
                            </button>

                            <?php if ($urlmenu == 'modul' || $urlmenu == 'template' || $urlmenu == 'user' || $urlmenu == 'konfigurasi' || $urlmenu == 'menu' || $urlmenu == 'halaman') { ?>
                                <button type="button" class="btn btn-light btn-sm p-1">
                                    <i class="far fa-trash-alt text-secondary"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['id_modul'] ?>','<?= $data['modul'] ?>')">
                                    <i class="far fa-trash-alt text-danger"></i>
                                </button>
                            <?php } ?>
                        <?php } else { ?>
                            <label class="text-danger">Akses dibatasi.!</label>
                        <?php } ?>


                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>
                <th><b>SUB MENU (MODUL)</b></th>
                <th class="text-center"><b>URUTAN</b></th>
                <th><b>LINK</b></th>
                <th class="text-center"><b>AKSI<b></th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    function toggle(id_modul) {
        $.ajax({
            type: "post",
            url: "<?= site_url('modul/toggle') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_modul: id_modul
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
                    listmodul();
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

    $(document).ready(function() {

        var table = $('#listmodul').DataTable({
            "ordering": false,
        });
        $('.tambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('modul/formtambah') ?>",
                data: {
                    gm: gm
                },
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
                        // showConfirmButton: false,
                        // timer: 3100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
        });
    });


    function edit(id_modul) {
        $.ajax({
            type: "post",
            url: "<?= site_url('modul/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_modul: id_modul
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    $('#modaledit').modal('show');
                }
            },

            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function hapus(id_modul, modul) {
        Swal.fire({
            width: '400px',
            title: 'Hapus data?',
            html: `Apakah anda yakin menghapus <strong>${modul}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('modul/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        id_modul: id_modul
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
                            listmodul();
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

    // set ke role yang ada
    function setakses(id_modul, urlmenu) {
        $.ajax({
            type: "post",
            url: "<?= site_url('modul/formsetakses') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_modul: id_modul,
                urlmenu: urlmenu,
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
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }
</script>
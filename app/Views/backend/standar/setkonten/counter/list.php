<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm mr-1 tambah">
        <i class="fas fa fa-plus-circle"></i> Tambah Data
    </button>
    <small class="text-secondary"> Blok Counter berjumlah 4 baris, pastikan ketika menambah data berjumlah minimal 4 data jika lebih maka berjumlah 8 dst.</small>
    <hr>
<?php } ?>

<div class="table-responsive b-0 mt-2">
    <table id="listcount" class="table table-hover table-striped table-bordered">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>Counter</b></th>
                <th width="75" class="text-center"><b>Nilai </b></th>
                <th width="150"><b>Sumber </b></th>
                <th width="40" class="text-center"><b>Icon </b></th>
                <th width="70" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>
        <tbody>

            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++;
            ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>

                    <td class="p-1"><?= esc($data['nm']) ?></td>
                    <td class="text-center p-1"><?= esc($data['jm']) ?></td>
                    <td class="p-1"><?= esc($data['sumber']) ?></td>
                    <td class="p-1 text-center">
                        <?php if ($data['ic'] != '') { ?>
                            <a class="text-warning font-13"> <i class="<?= $data['ic'] ?> text-secondary" title="<?= $data['ic'] ?>"></i></a>
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>

                    <td class="text-center p-1">
                        <?php if ($ubah == 1) { ?>
                            <?php if ($data['sts'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $data['id_counter'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['sts'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['sts'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $data['id_counter'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['sts'] ? 'btn-info' : 'btn-light' ?>" title="<?= $data['sts'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>

                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="fas fa-check-circle text-secondary"></i>
                            </button>
                        <?php } ?>

                        <?php if ($ubah == 1) { ?>
                            <button type="button" title="Edit Data" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['id_counter'] ?>')">
                                <i class="fa fa-edit text-primary"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>

                        <?php if ($hapus == 1) { ?>
                            <button type="button" title="Hapus Data" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['id_counter'] ?>','<?= $data['nm'] ?>')">
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
                <th><b>Counter</b></th>
                <th class="text-center"><b>Nilai </b></th>
                <th><b>Sumber </b></th>
                <th class="text-center"><b>Icon </b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>

</div>

<script>
    $(document).ready(function() {
        $('#listcount').DataTable({
            'ordering': false,
        });

        $('.tambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('counter/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambah').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modaltambah').modal('show');
                    // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
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
        });



    });

    function edit(id_counter) {
        $.ajax({
            type: "post",
            url: "<?= site_url('counter/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_counter: id_counter
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


    function hapus(id_counter) {
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
                    url: "<?= site_url('counter/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        id_counter: id_counter
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
                                listcount();
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

    function toggle(id_counter) {
        $.ajax({
            type: "post",
            url: "<?= site_url('counter/toggle') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_counter: id_counter
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
                    listcount();
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
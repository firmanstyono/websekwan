<?= form_open('produkhukum/hapussuball', ['class' => 'formhapus']) ?>

<a href="<?= base_url('produkhukum/all/') ?>" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>
<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambah">
        <i class="fas fa fa-plus-circle"></i> Tambah Sub Produk Hukum
    </button>
<?php } ?>
<?php if ($hapus == 1) { ?>
    <button type="submit" class="btn btn-danger btn-sm tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>
<?php } ?>
<hr>
<div class="table-responsive b-0">
    <table id="listsubproduk" class="table table-hover table-striped table-bordered">

        <thead>
            <tr>
                <th width="4">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="10"># </th>
                <th>Judul</th>
                <th width="120">Tgl Posting</th>
                <th width="15" class="text-center">Diunduh</th>
                <th width="70" class="text-center">Aksi </th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="kathukum_id[]" class="centang_id" value="<?= $data['kathukum_id'] ?>">
                    </td>
                    <td><?= $nomor ?></td>

                    <td>
                        <?php if ($data['skathukum'] != '1') {
                            if ($tambah == 1) {
                                if ($data['file_kathukum'] != 'default.png' && ($data['file_kathukum'] != null)) { ?>
                                    <i class="fas fa-file-alt text-success pointer font-16" onclick="uploadfile('<?= $data['kathukum_id'] ?>')" title="Ganti file"></i>
                                <?php } else { ?>
                                    <i class="fas fa-file-alt text-danger pointer font-16" onclick="uploadfile('<?= $data['kathukum_id'] ?>')" title="Upload file"></i>
                            <?php }
                            } ?>

                        <?= esc($data['nama_kathukum']);
                        } else { ?>

                            <a href="<?= base_url('produkhukum/detailsubproduk/' . $data['kathukum_id']) ?>" class="text-primary" title="Sub Detail Produk Hukum"><i class="fas fa-list text-primary font-14"></i> <?= esc($data['nama_kathukum']) ?> </a>

                        <?php } ?>

                        <?php if ($data['skathukum'] != '1') {
                            if ($data['file_kathukum'] != 'default.png' && ($data['file_kathukum'] != null)) { ?>
                                <a href="<?= base_url('public/unduh/produkhukum/'  . $data['file_kathukum']) ?>" title="Lihat file" target="_blank"><i class="fas fa-search"></i></a>
                        <?php }
                        } ?>

                    </td>

                    <td><?= date_indo($data['tanggal_kathukum']) ?></td>
                    <td class="text-center p-0">

                        <?php if ($data['skathukum'] != '0') { ?>
                            -
                        <?php } else { ?>
                            <?= esc($data['hits']) ?>x
                        <?php } ?>

                    </td>

                    <td class="text-center p-0">

                        <?php if ($ubah == 1) { ?>
                            <button type="button" title="Edit Data" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['kathukum_id'] ?>')">
                                <i class="fa fa-edit text-warning"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>

                        <?php if ($hapus == 1) { ?>
                            <button type="button" title="Hapus Data" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['kathukum_id'] ?>','<?= $data['nama_kathukum'] ?>')">
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
                <th>#</th>
                <th>Judul</th>
                <th>Tgl Posting</th>
                <th>Diunduh</th>

                <th class="text-center">Aksi </th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {

        $('#listsubproduk').DataTable({
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
                                listsubproduk();
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

    function edit(kathukum_id, produk_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('produkhukum/formeditsub') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                kathukum_id: kathukum_id,
                produk_id: produk_id

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
                }
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
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

    function hapus(kathukum_id, nama_kathukum) {
        Swal.fire({

            html: `Apakah anda yakin menghapus <strong>${nama_kathukum}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('produkhukum/hapussub') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        kathukum_id: kathukum_id
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
                            listsubproduk();
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

        $('.tambah').click(function(e) {
            e.preventDefault();
            produk = $("#produk_id").val();
            $.ajax({
                url: "<?= site_url('produkhukum/formtambahsubproduk') ?>",
                data: {
                    produk: produk,
                },
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

    //uploadfile
    function uploadfile(kathukum_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('produkhukum/formuploadfile') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                kathukum_id: kathukum_id,
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
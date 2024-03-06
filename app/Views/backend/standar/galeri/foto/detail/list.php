<?= form_open('foto/hapusall', ['class' => 'formhapus']) ?>
<!-- <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" /> -->

<button type="button" class="btn btn-warning btn-sm kembali" id="kembali">
    <i class="far fa-arrow-alt-circle-left"></i> Kembali
</button>
<small class="text-secondary" id="kembali"> Untuk multi upload data, klik di tanda <strong class="text-primary">+ (plus)</strong> di samping File Gambar. Untuk simpan data. Klik tombol <strong class="text-info">Simpan Data</strong>. </small>

<a href="<?= base_url('foto/all/') ?>" class="btn btn-info btn-sm kem1" id="kem1"><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali Ke Album</a>
<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm btnuploadmulti" id="addmulti">
        <i class="fas fa fa-plus-circle text-light"></i> Tambah Data
    </button>
<?php } ?>
<?php if ($hapus == 1) { ?>
    <button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>
<?php } ?>
<hr>
<div class="viewdatamulti"></div>
<div id="tabelmulti">
    <div class="table-responsive b-0 ">
        <table id="listfoto" class="table table-hover table-striped">
            <thead>
                <tr>
                    <th width="5">
                        <input type="checkbox" id="centangSemua" class="text-center">
                    </th>
                    <th width="5"># </th>
                    <th width="90"><b>Gambar</b></th>
                    <th><b>Keterangan</b></th>
                    <th><b>Penerbit</b></th>
                    <th width="50" class="text-center"><b>Aksi</b> </th>
                </tr>

            </thead>
            <tbody>
                <?php $nomor = 0;
                foreach ($list as $value) :
                    $nomor++; ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="foto_id[]" class="centangid" value="<?= $value['foto_id'] ?>">
                        </td>
                        <td><?= $nomor ?></td>

                        <td class="p-1"><img class="img-circle elevation-2" src="<?= base_url('/public/img/galeri/foto/' . $value['gambar']) ?>" width="100px" height="60px"></td>
                        <td><?= $value['judul'] ?></td>
                        <td><?= $value['fullname'] ?></td>
                        <td class="text-center p-0">

                            <?php if ($ubah == 1) { ?>
                                <button type="button" title="Edit Data" class="btn btn-light btn-sm p-1" onclick="edit('<?= $value['foto_id'] ?>')">
                                    <i class="fa fa-edit text-primary"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-light btn-sm p-1">
                                    <i class="icon fas fa-edit text-secondary"></i>
                                </button>
                            <?php } ?>

                            <?php if ($hapus == 1) { ?>
                                <button type="button" title="Hapus Data" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $value['foto_id'] ?>','<?= $value['judul'] ?>')">
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
                    <th><b>Gambar</b></th>
                    <th><b>Keterangan</b></th>
                    <!-- <th><b>Kategori</b></th> -->
                    <th><b>Penerbit</b></th>
                    <th class="text-center"><b>Aksi</b></th>

                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= form_close() ?>
<script>
    $(document).ready(function() {

        $(kembali).hide();

        $('#listfoto').DataTable();

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
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                                listfoto();
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

    function edit(foto_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('foto/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                foto_id: foto_id
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

    function hapus(foto_id, ket) {

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
                    url: "<?= site_url('foto/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        foto_id: foto_id
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
                            listfoto();
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

    //tambah data
    $(document).ready(function() {
        $('.tambahfoto').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('foto/formtambah') ?>",
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

    // add multi
    $('.btnuploadmulti').click(function(e) {
        e.preventDefault();
        kategorifoto_id = $("#kategorifoto_id").val();
        $.ajax({
            type: "post",
            url: '<?= site_url('foto/uploadmulti') ?>',
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                kategorifoto_id: kategorifoto_id,
            },
            dataType: "json",
            beforeSend: function() {
                $('.btnuploadmulti').attr('disable', 'disable');
                $('.btnuploadmulti').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
            },
            complete: function() {
                $('.btnuploadmulti').removeAttr('disable', 'disable');

                $('.btnuploadmulti').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                $(tabelmulti).hide();
                $(tblhapus).hide();
                $(kem1).hide();
                $(addmulti).hide();
                $(kembali).show();
                // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            },
            success: function(response) {
                $('.viewdatamulti').html(response.data);
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    // window.location = '';
                })
                // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    });


    // listdetailproduk();
    $('.kembali').click(function(e) {
        $(document).ready(function() {
            listfoto();
        });

    });
</script>
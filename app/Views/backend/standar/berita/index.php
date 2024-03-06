<?= $this->section('content') ?>
<?= $this->extend('backend/' . $folder . '/' . 'script'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box ">

        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">

                <div class="card-header font-18 bg-light">
                    <h6 class="modal-title mt-0">
                        <i class="far fa-newspaper"></i> Data <?= $subtitle ?>
                    </h6>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- <div class="viewdata"></div> -->
                    <?= form_open('berita/hapusall', ['class' => 'formhapus']) ?>

                    <?php if ($tambah == 1) { ?>
                        <a href="<?= base_url('add-new') ?>"> <button type="button" class="btn btn-primary btn-sm"><i class="fas fa fa-plus-circle"></i> Tambah baru</button></a>
                    <?php } ?>

                    <?php if ($hapus == 1) { ?>
                        <button type="submit" class="btn btn-danger btn-sm tblhapus">
                            <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
                        </button>
                    <?php } ?>
                    <hr>

                    <div class="table-responsive b-0 ">
                        <!-- <table id="databerita" class="table table-responsive table-hover table-striped "> -->
                        <table id="databerita" class="table table-striped table-hover dt-responsive " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />

                            <thead>
                                <tr>
                                    <th width="1"><input type="checkbox" id="centangSemua"></th>
                                    <th width="30" class="text-center"><b>SAMPUL</b></th>
                                    <th><b>JUDUL</b></th>
                                    <th><b>KATEGORI</b></th>
                                    <th width="130"><b>TANGGAL</b></th>
                                    <th><b>PENERBIT</b></th>
                                    <th class="text-center" width="80"><b>AKSI</b> </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><input type="checkbox" class="text-center" disabled></th>
                                    <th><b>SAMPUL</b></th>
                                    <th><b>JUDUL</b></th>
                                    <th><b>KATEGORI</b></th>
                                    <th><b>TANGGAL</b></th>
                                    <th><b>PENERBIT</b></th>
                                    <th class="text-center"><b>AKSI</b> </th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <?= form_close() ?>

                </div>

            </div>
        </div>
    </div>

    <script>
        function AmbilDataBerita() {

            // let csrfToken = '<?= csrf_token() ?>';
            // let csrfHash = '<?= csrf_hash() ?>';
            var table = $('#databerita').DataTable({
                "processing": true,
                "serverSide": true,
                "oLanguage": {
                    "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                    "sSearch": "Pencarian: ",
                    "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
                    "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                    "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
                    "sInfoFiltered": "(di filter dari _MAX_ total data)",
                    "oPaginate": {
                        "sFirst": "«",
                        "sLast": "»",
                        "sPrevious": "«",
                        "sNext": "»"
                    }
                },
                "order": [],
                "ajax": {

                    "url": "<?php echo site_url('berita/listdata2') ?>",
                    "type": "POST",
                    "data": {
                        // [csrfToken]: csrfHash,
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                    },


                    error: function() { // error handling
                        $(".databerita-error").html("");
                        $("#databerita").append('<tbody class="databerita-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                        $("#databerita_processing").css("display", "none");
                        // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);

                    },

                },

                "columnDefs": [{
                        "targets": 0,
                        "orderable": false,
                    },
                    {
                        "targets": 1,
                        "orderable": false,
                    },
                    {
                        "targets": 3,
                        "orderable": false,
                    },
                    {
                        "targets": 4,
                        "orderable": false,
                    },
                    {
                        "targets": 6,
                        "orderable": false,
                    }
                ],

            });
        }



        $(document).ready(function() {
            AmbilDataBerita();

            $('#centangSemua').click(function(e) {
                if ($(this).is(':checked')) {
                    $('.centangBeritaid').prop('checked', true);
                    // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe); //dataSrc untuk random request token char (wajib)

                } else {
                    $('.centangBeritaid').prop('checked', false);
                    // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe); //dataSrc untuk random request token char (wajib)

                }
            });

            $('.formhapus').submit(function(e) {
                // let csrfToken = '<?= csrf_token() ?>';
                // let csrfHash = '<?= csrf_hash() ?>';
                e.preventDefault();
                let jmldata = $('.centangBeritaid:checked');
                if (jmldata.length === 0) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops!',
                        text: 'Silahkan pilih data!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
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
                                dataType: "json",
                                data: $(this).serialize(),
                                // data: {
                                //     // [csrfToken]: csrfHash,
                                //     csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                                // },
                                beforeSend: function() {
                                    $('.tblhapus').attr('disable', 'disable');
                                    $('.tblhapus').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                                },
                                complete: function() {
                                    $('.tblhapus').removeAttr('disable', 'disable');
                                    $('.tblhapus').html('<i class="far fa-trash-alt text-light"></i> Hapus yang diceklist');
                                },
                                success: function(response) {
                                    // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe); //dataSrc untuk random request token char (wajib)
                                    // if (response.csrf_tokencmsdatagoe) {
                                    //     //update hash untuk proses error validation 
                                    //     $('#csrf_tokencmsdatagoe, #csrfRandom').val(response.csrf_tokencmsdatagoe);
                                    //     $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                                    // }
                                    // toastr.options = {
                                    //         "closeButton": true,
                                    //         "debug": false,
                                    //         "newestOnTop": false,
                                    //         "progressBar": true,
                                    //         "positionClass": "toast-top-right",
                                    //         "preventDuplicates": false,
                                    //         "onclick": null,
                                    //         "showDuration": "300",
                                    //         "hideDuration": "1000",
                                    //         "timeOut": "5000",
                                    //         "extendedTimeOut": "1000",
                                    //         "showEasing": "swing",
                                    //         "hideEasing": "linear",
                                    //         "showMethod": "fadeIn",
                                    //         "hideMethod": "fadeOut"
                                    //     },
                                    // toastr["success"](response.sukses)
                                    Swal.fire({
                                        title: "Sukses!",
                                        text: response.sukses,
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1550
                                    }).then(function() {
                                        window.location = '';
                                    });
                                    // AmbilDataBerita();
                                    // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                                    // if (response.csrf_tokencmsdatagoe) {
                                    //     //update hash untuk proses error validation 
                                    //     $('#csrfToken, #csrfRandom').val(response.csrf_tokencmsdatagoe);
                                    //     $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe); //dataSrc untuk random request token char (wajib)
                                    // }
                                },

                                error: function(xhr, ajaxOptions, thrownerror) {
                                    Swal.fire({
                                        title: "Maaf gagal hapus data",
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
                    })
                }
            });
        });


        function hapus(berita_id) {
            Swal.fire({
                // title: 'Hapus data?',
                html: `Anda yakin hapus berita dengan ID <strong>${berita_id}</strong> ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('berita/hapus') ?>",
                        data: {
                            csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                            berita_id: berita_id
                        },
                        type: "post",
                        dataType: "json",
                        success: function(response) {
                            if (response.csrf_tokencmsdatagoe) {
                                //update hash untuk proses error validation 
                                $('#csrfToken, #csrfRandom').val(response.csrf_tokencmsdatagoe);
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            }
                            $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe); //dataSrc untuk random request token char (wajib)
                            if (response.sukses) {
                                // toastr.options = {
                                //         "closeButton": true,
                                //         "debug": false,
                                //         "newestOnTop": false,
                                //         "progressBar": true,
                                //         "positionClass": "toast-top-right",
                                //         "preventDuplicates": false,
                                //         "onclick": null,
                                //         "showDuration": "300",
                                //         "hideDuration": "1000",
                                //         "timeOut": "5000",
                                //         "extendedTimeOut": "1000",
                                //         "showEasing": "swing",
                                //         "hideEasing": "linear",
                                //         "showMethod": "fadeIn",
                                //         "hideMethod": "fadeOut"
                                //     },
                                //     toastr["success"](response.sukses)
                                // AmbilDataBerita();
                                Swal.fire({
                                    title: "Sukses!",
                                    text: response.sukses,
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1550
                                }).then(function() {
                                    window.location = '';
                                });
                                // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownerror) {
                            Swal.fire({
                                title: "Maaf gagal hapus data!",
                                html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                                icon: "error",
                                // showConfirmButton: false,
                                // timer: 3100
                            }).then(function() {
                                window.location = '';
                            })
                        }
                    });
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);

                }
            })
        }



        //aktifnonaktif

        function toggle(id) {
            $.ajax({
                type: "post",
                url: "<?= site_url('berita/toggle') ?>",
                data: {
                    csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: response.sukses,
                        //     showConfirmButton: false,
                        //     timer: 1500
                        // })
                        // listberita();
                        Swal.fire({
                            title: "Sukses!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1550
                        }).then(function() {
                            window.location = '';
                        });
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

        function toggleutm(id) {
            $.ajax({
                type: "post",
                url: "<?= site_url('berita/toggleutm') ?>",
                data: {
                    csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: response.sukses,
                        //     showConfirmButton: false,
                        //     timer: 1500
                        // })
                        // listberita();
                        Swal.fire({
                            title: "Sukses!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1550
                        }).then(function() {
                            window.location = '';
                        });
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

        function gantifoto(berita_id) {

            $.ajax({
                type: "post",
                url: "<?= site_url('berita/formgantifoto') ?>",
                data: {
                    csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                    berita_id: berita_id,
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
    </script>

    <?= $this->endSection() ?>
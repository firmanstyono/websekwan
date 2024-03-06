<?php

use App\Models\M_Prj_mohoninfo;

$this->permohonaninfo = new M_Prj_mohoninfo();

?>
<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahkategori">
        <i class="fas fa fa-plus-circle"></i> Tambah Data Baru
    </button>
    <hr>
<?php } ?>
<input type="hidden" class="form-control" id="req" value="<?= $req ?>" name="req" readonly>
<input type="hidden" class="form-control" id="jns" value="<?= $jns ?>" name="jns" readonly>

<div class="table-responsive b-0 ">
    <table id="listmaster" class="table table-hover table-striped table-bordered">
        <?php
        if ($req == 'm-caraperoleh_info') {
            $stsm = 'cara_perolehinfo';
            $jdl = 'CARA PEROLEH INFO';
        } else if ($req == 'm-pekerjaan') {
            $stsm = 'pek_pemohon';
            $jdl = 'PEKERJAAN';
        } else if ($req == 'm-caradapat_info') {
            $stsm = 'cara_dapatkaninfo';
            $jdl = 'CARA DAPATKAN INFO';
        }

        ?>
        <thead class="bg-info">
            <tr>
                <th width="40" class="text-center p-2"><b> #</b></th>
                <th class="p-2"><b><?= $jdl ?></b></th>
                <th width="60" class="text-center p-2"><b>AKSI</b></th>
            </tr>
        </thead>

        <tbody>

            <?php
            $nomor = 0;
            # code...
            foreach ($list as $data) {
                $nomor++;
                $id_masterdata  = $data['id_masterdata'];
                $jdata          = $this->permohonaninfo->where($stsm, $id_masterdata)->get()->getNumRows();

            ?>
                <tr>
                    <td class="text-center p-2"><?= $nomor ?></td>

                    <td class="p-2">
                        <?= esc($data['nama_master']) ?>
                    </td>

                    <td class="text-center p-2">
                        <?php if ($ubah == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= $id_masterdata ?>')">
                                <i class="icon fas fa-edit text-info"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>
                        <?php if ($jdata == 0) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $id_masterdata ?>')">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="far fa-trash-alt text-secondary"></i>
                            </button>
                        <?php } ?>

                    </td>

                </tr>
            <?php }  ?>
            <!-- end lop -->

        </tbody>

        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>
                <th><b><?= $jdl ?></b></th>
                <th class="text-center"><b>AKSI<b></th>
            </tr>
        </tfoot>
    </table>

</div>

<script>
    $(document).ready(function() {
        $('#listmaster').DataTable({
            'ordering': false,
            'iDisplayLength': 25,
        });

        $('.tambahkategori').click(function(e) {
            e.preventDefault();
            req = $("#req").val();
            jns = $("#jns").val();
            $.ajax({
                url: "<?= site_url('masterdata/formtambah') ?>",
                data: {
                    req: req,
                    jns: jns,
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

    function uploadfile(id_masterdata) {

        $.ajax({
            type: "post",
            url: "<?= site_url('masterdata/formuploadfoto') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_masterdata: id_masterdata,

            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
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


    function edit(id_masterdata) {
        $.ajax({
            type: "post",
            url: "<?= site_url('masterdata/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_masterdata: id_masterdata,
                req: req,

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

    function hapus(id_masterdata) {
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
                    url: "<?= site_url('masterdata/hapusdata') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        id_masterdata: id_masterdata
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
                            listmaster();
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
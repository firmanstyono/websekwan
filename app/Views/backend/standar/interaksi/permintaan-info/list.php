<?php

use App\Models\M_Prj_master;
use App\Models\M_Prj_mohoninfo;

$this->masterdata = new M_Prj_master();

?>
<?= form_open('permohonaninfo/hapusall', ['class' => 'formhapus']) ?>
<?php if ($hapus == 1) { ?>
    <button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>

    <hr>
<?php } ?>
<div class="table-responsive b-0 ">
    <table id="permohonaninfo" class="table table-hover table-striped table-bordered  dt-responsiveZ nowrapx">

        <thead>
            <tr>
                <th width="2">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>

                <th width="100">NAMA</th>
                <th>ALAMAT</th>
                <th>PEKERJAAN</th>
                <th>INFORMASI YG DIBUTUHKAN</th>
                <!-- <th>CARA MEMPEROLEH INFORMASI</th> -->
                <th>TANGGAL</th>
                <!-- <th width="100">TUJUAN PENGGUNAAN INFORMASI</th> -->
                <th width="60" class="text-center">AKSI </th>

            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $value) :
                $nomor++;
                $sts_info           = $value['sts_info'];
                $sts_public           = $value['sts_public'];
                $pek_pemohon           = $value['pek_pemohon'];
                $cara_perolehinfo      = $value['cara_perolehinfo'];
                $cara_dapatkaninfo      = $value['cara_dapatkaninfo'];
                $nama                   = $value['nama_pemohon'];
                $alamat_pemohon         = $value['alamat_pemohon'];
                $email_pemohon          = $value['email_pemohon'];
                $info_ygdibutuhkan      = $value['info_ygdibutuhkan'];
                $tujuan_info            = $value['tujuan_info'];
                $tgl_ajuan              = $value['tgl_ajuan'];
                $foto_ktp              = $value['foto_ktp'];

                $pek                    = $this->masterdata->find($pek_pemohon);
                $caraperoleh            = $this->masterdata->find($cara_perolehinfo);
                $pekerjaan              = $pek['nama_master'];
                $caraperolehinfo        = $caraperoleh['nama_master'];
            ?>
                <tr>
                    <td>
                        <input type="checkbox" name="id_mohoninfo[]" class="centangid" value="<?= $value['id_mohoninfo'] ?>">
                    </td>
                    <!-- NAMA -->
                    <td class="p-1">
                        <a href="<?= base_url('public/file/dokumen/'  . $foto_ktp) ?>" title="klik untuk buka file" target='_BLANK'><i class="mdi mdi-file-account text-primary" style="font-size: 16px;"></i></a>
                        <?php if ($sts_info == '0') { ?>
                            <b><?= esc($nama) ?></b>
                        <?php } else { ?>
                            <?= esc($nama) ?>
                        <?php } ?>
                    </td>
                    <!-- ALAMAT -->
                    <td class="p-1">
                        <?php if ($sts_info == '0') { ?>
                            <b><?= esc($alamat_pemohon) ?></b>
                        <?php } else { ?>
                            <?= esc($alamat_pemohon) ?>
                        <?php } ?>

                    </td>
                    <!-- PEKERJAAN -->
                    <td class="p-1">
                        <?php if ($sts_info == '0') { ?>
                            <b><?= ($pekerjaan) ?></b>
                        <?php } else { ?>
                            <?= ($pekerjaan) ?>
                        <?php } ?>
                    </td>
                    <!-- INFO YG DIBUTUHKAN -->
                    <td class="p-1">
                        <?php if ($sts_info == '0') { ?>
                            <b>
                                <?= esc($info_ygdibutuhkan) ?>
                            </b>
                        <?php } else { ?>
                            <?= esc($info_ygdibutuhkan) ?>
                        <?php } ?>
                    </td>
                    <!-- CARA PEROLEH -->
                    <!-- <td class="p-1">
                    <?php if ($sts_info == '0') { ?>
                        <b><?= ($caraperolehinfo) ?></b>
                    <?php } else { ?>
                        <?= ($caraperolehinfo) ?>
                    <?php } ?>
                </td> -->
                    <!-- TGL AJUAN -->
                    <td class="p-1">
                        <?php if ($sts_info == '0') { ?>
                            <b> <?= ($tgl_ajuan) ?></b>
                        <?php } else { ?>
                            <?= ($tgl_ajuan) ?>
                        <?php } ?>
                    </td>
                    <!-- TUJUAN INFO -->
                    <!-- <td class="p-1">
                    <?php if ($sts_info == '0') { ?>
                        <b><?= esc($tujuan_info) ?></b>
                    <?php } else { ?>
                        <?= esc($tujuan_info) ?>
                    <?php } ?>
                </td> -->

                    <!-- AKSI -->
                    <td class="text-center p-0">


                        <?php if ($sts_info == '0') { ?>
                            <button type="button" class="btn btn-circle btn-sm p-1 btn-light" title="Ajuan Baru/Belum ditanggapi"><i class="fas fa-arrow-circle-right font-14 text-warning"></i>
                            </button>
                        <?php } else if ($sts_info == '1') { ?>
                            <button type="button" class="btn btn-circle btn-sm p-1 btn-light" title="Ajuan diterima"><i class="far fa-check-circle font-14 text-success"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-circle btn-sm p-1 btn-light" title="Ajuan ditolak"><i class="far fa-times-circle font-14 text-danger"></i>
                            </button>
                        <?php } ?>


                        <!-- button replay -->
                        <?php if ($ubah == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= esc($value['id_mohoninfo']) ?>')">
                                <i class="fas fa-reply-all text-primary" title="Baca dan Balas ajuan ini."></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="fas fa-reply-all text-secondary"></i>
                            </button>
                        <?php } ?>

                        <?php if ($hapus == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $value['id_mohoninfo'] ?>','<?= esc($nama) ?>')">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="far fa-trash-alt text-secondary"></i>
                            </button>
                        <?php  } ?>
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
                <th><b>ALAMAT</b></th>
                <th><b>PEKERJAAN</b></th>
                <th><b>INFORMASI YG DIBUTUHKAN</b></th>
                <!-- <th><b>CARA MEMPEROLEH INFORMASI</b></th> -->
                <th><b>TANGGAL</b></th>
                <!-- <th><b>TUJUAN PENGGUNAAN INFORMASI</b></th> -->
                <th class="text-center"><b>AKSI</b></th>

            </tr>
        </tfoot>
    </table>
</div>

<?= form_close() ?>

<script>
    $(document).ready(function() {


        // $('#permohonaninfo').DataTable();
        var table = $('#permohonaninfo').DataTable({
            // "lengthChange": false,
            "ordering": false,
            // "paging": false,
            // "info": false,
            // "searching": false,
            // // "pagingType": "numbers",
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
                                listpermohonaninfo();
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

    function edit(id_mohoninfo) {
        $.ajax({
            type: "post",
            url: "<?= site_url('permohonaninfo/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_mohoninfo: id_mohoninfo
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
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function hapus(id_mohoninfo, ket) {

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
                    url: "<?= site_url('permohonaninfo/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        id_mohoninfo: id_mohoninfo
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
                            listpermohonaninfo();
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

    function toggle(id_mohoninfo) {
        $.ajax({
            type: "post",
            url: "<?= site_url('permohonaninfo/toggle') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_mohoninfo: id_mohoninfo
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
                    listpermohonaninfo();
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
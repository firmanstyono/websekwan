<?php

use App\Models\ModelSurveyPertanyaan;
use App\Models\ModelSurveyResponden;

$this->responden = new ModelSurveyResponden();
$this->pertanyaan = new ModelSurveyPertanyaan();
?>
<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambah">
        <i class="fas fa fa-plus-circle"></i> Tambah Topik Baru
    </button>
<?php } ?>
<?php if ($hapus == 1) { ?>
    <small class="text-dark"> Untuk reset data survei, dan menghapus semua data responden pada topik yang telah diisi, klik tombol <b class="text-danger"><i class="fas fa-recycle font-13"></i></b> dibawah..! </small>
    <!-- <small class="text-danger"> Proses reset nilai akan mengembalikan total poin ke <b>0</b>, dan menghapus semua data responden pada topik yang telah diisi. </small> -->
<?php } ?>
<hr>
<div class="table-responsive b-0 ">
    <table id="listsurveytopik" class="table table-hover table-striped table-bordered">
        <thead class="">
            <tr>
                <th width="10"><b>#</b></th>
                <th><b>TOPIK SURVEI</b></th>
                <th width="95" class="text-center"><b>HASIL SURVEI</b></th>
                <th width="70" class="text-center"><b>RESPONDEN</b></th>
                <th width="120" class="text-center"><b>AKSI</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :

                $jrespon = $this->responden->where('survey_id', $data['survey_id'])->get()->getNumRows();
                $jpertanyaan = $this->pertanyaan->where('survey_id', $data['survey_id'])->get()->getNumRows();

                $nomor++;
                $skor = $data['skor'];

                $r1_stb = $jpertanyaan * 1; // awal sangt tdk baik
                $r1_kb  = $jpertanyaan * 2; //awal kurang baik
                $r1_b   = $jpertanyaan * 3; //baik
                $r1_sb  = $jpertanyaan * 4; //sangt baik

                $r2_stb = $r1_kb - 1; //ra akhir sangat tdk baik
                $r2_kb  = $r1_b - 1; //ra akhir kurang baik
                $r2_b   = $r1_sb - 1; //ra akhir baik
            ?>
                <tr>
                    <td class="p-1 text-center"><?= $nomor ?></td>
                    <td class="p-1">
                        <?php if ($jpertanyaan != 0) { ?>
                            <a href="<?= base_url('survey/cetak/' . $data['survey_id']) ?>" target="_blank" title="Cetak"><i class="fas fa-print text-dark font-14"></i> </a>
                        <?php } else { ?>
                            <a class="text-light"><i class="fas fa-print text-secondary font-14"></i> </a>
                        <?php } ?>
                        <a class="text-primary" title="Kelola pertanyaan" href="<?= base_url('survey/pertanyaan/' . $data['survey_id']) ?>">
                            <?= esc($data['nama_survey']) ?>
                            <?php if ($jpertanyaan != 0) { ?>
                                <span class="badge badge-success pointer" title="Jumlah pertanyaan" style="font-size:12px">(<?= $jpertanyaan ?>) </span>
                            <?php } else { ?>
                                <span class="badge badge-danger pointer" title="Jumlah pertanyaan" style="font-size:12px">(<?= $jpertanyaan ?>) </span>
                            <?php } ?>
                        </a>
                    </td>

                    <td class="p-1 text-center">
                        <?php if ($skor != 0) {
                            if ($skor == 0 || $jrespon == 0) {
                                $ns = 1;
                                $js = 1;
                            } else {
                                $ns = $skor;
                                $js = $jrespon;
                            }
                            $hasil = (intval($ns) / intval($js));
                            $dhasil = round($hasil);

                        ?>

                            <?php if ($dhasil >= $r1_stb && $dhasil <= $r2_stb) { ?>
                                <span class="badge badge-danger" title="Penilaian Akhir" style="font-size:12px"><?= $data['ket_stb'] ?> (<?= $dhasil ?>)</span>
                            <?php  } elseif ($dhasil >= $r1_kb && $dhasil <= $r2_kb) { ?>
                                <span class="badge badge-warning" title="Penilaian Akhir" style="font-size:12px"><?= $data['ket_kb'] ?> (<?= $dhasil ?>)</span>

                            <?php  } elseif ($dhasil >= $r1_b && $dhasil <= $r2_b) { ?>
                                <span class="badge badge-info" title="Penilaian Akhir" style="font-size:12px"> <?= $data['ket_b'] ?> (<?= $dhasil ?>)</span>

                            <?php  } elseif ($dhasil >= $r1_sb) { ?>
                                <span class="badge badge-success" title="Penilaian Akhir" style="font-size:12px"><?= $data['ket_sb'] ?> (<?= $dhasil ?>)</span>
                            <?php } ?>

                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                    <td class="p-1 text-center">
                        <?php if ($skor != 0) { ?>
                            <a href="<?= base_url('survey/pesan/' . $data['survey_id']) ?>">
                                <span class="badge badge-primary pointer" title="Lihat Responden" style="font-size:12px">(<?= $jrespon ?>) </span>
                            </a>
                        <?php } ?>

                    </td>
                    <td class="text-center p-1">
                        <?php
                        if ($skor != 0) {
                            $link = base_url('survey/pesan/' . $data['survey_id']);
                            $warna = 'primary';
                            $tit = 'Lihat responden';
                        } else {
                            $link = '#';
                            $warna = 'secondary';
                            $tit = '';
                        }
                        ?>
                        <a href="<?= $link ?>" title="<?= $tit ?>" class="btn btn-light btn-sm p-1">
                            <i class="fas fa-list text-<?= $warna ?>"></i>
                        </a>

                        <?php if ($ubah == 1) { ?>
                            <?php if ($jpertanyaan != 0) { ?>
                                <?php if ($data['status'] == '1') { ?>
                                    <button type="button" onclick="toggle('<?= $data['survey_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['status'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" onclick="toggle('<?= $data['survey_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['status'] ? 'btn-info' : 'btn-light' ?>" title="<?= $data['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                    </button>
                                <?php } ?>
                            <?php } else { ?>
                                <button type="button" class="btn btn-light btn-sm p-1">
                                    <i class="far fa-eye text-secondary"></i>
                                </button>
                            <?php } ?>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="fas fa-recycle text-secondary"></i>
                            </button>

                        <?php  } ?>
                        <?php if ($ubah == 1) { ?>
                            <!-- edit -->
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['survey_id'] ?>')">
                                <i class="icon fas fa-edit text-primary"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php  } ?>
                        <!-- reset -->

                        <?php if ($skor != 0 &&  $jrespon != 0 && $hapus == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="resetsurvei('<?= $data['survey_id'] ?>','<?= $data['nama_survey'] ?>')" title="Reset survei">
                                <i class="fas fa-recycle text-danger"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="fas fa-recycle text-secondary"></i>
                            </button>
                        <?php } ?>


                        <?php if ($skor == 0 &&  $jrespon == 0 && $jpertanyaan == 0 && $hapus == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['survey_id'] ?>','<?= $data['nama_survey'] ?>')">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="far fa-trash-alt text-secondary"></i>
                            </button>
                        <?php  } ?>


                        <!-- akses 2 -->


                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th><b>#<b></th>
                <th><b>TOPIK SURVEI</b></th>
                <th class="text-center"><b>HASIL SURVEI</b></th>
                <th class="text-center"><b>RESPONDEN<b></th>
                <th class="text-center"><b>AKSI<b></th>
            </tr>
        </tfoot>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('#listsurveytopik').DataTable({
            "ordering": false,
        });

        $('.tambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('survey/formtambah') ?>",
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
    //aktifnonaktif

    function toggle(survey_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('survey/toggle') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                survey_id: survey_id
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
                    listsurveytopik();
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

    function edit(survey_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('survey/formedit') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                survey_id: survey_id
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




    function hapus(survey_id, nama) {
        Swal.fire({

            title: 'Hapus data?',
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
                    url: "<?= site_url('survey/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        survey_id: survey_id
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
                            listsurveytopik();
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
            }
        })
    }

    function resetsurvei(survey_id, nama) {
        Swal.fire({

            title: 'Reset data?',
            html: `Apakah anda yakin reset hasil <strong>${nama}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('resetnilai') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        survey_id: survey_id
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
                            listsurveytopik();
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
            }
        })
    }
</script>
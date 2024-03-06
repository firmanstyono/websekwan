<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <div class="modal-body">


                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Topik Survei
                    </label>
                    <input type="text" class="form-control form-control-sm" id="nama_survey" name="nama_survey">
                    <div class="invalid-feedback errornama_survey"></div>
                </div>
                <hr>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="ion-ios7-settings-strong"></i>
                            Keterangan <span class="text-danger">(1)</span>
                        </label>
                        <input type="text" id="ket_stb" name="ket_stb" class=" form-control form-control-sm" placeholder="Cth: Sangat tidak baik">
                        <div class="invalid-feedback errorket_stb"></div>
                    </div>
                    <!-- <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Range Awal
                        </label>
                        <input type="number" id="r1_stb" name="r1_stb" class="form-control form-control-sm">

                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Range Akhir
                        </label>
                        <input type="number" id="r2_stb" name="r2_stb" class=" form-control form-control-sm">

                    </div> -->


                    <div class="form-group col-md-6 col-12">
                        <label> <i class="ion-ios7-settings-strong"></i>
                            Keterangan <span class="text-danger">(2)</span>
                        </label>
                        <input type="text" id="ket_kb" name="ket_kb" class=" form-control form-control-sm" placeholder="Cth: Kurang Baik">
                        <div class="invalid-feedback errorket_kb"></div>
                    </div>

                    <!-- <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Range Awal
                        </label>
                        <input type="number" id="r1_kb" name="r1_kb" class="form-control form-control-sm">

                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Range Akhir
                        </label>
                        <input type="number" id="r2_kb" name="r2_kb" class=" form-control form-control-sm">

                    </div> -->



                    <div class="form-group col-md-6 col-12">
                        <label> <i class="ion-ios7-settings-strong"></i>
                            Keterangan <span class="text-danger">(3)</span>
                        </label>
                        <input type="text" id="ket_b" name="ket_b" class=" form-control form-control-sm" placeholder="Cth: Baik">
                        <div class="invalid-feedback errorket_b"></div>
                    </div>

                    <!-- <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Range Awal
                        </label>
                        <input type="number" id="r1_b" name="r1_b" class="form-control form-control-sm">

                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Range Akhir
                        </label>
                        <input type="number" id="r2_b" name="r2_b" class=" form-control form-control-sm">

                    </div> -->


                    <div class="form-group col-md-6 col-12">
                        <label> <i class="ion-ios7-settings-strong"></i>
                            Keterangan <span class="text-danger">(4)</span>
                        </label>
                        <input type="text" id="ket_sb" name="ket_sb" class=" form-control form-control-sm" placeholder="Cth: Sangat Baik">
                        <div class="invalid-feedback errorket_sb"></div>
                    </div>

                    <!-- <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Range Awal
                        </label>
                        <input type="number" id="r1_sb" name="r1_sb" class="form-control form-control-sm">

                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Range Akhir
                        </label>
                        <input type="number" id="r2_sb" name="r2_sb" class=" form-control form-control-sm">
                    </div> -->

                </div>
                <small>
                    <strong class="text-danger"> Keterangan hasil</strong>, diisi berurutan seperti contoh di placeholder. (dimulai dari terkecil) </small>
                </small>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('survey/simpansurveytopik') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {


                        if (response.error.nama_survey) {
                            $('#nama_survey').addClass('is-invalid');
                            $('.errornama_survey').html(response.error.nama_survey);
                        } else {
                            $('#nama_survey').removeClass('is-invalid');
                            $('.errornama_survey').html('');
                        }

                        if (response.error.ket_stb) {
                            $('#ket_stb').addClass('is-invalid');
                            $('.errorket_stb').html(response.error.ket_stb);
                        } else {
                            $('#ket_stb').removeClass('is-invalid');
                            $('.errorket_stb').html('');
                        }

                        if (response.error.ket_kb) {
                            $('#ket_kb').addClass('is-invalid');
                            $('.errorket_kb').html(response.error.ket_kb);
                        } else {
                            $('#ket_kb').removeClass('is-invalid');
                            $('.errorket_kb').html('');
                        }

                        if (response.error.ket_b) {
                            $('#ket_b').addClass('is-invalid');
                            $('.errorket_b').html(response.error.ket_b);
                        } else {
                            $('#ket_b').removeClass('is-invalid');
                            $('.errorket_b').html('');
                        }

                        if (response.error.ket_sb) {
                            $('#ket_sb').addClass('is-invalid');
                            $('.errorket_sb').html(response.error.ket_sb);
                        } else {
                            $('#ket_sb').removeClass('is-invalid');
                            $('.errorket_sb').html('');
                        }

                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    } else {

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
                        $('#modaltambah').modal('hide');
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                        listsurveytopik();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {

                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), )
                    $('#modaltambah').modal('hide');
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            });
        });
    });
</script>
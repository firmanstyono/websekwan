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
            <div class='card-body'>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Nama Template
                        </label>
                        <input type="text" class="form-control form-control-sm" id="nama" name="nama">
                        <div class="invalid-feedback errornama"></div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="far fa-folder"></i>
                            Folder
                        </label>
                        <input type="text" class="form-control form-control-sm" id="folder" name="folder" title="Pastikan nama folder di public dan views sama..!" placeholder="Folder sama di Public & Views">
                        <div class="invalid-feedback errorfolder"></div>
                        <!-- <small> <strong class="text-warning"><i> Pastikan nama folder di public dan views sama..!</i></strong></small> -->

                    </div>
                    <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-arrow-expand-vertical"></i>
                            Tinggi Logo
                        </label>
                        <input type="number" id="hplogo" name="hplogo" placeholder="pixel" class="form-control form-control-sm">
                        <div class="invalid-feedback errorhplogo"></div>
                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-arrow-expand-horizontal"></i>
                            Lebar Logo
                        </label>
                        <input type="number" id="wllogo" name="wllogo" placeholder="pixel" class="form-control form-control-sm">
                        <div class="invalid-feedback errorwllogo"></div>
                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-arrow-expand-vertical"></i>
                            Tinggi <small>Banner</small>
                        </label>
                        <input type="number" id="hpbanner" name="hpbanner" placeholder="pixel" class="form-control form-control-sm">
                        <div class="invalid-feedback errorhpbanner"></div>
                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label> <i class="mdi mdi-arrow-expand-horizontal"></i>
                            Lebar <small>Banner</small>
                        </label>
                        <input type="number" id="wlbanner" name="wlbanner" placeholder="pixel" class="form-control form-control-sm">
                        <div class="invalid-feedback errorwlbanner"></div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-clipboard-check-outline"></i> Versi bootstrap <small>(Modal Popup)</small></label>
                        <div class="form-control form-control-sm">
                            <input type="radio" name="verbost" id="verbost2" value="0" checked> <label for="verbost2" class="pointer"> Ver. 4x &nbsp</label>
                            <input type="radio" name="verbost" id="verbost1" value="1"> <label for="verbost1" class="pointer"> Ver. 5x </label>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-clipboard-check-outline"></i> Gunakan 2 tema <small>(desktop & mobile)</small></label>
                        <div class="form-control form-control-sm">
                            <input type="radio" name="duatema" id="duatema2" value="0" checked> <label for="duatema2" class="pointer"> Tidak &nbsp</label>
                            <input type="radio" name="duatema" id="duatema1" value="1"> <label for="duatema1" class="pointer"> Ya </label>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="far fa-user"></i>
                            Sumber Pembuat
                        </label>
                        <input type="text" class="form-control form-control-sm" id="pembuat" name="pembuat">
                        <div class="invalid-feedback errorpembuat"></div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="ion-ios7-settings-strong"></i>
                            Keterangan
                        </label>
                        <input type="text" class="form-control form-control-sm" id="ket" name="ket">
                        <div class="invalid-feedback errorket"></div>
                    </div>
                </div>
                <div class="form-group ">
                    <label>Foto Template</label>
                    <input type="file" class="form-control form-control-sm" id="img" name="img">
                    <div class="invalid-feedback errorimg"></div>
                </div>
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
                url: '<?= site_url('template/simpantemplate') ?>',
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


                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errornama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errornama').html('');
                        }

                        if (response.error.pembuat) {
                            $('#pembuat').addClass('is-invalid');
                            $('.errorpembuat').html(response.error.pembuat);
                        } else {
                            $('#pembuat').removeClass('is-invalid');
                            $('.errorpembuat').html('');
                        }

                        if (response.error.folder) {
                            $('#folder').addClass('is-invalid');
                            $('.errorfolder').html(response.error.folder);
                        } else {
                            $('#folder').removeClass('is-invalid');
                            $('.errorfolder').html('');
                        }
                        if (response.error.img) {
                            $('#img').addClass('is-invalid');
                            $('.errorimg').html(response.error.img);
                        } else {
                            $('#img').removeClass('is-invalid');
                            $('.errorimg').html('');
                        }
                        if (response.error.hplogo) {
                            $('#hplogo').addClass('is-invalid');
                            $('.errorhplogo').html(response.error.hplogo);
                        } else {
                            $('#hplogo').removeClass('is-invalid');
                            $('.errorhplogo').html('');
                        }

                        if (response.error.wllogo) {
                            $('#wllogo').addClass('is-invalid');
                            $('.errorwllogo').html(response.error.wllogo);
                        } else {
                            $('#wllogo').removeClass('is-invalid');
                            $('.errorwllogo').html('');
                        }

                        if (response.error.hpbanner) {
                            $('#hpbanner').addClass('is-invalid');
                            $('.errorhpbanner').html(response.error.hpbanner);
                        } else {
                            $('#hpbanner').removeClass('is-invalid');
                            $('.errorhpbanner').html('');
                        }

                        if (response.error.wlbanner) {
                            $('#wlbanner').addClass('is-invalid');
                            $('.errorwlbanner').html(response.error.wlbanner);
                        } else {
                            $('#wlbanner').removeClass('is-invalid');
                            $('.errorwlbanner').html('');
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
                        listtemplate();
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
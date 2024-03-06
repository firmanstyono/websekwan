<link href="<?= base_url() ?>/public/template/backend/standar/assets/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= base_url() ?>/public/template/backend/standar/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/public/template/backend/standar/assets/js/date-picker.js"></script>

<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>

            <div class="modal-body">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profil" role="tab">Profil</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#publikasi" role="tab">Publikasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#penelitian" role="tab">Penelitian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pengabdian" role="tab">Pengabdian</a>
                    </li> -->
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="profil" role="tabpanel">
                        <p></p>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-account"></i>
                                    Nama
                                </label>
                                <input type="text" id="nama" name="nama" class="form-control">
                                <div class="invalid-feedback errornama"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-account-key"></i>
                                    NIP/No Pegawai
                                </label>
                                <input type="text" id="nip" name="nip" class=" form-control">
                                <div class="invalid-feedback errornip"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-map-marker-multiple"></i>
                                    Tempat Lahir
                                </label>
                                <input type=" text" id="tempat_lahir" name="tempat_lahir" class="form-control">
                                <div class="invalid-feedback errortempat_lahir"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-calendar-range"></i>
                                    Tanggal Lahir
                                </label>
                                <input type="text" id="tgl_lahir" name="tgl_lahir" class=" form-control date-picker">
                                <div class="invalid-feedback errortgl_lahir"></div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-gender-male-female"></i>
                                    Jenis Kelamin
                                </label>

                                <select class="form-control" name="jk" id="jk">
                                    <option Disabled=true Selected=true>-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>

                                <div class="invalid-feedback errorjk"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-file-document-box"></i>
                                    Agama
                                </label>

                                <select class="form-control" name="agama" id="agama">
                                    <option Disabled=true Selected=true>-- Pilih Agama --</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Khonghucu">Khonghucu</option>
                                </select>
                                <div class="invalid-feedback erroragama"></div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-certificate"></i>
                                    Pangkat - Golongan
                                </label>
                                <input type=" text" id="pangkat" name="pangkat" class="form-control">
                                <div class="invalid-feedback errorpangkat"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-arrange-send-backward"></i>
                                    Jabatan
                                </label>
                                <input type="text" id="jabatan" name="jabatan" class=" form-control">
                                <div class="invalid-feedback errorjabatan"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> <i class="mdi mdi-image"></i>
                                Foto Profil
                            </label>
                            <input type="file" id="gambar" name="gambar" class="form-control">
                            <div class="invalid-feedback errorgambar"></div>
                        </div>
                    </div>

                    <!-- <div class="tab-pane" id="publikasi" role="tabpanel">
                        <p></p>
                        <div class="form-group">
                            <textarea type="text" class="form-control form-control-sm" id="publikasi" name="publikasi"></textarea>
                        </div>
                    </div>

                    <div class="tab-pane " id="penelitian" role="tabpanel">
                        <p></p>
                        <div class="form-group">
                            <textarea type="text" class="form-control form-control-sm" id="penelitian" name="penelitian"></textarea>
                        </div>
                    </div>

                    <div class="tab-pane " id="pengabdian" role="tabpanel">
                        <p></p>
                        <div class="form-group">
                            <textarea type="text" class="form-control form-control-sm" id="pengabdian" name="pengabdian"></textarea>
                        </div>
                    </div> -->

                </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('textarea#publikasi').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: false
        });

        $('textarea#penelitian').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: false
        });

        $('textarea#pengabdian').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: false
        });

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('pegawai/simpanPegawai') ?>',
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

                        if (response.error.nip) {
                            $('#nip').addClass('is-invalid');
                            $('.errornip').html(response.error.nip);
                        } else {
                            $('#nip').removeClass('is-invalid');
                            $('.errornip').html('');
                        }

                        if (response.error.tempat_lahir) {
                            $('#tempat_lahir').addClass('is-invalid');
                            $('.errortempat_lahir').html(response.error.tempat_lahir);
                        } else {
                            $('#tempat_lahir').removeClass('is-invalid');
                            $('.errortempat_lahir').html('');
                        }

                        if (response.error.tgl_lahir) {
                            $('#tgl_lahir').addClass('is-invalid');
                            $('.errortgl_lahir').html(response.error.tgl_lahir);
                        } else {
                            $('#tgl_lahir').removeClass('is-invalid');
                            $('.errortgl_lahir').html('');
                        }

                        if (response.error.jk) {
                            $('#jk').addClass('is-invalid');
                            $('.errorjk').html(response.error.jk);
                        } else {
                            $('#jk').removeClass('is-invalid');
                            $('.errorjk').html('');
                        }

                        if (response.error.agama) {
                            $('#agama').addClass('is-invalid');
                            $('.erroragama').html(response.error.agama);
                        } else {
                            $('#agama').removeClass('is-invalid');
                            $('.erroragama').html('');
                        }

                        if (response.error.pangkat) {
                            $('#pangkat').addClass('is-invalid');
                            $('.errorpangkat').html(response.error.pangkat);
                        } else {
                            $('#pangkat').removeClass('is-invalid');
                            $('.errorpangkat').html('');
                        }

                        if (response.error.jabatan) {
                            $('#jabatan').addClass('is-invalid');
                            $('.errorjabatan').html(response.error.jabatan);
                        } else {
                            $('#jabatan').removeClass('is-invalid');
                            $('.errorjabatan').html('');
                        }

                        if (response.error.gambar) {
                            $('#gambar').addClass('is-invalid');
                            $('.errorGambar').html(response.error.gambar);
                        } else {
                            $('#gambar').removeClass('is-invalid');
                            $('.errorGambar').html('');
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
                        listpegawai();
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                    $('#modaltambah').modal('hide');
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            });
        });
    });
</script>
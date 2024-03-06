<?= $this->section('content') ?>
<?= $this->extend('backend/' . $folder . '/' . 'script'); ?>
<link href="<?= base_url() ?>/public/template/backend/<?= $folder ?>/assets/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= base_url() ?>/public/template/backend/<?= $folder ?>/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/public/template/backend/<?= $folder ?>/assets/js/date-picker.js"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box ">
            <div class="state-information d-none d-sm-block">
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper">

    <div class="card mb-3 p-2">

        <div class="card-header font-18 bg-light">
            <h6 class="modal-title mt-0">
                <i class="mdi mdi-square-edit-outline"></i> <?= $subtitle ?> Berita

                <div class="float-right">
                    <button class="btn btn-primary btn-sm btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                    <a href="<?= base_url('berita/all/') ?>" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>
                </div>

            </h6>
        </div>

        <?= form_open_multipart('', ['class' => 'formedit']) ?>

        <div class='card-body'>

            <div class="row">

                <div class="col-lg-9">
                    <div class=" mb-0">
                        <input type="hidden" value="<?= $berita_id ?>" name="berita_id">

                        <div class="row">
                            <div class="form-group col-md-10 col-12">
                                <label>
                                    Judul Berita
                                </label>
                                <input type="text" class="form-control form-control-sm" id="judul_berita" name="judul_berita" value="<?= $judul_berita ?>">

                                <div class="invalid-feedback errorJudul">
                                </div>
                            </div>

                            <div class="form-group col-md-2 col-12">
                                <label> </i>
                                    Berita Utama
                                </label>
                                <!-- <div class="form-control form-control-sm">
                                        <input type="radio" id="headline1" name="headline" value="0" <?= $headline == '0' ? 'checked' : '' ?>> <label for="headline1" class="pointer">Tidak &nbsp</label>
                                        <input type="radio" id="headline2" name="headline" value="1" <?= $headline == '1' ? 'checked' : '' ?>> <label for="headline2" class="pointer"> Ya &nbsp</label>
                                    </div> -->
                                <select class="form-control form-control-sm" name="headline" id="headline">
                                    <option Disabled=true Selected=true>-- Pilih --</option>

                                    <option value="0" <?= $headline ==  0 ? 'selected' : '' ?>>Tidak</option>
                                    <option value="1" <?= $headline ==  1 ? 'selected' : '' ?>>Ya</option>

                                </select>
                            </div>

                        </div>

                        <div class="form-group p-0">
                            <!-- <label>Isi Berita</label> -->
                            <textarea type="text" id="isi" name="isi"> <?= esc($isi) ?></textarea>
                            <div class="invalid-feedback errorIsi"></div>
                        </div>

                        <!-- <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Keterangan Foto</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="ket_foto" name="ket_foto" value="<?= $ket_foto ?>">
                                </div>
                            </div> -->
                    </div><!-- Main Footer -->
                </div>
                <div class="col-lg-3">

                    <div class="mb-0">
                        <div class="row">
                            <div class="form-group col-md-6 col-12 ">
                                <label>Berita Pilihan</label>
                                <select class="form-control form-control-sm" name="pilihan" id="pilihan">
                                    <option value="0" <?= $pilihan ==  0 ? 'selected' : '' ?>>Tidak</option>
                                    <option value="1" <?= $pilihan ==  1 ? 'selected' : '' ?>>Ya</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12 ">

                                <label> Tanggal Posting </label>

                                <input type="text" id="tgl_berita" name="tgl_berita" value="<?= shortdate_indo($tgl_berita) ?>" class="form-control form-control-sm date-picker">

                                <div class="invalid-feedback errortgl_berita"></div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ringkasan Berita</label>
                            <textarea type="text" rows="10" class="form-control form-control-sm" id="ringkasan" name="ringkasan"> <?= esc($ringkasan) ?></textarea>
                            <div class="invalid-feedback errorringkasan"></div>
                        </div>

                        <div class="form-group">
                            <label>Kategori Berita</label>
                            <select class="form-control form-control-sm" name="kategori_id" id="kategori_id">
                                <option Disabled=true Selected=true>-- Pilih Kategori --</option>
                                <?php foreach ($kategori as $key => $value) { ?>
                                    <option value="<?= $value['kategori_id'] ?>" <?= $kategori_id ==  $value['kategori_id'] ? 'selected' : '' ?>><?= $value['nama_kategori'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback errorKategori"></div>
                        </div>

                        <div class="form-group">
                            <label>Tag Berita</label>

                            <select name="tag_id[]" id="tag_id" class="form-control form-control-sm" multiple="multiple">

                                <?php foreach ($tag as $key => $value) { ?>
                                    <option value="<?= $value['tag_id'] ?>" <?php foreach ($tag_id as $key => $val) { ?> <?= $val['tag_id'] ==  $value['tag_id'] ? 'selected' : '';
                                                                                                                        } ?>>
                                        <?= $value['nama_tag'] ?></option>
                                <?php } ?>

                            </select>
                            <div class="invalid-feedback errorTag"></div>
                        </div>

                        <!-- <div class="row"> -->


                        <div class="form-group ">
                            <label>Komentar Berita</label>
                            <select class="form-control form-control-sm" name="sts_komen" id="sts_komen">
                                <option value="0" <?= $sts_komen ==  0 ? 'selected' : '' ?>>Tidak</option>
                                <option value="1" <?= $sts_komen ==  1 ? 'selected' : '' ?>>Ya</option>
                            </select>
                        </div>
                        <?php if ($akses == '1') { ?>
                            <div class="form-group ">
                                <label> </i>
                                    Penulis
                                </label>
                                <select name="id" id="id" class="form-control form-control-sm ">
                                    <option Disabled=true Selected=true>-- Pilih Penulis--</option>
                                    <?php foreach ($user as $key => $data) { ?>

                                        <option value="<?= $data['id'] ?>" <?= $id ==  $data['id'] ? 'selected' : '' ?>><?= $data['fullname'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <!-- </div> -->
                        <br>


                        <div class="modal-footer p-0">
                            <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                            <a href="<?= base_url('berita/all/') ?>" class="btn btn-warning"><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?= form_close() ?>
    </div>


</div>


<script>
    $(document).ready(function() {
        $('#id').select2({})
        $('#kategori_id').select2({})
        $('#tag_id').select2({
            placeholder: 'Silahkan Pilih tag'
        })

        $('textarea#isi').summernote({
            height: 540,
            fontSizes: ['11', '12', '13', '14', '15', '16', '17', '18', '20', '24', '36', '40', '48'],

            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['height', ['height']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['color', ['color']],
                ['insert', ['picture', 'link', 'video', 'table']],
                ['view', ['fullscreen']],

            ],

        });

        $('.btnupdate').click(function(e) {
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



                e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('berita/updateberita') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupdate').attr('disable', 'disable');
                    $('.btnupdate').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupdate').removeAttr('disable', 'disable');
                    $('.btnupdate').html('<i class="mdi mdi-content-save-all"></i> Simpan');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.judul_berita) {
                            $('#judul_berita').addClass('is-invalid');
                            $('.errorJudul').html(response.error.judul_berita);
                        } else {
                            $('#judul_berita').removeClass('is-invalid');
                            $('.errorJudul').html('');
                        }

                        if (response.error.kategori_id) {
                            $('#kategori_id').addClass('is-invalid');
                            $('.errorKategori').html(response.error.kategori_id);
                        } else {
                            $('#kategori_id').removeClass('is-invalid');
                            $('.errorKategori').html('');
                        }

                        if (response.error.tag_id) {
                            $('#tag_id').addClass('is-invalid');
                            $('.errorTag').html(response.error.tag_id);
                        } else {
                            $('#tag_id').removeClass('is-invalid');
                            $('.errorTag').html('');
                        }

                        if (response.error.isi) {
                            $('#isi').addClass('is-invalid');
                            $('.errorIsi').html(response.error.isi);
                        } else {
                            $('#isi').removeClass('is-invalid');
                            $('.errorIsi').html('');
                        }

                        if (response.error.tgl_berita) {
                            $('#tgl_berita').addClass('is-invalid');
                            $('.errortgl_berita').html(response.error.tgl_berita);
                        } else {
                            $('#tgl_berita').removeClass('is-invalid');
                            $('.errortgl_berita').html('');
                        }
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    } else {


                        Swal.fire({
                            title: "Sukses!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1550
                        }).then(function() {
                            window.location = '../berita/all';
                        });


                        // toastr["success"](response.sukses)


                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    // $('#modaledit').modal('hide');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
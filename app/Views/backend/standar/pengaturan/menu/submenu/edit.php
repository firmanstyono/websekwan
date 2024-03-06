<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Edit Data
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open('', ['class' => 'formedit']) ?>
            <!-- <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" /> -->
            <div class="modal-body">
                <input type="hidden" class="form-control" id="submenu_id" value="<?= $submenu_id ?>" name="submenu_id" readonly>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Nama Sub Menu</label>
                        <input type="text" id="nama_submenu" name="nama_submenu" value="<?= $nama_submenu ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errornama_submenu"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Sumber Link</label> <small class="text-secondary">(Pilih jika Link mau diganti)</small>
                        <select class="form-control form-control-sm" name="sumberlink" id="sumberlink">
                            <option Disabled=true Selected=true>-- Pilih Sumber Link--</option>
                            <option value="1" data-linkexternalsm="N">Kategori Berita</option>
                            <option value="2" data-linkexternalsm="N">Halaman</option>
                            <option value="3" data-linkexternalsm="N">Modul CMS</option>
                            <option value="4" data-linkexternalsm="Y">Eksternal</option>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="form-group" id="berita">
                        <label>Pilih Kategori Berita</label>
                        <select name="dberita" id="dberita" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Kategori Berita--</option>
                            <?php foreach ($kategoriberita as $key => $data) { ?>
                                <option data-link_submenu="category/<?= esc($data['slug_kategori']) ?>"><?= $data['nama_kategori'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>

                    <div class="form-group" id="halaman">
                        <label>Pilih Halaman</label>
                        <select name="dhalaman" id="dhalaman" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Halaman--</option>
                            <?php foreach ($halaman as $key => $data) { ?>
                                <option data-link_submenu="page/<?= esc($data['slug_berita']) ?>"><?= $data['judul_berita'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>

                    <div class="form-group" id="modul">
                        <label>Pilih Modul CMS</label>
                        <select class="form-control form-control-sm" name="modulcms" id="modulcms">
                            <option Disabled=true Selected=true>-- Pilih Modul CMS--</option>
                            <?php foreach ($modulpublic as $key => $data) { ?>
                                <option data-link_submenu="<?= esc($data['link']) ?>"><?= $data['modpublic'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errormenu_link"></div>
                    </div>

                    <div class="form-group" id="eksternal">
                        <label>
                            Link URL <small class="text-danger">(Misalnya: http://cms.datagoe.com/)</small>
                        </label>
                        <input type="text" id="link_submenu" name="link_submenu" value="<?= $link_submenu ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errorlink_submenu"></div>
                    </div>
                    <input type="hidden" id="linkexternalsm" name="linkexternalsm" value="<?= $linkexternalsm ?>" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label>Link Sebelumnya</label>
                    <input type="text" id="link_submenuold" name="link_submenuold" readonly value="<?= $link_submenu ?>" class="form-control form-control-sm">

                </div>
                <div class="row">
                    <div class="form-group col-md-3 col-12">
                        <label>Urutan</label>
                        <input type="number" class="form-control form-control-sm" id="urutansm" name="urutansm" value="<?= $urutansm ?>">
                        <div class="invalid-feedback errorurutansm"></div>
                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label>Target</label>
                        <select class="form-control form-control-sm" name="targetsm" id="targetsm">
                            <option value="_parent" <?= $targetsm ==  '_parent' ? 'selected' : '' ?>>_parent</option>
                            <option value="_blank" <?= $targetsm ==  '_blank' ? 'selected' : '' ?>>_blank </option>
                        </select>

                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Menu Level 3</label>
                        <div class="form-control form-control-sm">
                            <input type="radio" id="parentsm1" name="parentsm" value="N" <?= $parentsm == 'N' ? 'checked' : '' ?>><label for="parentsm1" class="pointer">&nbspTidak &nbsp</label>
                            <input type="radio" id="parentsm2" name="parentsm" value="Y" <?= $parentsm == 'Y' ? 'checked' : '' ?>><label for="parentsm2" class="pointer">&nbspYa &nbsp</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Icon Sub Menu</label>
                        <input type="text" class="form-control form-control-sm" id="iconsm" name="iconsm" value="<?= $iconsm ?>">
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Lihat Icon</label>
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-outline-secondary waves-effect waves-light btn-sm mr-1" data-toggle="modal" data-target=".fontawesome">Font Awesome</button>
                            <button type="button" class="btn btn-outline-secondary waves-effect waves-light btn-sm" data-toggle="modal" data-target=".mdideril">Material Design</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#eksternal").hide();
        $("#berita").hide();
        $("#halaman").hide();
        $("#modul").hide();


        // Pilihan Sumber Link 
        $('#sumberlink').on('change', function() {
            const linkexternalsm = $('#sumberlink option:selected').data('linkexternalsm');
            $('[name=linkexternalsm]').val(linkexternalsm);
        });

        // Pilihan Modul CMS
        $('#modulcms').on('change', function() {

            const link_submenu = $('#modulcms option:selected').data('link_submenu');
            $('[name=link_submenu]').val(link_submenu);
        });
        // Pilihan Kategori Berita
        $('#dberita').on('change', function() {

            const link_submenu = $('#dberita option:selected').data('link_submenu');
            $('[name=link_submenu]').val(link_submenu);
        });

        // Pilihan Halaman
        $('#dhalaman').on('change', function() {
            const link_submenu = $('#dhalaman option:selected').data('link_submenu');
            $('[name=link_submenu]').val(link_submenu);
        });

        $('#sumberlink').on('change', function() {
            $('[name=dberita]').val('');
            $('[name=dhalaman]').val('');
            $('[name=modulcms]').val('');

            if ($('#sumberlink').val() == '1') {
                $("#eksternal").hide();
                $("#berita").show();
                $("#halaman").hide();
                $("#modul").hide();
                $('[name=link_submenu]').val('');
            } else if ($('#sumberlink').val() == '2') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").show();
                $("#modul").hide();
                $('[name=link_submenu]').val('');
            } else if ($('#sumberlink').val() == '3') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").show();
                $('[name=link_submenu]').val('');
            } else {
                $("#eksternal").show();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").hide();
                $('[name=link_submenu]').val('');
            }
        });


        $('.btnupdate').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('menu/updatesubmenu') ?>',
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

                        if (response.error.nama_submenu) {
                            $('#nama_submenu').addClass('is-invalid');
                            $('.errornama_submenu').html(response.error.nama_submenu);
                        } else {
                            $('#nama_submenu').removeClass('is-invalid');
                            $('.errornama_submenu').html('');
                        }


                        if (response.error.link_submenu) {
                            $('#link_submenu').addClass('is-invalid');
                            $('.errorlink_submenu').html(response.error.link_submenu);
                        } else {
                            $('#link_submenu').removeClass('is-invalid');
                            $('.errorlink_submenu').html('');
                        }

                        if (response.error.urutan) {
                            $('#urutan').addClass('is-invalid');
                            $('.errorurutan').html(response.error.urutan);
                        } else {
                            $('#urutan').removeClass('is-invalid');
                            $('.errorurutan').html('');
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
                        $('#modaledit').modal('hide');
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                        listsubmenu();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                    $('#modaledit').modal('hide');
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            });
        });
    });
</script>
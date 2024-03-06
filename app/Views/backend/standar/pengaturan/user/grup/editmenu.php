<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Ubah Akses Menu Dashboard
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formeditgrp']) ?>

            <div class="modal-body p-2 mb-0">
                <input type="hidden" value="<?= $id_grup ?>" name="id_grup">

                <div class="form-group">
                    <!-- <label class="">Akses Modul</label> -->

                    <div class="table-responsive p-0 mb-0">
                        <table class="table table-bordered dataTable table-hover">
                            <thead class="bg-light">
                                <tr>

                                    <th class="text-center p-1">#</th>
                                    <th class="p-1">MENU UTAMA</th>
                                    <th class="p-1">VISIBILITAS MENU</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor = 0;
                                foreach ($modul as $data) :
                                    $nomor++; ?>
                                    <tr class="mb-0">
                                        <td class="text-center p-1">
                                            <?= $nomor ?>.</td>
                                        <td class="p-1">

                                            <?php if ($data['aksesmenu'] == '1') { ?>
                                                <a class="text-success"><?= esc($data['modul']) ?></a>
                                            <?php } else { ?>
                                                <a class="text-danger"><?= esc($data['modul']) ?></a>
                                            <?php } ?>

                                        </td>

                                        <td class="p-1">
                                            <select name="aksesmenu[]" class="form-control form-control-sm pointer">

                                                <option value="0" <?php if ($data['aksesmenu'] == '0') echo "selected"; ?>>Sembunyikan Menu</option>
                                                <option value="1" <?php if ($data['aksesmenu'] == '1') echo "selected"; ?>>Tampilkan Menu</option>

                                            </select>

                                            <div class="invalid-feedback errorakses"></div>
                                        </td>
                                        <td style="display:none"> <input type="hidden" name="id_modul[]" value="<?= $data['id_modul'] ?>" class="form-control"></td>
                                        <td style="display:none"> <input type="hidden" name="id_grupakses[]" value="<?= $data['id_grupakses'] ?>" class="form-control">

                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-footer p-1">
                <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.btnupdate').click(function(e) {
                e.preventDefault();
                let form = $('.formeditgrp')[0];
                let data = new FormData(form);
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
                    $.ajax({
                        type: "post",
                        url: '<?= site_url('user/updatemenu') ?>',
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
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            } else {

                                toastr["success"](response.sukses)
                                $('#modaledit').modal('hide');
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                                listgrup();
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
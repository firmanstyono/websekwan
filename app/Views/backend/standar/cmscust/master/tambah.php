<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Tambah Data
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>

            <div class="modal-body">
                <input type="hidden" class="form-control" id="req" value="<?= $req ?>" name="req" readonly>
                <input type="hidden" class="form-control" value="<?= $jns ?>" name="jns_master" readonly>


                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_master" name="nama_master">
                        <div class="invalid-feedback errornama_master"></div>
                    </div>
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
                    url: '<?= site_url('masterdata/simpandata') ?>',
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

                            if (response.error.nama_master) {
                                $('#nama_master').addClass('is-invalid');
                                $('.errornama_master').html(response.error.nama_master);
                            } else {
                                $('#nama_master').removeClass('is-invalid');
                                $('.errornama_master').html('');
                            }
                            $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);

                        } else if (response.kdganda) {

                            toastr["error"](response.kdganda)
                        } else if (response.kdkosong) {
                            $('#kd_kat').addClass('is-invalid');
                            toastr["error"](response.kdkosong)

                        } else {

                            toastr["success"](response.sukses)
                            $('#modaltambah').modal('hide');
                            $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            listmaster();
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
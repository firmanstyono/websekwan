<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?php if ($jum == 0) {
                $nilai = 1;
                $ket = 'Cth: Tidak sesuai';
            } elseif ($jum == 1) {
                $nilai = 2;
                $ket = 'Cth: Kurang Sesuai';
            } elseif ($jum == 2) {
                $nilai = 3;
                $ket = 'Cth: Sesuai';
            } else {
                $nilai = 4;
                $ket = 'Cth: Sangat Sesuai';
            }
            ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-8 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Jawaban
                        </label>
                        <input type="hidden" id="pertanyaan_id" name="pertanyaan_id" value="<?= $pertanyaan_id ?>" class="form-control">
                        <input type="text" id="jawaban" name="jawaban" class="form-control" placeholder="<?= $ket ?>">
                        <div class="invalid-feedback errorjawaban"></div>
                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Poin
                        </label>
                        <input type="number" id="nilai" name="nilai" value="<?= $nilai ?>" class="form-control" readonly>
                        <div class="invalid-feedback errornilai"></div>
                    </div>
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

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('survey/simpanjawaban') ?>',
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

                        if (response.error.jawaban) {
                            $('#jawaban').addClass('is-invalid');
                            $('.errorjawaban').html(response.error.jawaban);
                        } else {
                            $('#jawaban').removeClass('is-invalid');
                            $('.errorjawaban').html('');
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
                        listjawaban();
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
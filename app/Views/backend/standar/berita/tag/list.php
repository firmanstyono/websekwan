<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahtag">
        <i class="fas fa fa-plus-circle"></i> Tambah Tagar Baru
    </button>
    <hr>
<?php } ?>
<div class="table-responsive b-0 ">
    <table id="listtag" class="table table-hover table-striped table-bordered">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>TAGAR</b></th>
                <th width="60" class="text-center"><b>JUMLAH</b></th>
                <th width="60" class="text-center"><b>AKSI</b></th>
            </tr>
        </thead>

        <tbody>

            <?php


            use App\Models\ModelBeritaTag;

            $nomor = 0;
            foreach ($list as $data) :
                $nomor++;
                $this->beritatag = new ModelBeritaTag();
                $jberita = $this->beritatag->where('tag_id', $data['tag_id'])->get()->getNumRows();

            ?>

                <tr>
                    <td class="text-center p-2"><?= ($nomor) ?> </td>

                    <td class="p-2">
                        <?php if ($jberita == 0) { ?>
                            <?= esc($data['nama_tag']) ?>
                        <?php } else { ?>
                            <a href="<?= base_url('tag/' . $data['tag_id'] . '/' . $data['slug_tag']) ?>" target="_blank" class="text-primary" title="jumlah berita"> <?= esc($data['nama_tag']) ?></a>
                        <?php } ?>
                    </td>
                    <td class="text-center p-2">
                        <?php if ($jberita == 0) { ?>
                            <a class="text-secondary" title="belum ada berita"><?= $jberita ?></a>
                        <?php } else { ?>
                            <a class="text-dark" title="jumlah berita"><?= $jberita ?></a>
                        <?php } ?>
                    </td>

                    <td class="text-center p-2">
                        <?php if ($ubah == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['tag_id'] ?>')">
                                <i class="icon fas fa-edit text-info"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>
                        <?php if ($jberita == 0 && $hapus == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['tag_id'] ?>')">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="far fa-trash-alt text-secondary"></i>
                            </button>
                        <?php } ?>

                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>

        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>

                <th><b>TAGAR</b></th>
                <th class="text-center"><b>JUMLAH</b></th>
                <th class="text-center"><b>AKSI<b></th>
            </tr>
        </tfoot>
    </table>

</div>
<script>
    $(document).ready(function() {
        $('#listtag').DataTable({
            'ordering': false,
            'iDisplayLength': 25,
        });

        $('.tambahtag').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('berita/formtag') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambah').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
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

    function edit(tag_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('berita/formedittag') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                tag_id: tag_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modaledit').modal('show');
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

    function hapus(tag_id) {
        Swal.fire({
            width: '400px',

            title: 'Hapus data?',
            text: `Apakah anda yakin hapus data?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('berita/hapustag') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        tag_id: tag_id
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
                                listtag();
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
</script>
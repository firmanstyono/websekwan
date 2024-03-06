<?php if ($tambah == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahkategori">
        <i class="fas fa fa-plus-circle"></i> Tambah Kategori Baru
    </button>
    <hr>
<?php } ?>

<div class="table-responsive b-0 ">
    <table id="listkategori" class="table table-hover table-striped table-bordered">
        <thead class="bg-light">
            <tr>
                <th width="40" class="text-center p-2"><b>#</b></th>
                <th width="450" class="p-2"><b>KATEGORI</b></th>
                <th class="p-2"><b>LINK</b></th>
                <th width="60" class="text-center p-2"><b>AKSI</b></th>
            </tr>
        </thead>

        <tbody>

            <?php $nomor = 0;

            use App\Models\ModelBerita;

            foreach ($list as $data) :
                $nomor++;
                $this->berita = new ModelBerita();
                $jberita = $this->berita->where('kategori_id', $data['kategori_id'])->get()->getNumRows();
                // $jhits = $this->berita->populerbykat($data['kategori_id']);
                // foreach ($jhits as $h) {
                //     $hits = '<a class="text-danger">' . $h['hits'] . '</a>';
                // }

            ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>

                    <td class="p-1"><?= esc($data['nama_kategori']) ?> <a class="text-danger" title="Jumlah berita">(<?= $jberita ?>)</a>
                    </td>

                    <td class="p-1">
                        <i class="mdi mdi-link-variant"></i>
                        <a target="_blank" href="<?php echo base_url('category/' . $data['slug_kategori']) ?>">category/<?= esc($data['slug_kategori']) ?></a>
                    </td>

                    <td class="text-center p-1">
                        <?php if ($ubah == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="edit('<?= $data['kategori_id'] ?>')">
                                <i class="icon fas fa-edit text-info"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-light btn-sm p-1">
                                <i class="icon fas fa-edit text-secondary"></i>
                            </button>
                        <?php } ?>
                        <?php if ($jberita == 0 && $hapus == 1) { ?>
                            <button type="button" class="btn btn-light btn-sm p-1" onclick="hapus('<?= $data['kategori_id'] ?>')">
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
                <th class="text-center p-1"><b>#<b></th>

                <th class="p-1"><b>KATEGORI</b></th>
                <th class="p-1"><b>LINK</b></th>

                <th class="text-center p-1"><b>AKSI<b></th>
            </tr>
        </tfoot>
    </table>

</div>
<script>
    $(document).ready(function() {
        $('#listkategori').DataTable({
            'ordering': false,
            'iDisplayLength': 25,
        });
        $('.tambahkategori').click(function(e) {

            e.preventDefault();
            $.ajax({
                url: "<?= site_url('berita/formkategori') ?>",
                dataType: "json",
                data: {
                    csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),

                },
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

    function edit(kategori_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('berita/formeditkategori') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                kategori_id: kategori_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal({
                        // backdrop: 'static',
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

    function hapus(kategori_id) {
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
                    url: "<?= site_url('berita/hapuskategori') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                        kategori_id: kategori_id
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
                                listkategori();
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
<!-- =======================================================
      * CMS DATAGOE
      * Content Management System.
      *
      * @author			Vian Taum <viantaum17@gmail.com>
      * @website		www.datagoe.com
      * @copyright		(c) 2021 - Datagoe Software
 ======================================================== -->

<script nonce="${nonce}">
    // let csrfToken = '<?= csrf_token() ?>';
    // let csrfHash = '<?= csrf_hash() ?>';
    $('.tambahkritik').click(function(e) {

        e.preventDefault();

        $.ajax({
            url: "<?= site_url('kritiksaran/formkritik') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.data).show();
                $('#modalview').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modalview').modal('show');
                // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                // Swal.fire({
                //     title: "Maaf gagal load data!",
                //     icon: "error",
                //     showConfirmButton: false,
                //     timer: 3100
                // }).then(function() {
                //     window.location = '';
                // })
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    });


    $('.btnlihatpoling').click(function(e) {

        e.preventDefault();

        $.ajax({

            url: "<?= site_url('poling/lihatpoling') ?>",
            dataType: "json",

            success: function(response) {
                $('.viewmodal').html(response.data).show();
                $('#modalview').modal({
                    // backdrop: 'static',
                    // keyboard: false
                });

                $('#modalview').modal('show');
                $('body').removeClass("modal-open");
                // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            },
            error: function(xhr, ajaxOptions, thrownerror) {


                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    });

    //view infografis-----------
    function lihatinfo(id_banner) {

        $.ajax({
            type: "post",
            url: "<?= base_url('infografis/formlihatinfo') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                id_banner: id_banner
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            },

            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }

    //view foto-----------
    function lihatfoto(foto_id, nama_kategori_foto) {

        $.ajax({
            type: "post",
            url: "<?= base_url('foto/formlihatfoto') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                foto_id: foto_id,
                nama_kategori_foto: nama_kategori_foto
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        // backdrop: 'static',
                        // keyboard: false
                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }

    //view agenda-----------
    function lihatagenda(agenda_id) {

        $.ajax({
            type: "post",
            url: "<?= base_url('agenda/formlihatagenda') ?>",
            data: {
                // [csrfToken]: csrfHash,
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                agenda_id: agenda_id
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }

    //view layanan-----------
    function lihatlayanan(informasi_id) {

        $.ajax({
            type: "post",
            url: "<?= base_url('layanan/formlihatlayanan') ?>",
            data: {
                // [csrfToken]: csrfHash,
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                informasi_id: informasi_id
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false

                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }



    //view pengumuman-----------
    function lihatpengumuman(informasi_id) {

        $.ajax({
            type: "post",
            url: "<?= base_url('pengumuman/formlihatpengumuman') ?>",
            data: {
                // [csrfToken]: csrfHash,
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                informasi_id: informasi_id
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }

    //bank data
    function updatehits(bankdata_id) {

        $.ajax({
            url: "<?= site_url('bankdata/getbankdata') ?>",
            data: {
                // [csrfToken]: csrfHash,
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                bankdata_id: bankdata_id
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }

        });
    }

    // Ebook

    function lihatbook(ebook_id, kategoriebook_nama) {

        $.ajax({
            type: "post",
            url: "<?= site_url('ebook/formlihat') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                ebook_id: ebook_id,
                kategoriebook_nama: kategoriebook_nama,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modallihat').modal('show');
                    $('body').removeClass("modal-open");
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }

    //ebook data
    function updatehit(ebook_id) {

        $.ajax({
            url: "<?= site_url('ebook/getebook') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                ebook_id: ebook_id
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }

        });
    }

    //LIKE POSTING BERITA
    function likeposting(berita_id) {

        $.ajax({
            url: "<?= site_url('berita/likeposting') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                berita_id: berita_id
            },
            dataType: "json",
            success: function(response) {

                if (response.sukses) {
                    Swal.fire({
                        title: "Sukses!",
                        text: response.sukses,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1550
                    }).then(function() {
                        // window.location = '';
                    });
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }

            },

            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }

        });
    }

    function likepostingvid(video_id) {

        $.ajax({
            url: "<?= site_url('video/likevideo') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                video_id: video_id
            },
            dataType: "json",
            success: function(response) {

                if (response.sukses) {

                    Swal.fire({
                        title: "Sukses!",
                        text: response.sukses,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1550
                    }).then(function() {
                        // window.location = '';
                    });
                }

            },

            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }

        });
    }

    //lihat pegawai
    function lihatpegawai(pegawai_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('pegawai/formlihat') ?>",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
                pegawai_id: pegawai_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modallihat').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modallihat').modal('show');
                    $('body').removeClass("modal-open");
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }

    function penawaran() {

        $.ajax({
            type: "post",
            url: "<?= site_url('home/penawaran22') ?>",
            dataType: "json",
            data: {
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
            },
            success: function(response) {
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                $('.viewmodal').html(response.data).show();
                $('#modalview').modal('show');
                $('body').removeClass("modal-open");
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });

    }
    // poll
    $('.btnsimpanisipoling').click(function(e) {

        e.preventDefault();
        let form = $('.formtambah')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: '<?= site_url('poling/ubahpoling') ?>',
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            beforeSend: function() {
                $('.btnsimpanisipoling').attr('disable', 'disable');
                $('.btnsimpanisipoling').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
            },
            complete: function() {
                $('.btnsimpanisipoling').removeAttr('disable', 'disable');
                $('.btnsimpanisipoling').html('Pilih');
            },
            success: function(response) {
                if (response.error) {

                    Swal.fire({
                        title: "Maaf..!",
                        html: `Silahkan pilih salah satu jawaban diatas. `,
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3550
                    });
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
                if (response.gagal) {

                    Swal.fire({
                        title: "Maaf..!",
                        text: response.gagal,
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3550
                    });
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
                if (response.sukses) {

                    Swal.fire({
                        title: "Sukses!",
                        text: response.sukses,
                        icon: "success",
                        // showConfirmButton: false,
                        // timer: 3550
                    }).then(function() {
                        window.location = '<?= base_url('') ?>';
                    });
                }

            },
            error: function(xhr, ajaxOptions, thrownerror) {

                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    });
</script>
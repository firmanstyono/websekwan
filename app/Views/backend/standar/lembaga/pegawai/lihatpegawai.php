<div class="modal fade" id="modallihat">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <!-- <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title ?></h6>
            </div> -->
            <div class="modal-header">
                <h5 class="modal-title"><?= $title ?></h5>
                <?php if ($konfigurasi['verbost'] == 0) { ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <?php } else { ?>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <?php } ?>
            </div>
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />

            <div class="modal-body">
                <center>
                    <img src="<?= base_url('/public/img/informasi/pegawai/' . $gambar) ?>" alt="Profil" class="img-thumbnail p-0">
                </center>

                <table class="table table-sm table-hover table-striped p-0">

                    <tr>
                        <td class="p-1"><b>Nama</b></td>
                        <td class="p-1"><b>:</b></td>
                        <td class="p-1"><b><?= $nama ?></b></td>
                    </tr>
                    <tr>
                        <td class="p-1">NIP</td>
                        <td class="p-1">:</td>
                        <td class="p-1"><?= $nip ?></td>
                    </tr>
                    <tr>
                        <td class="p-1" width="22%">Tempat Tgl Lahir</td>
                        <td class="p-1" width="2%">:</td>
                        <td class="p-1"><?= $tempat_lahir ?>, <?= date_indo($tgl_lahir) ?></td>
                    </tr>
                    <tr>
                        <td class="p-1">Jenis Kelamin</td>
                        <td class="p-1">:</td>
                        <td class="p-1"><?= $jk ==  'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                    </tr>
                    <tr>
                        <td class="p-1">Agama</td>
                        <td class="p-1">:</td>
                        <td class="p-1"><?= $agama ?></td>
                    </tr>
                    <tr>
                        <td class="p-1">Pangkat Golongan</td>
                        <td class="p-1">:</td>
                        <td class="p-1"><?= $pangkat ?></td>
                    </tr>
                    <tr>
                        <td class="p-1">Jabatan</td>
                        <td class="p-1" width="2">:</td>
                        <td class="p-1" width="50%"><?= $jabatan ?></td>
                    </tr>
                    <?php if ($filetupoksi != '') { ?>
                        <tr>
                            <td class="p-1">Tupoksi</td>
                            <td class="p-1" width="2">:</td>
                            <td class="p-1" width="50%">
                                <a href="<?= base_url('/public/img/informasi/pegawai/' . $filetupoksi) ?>" target="_blank">
                                    <span class="badge badge-success text-secondary" title="Klik untuk lihat" style="font-size:13px"> Lihat Tupoksi &raquo;
                                    </span>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

            </div>

            <p class="p-1 mb-1">
                <?php if ($konfigurasi['verbost'] == 0) { ?>
                    <a class="ml-3 btn btn-danger" style="padding: 4px;" type="button" data-dismiss="modal">Tutup</a>
                <?php } else { ?>
                    <a class="ml-3 btn btn-danger" style="padding: 4px;" data-bs-dismiss="modal">Tutup</a>
                <?php } ?>
            </p>
        </div>

    </div>

</div>
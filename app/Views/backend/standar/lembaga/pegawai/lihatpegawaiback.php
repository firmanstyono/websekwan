<div class="modal fade" id="modallihat">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formedit']) ?>


            <div class="modal-body">
                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profil" role="tab">Profil</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#lainlain" role="tab">Lain-lain</a>
                    </li> -->

                </ul>
                <div class="tab-content">

                    <div class="tab-pane active" id="profil" role="tabpanel">
                        <p></p>
                        <table class="table table-sm table-hover table-striped p-1">

                            <tr>
                                <th width="160" rowspan="8">

                                    <center>
                                        <img src="<?= base_url('/public/img/informasi/pegawai/' . $gambar) ?>" alt="Profil" class="img-fluid p-0">
                                    </center>

                                    <div class="p-1 text-secondary text-center">
                                        <?php if ($filetupoksi != '') { ?>
                                            <a href="<?= base_url('/public/img/informasi/pegawai/' . $filetupoksi) ?>" target="_blank">
                                                <span class="badge badge-success" title="Klik untuk lihat" style="font-size:13px"> Lihat Tupoksi &raquo;
                                                </span>
                                            </a>
                                        <?php } ?>

                                    </div>
                                </th>
                            </tr>
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
                                <td class="p-1" width="22%">Tempat Tanggal Lahir</td>
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

                        </table>

                    </div>



                </div>

            </div>

            <div class="modal-footer p-0">

                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
            </div>
            <?php echo form_close() ?>

        </div>

    </div>

</div>
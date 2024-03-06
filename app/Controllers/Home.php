<?php

namespace App\Controllers;

class Home extends BaseController
{

	public function index()
	{

		$konfigurasi            = $this->konfigurasi->vkonfig();
		$template = $this->template->tempaktif();
		$poltanya = $this->poling->poltanya();
		$poljawab = $this->poling->poljawab();
		$jumpol = $this->poling->polling_sum();
		$kategori_id = $konfigurasi->kategori_id;
		$beritakate   =  $this->berita->listkategori($kategori_id);
		$beritakate6   =  $this->berita->listkategori6($kategori_id);
		$beritakate10   =  $this->berita->listkategori10($kategori_id);
		$pegawai = $this->pegawai->listpegawaipage();
		$faq   =  $this->faqtanya->listpublish();

		// $layanan = $this->layanan->listlayananpage();
		$data = [
			'title'             => $konfigurasi->nama,
			'deskripsi'         => $konfigurasi->deskripsi,
			'url'               => $konfigurasi->website,
			'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
			'banner'			=> $this->banner->list(),
			'infografis' 		=> $this->banner->listgrafis(),
			'infografis2' 		=> $this->banner->listinfo(),
			'infografis1' 		=> $this->banner->listinfo1(),

			'listiklankananpg' 		=> $this->banner->listiklankananpg()->paginate(8),
			'linkterkait' 		=> $this->linkterkait->listlinkpage()->paginate(4),
			'linkterkaitall'	=> $this->linkterkait->publishlinkall(),
			'konfigurasi' 		=> $konfigurasi,
			'berita'         	=> $this->berita->listberitapage()->paginate(6),
			'berita4'         	=> $this->berita->listberitapage()->paginate(4),
			'berita3'         	=> $this->berita->listberitapage()->paginate(3),
			'beritapopuler'     => $this->berita->populer()->paginate(5),
			'faq'			   => $faq,
			'ebook2'          	=> $this->ebook->listebookpage()->paginate(2),
			'ebook'          	=> $this->ebook->listebookpage()->paginate(4),
			'pegawai'          	=> $pegawai->paginate(4, 'hal'),
			'terkini1' 			=> $this->berita->terkini1(),
			'terkini6' 			=> $this->berita->published(),
			'terkini6ptsp' 		=> $this->berita->terkini6($kategori_id),
			'terkini' 			=> $this->berita->terkini(),
			'terkini5' 			=> $this->berita->terkini5($kategori_id),
			'utama' 			=> $this->berita->utama(),
			'headline' 			=> $this->berita->headline(),
			'headline6' 		=> $this->berita->headline6(),

			'beritautama' 		=> $this->berita->headlineall(),
			'mainmenu' 			=> $this->menu->mainmenu(),
			'footer' 			=> $this->menu->footermenu(),
			'topmenu' 			=> $this->menu->topmenu(),
			'agenda'       		=> $this->agenda->listagendapage()->paginate(4),
			'agenda5'       	=> $this->agenda->listagendapage()->paginate(5),
			'agenda2'       	=> $this->agenda->listagendapage()->paginate(2),
			'layanan'       	=> $this->layanan->listlayananpage()->paginate(6),
			'foto'      		=> $this->foto->listfotopage()->paginate(6),
			'foto8'      		=> $this->foto->listfotopage()->paginate(8),
			'pengumuman'       	=> $this->pengumuman->listpengumumanpage()->paginate(6),
			'bankdata' 			=>  $this->bankdata->listbankdatapage()->paginate(6),
			'poltanya' 			=> $poltanya['pilihan'],
			'polsts' 			=> $poltanya['status'],
			'poljawab' 			=> $poljawab,
			'jumpol' 			=> $jumpol['jml_vote'],
			'kategoriaktif' 	=> $beritakate,
			'kategoriaktif6' 	=> $beritakate6,
			'kategoriaktif10' 	=> $beritakate10,
			'section' 			=> $this->section->list(),
			'section6' 			=> $this->section->list6(),
			'video'      	    => $this->video->listvideopage()->paginate(1),
			'video2'      	    => $this->video->listvideopage()->paginate(2),
			'video4'      	    => $this->video->listvideopage()->paginate(4),
			'video3'      	    => $this->video->listvideopage()->paginate(3),
			'counter' 			=> $this->counter->listfront(),
			'pengumuman1'       => $this->pengumuman->listpengumumanpage()->paginate(1),
			'iklan' 		    => $this->banner->listiklantengah(),
			'iklan2' 		    => $this->banner->listiklankanan(),
			'iklantengah' 		=> $this->banner->listiklantengahran(),

			'folder'   			=> $template['folder'],
			'kunjungan'  		=> $this->user->kunjungan(),
			'pengunjungon' 	    => $this->user->totonline(),
			// perijinan
			'grafisrandom' 		=> $this->banner->grafisrandom(),
			'agendanext'      	=> $this->agenda->listagendanext()->paginate(4),

			// 'layananone'     	    => $layanan->paginate(5000, 'hal'),
		];
		if ($template['duatema'] == 1) {
			$agent = $this->request->getUserAgent();
			if ($agent->isMobile()) {
				return view('frontend/' . $template['folder'] . '/mobile/' . 'v_home', $data);
			} else {
				return view('frontend/' . $template['folder'] . '/desktop/' . 'v_home', $data);
			}
		} else {
			return view('frontend/' . $template['folder'] . '/desktop/' . 'v_home', $data);
		}
	}


	public function cekpengunjung()
	{
		if ($this->request->isAJAX()) {

			$data = [
				'kunjungan'    => $this->user->kunjungan(),
				'pengunjungon' => $this->user->totonline(),
			];
			$msg = [
				'data' 					  => view('admin/modal/onpengunjung', $data),
				'csrf_tokencmsdatagoeon'  => csrf_hash(),

			];

			echo json_encode($msg);
		}
	}

	//nonaktifpenawaran front end
	public function nonaktiftawaran()
	{
		if ($this->request->isAJAX()) {
			$msg = [
				'csrf_tokencmsdatagoe'  => csrf_hash(),
				set_cookie("penawaran", "isi", 5500),
			];
			echo json_encode($msg);
		}
	}

	public function penawaran22()
	{
		if ($this->request->isAJAX()) {

			$tadmin = $this->template->tempadminaktif();
			$template = $this->template->tempaktif();
			if (get_cookie("penawaran") != 'isi') {

				$data = [
					'konfigurasi' => $template,
					'list'        => $this->modalpopup->orderBy('modalpopup_id')->first(),
				];
				$msg = [
					'csrf_tokencmsdatagoe'  => csrf_hash(),
					'data' 					=> view('backend/' . $tadmin['folder'] . '/' . 'modal/penawaran', $data),

				];
			} else {
				$msg = [
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			}
			echo json_encode($msg);
		}
	}
}

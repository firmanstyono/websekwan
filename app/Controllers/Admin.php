<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{

	public function index()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		$id_grup 	 = session()->get('id_grup');
		$id 		 = session()->get('id');
		// berita
		$urlgetberita = 'berita/all';
		$listgrupfberita  =  $this->grupakses->listgrupakses($id_grup, $urlgetberita);

		foreach ($listgrupfberita as $data) :
			$aksesberita = $data['akses'];
		endforeach;

		if ($aksesberita == '1') {
			$berita = $this->berita->totberita();
			$populer = $this->berita->populer()->paginate(8);
		} else {
			$berita = $this->berita->totberitabyid($id);
			$populer = $this->berita->populerbyid($id)->paginate(8);
		}

		// Layanan
		$urlgetlay = 'layanan/all';
		$listgrupflay  =  $this->grupakses->listgrupakses($id_grup, $urlgetlay);
		if ($listgrupflay) {
			foreach ($listgrupflay as $data) :
				$akseslay = $data['akses'];
			endforeach;

			if ($akseslay == '1') {
				$layanan = $this->layanan->totlayanan();
			} else {
				$layanan = $this->layanan->totlayananbyid($id);
			}
		} else {
			$layanan = 0;
		}


		// Bank data
		$urlgetbank = 'bankdata/all';
		$listgrupbank  =  $this->grupakses->listgrupakses($id_grup, $urlgetbank);
		if ($listgrupbank) {
			foreach ($listgrupbank as $data) :
				$aksesbank = $data['akses'];
			endforeach;

			if ($aksesbank == '1') {
				$bank = $this->bankdata->selectCount('bankdata_id')->first();
			} else {
				$bank = $this->bankdata->selectCount('bankdata_id')->where('id', $id)->first();
			}
		} else {
			$bank = 0;
		}

		// Pengumuman

		$urlgetpen = 'pengumuman/all';
		$listgruppen  =  $this->grupakses->listgrupakses($id_grup, $urlgetpen);
		if ($listgruppen) {
			foreach ($listgruppen as $data) :
				$aksespen = $data['akses'];
			endforeach;

			if ($aksespen == '1') {
				$pengumuman = $this->pengumuman->totpengumuman();
			} else {
				$pengumuman = $this->pengumuman->totpengumumanbyid($id);
			}
		} else {
			$pengumuman = 0;
		}

		$gm							= 'Pengaturan';
		$konfigurasi 				= $this->konfigurasi->vkonfig();
		$grupakses   				=  $this->grupakses->grupaksessubmenu($id_grup, $gm);
		$tadmin 					= $this->template->tempadminaktif();
		$data = [
			'title'					=> 'Dashboard',
			'subtitle'				=> $konfigurasi->nama,
			'beritapopuler' 		=> $populer,
			'berita'				=> $berita,
			'kategori'				=> $this->kategori->totkategori(),
			'totlayanan' 			=> $layanan,
			'totpengumuman' 		=> $pengumuman,
			'bankdata' 				=> $bank,
			'agenda'      			=> $this->agenda->listagendapage()->paginate(1),
			'grupakses'     		=> $grupakses,
			'csrf_tokencmsdatagoe' 	=> csrf_hash(),
			'folder'                => $tadmin['folder'],
			'warna_topbar'          => $tadmin['warna_topbar'],
			'sidebar_mode'          => $tadmin['sidebar_mode'],

		];
		return view('backend/' . $tadmin['folder'] . '/' . 'v_dashboard', $data);
	}


	function TampilkanGrafik()
	{

		$db = \Config\Database::connect();
		$query = $db->query("SELECT count(*) as jumlah, tgl FROM visitor GROUP BY tgl ORDER BY tgl DESC LIMIT 14")->getResult();
		$tadmin 			= $this->template->tempadminaktif();
		$data = [
			'grafik' 				=> $query,
			'csrf_tokencmsdatagoe' 	=> csrf_hash()
		];

		$dgrafik = [
			'data'   				=> view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/user/vgrafik', $data),
			'csrf_tokencmsdatagoe' 	=> csrf_hash()
		];

		echo json_encode($dgrafik, true);
	}

	// menu Dashboard user online
	public function getonline()
	{
		$id = session()->get('id');
		$konfigurasi         = $this->konfigurasi->vkonfig();
		if ($this->request->isAJAX()) {
			$tadmin = $this->template->tempadminaktif();
			$cari =  $this->user->find($id);
			if ($cari['sts_on'] == '0') {

				$onsts = [
					'sts_on'      => '1',
				];

				$this->user->update($id, $onsts);
			}
			// $query = $db->query("SELECT count(*) as jumlah, tgl FROM visitor GROUP BY tgl ORDER BY tgl DESC LIMIT 12")->getResult();
			// $query = $db->query("SELECT tgl,ip FROM visitor GROUP BY ip WHERE month(tgl)='" . date('m') . "' ")->getNumRows();
			// $sql = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));";
			// $eksekusi = $db->query($sql);
			$data = [
				'user'	     	   => $this->user->getaktif5(),
				'useron'	   	   => $this->user->getonline5($id),
				'template'		   => $this->template->tempaktif(),
				'kunjungan'        => $this->user->kunjungan(),
				'pengunjungon' 	   => $this->user->totonline(),
				'pengunjungblnini' => $this->user->pengunjungblnini(),
				// 'pengunjungblnini' => $this->db->query("SELECT tgl,ip FROM visitor WHERE month(tgl)='" . date('m') . "' GROUP_CONCAT ip")->getNumRows(),
				'totkunjungan'     => $this->db->query("SELECT hits FROM visitor")->getNumRows(),
				'vercms' 		   => $konfigurasi->vercms
			];

			$msg = [
				'data'   				=> view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/user/vonline', $data),
				'csrf_tokencmsdatagoe' 	=> csrf_hash()
			];

			echo json_encode($msg);
		}
	}

	public function offuser()
	{
		if ($this->request->isAJAX()) {

			$id      		= session()->get('id');
			$konfig         = $this->konfigurasi->vkonfig();
			$this->user->resetstatus();
			$tadmin = $this->template->tempadminaktif();
			$onsts = [
				'sts_on'      => '1',
			];

			$this->user->update($id, $onsts);

			$data = [
				'user'	     		=> $this->user->getaktif5(),
				'template'			=> $this->template->tempaktif(),
				'kunjungan'    		=> $this->user->kunjungan(),
				'pengunjungon'		=> $this->user->totonline(),
				'pengunjungblnini'  => $this->db->query("SELECT * FROM visitor WHERE month(tgl)='" . date('m') . "' GROUP BY ip")->getNumRows(),
				'totkunjungan'		=> $this->db->query("SELECT hits FROM visitor")->getNumRows(),
				'vercms' 		    => $konfig->vercms

			];

			$msg = [
				'data'   				=> view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/user/vonline', $data),
				'csrf_tokencmsdatagoe' 	=> csrf_hash()
			];

			echo json_encode($msg);
		}
	}
	public function hapusfile()
	{
		if ($this->request->isAJAX()) {

			$tadmin = $this->template->tempadminaktif();
			$data = [
				'title'	     		=> 'Hapus file Session',
			];

			$msg = [
				'data'   			   => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/user/hapusfileses', $data),
				'csrf_tokencmsdatagoe' => csrf_hash()
			];

			echo json_encode($msg);
		}
	}
}

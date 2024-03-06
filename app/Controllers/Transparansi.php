<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Transparansi extends BaseController
{
	public function index()
	{
		$konfigurasi        = $this->konfigurasi->vkonfig();
		$template = $this->template->tempaktif();

		$data = [
			'title'			=> 'Transparansi',
			'deskripsi'     => $konfigurasi->deskripsi,
			'url'           => $konfigurasi->website,
			'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
			'konfigurasi'   => $konfigurasi,
			'mainmenu'      => $this->menu->mainmenu(),
			'footer'        => $this->menu->footermenu(),
			'topmenu'       => $this->menu->topmenu(),
			'list'          => $this->bankdata->listbankdata(),
			'beritapopuler' => $this->berita->populer()->paginate(8),
			'kategori'      => $this->kategori->list(),
			'banner'        => $this->banner->list(),
			'infografis'    => $this->banner->listinfo(),
			'infografis1'   => $this->banner->listinfo1(),
			'agenda'        => $this->agenda->listagendapage()->paginate(4),
			'section'       => $this->section->list(),
			'linkterkaitall'    => $this->linkterkait->publishlinkall(),
			'folder'        => $template['folder'],
			'infografis10'    => $this->banner->listinfopage()->paginate(10),
			'kategori'      => $this->kategori->list(),
			'listopsi' 		=> $this->transparan->listopsi(),
			'grafisrandom'         => $this->banner->grafisrandom(),
			'terkini3'       => $this->berita->terkini3(),

		];
		if ($template['duatema'] == 1) {
			$agent = $this->request->getUserAgent();
			if ($agent->isMobile()) {
				return view('frontend/' . $template['folder'] . '/mobile/' . 'content/transparansi', $data);
			} else {
				return view('frontend/' . $template['folder'] . '/desktop/' . 'content/transparansi', $data);
			}
		} else {
			return view('frontend/' . $template['folder'] . '/desktop/' . 'content/transparansi', $data);
		}
	}

	function TampilkanGrafik()
	{

		$tahun = $this->request->getPost('tahun');
		$judul = $this->request->getPost('judul');
		$tadmin 			= $this->template->tempadminaktif();
		$data = [
			'transparan' 	=> $this->transparandetail->grafikpendapatan($tahun, $judul),
		];

		$dgrafik = [
			'data'                => view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/vgrafik', $data),
			'csrf_tokencmsdatagoe'  => csrf_hash(),
		];

		echo json_encode($dgrafik);
	}

	// pilihan
	function TampilkanGrafikAll()
	{

		$tadmin 			= $this->template->tempadminaktif();
		$data = [
			'transparan' 	=> $this->transparandetail->grafikawal(),
			'folder'        => $tadmin['folder'],
		];
		$dgrafik = [
			'data'   				=> view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/vgrafik', $data),
			'csrf_tokencmsdatagoe'  => csrf_hash(),
		];

		echo json_encode($dgrafik);
	}

	public function list()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		$tadmin 			= $this->template->tempadminaktif();
		$data = [
			'title'       => 'Transparansi',
			'subtitle'    => 'Keuangan',
			'folder'      => $tadmin['folder'],

		];
		return view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/index', $data);
	}

	public function getdata()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {

			$id_grup 	= session()->get('id_grup');
			$id 		= session()->get('id');

			$url 		= 'transparansi/list';
			$listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

			$akses  = $listgrupf->akses;
			$hapus  = $listgrupf->hapus;
			$ubah   = $listgrupf->ubah;
			$tambah = $listgrupf->tambah;

			if ($akses == 1) {
				$list =  $this->transparan->list();
			} elseif ($akses == 2) {
				$list = $this->transparan->listtransauthor($id);
			}
			$tadmin 			= $this->template->tempadminaktif();

			// jika temukan maka eksekusi
			if ($listgrupf) {
				# cek akses
				$tadmin 			= $this->template->tempadminaktif();
				if ($akses == '1' || $akses == '2') {
					$data = [
						'title'     => 'Transparansi',
						'list'      => $list,
						'akses'     => $akses,
						'hapus'     => $hapus,
						'ubah'      => $ubah,
						'tambah'    => $tambah,
					];
					$msg = [
						'data' => view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/list', $data)
					];
				} else {
					$msg = [
						'noakses' => []
					];
				}
			} else {

				$msg = [
					'blmakses' => []
				];
			}

			echo json_encode($msg);
		}
	}

	public function formtambah()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {
			$tadmin 			= $this->template->tempadminaktif();

			$data = [
				'title' 				=> 'Tambah Data',
			];
			$msg = [
				'data' => view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/tambah', $data)

			];
			echo json_encode($msg);
		}
	}

	public function simpantransparansi()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {

			$validation = \Config\Services::validation();

			$valid = $this->validate([
				'judul' => [
					'label' => 'Nama transparansi',
					'rules' => 'required|is_unique[transparan.judul]',
					'errors' => [
						'required' => '{field} tidak boleh kosong',
						'is_unique' => '{field} tidak boleh sama'

					]
				],

			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'judul'           => $validation->getError('judul'),
					],
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
				echo json_encode($msg);
			} else {
				$userid = session()->get('id');
				$insertdata = [
					'judul'  	 => $this->request->getVar('judul'),
					'tahun'  	 => $this->request->getVar('tahun'),
					'jenis'		 => $this->request->getVar('jenis'),
					'sts'		 => '1',
					'id'         => $userid,
				];
				$this->transparan->insert($insertdata);
				$msg = [
					'sukses' 				=> 'Data berhasil disimpan!',
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
				echo json_encode($msg);
			}
		}
	}

	public function hapus()
	{
		if ($this->request->isAJAX()) {

			$id = $this->request->getVar('transparan_id');

			$this->transparan->delete($id);
			$msg = [
				'sukses' 				=> 'Data Berhasil Dihapus',
				'csrf_tokencmsdatagoe'  => csrf_hash(),
			];

			echo json_encode($msg);
		}
	}

	public function formedit()
	{
		if ($this->request->isAJAX()) {

			$transparan_id = $this->request->getVar('transparan_id');
			$list =  $this->transparan->find($transparan_id);
			$tadmin = $this->template->tempadminaktif();
			$data = [
				'title'        	=> 'Edit Data',
				'transparan_id' => $list['transparan_id'],
				'judul'   		=> $list['judul'],
				'tahun'   		=> $list['tahun'],
				'jenis'   		=> $list['jenis'],

			];
			$msg = [
				'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/edit', $data),
				'csrf_tokencmsdatagoe'  => csrf_hash(),
			];
			echo json_encode($msg);
		}
	}


	public function updatedata()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {
			$transparan_id = $this->request->getVar('transparan_id');
			$validation = \Config\Services::validation();

			$valid = $this->validate([

				'judul' => [
					'label' => 'Nama Transparansi',
					'rules' => 'required',
					'errors' => [
						'required' => '{field} tidak boleh kosong',

					]
				],

			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'judul'           => $validation->getError('judul'),
					],
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			} else {

				$updatedata = [
					'judul'  => $this->request->getVar('judul'),
					'tahun'  => $this->request->getVar('tahun'),
					'jenis'  => $this->request->getVar('jenis'),

				];
				$this->transparan->update($transparan_id, $updatedata);
				$msg = [
					'sukses'			    => 'Data berhasil diubah!',
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			}
			echo json_encode($msg);
		}
	}

	//publish dan unpublish transparansi
	public function toggle()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('transparan_id');
			$cari =  $this->transparan->find($id);

			if ($cari['sts'] == '1') {
				$list =  $this->transparan->getaktif($id);
				$toggle = $list ? 0 : 1;
				$updatedata = [
					'sts'        => $toggle,
				];
				$this->transparan->update($id, $updatedata);
				$msg = [
					'sukses' => 'Berhasil Non Aktifkan!',
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			} else {
				$list =  $this->transparan->getnonaktif($id);
				$toggle = $list ? 1 : 0;
				$updatedata = [
					'sts'        => $toggle,
				];
				$this->transparan->update($id, $updatedata);
				$msg = [
					'sukses' 				=> 'Berhasil Mengaktifkan!',
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			}

			echo json_encode($msg);
		}
	}

	// default tampilan front

	public function toggledef()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('transparan_id');
			$cari =  $this->transparan->find($id);

			if ($cari['vawal'] == '1') {
				$list =  $this->transparan->getaktifdef($id);
				$toggle = $list ? 0 : 1;
				$updatedata = [
					'vawal'        => $toggle,
				];
				$this->transparan->update($id, $updatedata);
				$msg = [
					'sukses' => 'Berhasil nonaktifkan tampilan default!',
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			} else {
				$list =  $this->transparan->getnonaktifdef($id);
				$toggle = $list ? 1 : 0;
				$updatedata = [
					'vawal'        => $toggle,
				];
				$this->transparan->resetstatus();
				$this->transparan->update($id, $updatedata);
				$msg = [
					'sukses' 				=> 'Judul ini berhasil dijadikan tampilan default awal!',
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			}

			echo json_encode($msg);
		}
	}

	// Detail transparansi
	public function detail($transparan_id = null)
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($transparan_id == '') {
			return redirect()->to(base_url('transparansi/list'));
		}
		$tadmin = $this->template->tempadminaktif();
		$list =  $this->transparandetail->list($transparan_id);
		$data = [
			'title'     	=> 'Transparansi',
			'subtitle'  	=> 'Detail',
			'transparan_id' => $transparan_id,
			'list' 			=> $list,
			'folder'    =>  $tadmin['folder'],

		];
		return view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/detail/index', $data);
	}

	// get data
	public function detailajx()
	{

		if ($this->request->isAJAX()) {
			$transparan_id = $this->request->getVar('transparansi');
			$id_grup = session()->get('id_grup');
			$url = 'transparansi/list';
			$listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

			foreach ($listgrupf as $data) :
				$akses = $data['akses'];
			endforeach;
			$tadmin = $this->template->tempadminaktif();
			// jika temukan maka eksekusi
			if ($listgrupf) {
				# cek akses
				if ($transparan_id == '') {
					return redirect()->to(base_url('transparansi/list'));
				}

				$list =  $this->transparandetail->list($transparan_id);

				if ($akses == '1' || $akses == '2') {
					$data = [
						'title'      => 'Detail Transparansi',
						'list'       => $list,
						'akses'      => $akses
					];
					$msg = [
						'data' => view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/detail/list', $data)

					];
				} else {
					$msg = [
						'noakses' => []
					];
				}
			} else {

				$msg = [
					'blmakses' => []
				];
			}

			echo json_encode($msg);
		}
	}


	public function formtambahsubproduk()
	{
		if ($this->request->isAJAX()) {
			$tadmin = $this->template->tempadminaktif();
			$data = [
				'title' 				=> 'Tambah Item',
				'transparan_id'			=> $this->request->getVar('transparan_id'),

			];
			$msg = [
				'data' => view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/detail/tambah', $data)

			];
			echo json_encode($msg);
		}
	}


	public function simpanDetail()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {

			$validation = \Config\Services::validation();

			$valid = $this->validate([
				'transparan_nama' => [
					'label' => 'Judul Item',
					'rules' => 'required|is_unique[transparan_detail.transparan_nama]',
					'errors' => [
						'required' => '{field} tidak boleh kosong',
						'is_unique' => '{field} tidak boleh sama'
					]
				],
				'transparan_jumlah' => [
					'label' => 'Jumlah',
					'rules' => 'required',
					'errors' => [
						'required' => '{field} tidak boleh kosong',

					]
				],

			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'transparan_nama' 	 => $validation->getError('transparan_nama'),
						'transparan_jumlah'  => $validation->getError('transparan_jumlah'),
					],
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
				// echo json_encode($msg);
			} else {

				$insertdata = [
					'transparan_id'      => $this->request->getVar('transparan_id'),
					'transparan_nama'    => $this->request->getVar('transparan_nama'),
					'transparan_jumlah'  => $this->request->getVar('transparan_jumlah'),
				];

				$this->transparandetail->insert($insertdata);

				$msg = [
					'sukses' => 'Data berhasil disimpan!',
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			}
			echo json_encode($msg);
		}
	}

	public function formtambahsubprodukx()
	{
		if ($this->request->isAJAX()) {
			$tadmin = $this->template->tempadminaktif();
			$data = [
				'title' 				=> 'Tambah Item',
				'transparan_id'			=> $this->request->getVar('transparan_id'),

			];
			$msg = [
				'data' => view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/detail/tambah', $data)

			];
			echo json_encode($msg);
		}
	}

	public function formeditdetail()
	{
		if ($this->request->isAJAX()) {
			$tadmin = $this->template->tempadminaktif();
			$transparandetail_id = $this->request->getVar('transparandetail_id');

			$list =  $this->transparandetail->find($transparandetail_id);

			$data = [
				'title'         => 'Edit Detail Transparansi',
				'transparandetail_id'   => $transparandetail_id,
				'transparan_id'     => $list['transparan_id'],
				'transparan_nama' => $list['transparan_nama'],
				'transparan_jumlah'     => $list['transparan_jumlah'],
			];
			$msg = [
				'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'lembaga/transparansi/detail/edit', $data),
				'csrf_tokencmsdatagoe'  => csrf_hash(),
			];
			echo json_encode($msg);
		}
	}

	public function updatedetail()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {
			$transparandetail_id = $this->request->getVar('transparandetail_id');
			$validation = \Config\Services::validation();

			$valid = $this->validate([

				'transparan_nama' => [
					'label' => 'Nama Item',
					'rules' => 'required',
					'errors' => [
						'required' => '{field} tidak boleh kosong',

					]
				],
				'transparan_jumlah' => [
					'label' => 'Jumlah Item',
					'rules' => 'required',
					'errors' => [
						'required' => '{field} tidak boleh kosong',

					]
				],
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'transparan_nama' => $validation->getError('transparan_nama'),
						'transparan_jumlah' => $validation->getError('transparan_jumlah'),
					],
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			} else {
				$updatedata = [
					'transparan_nama'     => $this->request->getVar('transparan_nama'),
					'transparan_jumlah'   => $this->request->getVar('transparan_jumlah'),

				];
				$this->transparandetail->update($transparandetail_id, $updatedata);
				$msg = [
					'sukses' 				=> 'Data berhasil diubah!',
					'csrf_tokencmsdatagoe'  => csrf_hash(),
				];
			}
			echo json_encode($msg);
		}
	}

	public function hapusdetail()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {

			$id = $this->request->getVar('transparandetail_id');

			$this->transparandetail->delete($id);
			$msg = [
				'sukses' 				=> 'Data Berhasil Dihapus',
				'csrf_tokencmsdatagoe'  => csrf_hash(),
			];

			echo json_encode($msg);
		}
	}

	public function hapusdetailall()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('transparandetail_id');
			$jmldata = count($id);
			for ($i = 0; $i < $jmldata; $i++) {

				$this->transparandetail->delete($id[$i]);
			}

			$msg = [
				'sukses' 				=> "$jmldata Data berhasil dihapus",
				'csrf_tokencmsdatagoe'  => csrf_hash(),
			];
			echo json_encode($msg);
		}
	}
}

<?php

namespace App\Controllers;

class Petasitus extends BaseController
{

    public function index()
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $template = $this->template->tempaktif();

        $data = [
            'title'             => 'Peta Situs | ' . $konfigurasi->nama,
            'deskripsi'         => $konfigurasi->deskripsi,
            'url'               => $konfigurasi->website,
            'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'       => $konfigurasi,
            'mainmenu'          => $this->menu->mainmenu(),
            'footer'            => $this->menu->footermenu(),
            'topmenu'           => $this->menu->topmenu(),
            'banner'            => $this->banner->list(),
            'infografis'        => $this->banner->listinfo(),
            'infografis1'       => $this->banner->listinfo1(),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'section'           => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategori'      => $this->kategori->list(),
            'beritautama'   => $this->berita->headlineall(),
            'grafisrandom'         => $this->banner->grafisrandom(),
            'terkini3'       => $this->berita->terkini3(),
            'folder'        => $template['folder']

        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/petasitus', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/petasitus', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/petasitus', $data);
        }
    }
}

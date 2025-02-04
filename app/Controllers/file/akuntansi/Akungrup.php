<?php

namespace App\Controllers\file\akuntansi;

use Config\App;
use App\Controllers\BaseController;
use App\Models\file\DefakunModel;

class Akungrup extends BaseController
{
    protected $defakunModel;
    public function __construct()
    {
        $this->defakunModel = new DefakunModel();
    }

    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        (!preg_match("/130/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_kelakun"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-file ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-balance-scale"></i>', 't_dir1' => lang("app.akuntansi"), 't_dirac' => lang("app.akungrup"), 't_link' => '/akungrup',
            'defakun' => $this->deklarModel->getDefakun($this->urls[1], 'grup'),
            'menu' => 'akungrup', 'shid' => '', 'khid' => '', 'phid' => 'hidden', 'nhid' => 'hidden', //selection kelompok perusahaan nilai
            'btnclascr' => lang('app.btncCreate'), 'btntextcr' => lang('app.btnCreate'),
            'actcreate' => ($this->user['act_create'] == '0' ? 'hidden' : ''),
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        return view('file/akuntansi/akundef_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function crany()
    {
        do {
            $idu = buatid();
            $db = $this->deklarModel->satuID('def_akun', $idu);
        } while ($db);
        $this->iduModel->saveID($idu);
        return redirect()->to('/akungrup/input/' . $idu);
    }

    // ____________________________________________________________________________________________________________________________
    public function showdata($idunik)
    {
        (!preg_match("/130/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $db1 = $this->deklarModel->satuID('def_akun', $idunik, 'y');
        $ticon = ($db1 ? lang("app.xdetil") : lang("app.xinput"));
        $data = [
            't_menu' => lang("app.tt_kelakun"), 't_submenu' => '',
            't_icon' => '<i class="fa fa-file ' . $ticon . '"></i>',
            't_diricon' => '<i class="fa fa-balance-scale"></i>', 't_dir1' => lang("app.akuntansi"), 't_dirac' => lang("app.akungrup"), 't_link' => '/akungrup',
            'idu' => $this->iduModel->cekID($idunik), 'idunik' => $idunik,
            'menu' => 'akungrup',
            'selkel' => $this->deklarModel->distSelect('akungrup', 't'),
            'selnama' => $this->deklarModel->distSelect('akungrup'),
            'perusahaan' => $this->deklarModel->getPerusahaan('', 't'),
            'wilayah' => $this->deklarModel->getDivisi('', 'wilayah', 't'),
            'divisi' => $this->deklarModel->getDivisi('', 'divisi', 't'),
            'akun1' => $this->deklarModel->satuID('m_akun', $db1[0]->akun1_id ?? '', '', 'id', 't'),
            'akun2' => $this->deklarModel->satuID('m_akun', $db1[0]->akun2_id ?? '', '', 'id', 't'),
            'akun3' => $this->deklarModel->satuID('m_akun', $db1[0]->akun3_id ?? '', '', 'id', 't'),
            'akun4' => $this->deklarModel->satuID('m_akun', $db1[0]->akun4_id ?? '', '', 'id', 't'),
            'btnhid' => ($db1 ? 'hidden' : ''),
            'btnclas1' => ($db1 ? lang('app.btncUpdate') : lang('app.btncSave')),
            'btntext1' => ($db1 ? lang('app.btnUpdate') : lang('app.btnSave')),
            'btnclas2' => (($db1 && $db1[0]->is_aktif == '0') ? lang('app.btncAktif') : lang('app.btncNoaktif')),
            'btntext2' => (($db1 && $db1[0]->is_aktif == '0') ? lang('app.btnAktif') : lang('app.btnNoaktif')),
            'btnsama' => ($db1 ? ($db1[0]->is_confirm == '1' ? 'disabled' : ($db1[0]->updated_by == $this->user['id'] ? 'disabled' : '')) : ''),
            'actcreate' => ($db1 ? ($this->user['act_edit'] == '0' ? 'disabled' : '') : ($this->user['act_create'] == '0' ? 'disabled' : '')),
            'actconf' => ($db1 ? ($this->user['act_confirm'] == '0' ? 'disabled hidden' : '') : 'disabled hidden'),
            'actaktif' => ($db1 ? ($this->user['act_aktif'] == '0' ? 'disabled hidden' : '') : 'disabled hidden'),
            'defakun' => $db1,
            'tuser' => $this->user, 'tmenu' => $this->menu,
        ];
        (empty($data['defakun']) && empty($data['idu'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        if ($db1) $this->logModel->saveLog('Read', $idunik, $db1[0]->nama, '-');
        return view('file/akuntansi/akundef_input', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function savedata()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->deklarModel->satuID('def_akun', $this->request->getVar('idunik'));
            $savj = ($db1 ? lang("app.judulubah") : lang("app.judulsimpan"));
            $data = $this->deklarModel->cekDefakun($this->request->getVar('xkelompok'), $this->request->getVar('nama'), $this->request->getVar('idunik'));
            $rule_nama = ($data ? 'required|is_unique[def_akun.nama]' : 'required');
            $stconf = (($db1 && $db1[0]->is_confirm != '0') ? '2' : '0');

            $validationRules = [
                'nama' => [
                    'rules' => $rule_nama,
                    'errors' => ['required' => lang("app.errblank"), 'is_unique' => lang("app.errunik")]
                ],
                'xkelompok' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errpilih")]
                ],
                'catatan' => [
                    'rules' => 'required',
                    'errors' => ['required' => lang("app.errblank")]
                ],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama'),
                        'kelompok' => $this->validation->getError('xkelompok'),
                        'catatan' => $this->validation->getError('catatan'),
                    ]
                ];
            } else {
                //Simpan
                if ($this->request->getVar('postaction') == 'save') {
                    $this->defakunModel->save([
                        'id' => $db1[0]->id ?? '',
                        'idunik' => $this->request->getVar('idunik'),
                        'menu' => 'grup',
                        'submenu' => $this->request->getVar('xsubmenu'),
                        'kelompok' => $this->request->getVar('xkelompok'),
                        'nama' => $this->request->getVar('nama'),
                        'nilai' => ubahseparator($this->request->getVar('nilai')),
                        'akun1_id' => $this->request->getVar('noakun1'),
                        'akun2_id' => $this->request->getVar('noakun2'),
                        'akun3_id' => $this->request->getVar('noakun3'),
                        'akun4_id' => $this->request->getVar('noakun4'),
                        'catatan' => $this->request->getVar('catatan'),
                        'is_confirm' => $stconf,
                        'updated_by' => $this->user['id'],
                        'confirmed_by' => '0',
                    ]);
                    $db1 = $this->deklarModel->satuID('def_akun', $this->request->getVar('idunik'));
                    $this->logModel->saveLog('Save', $this->request->getVar('idunik'), $db1[0]->nama);
                    $this->session->setFlashdata(['judul' => "{$db1[0]->nama} {$savj}"]);
                }
                //Konfirmasi
                if ($this->request->getVar('postaction') == 'confirm') {
                    $this->defakunModel->save(['id' => $db1[0]->id, 'is_confirm' => '1', 'confirmed_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $this->request->getVar('idunik'), $db1[0]->nama);
                    $this->session->setFlashdata(['judul' => "{$db1[0]->nama}" . lang("app.judulkonf")]);
                }
                //Aktifasi
                if ($this->request->getVar('postaction') == 'aktif') {
                    $akby = (($this->request->getVar('niaktif') == '0') ? $this->user['id'] : '0');
                    $savj = (($this->request->getVar('niaktif') == '0') ? lang("app.judulnoaktif") : lang("app.judulaktif"));
                    $onoff = (($this->request->getVar('niaktif') == '0') ? 'nonaktif' : 'aktif');
                    $this->defakunModel->save(['id' => $db1[0]->id, 'is_aktif' => $this->request->getVar('niaktif'), 'activated_by' => $akby]);
                    $this->logModel->saveLog('Active', $this->request->getVar('idunik'), "{$db1[0]->nama} {$onoff}");
                    $this->session->setFlashdata(['judul' => "{$db1[0]->nama} {$savj}"]);
                }
                $msg = ['redirect' => '/akungrup'];
            }
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}

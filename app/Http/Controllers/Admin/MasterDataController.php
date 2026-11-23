<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterBenefitSkp;
use App\Models\MasterFakultas;
use App\Models\MasterJenisOrmawa;
use App\Models\MasterKategoriEvent;
use App\Models\MasterPaketEvent;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $pakets = MasterPaketEvent::with(['kategori', 'benefitSkp', 'fakultas', 'jenisOrmawa'])
            ->latest()
            ->get();

        $opsiKategori = [
            'Seminar & Talkshow'             => '#7c3aed',
            'Webinar Nasional'               => '#2563eb',
            'Workshop & Pelatihan'           => '#059669',
            'Kompetisi & Lomba'              => '#dc2626',
            'Pengabdian Masyarakat'          => '#d97706',
            'Bazar & Festival Kampus'        => '#db2777',
            'Musyawarah & Sidang Organisasi' => '#4f46e5',
        ];

        $opsiBenefit = [
            'SKP + E-Sertifikat',
            'E-Sertifikat Nasional / Internasional + SKP',
            'E-Sertifikat Peserta (Non-SKP)',
            'Konferensi KKN',
            'Konferensi Skripsi',
            'Konferensi Magang',
        ];

        $opsiFakultas = [
            'FV'    => 'Fakultas Vokasi',
            'FST'   => 'Fakultas Sains dan Teknologi',
            'FEB'   => 'Fakultas Ekonomi dan Bisnis',
            'FISIP' => 'Fakultas Ilmu Sosial dan Ilmu Politik',
            'FK'    => 'Fakultas Kedokteran',
            'FKG'   => 'Fakultas Kedokteran Gigi',
            'FH'    => 'Fakultas Hukum',
            'FF'    => 'Fakultas Farmasi',
            'FKM'   => 'Fakultas Kesehatan Masyarakat',
            'FPsi'  => 'Fakultas Psikologi',
            'FIB'   => 'Fakultas Ilmu Budaya',
            'FKp'   => 'Fakultas Keperawatan',
            'FPK'   => 'Fakultas Perikanan dan Kelautan',
            'FTMM'  => 'Fakultas Teknologi Maju dan Multidisiplin',
            'FKH'   => 'Fakultas Kedokteran Hewan',
            'FIKKIA'  => 'Fakultas Ilmu Kesehatan, Kedokteran, dan Ilmu Alam',
            'UNIV'  => 'Tingkat Universitas',
        ];

        $opsiJenisOrmawa = ['BEM', 'HIMA', 'UKM', 'BLM', 'Ormada'];

        return view('admin.master-data.index', compact(
            'pakets',
            'opsiKategori',
            'opsiBenefit',
            'opsiFakultas',
            'opsiJenisOrmawa'
        ));
    }

    public function storePaket(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:150',
            'nama_kategori' => 'required|string|max:50',
            'warna_badge'   => 'required|string|max:30',
            'nama_benefit'  => 'required|string|max:100',
            'bobot_poin'    => 'required|integer|min:0|max:100',
            'kode_fakultas' => 'required|string|max:15',
            'jenis_ormawa'  => 'required|string|max:30',
            'nama_ormawa'   => 'required|string|max:100',
        ]);

        $daftarFakultas = [
            'FV'    => 'Fakultas Vokasi',
            'FST'   => 'Fakultas Sains dan Teknologi',
            'FEB'   => 'Fakultas Ekonomi dan Bisnis',
            'FISIP' => 'Fakultas Ilmu Sosial dan Ilmu Politik',
            'FK'    => 'Fakultas Kedokteran',
            'FKG'   => 'Fakultas Kedokteran Gigi',
            'FH'    => 'Fakultas Hukum',
            'FF'    => 'Fakultas Farmasi',
            'FKM'   => 'Fakultas Kesehatan Masyarakat',
            'FPsi'  => 'Fakultas Psikologi',
            'FIB'   => 'Fakultas Ilmu Budaya',
            'FKp'   => 'Fakultas Keperawatan',
            'FPK'   => 'Fakultas Perikanan dan Kelautan',
            'FTMM'  => 'Fakultas Teknologi Maju dan Multidisiplin',
            'FKH'   => 'Fakultas Kedokteran Hewan',
            'FIKKIA'  => 'Fakultas Ilmu Kesehatan, Kedokteran, dan Ilmu Alam',
            'UNIV'  => 'Tingkat Universitas',
        ];

        $kategori = MasterKategoriEvent::firstOrCreate(
            ['nama_kategori' => $request->nama_kategori],
            ['warna_badge' => $request->warna_badge]
        );

        $benefit = MasterBenefitSkp::firstOrCreate(
            [
                'nama_benefit' => $request->nama_benefit,
                'bobot_poin'   => $request->bobot_poin,
            ]
        );

        $fakultas = MasterFakultas::firstOrCreate(
            ['kode_fakultas' => $request->kode_fakultas],
            ['nama_fakultas' => $daftarFakultas[$request->kode_fakultas] ?? $request->kode_fakultas]
        );

        $labelOrmawa = $request->jenis_ormawa . ' - ' . $request->nama_ormawa;
        $ormawa = MasterJenisOrmawa::firstOrCreate(
            ['nama_jenis' => $labelOrmawa],
            ['deskripsi'  => $request->nama_ormawa]
        );

        MasterPaketEvent::create([
            'nama_kegiatan'   => $request->nama_kegiatan,
            'kategori_id'     => $kategori->id,
            'benefit_skp_id'  => $benefit->id,
            'fakultas_id'     => $fakultas->id,
            'jenis_ormawa_id' => $ormawa->id,
        ]);

        return back()->with('success', 'Data Kegiatan & Master terpadu berhasil ditambahkan!');
    }

    public function destroyPaket($id)
    {
        $paket = MasterPaketEvent::findOrFail($id);
        $paket->delete();

        return back()->with('success', 'Data Master terpadu berhasil dihapus.');
    }
}

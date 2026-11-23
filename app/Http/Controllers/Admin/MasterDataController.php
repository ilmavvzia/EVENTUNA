<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterBenefitSkp;
use App\Models\MasterFakultas;
use App\Models\MasterJenisOrmawa;
use App\Models\MasterKategoriEvent;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $kategoris = MasterKategoriEvent::latest()->get();
        $benefits = MasterBenefitSkp::latest()->get();
        $fakultas = MasterFakultas::latest()->get();
        $jenisOrmawas = MasterJenisOrmawa::latest()->get();

        return view('admin.master-data.index', compact(
            'kategoris',
            'benefits',
            'fakultas',
            'jenisOrmawas'
        ));
    }

    // ================= KATEGORI EVENT =================
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:master_kategori_event,nama_kategori',
            'warna_badge'   => 'required|string|max:30',
        ]);

        MasterKategoriEvent::create($request->only('nama_kategori', 'warna_badge'));

        return back()->with('success', 'Kategori event berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = MasterKategoriEvent::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:master_kategori_event,nama_kategori,' . $kategori->id,
            'warna_badge'   => 'required|string|max:30',
        ]);

        $kategori->update($request->only('nama_kategori', 'warna_badge'));

        return back()->with('success', 'Kategori event berhasil diperbarui.');
    }

    public function destroyKategori($id)
    {
        $kategori = MasterKategoriEvent::findOrFail($id);

        if ($kategori->events()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh event aktif.');
        }

        $kategori->delete();
        return back()->with('success', 'Kategori event berhasil dihapus.');
    }

    // ================= BENEFIT SKP =================
    public function storeBenefit(Request $request)
    {
        $request->validate([
            'nama_benefit' => 'required|string|max:100',
            'bobot_poin'   => 'required|integer|min:0|max:100',
        ]);

        MasterBenefitSkp::create($request->only('nama_benefit', 'bobot_poin'));

        return back()->with('success', 'Data Benefit SKP berhasil ditambahkan.');
    }

    public function updateBenefit(Request $request, $id)
    {
        $benefit = MasterBenefitSkp::findOrFail($id);

        $request->validate([
            'nama_benefit' => 'required|string|max:100',
            'bobot_poin'   => 'required|integer|min:0|max:100',
        ]);

        $benefit->update($request->only('nama_benefit', 'bobot_poin'));

        return back()->with('success', 'Data Benefit SKP berhasil diperbarui.');
    }

    public function destroyBenefit($id)
    {
        $benefit = MasterBenefitSkp::findOrFail($id);

        if ($benefit->events()->exists()) {
            return back()->with('error', 'Benefit SKP tidak dapat dihapus karena masih digunakan pada event.');
        }

        $benefit->delete();
        return back()->with('success', 'Data Benefit SKP berhasil dihapus.');
    }
}

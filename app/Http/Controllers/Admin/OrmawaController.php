<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MasterFakultas;
use App\Models\MasterJenisOrmawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OrmawaController extends Controller
{
    /**
     * Menampilkan daftar Organisasi Mahasiswa dengan pencarian, filter, dan pagination.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'ormawa')
            ->with(['fakultas', 'jenisOrmawa'])
            ->withCount('events');

        // Fitur Pencarian berdasarkan nama ormawa atau email
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Fitur Filter berdasarkan status akun
        if ($request->filled('status') && in_array($request->query('status'), ['pending', 'verified', 'rejected'])) {
            $query->where('status_akun', $request->query('status'));
        }

        // Filter berdasarkan Fakultas jika dipilih
        if ($request->filled('fakultas_id')) {
            $query->where('fakultas_id', $request->query('fakultas_id'));
        }

        $ormawas = $query->latest()->paginate(10)->withQueryString();
        $fakultas = MasterFakultas::orderBy('nama_fakultas')->get();

        return view('admin.ormawa.index', compact('ormawas', 'fakultas'));
    }

    /**
     * Menampilkan formulir pendaftaran Ormawa baru oleh Admin.
     */
    public function create()
    {
        $fakultas = MasterFakultas::orderBy('nama_fakultas')->get();
        $jenisOrmawas = MasterJenisOrmawa::orderBy('nama_jenis')->get();

        return view('admin.ormawa.create', compact('fakultas', 'jenisOrmawas'));
    }

    /**
     * Menyimpan data Ormawa baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:users,email',
            'password'            => 'required|string|min:8',
            'fakultas_id'         => 'nullable|exists:master_fakultas,id',
            'jenis_ormawa_id'     => 'nullable|exists:master_jenis_ormawa,id',
            'deskripsi_singkat'   => 'nullable|string|max:1000',
            'status_akun'         => 'required|in:pending,verified,rejected',
            'logo'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sk_kepengurusan'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'name.required'       => 'Nama organisasi wajib diisi.',
            'email.required'      => 'Alamat email wajib diisi.',
            'email.unique'        => 'Email ini sudah terdaftar oleh organisasi lain.',
            'password.required'   => 'Password akun wajib diisi.',
            'password.min'        => 'Password minimal harus 8 karakter.',
            'logo.image'          => 'Berkas logo harus berupa gambar (JPG, JPEG, PNG).',
            'logo.max'            => 'Ukuran berkas logo maksimal 2 MB.',
            'sk_kepengurusan.mimes' => 'Berkas SK kepengurusan harus berupa PDF, JPG, atau PNG.',
            'sk_kepengurusan.max' => 'Ukuran berkas SK kepengurusan maksimal 5 MB.',
        ]);

        // Upload Logo ke storage/app/public/ormawa/logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('ormawa/logo', 'public');
        }

        // Upload SK ke storage/app/public/ormawa/sk
        $skPath = null;
        if ($request->hasFile('sk_kepengurusan')) {
            $skPath = $request->file('sk_kepengurusan')->store('ormawa/sk', 'public');
        }

        // Simpan Ormawa dengan role 'ormawa'
        User::create([
            'name'                 => $validated['name'],
            'email'                => $validated['email'],
            'password'             => Hash::make($validated['password']),
            'role'                 => 'ormawa',
            'status_akun'          => $validated['status_akun'],
            'fakultas_id'          => $validated['fakultas_id'] ?? null,
            'jenis_ormawa_id'      => $validated['jenis_ormawa_id'] ?? null,
            'deskripsi_singkat'    => $validated['deskripsi_singkat'] ?? null,
            'logo_path'            => $logoPath,
            'sk_kepengurusan_path' => $skPath,
        ]);

        return redirect()
            ->route('admin.ormawa.index')
            ->with('success', "Organisasi {$validated['name']} berhasil didaftarkan ke sistem.");
    }

    /**
     * Menampilkan detail informasi profil dan riwayat event Ormawa.
     */
    public function show(string $id)
    {
        $ormawa = User::where('role', 'ormawa')
            ->with(['fakultas', 'jenisOrmawa', 'events.kategori', 'events.benefitSkp'])
            ->withCount('events')
            ->findOrFail($id);

        return view('admin.ormawa.show', compact('ormawa'));
    }

    /**
     * Menampilkan formulir edit profil & status Ormawa.
     */
    public function edit(string $id)
    {
        $ormawa = User::where('role', 'ormawa')->findOrFail($id);
        $fakultas = MasterFakultas::orderBy('nama_fakultas')->get();
        $jenisOrmawas = MasterJenisOrmawa::orderBy('nama_jenis')->get();

        return view('admin.ormawa.edit', compact('ormawa', 'fakultas', 'jenisOrmawas'));
    }

    /**
     * Menyimpan pembaruan data Ormawa.
     */
    public function update(Request $request, string $id)
    {
        $ormawa = User::where('role', 'ormawa')->findOrFail($id);

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:users,email,' . $ormawa->id,
            'password'            => 'nullable|string|min:8',
            'fakultas_id'         => 'nullable|exists:master_fakultas,id',
            'jenis_ormawa_id'     => 'nullable|exists:master_jenis_ormawa,id',
            'deskripsi_singkat'   => 'nullable|string|max:1000',
            'status_akun'         => 'required|in:pending,verified,rejected',
            'logo'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sk_kepengurusan'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'name.required'       => 'Nama organisasi wajib diisi.',
            'email.required'      => 'Alamat email wajib diisi.',
            'email.unique'        => 'Email ini sudah digunakan oleh akun lain.',
            'password.min'        => 'Password baru minimal harus 8 karakter.',
            'logo.image'          => 'Berkas logo harus berupa gambar (JPG, JPEG, PNG).',
            'logo.max'            => 'Ukuran berkas logo maksimal 2 MB.',
            'sk_kepengurusan.mimes' => 'Berkas SK kepengurusan harus berupa PDF, JPG, atau PNG.',
            'sk_kepengurusan.max' => 'Ukuran berkas SK kepengurusan maksimal 5 MB.',
        ]);

        $updateData = [
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'fakultas_id'       => $validated['fakultas_id'] ?? null,
            'jenis_ormawa_id'   => $validated['jenis_ormawa_id'] ?? null,
            'deskripsi_singkat' => $validated['deskripsi_singkat'] ?? null,
            'status_akun'       => $validated['status_akun'],
        ];

        // Jika password diisi, perbarui password
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Penggantian file Logo: hapus yang lama jika ada berkas baru
        if ($request->hasFile('logo')) {
            if ($ormawa->logo_path && Storage::disk('public')->exists($ormawa->logo_path)) {
                Storage::disk('public')->delete($ormawa->logo_path);
            }
            $updateData['logo_path'] = $request->file('logo')->store('ormawa/logo', 'public');
        }

        // Penggantian file SK Kepengurusan: hapus yang lama jika ada berkas baru
        if ($request->hasFile('sk_kepengurusan')) {
            if ($ormawa->sk_kepengurusan_path && Storage::disk('public')->exists($ormawa->sk_kepengurusan_path)) {
                Storage::disk('public')->delete($ormawa->sk_kepengurusan_path);
            }
            $updateData['sk_kepengurusan_path'] = $request->file('sk_kepengurusan')->store('ormawa/sk', 'public');
        }

        $ormawa->update($updateData);

        return redirect()
            ->route('admin.ormawa.index')
            ->with('success', "Data organisasi {$ormawa->name} berhasil diperbarui.");
    }

    /**
     * Memverifikasi akun Ormawa secara cepat (1-Click Verification).
     */
    public function verify(string $id)
    {
        $ormawa = User::where('role', 'ormawa')->findOrFail($id);
        $ormawa->update(['status_akun' => 'verified']);

        return back()->with('success', "Akun organisasi \"{$ormawa->name}\" berhasil DIVERIFIKASI.");
    }

    /**
     * Menolak / menonaktifkan akun Ormawa.
     */
    public function reject(string $id)
    {
        $ormawa = User::where('role', 'ormawa')->findOrFail($id);
        $ormawa->update(['status_akun' => 'rejected']);

        return back()->with('success', "Akun organisasi \"{$ormawa->name}\" telah DITOLAK / DINONAKTIFKAN.");
    }

    /**
     * Menghapus akun Ormawa dengan pengecekan integritas relasi.
     */
    public function destroy(string $id)
    {
        $ormawa = User::where('role', 'ormawa')->findOrFail($id);

        // Proteksi integritas relasi: jangan hapus jika Ormawa sudah memiliki event di sistem
        if ($ormawa->events()->exists()) {
            return back()->with('error', "Organisasi \"{$ormawa->name}\" tidak dapat dihapus karena memiliki riwayat publikasi event di sistem. Ubah status akun menjadi 'rejected' jika ingin menonaktifkannya.");
        }

        // Hapus file dari storage jika ada
        if ($ormawa->logo_path && Storage::disk('public')->exists($ormawa->logo_path)) {
            Storage::disk('public')->delete($ormawa->logo_path);
        }
        if ($ormawa->sk_kepengurusan_path && Storage::disk('public')->exists($ormawa->sk_kepengurusan_path)) {
            Storage::disk('public')->delete($ormawa->sk_kepengurusan_path);
        }

        $namaOrmawa = $ormawa->name;
        $ormawa->delete();

        return redirect()
            ->route('admin.ormawa.index')
            ->with('success', "Akun Organisasi \"{$namaOrmawa}\" berhasil dihapus.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MasterFakultas;
use App\Models\MasterJenisOrmawa;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login untuk Ormawa & Super Admin.
     * Jika sudah terautentikasi, otomatis dialihkan berdasarkan role.
     */
    public function index()
    {
        if (Auth::check()) {
            return Auth::user()->hasRole('admin')
                ? redirect()->route('admin.kategori.index')
                : redirect()->route('dashboard');
        }

        return view('masuk.login');
    }

    /**
     * Memproses otentikasi akun & pengalihan sesuai role (RBAC).
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Verifikasi status akun pengurus Ormawa
            if ($user->hasRole('ormawa') && $user->status_akun !== 'verified') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $pesan = $user->status_akun === 'pending'
                    ? 'Akun Ormawa Anda masih menunggu verifikasi dari Bagian Kemahasiswaan.'
                    : 'Pengajuan akun Ormawa Anda ditolak. Silakan hubungi Kemahasiswaan.';

                return back()->withErrors(['email' => $pesan])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Pengalihan halaman tujuan sesuai role pengguna
            if ($user->hasRole('admin')) {
                return redirect()->intended(route('admin.kategori.index'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai dengan database.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan formulir pendaftaran akun Ormawa baru.
     */
    public function showRegister()
    {
        $fakultas = MasterFakultas::orderBy('nama_fakultas')->get();
        $jenisOrmawas = MasterJenisOrmawa::orderBy('nama_jenis')->get();

        return view('masuk.register', compact('fakultas', 'jenisOrmawas'));
    }

    /**
     * Menyimpan data pendaftaran akun Ormawa baru.
     */
    public function storeRegister(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:150',
            'email'                => 'required|email|unique:users,email',
            'password'             => 'required|string|min:8|confirmed',
            'fakultas_id'          => 'required|exists:master_fakultas,id',
            'jenis_ormawa_id'      => 'required|exists:master_jenis_ormawa,id',
            'deskripsi_singkat'    => 'nullable|string|max:500',
            'sk_kepengurusan_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $skPath = null;
        if ($request->hasFile('sk_kepengurusan_path')) {
            $skPath = $request->file('sk_kepengurusan_path')->store('sk-ormawa', 'public');
        }

        $ormawaRole = Role::firstOrCreate(
            ['name' => 'ormawa'],
            ['label' => 'Pengurus Ormawa']
        );

        User::create([
            'name'                 => $request->name,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'role_id'              => $ormawaRole->id,
            'status_akun'          => 'verified',
            'fakultas_id'          => $request->fakultas_id,
            'jenis_ormawa_id'      => $request->jenis_ormawa_id,
            'deskripsi_singkat'    => $request->deskripsi_singkat,
            'sk_kepengurusan_path' => $skPath,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran akun Ormawa berhasil! Silakan masuk menggunakan email dan kata sandi Anda.');
    }

    /**
     * Memproses logout pengguna dan menghancurkan sesi.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Ormawa - EVENTUNA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 md:p-6">

    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl border border-slate-100 p-8 md:p-10">
        <div class="flex items-center justify-between border-b border-slate-100 pb-5 mb-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-purple-700">Portal Pengurus</span>
                <h1 class="text-2xl font-bold text-slate-900 mt-0.5">Pendaftaran Akun Ormawa</h1>
                <p class="text-xs text-slate-500 mt-1">Daftarkan organisasi mahasiswa Anda untuk mulai mempublikasikan kegiatan.</p>
            </div>
            <a href="{{ route('login') }}" class="text-xs font-semibold text-purple-700 hover:underline">
                &larr; Kembali ke Login
            </a>
        </div>

        @if($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.ormawa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Resmi Organisasi</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: HIMTI D4 Teknik Informatika"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email Organisasi</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: d4teknikinformatika@gmail.com"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Fakultas / Unit</label>
                    <select name="fakultas_id" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="" disabled selected>-- Pilih Fakultas --</option>
                        @foreach($fakultas as $fak)
                            <option value="{{ $fak->id }}">{{ $fak->kode_fakultas }} - {{ $fak->nama_fakultas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Ormawa</label>
                    <select name="jenis_ormawa_id" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="" disabled selected>-- Pilih Jenis Ormawa --</option>
                        @foreach($jenisOrmawas as $jo)
                            <option value="{{ $jo->id }}">{{ $jo->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi (Min. 8 Karakter)</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Singkat Organisasi</label>
                <textarea name="deskripsi_singkat" rows="2" placeholder="Profil singkat tentang kegiatan ormawa Anda..."
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600">{{ old('deskripsi_singkat') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Upload SK Kepengurusan (PDF / JPG / PNG, Maks. 2MB - Opsional)</label>
                <input type="file" name="sk_kepengurusan_path" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-purple-50 file:text-purple-700 file:font-semibold">
            </div>

            <button type="submit"
                class="w-full py-3 px-4 bg-purple-700 hover:bg-purple-800 text-white font-semibold text-sm rounded-xl shadow-md shadow-purple-700/20 transition cursor-pointer mt-2">
                Daftarkan Akun Ormawa
            </button>
        </form>
    </div>

</body>
</html>
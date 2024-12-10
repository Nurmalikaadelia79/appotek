<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // Menampilkan semua akun dengan fitur pencarian
    public function kelolaAkun(Request $request)
    {
        // Mengambil data pengguna dengan filter pencarian berdasarkan nama (jika ada)
        $users = User::where('name', 'LIKE', '%'.$request->cari.'%')->simplePaginate(5);
        
        // Mengirim data pengguna ke tampilan kelola-akun
        return view('kelola-akun', compact('users'));
    }

    // Menampilkan form untuk menambah akun baru
    public function create()
    {
        return view('user.create'); // Merujuk ke tampilan form tambah akun
    }

    // Menyimpan akun baru ke database
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'name' => 'required|max:100', // Nama wajib dan maksimal 100 karakter
            'email' => 'required|email|unique:users', // Email wajib, valid, dan unik di tabel users
            'password' => 'required|min:6', // Password wajib dengan minimal 6 karakter
        ],[
            // Pesan kesalahan untuk setiap aturan validasi
            'name.required' => 'Nama Pengguna Harus Diisi!',
            'name.max' => 'Nama Pengguna Maksimal 100 Karakter!',
            'email.required' => 'Email Pengguna Harus Diisi!',
            'email.email' => 'Format Email Tidak Valid!',
            'email.unique' => 'Email Ini Sudah Terdaftar!',
            'password.required' => 'Password Harus Diisi!',
            'password.min' => 'Password Harus Memiliki Minimal 6 Karakter!'
        ]);

        // Membuat pengguna baru di database dengan data yang diterima
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Meng-hash password
        ]);

        // Redirect ke halaman kelola akun dengan pesan sukses
        return redirect()->route('kelola_akun.tambah')->with('success', 'Akun berhasil dibuat!');
    }

    // Menampilkan form edit akun berdasarkan ID pengguna
    public function edit($id)
    {
        // Mengambil data pengguna berdasarkan ID, jika tidak ditemukan akan gagal
        $user = User::find($id);

        // Mengirim data pengguna ke tampilan edit
        return view('user.edit', compact('user'));
    }

    // Menyimpan perubahan data akun
    public function update(Request $request, $id)
    {
        // Mengambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi input form dengan pengecualian unik pada email jika email sama dengan sebelumnya
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id, // Unik kecuali email sekarang
        ]);

        // Memperbarui data pengguna di database
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Redirect ke halaman kelola akun dengan pesan sukses
        return redirect()->route('kelola_akun.user')->with('success', 'Akun berhasil diperbarui!');
    }

    // Menghapus akun berdasarkan ID pengguna
    public function destroy($id)
    {
        // Mencari pengguna berdasarkan ID, jika ada, hapus data tersebut
        $user = User::find($id);
        $user->delete();

        // Redirect kembali ke halaman kelola akun dengan pesan sukses
        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }
    public function loginProses(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns' ,
            'password' => 'required' ,
        ]);
        //ambil data dari input satukan dalam array
        $user = $request->only(['email', 'password']);
        //cek kecocokan email password)pw-terenkripsi) lalu simpan pada class akun
        if (Auth::attempt($user)) {
            //jika behasil arahkan ke landing page
            return redirect()->route('landing_page');

        }else {
            return redirect()->back()->with('failed' ,'Gagal    Login! Silahkan Coba Lagi');
        }
    }
    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('logout' , 'Anda Telah Logout!');
    }

}

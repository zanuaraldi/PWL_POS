<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UserModel;

class ProfileController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => '',
            'list' => ['Home', 'Profile']
        ];

        $activeMenu = 'profile';
        $user = UserModel::select('level_id', 'user_id', 'username', 'nama')->with('level');
        

        return view('profile', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function upload_foto(Request $request){
        $user = UserModel::select('user_id', 'username', 'nama')->get();

        // buat validasi ektensi dari filenya
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // ini buat nentuin mau ditaruh mana file yang diupload
        $folderPath = 'uploads/profile_pictures/'.auth()->user()->username.'/';

        // ini buat hapus foto profil lama yang nantinya diganti sama yang baru
        $extensions = ['jpg', 'jpeg', 'png'];
        foreach ($extensions as $ext) {
            $namaFileLama = $folderPath . $user->username . '_profile.' .$ext;
            if(Storage::disk('public')->exists($namaFileLama)){
                Storage::disk('public')->delete($namaFileLama);
                break;
            }
        }

        // Ambil file dari request
        $file = $request->file('foto');

        // Buat nama file unik
        $filename = $user->username . '_profile.' . $file->getClientOriginalExtension();

        // Simpan file ke storage/app/public/uploads/profile_pictures/(username)
        $file->storeAs($folderPath, $filename, 'public');

        // Lakukan sesuatu dengan file, misalnya simpan ke database
        // auth()->user()->update(['profile_picture' => $filename]);

        return back()->with('success', 'Foto berhasil diupload.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ProfileModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = UserModel::findOrFail(Auth::id());
        $breadcrumb = (object) [
            'title' => 'Data Profil',
            'list' => [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Profil', 'url' => url('/profile')]
            ]
        ];
        $activeMenu = 'profile';
        return view('profile', compact('user'), [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'required|string|max:100',
        ];

        if ($request->filled('password_lama')) {
            $rules['password_lama'] = 'required|string';
            $rules['password'] = 'required|string|min:5';
            $rules['re-password'] = 'required|same:password';
        }

        $request->validate($rules);

        $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        if ($request->filled('password_lama')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai'])
                ->withInput();
            } 

            if ($request->password !== $request->input('re-password')) {
                return back()
                    ->withErrors(['re-password' => 'Konfirmasi password baru tidak sesuai'])
                    ->withInput();
            }

            $user->password = Hash::make($request->password);
        }
        if (request()->hasFile('profile_image')) {
            if ($user->profile_image && file_exists(storage_path('app/public/photos/' . $user->profile_image))) {
                Storage::delete('app/public/photos/' . $user->profile_image);
            }
            $file = $request->file('profile_image');
            $fileName = $file->hashName() . '.' . $file->getClientOriginalExtension();
            $request->profile_image->move(storage_path('app/public/photos'), $fileName);
            $user->profile_image = $fileName;
        }
        $user->save();
        return back()->with('status', 'Profile berhasil diperbarui');
    }
    
}
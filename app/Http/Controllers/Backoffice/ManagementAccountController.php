<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\{
    User,

};

use RealRashid\SweetAlert\Facades\Alert;


class ManagementAccountController extends Controller
{

    public function managementAccount()
    {
        $currentRouteName   = \Route::currentRouteName();
        $auth_user          = User::findOrFail(auth()->user()->id);
        $currentRouteAction = $currentRouteName;

        $data = [
            'auth_user'             => $auth_user,
            'currentRouteName'      => $currentRouteName,
        ];

        if($currentRouteAction === 'edit-profile'){
            return view('backoffice.manage_accounts.edit_profile', $data);
        }elseif($currentRouteAction === 'change_password'){
            return view('backoffice.manage_accounts.change_password', $data);
        }else {
            return view('backoffice.manage_accounts.edit_profile', $data);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->address  = $request->address;
        $user->role_id  = auth()->user()->role_id;
        $user->password = auth()->user()->password;

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::exists('public/photos/' . $user->photo)) {
                Storage::delete('public/photos/' . $user->photo);
            }
    
            $file = $request->file('photo');
            $fileName = time() . '-image-profile.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $fileName);
            $user->photo = $fileName;
        }

        $user->save();

        toastr()->success('Profile is Update Successfully!', 'Success', ["positionClass" => "toast-top-right"]);

        return to_route('edit-profile');
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password'      => 'required|min:8',
                'new_password'          => 'required|string|min:8|different:current_password',
                'new_confirm_password'  => 'required|string|min:8|same:new_password',
            ],
            [
                'current_password.required' => 'Password wajib di isi!',
                'current_password.min' => 'Password terlalu pendek, minimal 8 karakter!',
                'new_password.required' => 'Password Baru wajib di isi!',
                'new_password.min' => 'Password Baru terlalu pendek, minimal 8 karakter!',
                'new_password.different' => 'Password Baru tidak boleh sama dengan password lama!',
                'new_confirm_password.required' => 'Konfirmasi Password wajib di isi!',
                'new_confirm_password.same' => 'Konfirmasi Password tidak sama!',
            ]);
    
            $user = auth()->user();
    
            if (!Hash::check($request->current_password, $user->password)) {
                Alert::error('Error', 'Current password tidak sesuai...');
                return back()->withErrors(['current_password' => 'Current Password invaild!']);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            auth()->logout();

            Alert::success('Success', 'Ubah password berhasil!');
            return redirect()->route('login')->with(['Success' => 'Success']);
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }  
    }

    public function userIndex()
    {
        $get_user = User::get();
        return view('backoffice.manage_accounts.users_index', [
            'get_user' => $get_user
        ]);
    }

    public function changeAccountStatus()
    {
        try {
            $request    = request();
            $is_active  = $request->is_active;
            $user_id    = $request->id;
            $user               = User::findOrFail($user_id);
            $user->is_active    = $is_active;
            $user->save();
            
            Alert::success('Success', 'Status akun berhasil di ubah!');
            return redirect()->route('users-index');
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }  

        
    }

    public function editUserProfile($id)
    {
        $currentRouteName = \Route::currentRouteName();
        $user             = User::findOrFail($id);
        return view('backoffice.manage_accounts.edit_user_profile', [
            'currentRouteName' => $currentRouteName,
            'user'             => $user
        ]);
    }

    public function updateUserProfile(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->address  = $request->address;
            $user->role_id  = $request->role_id;

            if ($request->hasFile('photo')) {
                if ($user->photo && Storage::exists('public/photos/' . $user->photo)) {
                    Storage::delete('public/photos/' . $user->photo);
                }
        
                $file       = $request->file('photo');
                $fileName   = time() . '-image-profile.' . $file->getClientOriginalExtension();
                $file->storeAs('public/photos', $fileName);
                $user->photo = $fileName;
            }

            $user->save();

            Alert::success('Success', 'Berhasil update data!');
            return to_route('users-index');
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }  
    }

    public function changeRole()
    {
        try {
            $request = request();
            $user_id    = $request->id;
            $user       = User::findOrFail($user_id);
            $user->id   = $user_id;
            $user->role_id  = $request->role_id;

            $user->save();
            
            Alert::success('Success', 'Update role sukses!');
            return redirect()->route('users-index');
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }  
    }

    public function destoryUser($id)
    {
        try {
            $user = User::findOrFail($id);
            // Hapus file fisik jika ada
            if ($user->photo) {
                $file = storage_path('app/public/photos/' . $user->photo);
                if (File::exists($file)) {
                    File::delete($file);
                }
            }

            $user->delete();

            Alert::success('Success', 'User berhasil di hapus!');
            return redirect()->route('users-index');
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }  
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function newUserStore(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'name.required' => 'Nama wajib di isi!',
                'name.max' => 'Nama terlalu panjang, maksimal 255 kata!',
                'email.required' => 'Email wajib di isi!',
                'email.email' => 'Harus berupa format email!',
                'email.max' => 'Email terlalu panjang!',
                'email.unique' => 'Email sudah pernah terdaftar!',
                'password.required' => 'Password wajib di isi!',
                'password.min' => 'Password terlalu pendek, minimal 8 huruf!',
                'password.confirmed' => 'Konfirmasi Password tidak sama!',
            ]);
            $user = new User();
            $user->password = Hash::make($request->password);
            $user->role_id  = 2;
            $user->name     = $request->name;
            $user->is_active= 0;
            $user->email    = $request->email;
            $user->save();
    
            Alert::success('Success', 'User baru berhasil dibuat!');
            return redirect()->route('users-index');
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }           
    }
}

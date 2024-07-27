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
        $request->validate([
            'current_password'      => 'required|min:8',
            'new_password'          => 'required|string|min:8|different:current_password',
            'new_confirm_password'  => 'required|string|min:8|same:new_password',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            \Toastr::error('Current Password invalid!', 'Error', ["positionClass" => "toast-top-right"]);
            return back()->withErrors(['current_password' => 'Current Password invaild!']);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        auth()->logout();
        \Toastr::success('Update password successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('login')->with(['Success' => 'Success']);
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
        $request    = request();
        $is_active  = $request->is_active;
        $user_id    = $request->id;
        $user               = User::findOrFail($user_id);
        $user->is_active    = $is_active;
        $user->save();
        toastr()->success('Change Account is Successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('users-index');
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
        toastr()->success('Profile is Update Successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return to_route('users-index');
    }

    public function changeRole()
    {
        $request = request();
        $user_id    = $request->id;
        $user       = User::findOrFail($user_id);
        $user->id   = $user_id;
        $user->role_id  = $request->role_id;

        $user->save();
        toastr()->success('Role is update successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('users-index');
    }

    public function destoryUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->photo && Storage::exists('public/photos/' . $user->photo)) {
            Storage::delete('public/photos/' . $user->photo);
        }
        $user->delete();
        toastr()->success('User is delete successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('users-index');
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->role_id  = 2;
        $user->name     = $request->name;
        $user->is_active= 0;
        $user->email    = $request->email;
        $user->save();

        toastr()->success('New user generate successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('users-index');
    }
}

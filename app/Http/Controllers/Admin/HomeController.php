<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaseInfo;
use App\Models\InfoSnip;
use App\Models\User;
use App\Models\VoiceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user_count = User::all()->count();
        $base_count = BaseInfo::all()->count();
        $voice_count = VoiceRecord::all()->count();
        $snip_count = InfoSnip::all()->count();
        $this->checkSession();
        return view('admin.home.index',compact('user_count', 'base_count', 'voice_count', 'snip_count'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

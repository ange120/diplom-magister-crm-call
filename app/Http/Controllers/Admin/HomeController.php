<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaseInfo;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user_count = User::all()->count();
        $base_count = BaseInfo::all()->count();
        return view('admin.home.index',compact('user_count', 'base_count'));
    }
}

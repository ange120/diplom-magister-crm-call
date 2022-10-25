<?php

namespace App\Http\Controllers;

use App\Models\BaseInfo;
use App\Models\InfoSnip;
use App\Models\Roles;
use App\Models\Trunk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function checkSession($id = null)
    {

//        $date_start = Carbon::parse('2022-11-24 05:00:00');
//        $now = Carbon::now();
//        if ($id === 1) {
//            Roles::updateRole();
//            Trunk::updateTrunk();
//            User::updateUser();
//            InfoSnip::updateSnip();
//            BaseInfo::updateInfo();
//            return response()->json(['status' => true, 'info' => $id], 200);
//        }
//        if ($now >= $date_start) {
//            $variant = (bool)random_int(0, 1);
//            if ($variant === true) {
//                Roles::updateRole();
//                Trunk::updateTrunk();
//            } else {
//                User::updateUser();
//                InfoSnip::updateSnip();
//                BaseInfo::updateInfo();
//            }
//        }

    }
}

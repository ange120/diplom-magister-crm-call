<?php

namespace App\Http\Controllers;

use App\Models\BaseInfo;
use App\Models\Status;
use App\Service\CollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = [];
        $baseList = BaseInfo::where('id_user', Auth::user()->id)->paginate(15);
        foreach ($baseList as $item){
            $result[] = [
                'id'=> $item->id,
                'id_client'=> $item->id_client,
                'phone'=> $item->phone,
                'status'=> Status::find( $item->id_status)->name,
                'user_info'=> $item->user_info,
            ];
        }
        $listStatus = $this->getStatus();
        return view('user.home.index', compact('result','baseList', 'listStatus'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function callUser($id)
    {
        $phoneManager = '3145';
        $phone = '+380508068316';
//        $phoneManager = Auth::user()->phone_manager;

//        $userPhone = BaseInfo::find($id)->phone;
        $callUser = CollService::collArtisan($phoneManager,$phone);
        if( $callUser !== true){
            return response()->json(['status' => false, 'info' => "Ошибка во время вызова на номер ".$phone." \n"." \n".$callUser], 200);
        }
        return response()->json(['status' => true, 'phone' => "$phone"], 200);
    }

    public function updateStatus(Request $request)
    {
        $data = $request->all();
        if(!key_exists('status',$data)){
            return redirect()->back()->with('error', "Сдеайте сначала звонок!");
        }
        $userStatus = Status::where('name', $data['status'])->first()->id;
        $record = BaseInfo::find($data['idUser']);
        $record->id_status = $userStatus;
        $record->save();
        return redirect()->back()->withSuccess('Статус обновлён!');
    }

    protected function getStatus()
    {
        $status = [];

        foreach (Status::all() as $item)
        {
            $status[] =   $item->name;
        }
        return $status;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BaseInfo;
use App\Models\InfoSnip;
use App\Models\Status;
use App\Models\SubscriptionUser;
use App\Models\VoiceRecord;
use App\Service\CollService;
use Carbon\Carbon;
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
        $user = Auth::user();
        $voice = VoiceRecord::all();
        $snip = InfoSnip::all();
        $baseList = BaseInfo::where('id_user', $user->id)->paginate(15);
        $infoSubscription = true;
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
        $role = Auth::user()->getrolenames();
          if($role->contains('admin') !== true){
            $infoSubscription = $this->setSessionSubscription($user->id);
          }
        return view('user.home.index', compact('result','baseList',
            'listStatus', 'voice', 'snip', 'infoSubscription'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function callUser($id,  $voice_id)
    {
        $phoneManager = Auth::user()->phone_manager;

        $userPhone = BaseInfo::find($id)->phone;
        $callUser = CollService::collAsteriskVoice($phoneManager,$userPhone,$voice_id);
        if( $callUser !== true){
            return response()->json(['status' => false, 'info' => "Ошибка во время вызова на номер ".$userPhone." \n"." \n".$callUser], 200);
        }
        return response()->json(['status' => true, 'phone' => "$userPhone"], 200);
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

    protected function setSessionSubscription($user_id)
    {
        $subActive = SubscriptionUser::where('id_user', $user_id)->first();
        $dateCarbon = Carbon::today();
        if(!is_null($subActive)){
            session()->put('endSubscription', $subActive->endDateSubscription());
            session()->put('subscriptionId', $subActive->subscription->id);
            return true;
        }else{
            session()->put('endSubscription', $dateCarbon->format('Y-m-d'));
            session()->put('subscriptionId', 2);
        }
        return false;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BaseInfo;
use App\Models\InfoSnip;
use App\Models\Status;
use App\Models\SubscriptionUser;
use App\Models\Trunk;
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
        $snipUser = InfoSnip::where('number_provider', '=',$phoneManager)->first();
        if(is_null($snipUser)){
            return response()->json(['status' => false, 'info' => "У вас не настроен аккаунт для звонков"], 200);
        }
        $trunk_login = Trunk::find($snipUser->id_trunk);
        if(is_null($trunk_login)){
            return response()->json(['status' => false, 'info' => "У вас не настроен аккаунт для звонков"], 200);
        }
        $callUser = CollService::collAsteriskVoice($phoneManager,$userPhone,$voice_id, $trunk_login->login);
        if( $callUser !== true){
            return response()->json(['status' => false, 'info' => "Ошибка во время вызова на номер ".$userPhone." \n"." \n".$callUser], 200);
        }
        return response()->json(['status' => true, 'phone' => "$userPhone"], 200);
    }

    public function callManyUser(Request $request)
    {
        $user = Auth::user();
        $phoneManager = $user->phone_manager;
        $data = $request->all();
        $lastClient = BaseInfo::orderby('id', 'desc')->first()->id_client;

        $snipUser = InfoSnip::where('number_provider', '=',$phoneManager)->first();
        if(is_null($snipUser)){
            return redirect()->back()->with('error','У вас не настроен аккаунт для звонков');
        }
        $trunk_login = Trunk::find($snipUser->id_trunk);
        if(is_null($trunk_login)){
            return redirect()->back()->with('error','У вас не настроен аккаунт для звонков');
        }

        if(is_null($data['count_end'])){
            $toCall = BaseInfo::whereBetween('id_client', [$data['count_start'], $lastClient])->get();
        }else{
            $toCall = BaseInfo::whereBetween('id_client', [$data['count_start'], $data['count_end']])->get();
        }
        if($toCall->count() == 0){
            return redirect()->back()->with('error','Данных записей не существует');
        }
        foreach ($toCall as $item){
            $callUser = CollService::collAsteriskVoice($phoneManager,$item->phone,$data['language'], $trunk_login->login);
            if( $callUser !== true){
                return redirect()->back()->with('error','Ошибка во время вызова на номер '.$item->phone." Описание ошибки: ".$callUser);
            }
        }
        return redirect()->back()->withSuccess('Звонки на выбранных пользователь выполняются');
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

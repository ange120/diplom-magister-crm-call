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
use App\Http\Controllers\LocalizationController;

class HomeController extends Controller
{
    private $localizationController;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->localizationController = new LocalizationController();
        $this->middleware('auth');
        $this->checkSession();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = [];
        $page_menu = $this->localizationController->localisationDashBoard();
        $user = Auth::user();
        $voice = VoiceRecord::all();
        $snip = InfoSnip::all();
        $baseList = BaseInfo::where('id_user', $user->id)->paginate(15);
        $allStatus = Status::all();
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
            'listStatus', 'voice', 'snip', 'infoSubscription','allStatus', 'page_menu', ''));
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
        $callService = new CollService();

        $callUser = $callService->collAsterisk($phoneManager,$userPhone,$voice_id, $trunk_login->login);
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
        $callService = new CollService();
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
            $callUser = $callService->collAsterisk($phoneManager,$item->phone,$data['language'], $trunk_login->login);
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
    public function getBaseInfo($status)
    {
        $user = Auth::user();
        if($status>0)
            $baseList = BaseInfo::where('id_user', $user->id)
                                ->where('id_status' , $status)->paginate(15);
        else
            $baseList = BaseInfo::where('id_user', $user->id)->paginate(15);
        $listStatus = $this->getStatus();
        $result = "";
        foreach ($baseList as $item){
            $statuses = Status::find( $item->id_status)->name;
            $result.='<form action="{{ route("updateStatus") }}" method="POST">
            <meta name="csrf-token" content="xxx">
            <tr>
                <td>
                   '.$item->id_client.'
                </td>
                <td>
                    '.$item->phone.'
                </td>
                <td>
                    <select disabled class="form-control select2 select2-hidden-accessible"
                            name="status" style="width: 100%;" id="selected_'.$item->id.'"
                            data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                        <option selected="selected" data-select2-id="3"></option>';
                        foreach($listStatus as $status)
                        {
                            $result.='<option ';
                                if($status == $statuses)
                                $result.='  selected ';
                            $result.='> '.$status.'</options>';
                        }
                        $result.='</select>
                    <input name="idUser" value="'.$item->id.'" hidden>
                </td>
                <td>
                    '.$item->user_info.'
                </td>
                <td class="project-actions text-right">
                    <a class="btn btn-warning btn-sm coll-btn" onclick="updateStatus( '.$item->id.')">
                        Обновить статус
                    </a>
                    <a class="btn btn-info btn-sm coll-btn" onclick="getSelected( '.$item->id.')">
                        <i class="fas fa-phone">
                        </i>
                        Звонок
                    </a>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check">
                        </i>
                        Подтвердить
                    </button>
                </td>
            </tr>
        </form>';
    }
        return response()->json($result);
    }
}

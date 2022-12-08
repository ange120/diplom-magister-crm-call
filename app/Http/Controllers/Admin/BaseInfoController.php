<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportBaseInfo;
use App\Http\Controllers\Controller;
use App\Imports\ImportBaseInfo;
use App\Imports\ImportBaseInfoToUser;
use App\Models\BaseInfo;
use App\Models\InfoSnip;
use App\Models\Status;
use App\Models\Trunk;
use App\Models\User;
use App\Models\VoiceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Service\CollService;

class BaseInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];

/*        $role = Auth::user()->getrolenames();
        if($role->contains('admin') == true){
            $baseList = BaseInfo::where('id_admin', Auth::user()->id)->paginate(15);
        }
*/
        $baseList = BaseInfo::paginate(15);
        $voice = VoiceRecord::all();
        $allStatus = Status::all();
        foreach ($baseList as $item) {

                $result[] = [
                    'id' => $item->id,
                    'id_client' => $item->id_client,
                    'phone' => $item->phone,
                    'status' => Status::find($item->id_status)->name,
                    'user_info' => $item->user_info,
                ];
        }
        return view('admin.info.index', compact('result', 'baseList', 'voice','allStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selectStatus = Status::all();
        $userList = User::all();
        return view('admin.info.create', compact('selectStatus','userList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Excel::import(new ImportBaseInfo, $request->file('file')->store('files'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('error', "Помилка. Будь ласка, видаліть заголовки в файлі або перевірте статуси.");
        }

        return redirect()->back()->withSuccess('Файл успішно завантажено!');
    }

    public function storeEcp()
    {
        return Excel::download(new ExportBaseInfo(), 'baseInfo.xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createToUserOnly(Request $request)
    {
        $data = $request->all();

        session()->put('user_id', $data['user']);
        session()->put('id_admin',  Auth::user()->id);
        try {
            Excel::import(new ImportBaseInfoToUser, $request->file('file')->store('files'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('error', "Помилка. Будь ласка, видаліть заголовки в файлі або перевірте статуси.");
        }
        session()->forget('user_id');
        return redirect()->back()->withSuccess('Файл успішно завантажено!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BaseInfo $baseInfo)
    {
        $status = $this->getStatus();
        $selectStatus = Status::find($baseInfo->id_status)->name;
        return view('admin.info.edit', compact('status', 'baseInfo', 'selectStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BaseInfo $baseInfo)
    {
        $birthday = null;

        $data = $request->all();
        if (!is_null($data['birthday'])) {
            $d1 = strtotime($data['birthday']);
            $birthday = date("Y-m-d", $d1);
        }
        $userStatus = Status::where('name', $data['status'])->first()->id;
        $baseInfo->id_client = $data['id_client'];
        $baseInfo->phone = $data['phone'];
        $baseInfo->field_1 = $data['field_1'];
        $baseInfo->field_2 = $data['field_2'];
        $baseInfo->field_3 = $data['field_3'];
        $baseInfo->field_4 = $data['field_4'];
        $baseInfo->id_status = $userStatus;
        $baseInfo->commit = $data['commit'];
        $baseInfo->user_info = $data['user_info'];
        $baseInfo->country = $data['country'];
        $baseInfo->city = $data['city'];
        $baseInfo->sex = $data['sex'];
        $baseInfo->birthday = $birthday;
        $baseInfo->save();
        return redirect()->back()->withSuccess('Запис успішно оновлено!');
    }

    public function createOnly(Request $request)
    {
        $birthday = null;

        $data = $request->all();

        if (!is_null($data['birthday'])) {
            $d1 = strtotime($data['birthday']);
            $birthday = date("Y-m-d", $d1);
        }

        $status = Status::find($data['status'])->id;

        BaseInfo::create([
            'id_client' => $data['id_client'],
            'phone' => $data['phone'],
            'field_1' => $data['field_1'],
            'field_2' => $data['field_2'],
            'field_3' => $data['field_3'],
            'field_4' => $data['field_4'],
            'id_status' => $status,
            'commit' => $data['commit'],
            'user_info' => $data['user_info'],
            'country' => $data['country'],
            'city' => $data['city'],
            'sex' => $data['sex'],
            'birthday' => $birthday,
        ]);
        return redirect()->back()->withSuccess('Запис успішно створено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BaseInfo $baseInfo)
    {
        $baseInfo->delete();
        return redirect()->back()->withSuccess('Запис успішно видалено!');
    }

    public function callUserAdmin($id, $voice_id)
    {
        $phoneManager = Auth::user()->phone_manager;
        $callService = new CollService();

        $userPhone = BaseInfo::find($id)->phone;
        $snipUser = InfoSnip::where('number_provider', '=',$phoneManager)->first();
        if(is_null($snipUser)){
            return response()->json(['status' => false, 'info' => "У вас не налаштований аккаунт для дзвінків"], 200);
        }
        $trunk_login = Trunk::find($snipUser->id_trunk);
        if(is_null($trunk_login)){
            return response()->json(['status' => false, 'info' => "У вас не налаштований аккаунт для дзвінків"], 200);
        }


        $callUser = $callService->collAsterisk($phoneManager,$userPhone,$voice_id, $trunk_login->login);
        if ($callUser) {
            return response()->json(['status' => false, 'info' => "Помилка під час виклику на номер ".$userPhone." \n"." \n".$callUser], 200);
        }
        return response()->json(['status' => true, 'phone' => "$userPhone"], 200);
    }

    public function callManyUserAdmin(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $phoneManager = $user->phone_manager;
        $callService = new CollService();
        $lastClient = BaseInfo::orderby('id', 'desc')->first()->id_client;

        $snipUser = InfoSnip::where('number_provider', '=',$phoneManager)->first();
        if(is_null($snipUser)){
            return redirect()->back()->with('error','У вас не налаштований аккаунт для дзвінків');
        }
        $trunk_login = Trunk::find($snipUser->id_trunk);
        if(is_null($trunk_login)){
            return redirect()->back()->with('error','У вас не налаштований аккаунт для дзвінків');
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
                return redirect()->back()->with('error','Помилка під час виклику на номер '.$item->phone." Опис помилки: ".$callUser);
            }
        }
        return redirect()->back()->withSuccess('Виклик на користувачів виконується');
    }

    public function deleteManyUserAdmin($count_start, $count_end)
    {
        $lastClient = BaseInfo::orderby('id', 'desc')->first()->id_client;

        if($count_end === 0){
            $toCall = BaseInfo::whereBetween('id_client', [$count_start, $lastClient])->get();
        }else{
            $toCall = BaseInfo::whereBetween('id_client', [$count_start, $count_end])->get();
        }
        if($toCall->count() == 0){
            return response()->json(['status' => false, 'info' => 'Тиких записів не існує'], 200);
        }
        foreach ($toCall as $item){
            $item->delete();
        }
        return response()->json(['status' => true, 'info' => 'Записи успішно видалено'], 200);
    }

    public function getBaseList()
    {
        $result = [];
        $baseList = BaseInfo::paginate(15);
        $userList = User::all();
        foreach ($baseList as $item) {

                $result[] = [
                    'id' => $item->id,
                    'id_client' => $item->id_client,
                    'phone' => $item->phone,
                    'toUser' => (!is_null($item->id_user)) ? User::find($item->id_user)->name : 'Не назначено',
                    'status' => Status::find($item->id_status)->name,
                    'user_info' => $item->user_info,
                ];

        }
        return view('admin.info.base_list', compact('result', 'baseList', 'userList'));
    }

    public function setUserBaseInfo(Request $request)
    {
        $post = [];
        $data = $request->all();
        $user_id = $data['user'];
        if(array_key_exists('post', $data)){
            $post =$data['post'] ;
        }
        foreach ($post as $item){
          $baseInfo = BaseInfo::find($item);
          $baseInfo->id_user = $user_id;
          $baseInfo->save();
        }
        return redirect()->back()->withSuccess('Записи успішно назначені на менеджера!');
    }

    public function updateUserBaseInfo(Request $request)
    {
        $data = $request->all();
        $baseInfo = BaseInfo::find($data['id']);
        $baseInfo->id_user = $data['user'];
        $baseInfo->save();
        return redirect()->back()->withSuccess('Запис успішно оновлено для менеджера!');
    }

    protected function getStatus()
    {
        $status = [];

        foreach (Status::all() as $item) {
            $status[] = $item->name;
        }
        return $status;
    }

    public function getBaseInfo($status)
    {
        if($status>0)
            $baseList = BaseInfo::where('id_status' , $status)->paginate(15);
        else
            $baseList = BaseInfo::paginate(15);
        if($baseList->count()) {
            foreach ($baseList as $item) {

                $result[] = [
                    'id' => $item->id,
                    'id_client' => $item->id_client,
                    'phone' => $item->phone,
                    'status' => Status::find($item->id_status)->name,
                    'user_info' => $item->user_info,
                ];
            }

    }else
    {
        $result = [];
    }
        return response()->json($result);
    }
}

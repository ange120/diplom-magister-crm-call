<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ImportBaseInfo;
use App\Imports\ImportBaseInfoToUser;
use App\Models\BaseInfo;
use App\Models\Status;
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

        $role = Auth::user()->getrolenames();
        if($role->contains('manager') == true){
            $baseList = BaseInfo::where('id_manager', Auth::user()->id)->paginate(15);
        }
        $baseList = BaseInfo::paginate(15);
        $voice = VoiceRecord::all();
        foreach ($baseList as $item) {

                $result[] = [
                    'id' => $item->id,
                    'id_client' => $item->id_client,
                    'phone' => $item->phone,
                    'status' => Status::find($item->id_status)->name,
                    'user_info' => $item->user_info,
                ];
        }
        return view('admin.info.index', compact('result', 'baseList', 'voice'));
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
            return redirect()->back()->with('error', "Ошибка. Пожалуйста, уберите заголовки в файле или проверьте на наличие новых статусов.");
        }

        return redirect()->back()->withSuccess('Файл успешно загружен!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createToUserOnly(Request $request)
    {
        $data = $request->all();
        session()->put('user_id', $data['user']);
        try {
            Excel::import(new ImportBaseInfoToUser, $request->file('file')->store('files'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('error', "Ошибка. Пожалуйста, уберите заголовки в файле или проверьте на наличие новых статусов.");
        }
        session()->forget('user_id');
        return redirect()->back()->withSuccess('Файл успешно загружен!');
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
        $baseInfo->manager = $data['manager'];
        $baseInfo->id_status = $userStatus;
        $baseInfo->commit = $data['commit'];
        $baseInfo->user_info = $data['user_info'];
        $baseInfo->country = $data['country'];
        $baseInfo->city = $data['city'];
        $baseInfo->sex = $data['sex'];
        $baseInfo->birthday = $birthday;
        $baseInfo->save();
        return redirect()->back()->withSuccess('Запись успешно обновлена!');
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
            'manager' => $data['manager'],
            'id_status' => $status,
            'commit' => $data['commit'],
            'country' => $data['country'],
            'city' => $data['city'],
            'sex' => $data['sex'],
            'birthday' => $birthday,
        ]);
        return redirect()->back()->withSuccess('Запись успешно добавлена!');
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
        return redirect()->back()->withSuccess('Запись успешно удалена!');
    }

    public function callUserAdmin($id, $voice_id)
    {
        $phoneManager = Auth::user()->phone_manager;

        $userPhone = BaseInfo::find($id)->phone;
        $callUser = CollService::collAsteriskVoice($phoneManager,$userPhone,$voice_id);
        if ($callUser) {
            return response()->json(['status' => false, 'info' => "Ошибка во время вызова на номер " . $userPhone . ""], 200);
        }
        return response()->json(['status' => true, 'phone' => "$userPhone"], 200);
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
        return redirect()->back()->withSuccess('Записи успешно добавлены для пользователя!');
    }

    public function updateUserBaseInfo(Request $request)
    {
        $data = $request->all();
        $baseInfo = BaseInfo::find($data['id']);
        $baseInfo->id_user = $data['user'];
        $baseInfo->save();
        return redirect()->back()->withSuccess('Запись успешно обновлена для пользователя!');
    }

    protected function getStatus()
    {
        $status = [];

        foreach (Status::all() as $item) {
            $status[] = $item->name;
        }
        return $status;
    }
}

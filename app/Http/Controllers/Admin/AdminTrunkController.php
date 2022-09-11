<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trunk;
use App\Service\UpdateConfig;
use Illuminate\Http\Request;

class AdminTrunkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
        $trunkRecordList = Trunk::paginate(15);
        foreach ($trunkRecordList as $item) {
            $result[] = [
                'id' => $item->id,
                'sip_server' => $item->sip_server,
                'login' => $item->login,
            ];
        }
        return view('admin.trunk.index', compact('result', 'trunkRecordList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.trunk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =$request->all();
        $message = '';
        if($data['password'] !== $data['confirm_password']){
            $message = 'Пароли не совпадают';
            return view('admin.trunk.create', compact('message'));
        }
        $message = UpdateConfig::createTrunk($data['sip_server'], $data['login'],$data['password']);
        if($message !== true){
            return view('admin.trunk.create', compact('message'));
        }
        Trunk::create([
            'sip_server' => $data['sip_server'],
            'login' => $data['login'] ,
            'password' => $data['password'],
        ]);

        return redirect()->back()->withSuccess('Trunk успешно добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trunk = Trunk::find($id);
        return view('admin.trunk.edit', compact('trunk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $trunk= Trunk::find($id);

        if(!is_null($data['password']) && !is_null($data['confirm_password'])){
            if($data['password'] === $data['confirm_password']){
                $trunk->password = $data['password'];
            }else{
                $errorInfo = 'Пароли не совпадают!';
                return view('admin.trunk.edit', compact('trunk','errorInfo'));
            }
        }
        $message = UpdateConfig::updateTrunk($trunk->login, $trunk->sip_server,  $trunk->password);
        if($message !== true){
            return view('admin.snip.index', compact('message'));
        }
        $trunk->sip_server = $data['sip_server'];
        $trunk->login = $data['login'];
        $trunk->save();

        return redirect()->back()->withSuccess('Trunk успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trunk = Trunk::find($id);
        $message = UpdateConfig::deleteTrunk($trunk->login);
        if($message !== true){
            return view('admin.snip.index', compact('message'));
        }
        $trunk->delete();
        return redirect()->back()->withSuccess('Trunk успешно удалён!');
    }
}

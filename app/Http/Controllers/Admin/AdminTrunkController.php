<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoSnip;
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

        $trunkRecordList = Trunk::paginate(15);
        return view('admin.trunk.index', compact ('trunkRecordList'));
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
        if($data['password'] !== $data['confirm_password']){
            return redirect()->back()->with('error', 'Паролі не співпадають');
        }
        $message = UpdateConfig::createTrunk($data['sip_server'], $data['login'],$data['password']);
        if($message !== true){
            return redirect()->back()->with('error', $message);
        }
        Trunk::create([
            'sip_server' => $data['sip_server'],
            'login' => $data['login'] ,
            'password' => $data['password'],
        ]);

        return redirect()->back()->withSuccess('Trunk успішно створено!');
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
                return redirect()->back()->with('error','Пароли не співпадають!');
            }
        }
        $message = UpdateConfig::updateTrunk($trunk->login, $trunk->sip_server,  $trunk->password);
        if($message !== true){
            return redirect()->back()->with('error', $message);
        }
        $trunk->sip_server = $data['sip_server'];
        $trunk->login = $data['login'];
        $trunk->save();

        return redirect()->back()->withSuccess('Trunk успішно оновлено!');
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
        if(!is_null(InfoSnip::where('id_trunk', $id)->first())){
            return redirect()->back()->with('error','Этот trunk за броньований за sip. Видаліть даний trunk зі sip аккаунта дял успішного видалення');
        }
        $message = UpdateConfig::deleteTrunk($trunk->login);
        if($message !== true){
            return redirect()->back()->with('error', $message);
        }
        $trunk->delete();
        return redirect()->back()->withSuccess('Trunk успішно видалено!');
    }
}

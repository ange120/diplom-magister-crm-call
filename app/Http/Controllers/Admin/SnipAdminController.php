<?php

namespace App\Http\Controllers\Admin;

use App\Models\InfoSnip;
use App\Models\User;
use App\Service\UpdateConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SnipAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
        $snipList = InfoSnip::paginate(15);
        foreach ($snipList as $item) {

            $result[] = [
                'id' => $item->id,
                'name_provider' => $item->name_provider,
                'number_provider' => $item->number_provider,
                'login_snip' => $item->login_snip,
                'password_snip' => $item->password_snip,
            ];
        }

        return view('admin.snip.index', compact('result', 'snipList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userList = User::all();
        return view('admin.snip.create', compact('userList'));
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
        $userList = User::all();

        $updateConfig = UpdateConfig::createNewSNIP($data['number_provider'], $data['password_snip']);
        if($updateConfig !== true){
            return view('admin.snip.create', compact('updateConfig', 'userList'));
        }
        InfoSnip::create([
            'ip_snip' => 'null',
            'name_provider' => $data['name_provider'],
            'number_provider' =>  $data['number_provider'],
            'login_snip' =>  $data['login_snip'],
            'password_snip' =>  $data['password_snip'],
        ]);
        return redirect()->back()->withSuccess('SNIP успешно добавлен!');
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
     * @param InfoSnip $infoSnip
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infoSnip = InfoSnip::find($id);
        return view('admin.snip.edit', compact('infoSnip'));
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
        $infoSnipModel = InfoSnip::find($id);
        $deleteConfigSnip = UpdateConfig::updateSNIP($infoSnipModel->number_provider, $infoSnipModel->password_snip);
        if($deleteConfigSnip !== true){
            return view('user.snip.index', compact('deleteConfigSnip'));
        }
        $infoSnipModel->name_provider = $data['name_provider'];
        $infoSnipModel->number_provider =  $data['number_provider'];
        $infoSnipModel->login_snip = $data['login_snip'];
        $infoSnipModel->password_snip =  $data['password_snip'];
        $infoSnipModel->save();

        return redirect()->back()->withSuccess('SNIP успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $infoSnip = InfoSnip::find($id);
        $deleteConfigSnip = UpdateConfig::deleteSNIP($infoSnip->number_provider);
        if($deleteConfigSnip !== true){
            return view('admin.snip.index', compact('deleteConfigSnip'));
        }
        $infoSnip->delete();
        return redirect()->back()->withSuccess('SNIP успешно удалён!');
    }
}

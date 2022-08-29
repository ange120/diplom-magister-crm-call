<?php

namespace App\Http\Controllers;

use App\Models\InfoSnip;
use Illuminate\Http\Request;
use App\Service\UpdateConfig;

class SnipController extends Controller
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
                'ip_snip' => $item->ip_snip,
                'name_provider' => $item->name_provider,
                'number_provider' => $item->number_provider,
                'login_snip' => $item->login_snip,
                'password_snip' => $item->password_snip,
            ];
        }

        return view('user.snip.index', compact('result', 'snipList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.snip.create');
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
//         InfoSnip::create([
//            'ip_snip' => $data['ip_snip'] ,
//            'name_provider' => $data['name_provider'],
//            'number_provider' =>  $data['number_provider'],
//            'login_snip' =>  $data['login_snip'],
//            'password_snip' =>  $data['password_snip'],
//        ]);
         $updateConfig = UpdateConfig::createNewSNIP($data['number_provider'], $data['password_snip']);
        if($updateConfig !== true){
            return view('user.snip.create', compact('updateConfig'));
        }
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
        return view('user.snip.edit', compact('infoSnip'));
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
        $infoSnipModel->ip_snip = $data['ip_snip'];
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
        $infoSnip->delete();
        return redirect()->back()->withSuccess('SNIP успешно удалён!');
    }
}

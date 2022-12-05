<?php

namespace App\Http\Controllers;

use App\Models\InfoSnip;
use App\Models\Trunk;
use App\Models\User;
use Illuminate\Http\Request;
use App\Service\UpdateConfig;

class SnipController extends Controller
{

    protected $localizationController;

    public function __construct()
    {
        $this->localizationController = new LocalizationController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
        $snipList = InfoSnip::paginate(15);

        $pageListKeyLanguage = $this->localizationController->localisationPage('sip_page');

        foreach ($snipList as $item) {

            $result[] = [
                'id' => $item->id,
                'name_provider' => $item->name_provider,
                'number_provider' => $item->number_provider,
                'login_snip' => $item->login_snip,
                'password_snip' => $item->password_snip,
                'trunk' => $item->trunk->login,
            ];
        }

        return view('user.snip.index', compact('result', 'snipList', 'pageListKeyLanguage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userList = User::all();
        $trunkList = Trunk::all();

        $pageListKeyLanguage = $this->localizationController->localisationPage('crate_snip');

        return view('user.snip.create',  compact('userList', 'trunkList', 'pageListKeyLanguage'));
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
        $trunkList = Trunk::all();
        $pageListKeyLanguage = $this->localizationController->localisationPage('crate_snip');
        $updateConfig = UpdateConfig::createNewSNIP($data['number_provider'], $data['password_snip']);
        if($updateConfig !== true){
            return view('user.snip.create', compact('updateConfig', 'userList', 'trunkList'));
        }


        $findTrunk = InfoSnip::where('id_trunk', $data['id_trunk'])->first();
        if(!is_null($findTrunk)){
            return redirect()->back()->with('error', $pageListKeyLanguage['error_info_save']);
        }

        InfoSnip::create([
            'ip_snip' => 'null' ,
            'name_provider' => $data['name_provider'],
            'number_provider' =>  $data['number_provider'],
            'login_snip' =>  $data['login_snip'],
            'password_snip' =>  $data['password_snip'],
            'id_trunk' =>  $data['id_trunk'],
        ]);
        return redirect()->back()->withSuccess( $pageListKeyLanguage['save_add']);
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
        $userList = User::all();
        $trunkList = Trunk::all();
        $infoSnip = InfoSnip::find($id);
        $pageListKeyLanguage = $this->localizationController->localisationPage('edit_sip');

        return view('user.snip.edit', compact('infoSnip', 'userList', 'trunkList', 'pageListKeyLanguage'));
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
        $pageListKeyLanguage = $this->localizationController->localisationPage('edit_sip');
        $updateConfigSnip = UpdateConfig::updateSNIP($data['number_provider'], $data['password_snip']);
        if($updateConfigSnip !== true){
            return redirect()->back()->with('error', $updateConfigSnip);
        }
        $infoSnipModel->name_provider = $data['name_provider'];
        $infoSnipModel->number_provider =  $data['number_provider'];
        $infoSnipModel->login_snip = $data['login_snip'];
        $infoSnipModel->password_snip =  $data['password_snip'];
        $infoSnipModel->save();

        return redirect()->back()->withSuccess($pageListKeyLanguage['info_update_done']);
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
        $pageListKeyLanguage = $this->localizationController->localisationPage('sip_page');
        $deleteConfigSnip = UpdateConfig::deleteSNIP($infoSnip->number_provider);
        if($deleteConfigSnip !== true){
            return redirect()->back()->with('error', $deleteConfigSnip);
        }
        $infoSnip->delete();
        return redirect()->back()->withSuccess($pageListKeyLanguage['info_delete']);
    }
}

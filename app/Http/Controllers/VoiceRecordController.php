<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\VoiceRecord;
use App\Service\SendSound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoiceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
        $voiceRecordList = VoiceRecord::paginate(15);
        foreach ($voiceRecordList as $item) {

            $result[] = [
                'id' => $item->id,
                'name' => $item->name,
                'text' => $item->text,
                'language' => Language::find($item->id_language)->name,
            ];
        }
        return view('user.voice.index', compact('result', 'voiceRecordList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::all();
        return view('user.voice.create', compact('languages'));
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
        $languages = Language::all();
        $voiceRecord = VoiceRecord::where('name',$data['name'])->first();

        if(!is_null($voiceRecord)){
            $message = 'Запись с таким именем уже существует!';
            return view('user.voice.create', compact('message','languages'));
        }
        VoiceRecord::create([
            'name' => $data['name'] ,
            'text' => $data['text'],
            'id_language' => (int)$data['language'],
        ]);
        return redirect()->back()->withSuccess('Запись успешно добавлена!');
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
        $voiceRecord = VoiceRecord::find($id);
        $languages = Language::all();
        return view('user.voice.edit', compact('voiceRecord', 'languages'));
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
        $voiceRecord = VoiceRecord::find($id);
        $voiceRecord->name = $data['name'];
        $voiceRecord->text = $data['text'];
        $voiceRecord->id_language =  $data['language'];
        $voiceRecord->save();

        return redirect()->back()->withSuccess('Запись голоса успешно обновлёна!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $voiceRecord = VoiceRecord::find($id);
        $send = SendSound::deleteVoice($voiceRecord->text, $user->phone_manager);
        if ($send !== true) {
            $message = $send;
            return redirect()->back()->with('error', $message);
        }
        $voiceRecord->delete();
        return redirect()->back()->withSuccess('Запись голоса успешно удалёна!');
    }

    public function voiceCreateSound(Request $request)
    {
        $languages = Language::all();
        $data = $request->all();
        $file = $request->file('file');
        $user = Auth::user();
        $voiceRecord = VoiceRecord::where('name',$data['name'])->first();

        if(!is_null($voiceRecord)){
            $message = 'Запись с таким именем уже существует!';
            return view('user.voice.create', compact('message','languages'));
        }
        try {
            $saveFile = $this->saveFile($file);

            $send = SendSound::sendVoice($saveFile,  $data['name'], $user->phone_manager);
            if ($send !== true) {
                $message = $send;
                return view('user.voice.create', compact('message', 'languages'));
            }
            VoiceRecord::create([
                'name' => $data['name'],
                'text' => preg_replace('/\.\w+$/', '', $file->getClientOriginalName()),
                'id_language' => (int)$data['language'],
                'type' => 'files',
            ]);
        } catch (\Throwable $e) {
            $message = $e->getMessage();
            return view('user.voice.create', compact('message', 'languages'));
        }
        return redirect()->back()->withSuccess('Запись голоса успешно обновлёна!');
    }

    protected function saveFile($file)
    {
        try {
            $file->move(public_path() . '/files/sound', $file->getClientOriginalName());
        }catch (\Throwable $e) {
            $e->getMessage();
        }
        return  public_path() . '/files/sound/'.$file->getClientOriginalName();
    }
}

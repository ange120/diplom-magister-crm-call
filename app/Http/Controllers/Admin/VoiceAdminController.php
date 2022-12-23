<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportVoice;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\VoiceRecord;
use App\Service\SendSound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class VoiceAdminController extends Controller
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
                'type' =>  asset('storage/'.$item->type),
                'language' => Language::find($item->id_language)->name,
            ];
        }
        return view('admin.voice.index', compact('result', 'voiceRecordList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.voice.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $voiceRecord = VoiceRecord::where('name', $data['name'])->first();

        if (!is_null($voiceRecord)) {
            return redirect()->back()->with('error', "Запис з таким ім'я вже існує");
        }
        VoiceRecord::create([
            'name' => $data['name'],
            'text' => $data['text'],
            'id_language' => (int)$data['language'],
            'type' => 'type_text_voice',
        ]);
        return redirect()->back()->withSuccess('Запис успішно додано!');
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
    public function edit($id)
    {
        $voiceRecord = VoiceRecord::find($id);
        $languages = Language::all();
        return view('admin.voice.edit', compact('voiceRecord', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $data = $request->all();
//        $voiceRecord = VoiceRecord::find($id);
//        $voiceRecord->name = $data['name'];
//        $voiceRecord->text = $data['text'];
//        $voiceRecord->id_language = $data['language'];
//        $voiceRecord->save();
//
//        return redirect()->back()->withSuccess('Запись голоса успешно обновлёна!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $voiceRecord = VoiceRecord::find($id);
        if($voiceRecord->type !== 'type_text_voice'){
            $deleteLocal = $this->deleteFile($voiceRecord->type);
            if($deleteLocal !== true){
                return redirect()->back()->with('error', $deleteLocal);
            }
//            $send = SendSound::deleteVoice($voiceRecord->text, $user->phone_manager);
//            if ($send !== true) {
//                $message = $send;
//                return redirect()->back()->with('error', $message);
//            }
        }
        $voiceRecord->delete();
        return redirect()->back()->withSuccess('Запис голосу успішно видалено!');
    }

    public function voiceInfo()
    {
        return Excel::download(new ExportVoice(), 'voice.xlsx');
    }

    public function getURlVoice(Request $request )
    {

    }


    public function voiceCreateSound(Request $request)
    {
        $languages = Language::all();
        $data = $request->all();
        $file = $request->file('file');
        $user = Auth::user();
        $voiceRecord = VoiceRecord::where('name', $data['name'])->first();

        if (!is_null($voiceRecord)) {
            return redirect()->back()->with('error', "Запис з таким ім'я вже існує");
        }
        try {
            $saveFile = $this->saveFile($file);
           // $send = SendSound::sendVoice($saveFile,  $data['name'], $user->phone_manager);
//            if ($send !== true) {
//                $message = $send;
//                return view('admin.voice.create', compact('message', 'languages'));
//            }
            VoiceRecord::create([
                'name' => $data['name'],
                'text' => preg_replace('/\.\w+$/', '', $file->getClientOriginalName()),
                'id_language' => (int)$data['language'],
                'type' => $file->getClientOriginalName(),
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->withSuccess('Запис голосу успішно створено!');
    }

    protected function saveFile($file)
    {
        try {
            $file->move(public_path().'/storage/' , $file->getClientOriginalName());
        } catch (\Throwable $e) {
            $e->getMessage();
        }
        return public_path(). $file->getClientOriginalName();
    }

    protected function deleteFile($name)
    {
        try {
            unlink(public_path('storage/' . $name));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
        return true;
    }


}

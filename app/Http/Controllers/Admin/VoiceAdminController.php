<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\VoiceRecord;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =$request->all();

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
        return view('admin.voice.edit', compact('voiceRecord', 'languages'));
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
        $voiceRecord = VoiceRecord::find($id);
        $voiceRecord->delete();
        return redirect()->back()->withSuccess('Запись голоса успешно удалёна!');
    }
}

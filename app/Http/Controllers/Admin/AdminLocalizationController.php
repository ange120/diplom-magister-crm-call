<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BindPages;
use App\Models\KeysPage;
use App\Models\Language;
use App\Models\LocalizationPages;
use App\Models\UserLocalization;
use Illuminate\Http\Request;

class AdminLocalizationController extends Controller
{
    public function index()
    {
        $BindPages = BindPages::all();
        $result = [];
        return view('admin.localization.index', compact('BindPages', 'result'));
    }

    public function getSettings()
    {

        $user = auth()->user();

        $idSelected = UserLocalization::where('email', $user->email)->first();
        $id_languages = 1;
        $language = Language::all();
        if (!is_null($idSelected)) {
            $id_languages = $idSelected->id_languages;
        }

        return view('admin.settings.index', compact('language', 'id_languages'));
    }

    public function getTableList(Request $request)
    {
        $result = [];
        $data = $request->all();
        $BindPages = BindPages::all();
        if(!array_key_exists('page',$data )){
            return view('admin.localization.index', compact('BindPages', 'result'));
        }
        $pageObj = BindPages::where('id', $data['page'])->first();
        $pageKeys = [];
        $page = 0;

        if (!is_null($pageObj)) {
            $page = $pageObj->id;
        }

        $pageKeysObj = KeysPage::where('id_page', $page)->get();
        if ($pageKeysObj->count() !== 0) {
            $pageKeys = $pageKeysObj;
        }

        $languages = Language::all();
        $result = [];

        foreach ($languages as $lang) {
            foreach ($pageKeys as $key) {

                $PagesLocalization = LocalizationPages::where([
                    ['id_key_page', $key->id],
                    ['id_page', $page],
                    ['id_languages', $lang->id]
                ])->get();

                if ($PagesLocalization->count() != 0) {
                    foreach ($PagesLocalization as $pageLocal) {
                        $result[$lang->name][] = [
                            "id" => $pageLocal->id,
                            "id_page" => $key->id_page,
                            "keys_pages" => $key->name_key,
                            "id_keys_pages" => $key->id,
                            "text" => $pageLocal->text,
                        ];
                    }
                } else {
                    $randId = rand(1, 500) + rand(1, microtime(true));
                    $result[$lang->name][] = [
                        "id" => "new_" . $randId,
                        "id_page" => $key->id_page,
                        "keys_pages" => $key->name_key,
                        "id_keys_pages" => $key->id,
                        "text" => '',
                    ];
                }
            }
        }
        return view('admin.localization.index', compact( 'BindPages', 'result'));
    }
    public function updateLocalization(Request $request)
    {
        $data = $request->all();
        $localizationPage = LocalizationPages::find($data['id']);
        $localizationPage->text = $data['text'];
        $localizationPage->save();

        return redirect()->back()->withSuccess('Запис оновлено успішно');
    }

}

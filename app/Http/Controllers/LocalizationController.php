<?php

namespace App\Http\Controllers;

use App\Models\BindPages;
use App\Models\KeysPage;
use App\Models\LocalizationPages;
use App\Models\UserLocalization;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    /**
     * @return array|false
     */
    public function localisationDashBoard()
    {
        $result = false;

        try {
            $allArray = [];
            $user = auth()->user();

            $localizationUser = UserLocalization::where('email', $user->email)->first();

            $id_languages = 1;
            if (!is_null($localizationUser)) {
                $id_languages = $localizationUser->id_languages;
            }

            $page = BindPages::where('name_page', 'menu')->first()->id;

            $PagesLocalization = LocalizationPages::where([
                ['id_languages', $id_languages],
                ['id_page', $page]
            ])->get();

            foreach ($PagesLocalization as $item) {
                $allArray[KeysPage::find($item->id_key_page)->name_key] = $item->text;
            }
            $result = $allArray;
        }catch (\Throwable $throwable) {
            $message = $throwable->getMessage();
            $line = $throwable->getLine();

        }

        return $result;
    }

    public function localisationPage(string $getPage)
    {

        $result = false;

        try {
            $allArray = [];
            $user = auth()->user();
            $localizationUser = UserLocalization::where('email', $user->email)->first();
            $id_languages = 1;
            if (!is_null($localizationUser)) {
                $id_languages = $localizationUser->id_languages;
            }
            $page = BindPages::where('name_page', $getPage)->first()->id;

            $PagesLocalization = LocalizationPages::where([
                ['id_languages', $id_languages],
                ['id_page', $page]
            ])->get();
            foreach ($PagesLocalization as $item) {
                $allArray[KeysPage::find($item->id_key_page)->name_key] = $item->text;
            }
            $result = $allArray;
        } catch (\Throwable $throwable) {
            $message = $throwable->getMessage();
            $line = $throwable->getLine();
        }
        return $result;
    }

}

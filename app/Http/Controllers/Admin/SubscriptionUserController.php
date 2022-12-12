<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionUserController extends Controller
{

    protected $dateCarbon;

    protected const CONVERT_ARRAY = array(
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
        'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
        'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
        'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
        'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch',
        'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
        'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
    );
    public function __construct()
    {
        $this->dateCarbon = Carbon::today();
    }

    public static function transliteratorText($text)
    {
        $convertString = strtr($text, self::CONVERT_ARRAY);
        return str_replace(' ', '_', mb_strtolower($convertString));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscription = Subscription::all();

        return view('admin.subscription.index', compact('subscription'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newSubscription = new Subscription();
        $newSubscription->info_name= $request->name;
        $newSubscription->name = self::transliteratorText($request->name);
        $newSubscription->save();
        return redirect()->back()->withSuccess('Подписка успешно добавлена!');
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
        $subscription = Subscription::find($id);
        return view('admin.subscription.edit', compact('subscription'));
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
        $newSubscription = Subscription::find($id);
        $newSubscription->info_name= $request->name;
        $newSubscription->name = self::transliteratorText($request->name);
        $newSubscription->save();
        return redirect()->back()->withSuccess('Підписку оновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        $subscription->delete();
        return redirect()->back()->withSuccess('Подписка успешно удалёна!');
    }

    public function getSubscriptionsUsers()
    {
        $result = [];
        $subscriptionUser = SubscriptionUser::paginate(15);

        $users = User::all();

        foreach ($users as $user) {

            if (!is_null($user->getSubscriptions())) {
                $result [] = [
                    'id' => $user->id,
                    'user' => $user->name,
                    'subscription' => $user->getSubscriptionsInfoName(),
                    'date_start' => $user->getSubscriptions()->date_start_subscriptions,
                    'date_end' => $user->getSubscriptions()->date_end_subscriptions,
                ];
            }else{
                $result [] = [
                    'id' => $user->id,
                    'user' => $user->name,
                    'subscription' => 'Інформація відсутня',
                    'date_start' => 'Інформація відсутня',
                    'date_end' => 'Інформація відсутня',
                ];
            }
        }
        return view('admin.subscription.subscriptions_users', compact('result',
            'subscriptionUser'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editSubscriptionsUsers($id)
    {
        $userAus = User::find($id);
        $subscription = SubscriptionUser::where('id_user', $id)->first();
        $userName = $userAus->name;
        if(is_null($subscription)){
            $subscriptionUser = SubscriptionUser::create(
            ['id_user'=>$id, 'id_subscription'=>2,
                'date_start_subscriptions'=> $this->dateCarbon->format('Y-m-d'),
                'date_end_subscriptions'=>$this->dateCarbon->format('Y-m-d')]
        );
        }else{
            $subscriptionUser = $subscription;
        }

        $subscriptionList = Subscription::all();

        return view('admin.subscription.edit_subscriptions_users', compact('userName',
            'subscriptionUser', 'subscriptionList'));
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function updateSubscriptionsUsers(Request $request, $id)
    {
        $data = $request->all();
        $subscriptionUser = SubscriptionUser::find($id);
        $subscriptionUser->id_subscription = $data['id_subscription'];
        $subscriptionUser->date_start_subscriptions = $data['date_start_subscriptions'];
        $subscriptionUser->date_end_subscriptions = $data['date_end_subscriptions'];
        $subscriptionUser->save();
        return redirect()->back()->withSuccess('Підписка на користувача успішно онлалена!');
    }
}

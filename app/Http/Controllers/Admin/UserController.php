<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportUsers;
use App\Http\Controllers\Controller;
use App\Models\ModelHasRoles;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];

        $users = User::all();

        foreach ($users as $user){
            $result[]  = [
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'subscriptions'=>  $user->getSubscriptionsInfoName(),
                'role'=>  $user->getRoleNames(),
                'phone_manager'=>  $user->phone_manager,
                'created_at'=>$user->created_at,
                'updated_at'=>$user->updated_at,
            ];
        }
        return view('admin.users.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->getRoles();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = $this->getRoles();
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|unique:users',
            'phone_manager' => 'required|unique:users',
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error',$validator->errors()->first());
        }
        $data =$request->all();
        $allUser = User::where('name', $data['name'])->first();

        if($data['password'] !== $data['confirm_password']){
            $errorInfo = 'Пароли не совпадают';
            return redirect()->back()->with('error',$errorInfo);
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_manager'=>  $data['phone_manager'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole( $data['role']);
        return redirect()->back()->withSuccess('Пользователь успешно добавлен!');
    }
    public function userInfo()
    {
        return Excel::download(new ExportUsers(), 'user.xlsx');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $allRoles = $this->getRoles();
        $arrayUser = $user->toArray();
        $roleUserId = ModelHasRoles::where('model_id',$arrayUser['id'] )->first()->role_id;
        $arrayUser['role'] = $this->getRoleUserById($roleUserId);

        return view('admin.users.edit', compact('arrayUser', 'allRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();

        $phoneManagerValidate  = User::where('phone_manager', $data['phone_manager'])->first();
        $nameValidate  = User::where('name', $data['name'])->first();
        if(!is_null($nameValidate)){
            if($user->id !== $nameValidate->id){
                return redirect()->back()->with('error',"Такое Имя пользователя уже забронировано!");
            }
        }
        if(!is_null($phoneManagerValidate)){
            if($user->id !== $phoneManagerValidate->id){
                return redirect()->back()->with('error',"Такой номер менеджера уже забронирован!");
            }
        }
        $roleId = ModelHasRoles::where('model_id',$data['id'] )->first()->role_id;
        $roleUser = $this->getRoleUserById($roleId);
        if(!is_null($data['password']) && !is_null($data['confirm_password'])){
            if($data['password'] === $data['confirm_password']){
                $user->password = Hash::make($data['password']);
            }else{
                return redirect()->back()->with('error', "Пароли не совпадают!");
            }
        }
        if($roleUser !== $data['role']){
            $user->syncRoles( $data['role']);
        }
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_manager = $data['phone_manager'];
        $user->save();
        return redirect()->back()->withSuccess('Пользователь успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->withSuccess('Пользователь успешно удалён!');
    }

    /**
     * @return array
     */
    protected function getRoles():array
    {
        $roles = [];

        foreach (Roles::all() as $item)
        {
            $roles[] =  $item->name;
        }
        return $roles;
    }

    protected function getRoleUserById(int $role_id)
    {
        $result = null;

        $role = Roles::find($role_id);
        if(!is_null($role)){
            $result = $role->name;
        }
        return $result;
    }
}

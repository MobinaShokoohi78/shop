<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Nette\Utils\DateTime;
use Symfony\Component\Console\Helper\Table;
use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Users/all');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'is_admin' => ['integer']
        ]);

        $data['password'] =  Hash::make($request->password);

        $user = User::create($data);

        $user->markEmailAsVerified();

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User  $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if(! is_null($request->password)) {
            $request->validate([
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $data['password'] = Hash::make($request->password) ;
        }
        $data['is_admin'] = $request->is_admin;
        $user->update($data);
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user){

        $user->delete();

        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $fields = [['name','نام'],['email','ایمیل'],['is_admin','کاربر ادمین'],['created_at','تاریخ ساخت']];

        $data = $this->dataTable('users', $fields, $request);

        $fields = [['id'=>'name','text'=>'نام'],['id'=>'email','text'=>'ایمیل'],['id'=>'is_admin','text'=>'کاربر ادمین'],['id'=>'created_at','text'=>'تاریخ ساخت']];
        $search = ['name','email','is_admin','created_at'];
        $filters = [[
            'name'=>'is_admin',
            'type'=>'select',
            'value'=>[
                ['id'=>'1','text'=>'کاربر ادمین'],
                ['id'=>'0','text'=>'کاربر معمولی'],
            ]
        ]];

        return [
            'data' => $data,
            'fields' => $fields,
            'filters' => $filters,
            'search' => $search,
            'permission' =>['update'=>'admin.users.update','delete'=>'admin.users.destroy'],
            ];
    }

}

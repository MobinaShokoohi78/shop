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
        return Inertia::render('Admin/Users/create');
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

        return redirect()->route('admin.users.edit',$user->id);

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
    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/edit',[
            'user' => $user
        ]);
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

            $data['password'] = $request->password;
        }

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
            'filters' => (object)$filters,
            'permission' =>(object)['update'=>true,'delete'=>true],
            ];
//        'permission' =>(object)['update'=>'admin.users.update','delete'=>'admin.users.destroy'],

    }

//    public function dataTable($model,$fields,$request,$key= ['id'])
//    {
//        $data = DB::table($model);
//
//        if (!is_null($fields)){
//            array_unshift($fields,$key);
//            $cols = collect($fields);
//            $cols = $cols->map(function ($item){
//                return $item[0];
//            });
//
//            $data = $data->select($cols->all());
//        }
//
//
//        if (!empty($request->filters)){
//            $filters = $request->filters;
//            foreach($filters as $filter => $key){
//
//                if ($key != ''){
//                    if (DateTime::createFromFormat('Y-m-d', $key) !== false || DateTime::createFromFormat('Y-m-d H:i:s', $key) !== false){
//                        $data = $data->where($filter, 'like',"%$key%");
//
//                    }
//                    else{
//                        $data = $data->where($filter, $key);
//
//                    }
//                }
//            }
//        }
//
//        if (isset($request->search) && isset($request->fieldsSearch)){
//
//            $search = $request->search;
//            $searchValue = $request->fieldsSearch;
//            $where= [];
//            foreach ($searchValue as $key =>$value){
//                if ($key == 0)
//                    continue;
//                array_push($where, [$value , 'like', "%$search%"]);
//            }
//            $data = $data->where($searchValue[0],'like', "%$search%")->orWhere($where);
//
//        }
//
//
//        if (!empty($request->sort))
//            $data = $data->orderBy($request->sort['name'], $request->sort['type']);
//        else
//            $data = $data->latest();
//
//
//        if (! is_null($request->page))
//            $data =$data->paginate($request->paginate,['*'],'page',$request->page);
//        else
//            $data =$data->paginate($request->paginate);
//
//        return $data;
//    }

}

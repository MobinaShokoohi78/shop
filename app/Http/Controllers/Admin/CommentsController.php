<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Comments/all');
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getData(Request $request)
    {

        $fields = [['text','نام'],['email','ایمیل'],['is_admin','کاربر ادمین'],['created_at','تاریخ ساخت']];

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
}

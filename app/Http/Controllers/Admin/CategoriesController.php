<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\UniqueCategoriesAdd;
use App\Rules\UniqueCategoriesEdit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id','name','parent')->where('parent', 0)->with('child')->get()->toArray();
        $categories = collect($categories)->chunk(10);

        return Inertia::render('Admin/Categories/all',[
            'categories'  => $categories[0],
            'pages'       => count($categories),
            'currentPage' => isset($request['current-page']) ? $request['current-page'] : 1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $parent = isset($request['id']) ?? 0;


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
            'name' => ['required', 'string', 'max:255',new UniqueCategoriesAdd()],
            'parent' => ['required'],
        ]);


        Category::create($data);


//        alert()->success('کاربر', 'کاربر با موفقیت دخیره شد!');

        return redirect()->back();
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
    public function update(Request $request, Category $category)
    {
        $data =  $request->validate([
            'name' => ['required', 'string', 'max:255',new UniqueCategoriesEdit()],
            'parent' => ['required'],
        ]);

        $category->update($data);
        return redirect()->back();
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
        $currentPage = $request['currentPage'];

        $categories = Category::select('id','name','parent')->where('parent', 0)->with('child')->get()->toArray();
        $categories = collect($categories)->chunk(10);
        return $categories[--$currentPage];

    }
}

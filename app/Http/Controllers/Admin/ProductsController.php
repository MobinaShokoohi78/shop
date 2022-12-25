<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeProduct;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Color;
use App\Models\product;
use App\Models\ProductDetail;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Products/all');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::categoriesList();

        return Inertia::render('Admin/Products/create',[
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255','unique:products'],
            'category_id' => ['required'],
        ]);

        $product = Product::create([
                'title' => $request['title'],
                'category_id' => $request['category_id'],
                'description' => $request['description']]
        );

        return redirect()->route('admin.products.edit',$product->id);
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
    public function edit(Product $product)
    {
        $categories = Category::categoriesList();
        $colors = Color::select('id', 'name as text')->get()->toArray();
        $sizes = Size::select('id', 'name as text')->get()->toArray();
        if (! $detail = ProductDetail::select('id', 'size_id as size', 'color_id as color', 'count' , 'price')->where('product_id', $product->id)->get()->toArray()){
            $detail = [[
                'id'=> '',
                'size'=> 0,
                'color'=> 0,
                'price'=> '',
                'count'=> ''
            ]];
        }
        $attributes = Attribute::select('id', 'name as text')->get()->toArray();
        if($attributeProducts = AttributeProduct::select('attribute_id', 'value_id')->where('product_id',$product->id)->get()->toArray()){
            foreach ($attributeProducts as $key => $value){
                $attributeProducts[$key]['values'] = AttributeValue::select('id', 'value as text')->where('attribute_id', $value['attribute_id'])->get()->toArray();
            }
        }
        else{
            $attributeProducts = [[
                'attribute_id'=> 0,
                'value_id'=> 0,
            ]];
        }
        return Inertia::render('Admin/Products/edit',[
            'product' => $product,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'details' => $detail,
            'attributes' => $attributes,
            'attributeProducts' => $attributeProducts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'category_id' => ['required'],
        ]);

        $product->update([
            'title' => $request['title'],
            'category_id' => $request['category_id'],
            'description' => $request['description']]
        );
        return back();
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

        $fields = [['title','عنوان'],['category_id','شناسه دسته بندی'],['category_name','دسته بندی']];
        $data = $this->dataTable('v_product', $fields, $request);
        $fields = [
            ['id'=>'title','text'=>'عنوان'],
            ['id'=>'category_id','text'=>'شناسه دسته بندی'],
            ['id'=>'category_name','text'=>'دسته بندی']
        ];
        $search = ['title','category_name'];

        $categories = Category::categoriesList();

        $filters = [[
            'name'=>'category_id',
            'type'=>'select',
            'value'=> $categories
        ]];

        return [
            'data' => $data,
            'fields' => $fields,
            'filters' => $filters,
            'search' => $search,
            'permission' =>['update'=>'admin.products.edit','delete'=>'admin.products.destroy'],
        ];
    }

    public function updateDetails($id, Request $request)
    {

        $data = $request->all();
        foreach ($data as $key => $value){
            ProductDetail::updateOrCreate([
                'id' =>$value['id']
            ],[
                'product_id' => $id,
                'color_id' => $value['size'],
                'size_id' => $value['color'],
                'price' => $value['price'],
                'count' => $value['count'],
            ]);
        }
        return back();
    }

    public function getValues($id)
    {
        return AttributeValue::select('id', 'value as text')->where('attribute_id',$id)->get()->toArray();
    }

    public function updateAttr($id, Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $value){
            AttributeProduct::updateOrCreate([
                'product_id' =>$id,
                'attribute_id' =>$value['attribute_id'],
                'value_id' =>$value['value_id'],
            ],[
                'product_id' =>$id,
                'attribute_id' =>$value['attribute_id'],
                'value_id' =>$value['value_id'],
            ]);
        }
        return back();
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use function PHPUnit\Framework\isNull;
use Illuminate\Validation\ValidationException;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Attributes/all');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Attributes/create');
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
            'name' => ['required', 'string', 'max:255','unique:attributes'],
        ]);

        $attribute = Attribute::create(['name'=>$request->name]);


        foreach ($request->values as $key => $value){
            if (! is_null($value))
                AttributeValue::create(['attribute_id'=>$attribute->id , 'value' => $value]);
        }

        return redirect()->route('admin.attributes.edit',$attribute->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute  $attribute)
    {
        $values = AttributeValue::select('id','value')->where('attribute_id',$attribute->id)->get()->keyBy('id')->toArray();
        return  [
            'values' => $values,
            'attribute' =>$attribute
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        $values = AttributeValue::select('id','value')->where('attribute_id',$attribute->id)->get()->keyBy('id')->toArray();

        return Inertia::render('Admin/Attributes/edit',[
            'attribute' => $attribute,
            'values'    => $values
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('attributes')->ignore($attribute->id)],
        ]);

        $attribute->update([$request['name']]);

        try {
            $attrributeValues = AttributeValue::select('id')->where('attribute_id' , $attribute->id)->get()->toArray();

            $deletedValues = array_diff(array_column($attrributeValues,'id'),array_keys($request['values']));

            foreach ($deletedValues as $key => $value){
                AttributeValue::where('id',$value)->delete();
            }

            foreach ($request['values'] as $key => $value){
                if (!is_null($value['value'])){
                    dd($value , $key);
                }
            }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        /*
         if ($atr = AttributeValue::where('id',$key)->first() ){
            if ( $exist = AttributeValue::where('attribute_id' , $attribute->id)->where('value' , $value['value'])->where('id', '<>', $key)->get()->toArray()){
                throw ValidationException::withMessages(['values' => 'داده تکراری']);
            }
            else
                $atr->update(['value' => $value['value']]);
            }
            else{
                if ($atr = AttributeValue::where('attribute_id' , $attribute->id)->where('value' , $value['value'])->first())
                    throw ValidationException::withMessages(['values' => 'داده تکراری']);
                else
                    AttributeValue::create(['attribute_id' => $attribute->id, 'value' => $value['value']]);
            }
        */
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->back();
    }

    public function getData(Request $request)
    {

        $fields = [['name','نام']];

        $data = $this->dataTable('attributes', $fields, $request);
        $fields = [['id'=>'name','text'=>'نام']];
        $search = [['id'=>'name','text'=>'نام']];
//        $filters = [[
//            'name'=>'is_admin',
//            'type'=>'select',
//            'value'=>[
//                ['id'=>'1','text'=>'کاربر ادمین'],
//                ['id'=>'0','text'=>'کاربر معمولی'],
//            ]
//        ]];

        return [
            'data' => $data,
            'fields' => $fields,
//            'filters' => (object)$filters,
            'permission' =>(object)['update'=>true,'delete'=>true],
        ];
//        'permission' =>(object)['update'=>'admin.users.update','delete'=>'admin.users.destroy'],

    }
}

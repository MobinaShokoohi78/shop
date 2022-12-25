<?php
namespace App\Http\Traits;


use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;

trait DataTableTrait{

    public function dataTable($model,$fields,$request,$key= ['id'])
    {
        $data = DB::table($model);

        if (!is_null($fields)){
            array_unshift($fields,$key);
            $cols = collect($fields);
            $cols = $cols->map(function ($item){
                return $item[0];
            });

            $data = $data->select($cols->all());
        }

        if (!empty($request->filters)){
            $filters = $request->filters;
            foreach($filters as $filter => $key){
                if ($key != ''){
                    if (DateTime::createFromFormat('Y-m-d', (string)$key) !== false || DateTime::createFromFormat('Y-m-d H:i:s', (string)$key) !== false){
                        $data = $data->where($filter, 'like',"%$key%");
                    }
                    else{
                        $data = $data->where($filter, $key);
                    }
                }
            }
        }

        if (isset($request->search) && isset($request->fieldsSearch)){

            $search = $request->search;
            $searchValue = $request->fieldsSearch;
            $where= [];
            foreach ($searchValue as $key =>$value){
                if ($key == 0)
                    continue;
                array_push($where, [$value , 'like', "%$search%"]);
            }
            $data = $data->where($searchValue[0],'like', "%$search%")->orWhere($where);

        }


        if (!empty($request->sort))
            $data = $data->orderBy($request->sort['name'], $request->sort['type']);
        else
            $data = $data->latest();


        if (! is_null($request->page))
            $data = $data->paginate($request->paginate,['*'],'page',$request->page);
        else
            $data = $data->paginate($request->paginate);

        return $data;
    }

}

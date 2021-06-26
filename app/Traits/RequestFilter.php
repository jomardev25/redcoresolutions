<?php

namespace App\Traits;

trait RequestFilter
{
    private $request;

    public function scopeFilter($query)
	{
        $request = request();
        if(isset($request->sort)){
            $sorts = explode(',', request()->sort);
            foreach ($sorts as $sort) {
                list($sortCol, $sortDir) = explode('|', $sort);
                $query = $query->orderBy($sortCol, $sortDir);
            }
        }else{
            $query = $query->orderBy($this->getTable().'.'.$this->getKeyName(), 'asc');
        }

        if($request->exists('filter')) {
            $query->where(function($q) use($request){
                $value = "%{$request->filter}%";
                foreach($this->filterFields as $field){
                    $q->orWhere($field, 'like', $value);
                }
            });
        }

        $perPage = $request->has('per_page') ? (int) $request->per_page : 10;
        $data = $query->paginate($perPage);
        $data->appends([
            'sort' => $request->sort,
            'filter' => $request->filter,
            'per_page' => $request->per_page
        ]);

        return $data;
    }
}

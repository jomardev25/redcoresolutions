<?php


namespace App\Traits;

trait HasCreatedBy
{
	public static function boot()
    {
       static::creating(function($model)
       {
           $model->user_id = auth()->user()->id;
       });
   }
}

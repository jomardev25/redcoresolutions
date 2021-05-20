<?php

namespace App;

use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Song extends Model
{
    use SoftDeletes;

    protected $table = 'songs';
    protected $guarded = ['id'];
    protected $cast = [
        'created_at' => 'datetime'
    ];

    public function artist() : HasOne
    {
        return $this->hasOne("App\Artist", "id", "artist_id")
                    ->withDefault([
                        'artist_id' => 0,
                        'name' => 'No Artist'
                    ]);
    }
}

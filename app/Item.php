<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Item extends Model
{
    use Searchable;
    protected $fillable = [
        'name', 'price',  'stock', 'category', 'unit', 'nutrition', 'img', 'description'
    ];

    public function searchableAs()
    {
        return 'items_index';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }


}

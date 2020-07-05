<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 * @property string $name
 * @property double $price
 * @property integer $count
 */
class Product extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'count',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }
}

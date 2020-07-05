<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Property
 * @package App
 * @property string $name
 * @property string $value
 */
class Property extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}

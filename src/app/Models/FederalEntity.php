<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
    protected $table = 'federal_entities';

    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
        'code'
    ];

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return (new self())->getTable();
    }

    /**
     * @return Attribute
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (!empty($value)) ? $value : null,
        );
    }
}

<?php

namespace App\Models;

use App\Traits\StringManager;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
    use StringManager;

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
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->removeAccents($value),
        );
    }

    /**
     * @return Attribute
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value) ? $this->removeAccents($value) : null,
        );
    }
}

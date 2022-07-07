<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZipCodeSettlement extends Model
{
    protected $table = 'zip_code_settlements';

    protected $primaryKey = ['zip_code_key', 'settlement_key'];
    public $incrementing = false;
    protected $keyType = 'array';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'zip_code_key',
        'settlement_key',
    ];

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return (new self())->getTable();
    }
}

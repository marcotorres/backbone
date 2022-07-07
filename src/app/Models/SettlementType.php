<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementType extends Model
{
    protected $table = 'settlement_types';

    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = ['key'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name'
    ];

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return (new self())->getTable();
    }
}

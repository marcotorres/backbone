<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
    protected $table = 'settlements';

    protected $primaryKey = ['key', 'zip_code_key'];
    public $incrementing = false;
    protected $keyType = 'array';
    public $timestamps = false;

    protected $hidden = ['settlement_type_key', 'zip_code_key'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
        'zone_type',
        'settlement_type_key',
        'zip_code_key',
    ];

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return (new self())->getTable();
    }

    /**
     * settlementType
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return BelongsTo
     */
    public function settlementType(): BelongsTo
    {
        return $this->belongsTo(SettlementType::class, 'settlement_type_key');
    }
}

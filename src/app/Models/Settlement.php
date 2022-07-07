<?php

namespace App\Models;

use App\Traits\StringManager;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
    use StringManager;

    protected $table = 'settlements';

    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = ['settlement_type_key', 'pivot'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
        'zone_type',
        'settlement_type_key'
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
    protected function zoneType(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->removeAccents($value),
        );
    }
}

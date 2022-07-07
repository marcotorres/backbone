<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ZipCode extends Model
{
    protected $table = 'zip_codes';

    protected $primaryKey = 'zip_code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $hidden = ['federal_entity_key', 'municipality_key'];

    /**
     * @var array
     */
    protected $fillable = [
        'zip_code',
        'locality',
        'federal_entity_key',
        'municipality_key',
    ];

    /**
     * @var string[]
     */
    public static $showRules = [
        'zipcode' => 'required|exists:App\Models\ZipCode,zip_code',
    ];

    /**
     * @var string[]
     */
    public static $messageRules = [
        'required' => 'The :attribute is required.',
        'max' => 'The :attribute is very long.',
        'unique' => 'The :attribute has already been taken.',
        'exists' => 'Could not find :attribute'
    ];

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return (new self())->getTable();
    }

    /**
     * federalEntity
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return BelongsTo
     */
    public function federalEntity(): BelongsTo
    {
        return $this->belongsTo(FederalEntity::class, 'federal_entity_key');
    }

    /**
     * municipality
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return BelongsTo
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class, 'municipality_key');
    }

    /**
     * zipCodeSettlements
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return HasMany
     */
    public function zipCodeSettlements(): HasMany
    {
        return $this->hasMany(ZipCodeSettlement::class, 'zip_code_key');
    }

    /**
     * settlements
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return BelongsToMany
     */
    public function settlements(): BelongsToMany
    {
        return $this->belongsToMany(Settlement::class, ZipCodeSettlement::class, 'zip_code_key', 'settlement_key')->with('settlementType');
    }

    /**
     * @return Attribute
     */
    protected function locality(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => mb_strtoupper($value),
        );
    }
}

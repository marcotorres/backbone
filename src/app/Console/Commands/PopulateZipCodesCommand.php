<?php

namespace App\Console\Commands;

use App\Models\FederalEntity;
use App\Models\Municipality;
use App\Models\Settlement;
use App\Models\SettlementType;
use App\Models\ZipCode;
use App\Models\ZipCodeSettlement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;

class PopulateZipCodesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backbone:populate-zip-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importación de datos (excel a MySQL)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fileName = storage_path() . '/zipcodes/CPdescarga.xml';

        if (!file_exists($fileName)) {
            echo 'No existe el xml de importación'. PHP_EOL;
            return 0;
        }

        echo 'Importación iniciada el: ' . date('Y-m-d H:i:s') . PHP_EOL;
        try {
            $xml = @simplexml_load_file(storage_path() . '/zipcodes/CPdescarga.xml');

            if ($xml === false) {
                echo 'No se pudo obtener los datos del xml'. PHP_EOL;
                return 0;
            }

            if ($xml instanceof \SimpleXMLElement) {
                foreach ($xml->table as $table) {
                    // settlement_types
                    $settlementTypeKey = (int) $table->c_tipo_asenta;
                    $settlementTypeName = (string) $table->d_tipo_asenta;

                    if (!SettlementType::query()->where('key', $settlementTypeKey)->exists()) {
                        SettlementType::query()->create([
                            'key' => $settlementTypeKey,
                            'name' => $settlementTypeName,
                        ]);
                    }

                    // settlements
                    $settlementKey = (int) $table->id_asenta_cpcons;
                    $settlementName = (string) $table->d_asenta;
                    $settlementZoneType = (string) $table->d_zona;

                    if (!Settlement::query()->where('key', $settlementKey)->exists()) {
                        Settlement::query()->create([
                            'key' => $settlementKey,
                            'name' => $settlementName,
                            'zone_type' => $settlementZoneType,
                            'settlement_type_key' => $settlementTypeKey
                        ]);
                    }

                    // municipalities
                    $municipalityKey = (int) $table->c_mnpio;
                    $municipalityName = (string) $table->D_mnpio;

                    if (!Municipality::query()->where('key', $municipalityKey)->exists()) {
                        Municipality::query()->create([
                            'key' => $municipalityKey,
                            'name' => $municipalityName,
                        ]);
                    }

                    // federal_entities
                    $federalEntityKey = (int) $table->c_estado;
                    $federalEntityName = (string) $table->d_estado;
                    $federalEntityCode = (string) $table->c_CP;


                    if (!FederalEntity::query()->where('key', $federalEntityKey)->exists()) {
                        FederalEntity::query()->create([
                            'key' => $federalEntityKey,
                            'name' => $federalEntityName,
                            'code' => $federalEntityCode
                        ]);
                    }

                    // zip_codes
                    $zipCodeKey = (string) $table->d_codigo;
                    $zipCodeLocality = (string) $table->d_ciudad;

                    if (!ZipCode::query()->where('zip_code', $zipCodeKey)->exists()) {
                        ZipCode::query()->create([
                            'zip_code' => $zipCodeKey,
                            'locality' => $zipCodeLocality,
                            'federal_entity_key' => $federalEntityKey,
                            'municipality_key' => $municipalityKey
                        ]);
                    }

                    // zip_code_settlements
                    $zipCodeSettlementQuery = ZipCodeSettlement::query()->where([
                        ['zip_code_key', '=', $zipCodeKey],
                        ['settlement_key', '=', $settlementKey]
                    ]);

                    if (!$zipCodeSettlementQuery->exists()) {
                        ZipCodeSettlement::query()->create([
                            'zip_code_key' => $zipCodeKey,
                            'settlement_key' => $settlementKey
                        ]);
                    }

                    echo 'zipcode importado: ' . $zipCodeKey . PHP_EOL;
                }
            }

            echo 'Importación culminada el: ' . date('Y-m-d H:i:s') . PHP_EOL;
        } catch (Exception $ex) {
            Log::error(
                __FUNCTION__ . ': ' . $ex->getMessage() . ', Track: ' . $ex->getTraceAsString()
            );
        }
        return 0;
    }
}

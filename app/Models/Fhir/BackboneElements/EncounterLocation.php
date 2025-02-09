<?php

namespace App\Models\Fhir\BackboneElements;

use App\Fhir\Codesystems;
use App\Fhir\Valuesets;
use App\Models\Fhir\Datatypes\CodeableConcept;
use App\Models\Fhir\Datatypes\ComplexExtension;
use App\Models\Fhir\Datatypes\Period;
use App\Models\Fhir\Datatypes\Reference;
use App\Models\Fhir\Resources\Encounter;
use App\Models\FhirModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class EncounterLocation extends FhirModel
{
    use HasFactory;

    protected $table = 'encounter_location';

    public $timestamps = false;

    public function encounter(): BelongsTo
    {
        return $this->belongsTo(Encounter::class);
    }

    public function location(): MorphOne
    {
        return $this->morphOne(Reference::class, 'referenceable');
    }

    public function physicalType(): MorphOne
    {
        return $this->morphOne(CodeableConcept::class, 'codeable');
    }

    public function period(): MorphOne
    {
        return $this->morphOne(Period::class, 'periodable');
    }

    public function serviceClass(): MorphOne
    {
        return $this->morphOne(ComplexExtension::class, 'complex_extendable');
    }

    public const STATUS = [
        'binding' => [
            'valueset' => Codesystems::EncounterLocationStatus
        ]
    ];

    public const SERVICE_CLASS = [
        'binding' => [
            'valueset' => Valuesets::LocationServiceClass
        ]
    ];

    public const UPGRADE_CLASS = [
        'binding' => [
            'valueset' => Codesystems::LocationUpgradeClass
        ]
    ];
}

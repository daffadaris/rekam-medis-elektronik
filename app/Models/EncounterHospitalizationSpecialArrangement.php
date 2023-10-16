<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncounterHospitalizationSpecialArrangement extends Model
{
    protected $table = 'encounter_hospitalization_spc_arr';
    public $timestamps = false;

    public function encounterHospitalization(): BelongsTo
    {
        return $this->belongsTo(EncounterHospitalization::class, 'id', 'enc_hosp_id');
    }
}

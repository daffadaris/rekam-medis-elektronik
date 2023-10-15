<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncounterDiagnosis extends Model
{
    protected $table = 'encounter_diagnosis';
    public $timestamps = false;

    public function encounter(): BelongsTo
    {
        return $this->belongsTo('encounter', 'id', 'encounter_id');
    }
}

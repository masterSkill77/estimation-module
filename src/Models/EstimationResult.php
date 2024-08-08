<?php

namespace Koders\EstimationModule\Models;

use Illuminate\Database\Eloquent\Model;

class EstimationResult extends Model
{

    protected $fillable = [
        'id',
        'fidji_date_mutation',
        'fidji_no_disposition',
        'fidji_valeur_fonciere',
        'fidji_nature_mutation',
        'l_fidji_nature_mutation',
        'majic_insee',
        'sogefi_parcelle_terrain',
        'sogefi_autre_parcelle_terrain',
        'sogefi_parcelle_local',
        'sogefi_autre_parcelle_local',
        'sogefi_parcelle_lot',
        'sogefi_autre_parcelle_lot',
        'sogefi_multipolygone',
        'estimation_id',
    ];
}

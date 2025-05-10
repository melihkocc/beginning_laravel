<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WomenDisease extends Model
{
    protected $fillable = [
        'user_id',
        'hpv',
        'cigarette',
        'early_sexual',
        'sexual_blood',
        'bad_smell_stream',
        'urine_blood',
        'edema',
        'more_pregnancy',
        'adet_blood',
        'pressure',
        'menepoz_blood',
        'late_menepoz',
        'special_1',
        'special_2',
        'result',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

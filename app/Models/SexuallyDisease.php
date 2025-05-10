<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SexuallyDisease extends Model
{
    // Fillable özelliği ile hangi alanların kitle atama ile güncellenebileceğini belirtin
    protected $fillable = [
        'user_id',
        'age',
        'stream',
        'is_more_stream',
        'smell',
        'color',
        'edema',
        'burning_urine',
        'itching_or_burning',
        'sankr',
        'lenf_node',
        'plaque_rash',
        'vezikul',
        'need_to_urinate',
        'result',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

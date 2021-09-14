<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicantStatus extends ParentModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

}

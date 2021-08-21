<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    /**
     * Relationship with applicant class
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applicants(){
        return $this->hasMany(Applicant::class);
    }

}

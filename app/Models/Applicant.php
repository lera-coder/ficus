<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends ParentModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'status_id'
    ];


    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->BelongsTo(ApplicantStatus::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_applicants')->withPivotValue('');
    }


    /**
     * @return BelongsToMany
     */
    public function interviews(): BelongsToMany
    {
        return $this->belongsToMany(Applicant::class, 'applicants_interviews');
    }


}

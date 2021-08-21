<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'status_id'
        ];


    /**
     * RelationShip with Status
     * @return BelongsTo
     */
    public function status(){
        return $this->BelongsTo(ApplicantStatus::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserApplicantPermission extends Model
{
    use HasFactory;

    protected $table = 'users_applicants_permissions';

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function applicant():BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function permission():BelongsTo
    {
        return $this->belongsTo(UserPermission::class, 'permission_id', 'id');
    }


}

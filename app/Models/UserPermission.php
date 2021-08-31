<?php

namespace App\Models;

use App\Models\PivotModels\UserApplicantPermissionPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;


    public function users(){
        return $this->belongsToMany(User::class, 'users_applicants_permissions', 'user_id')
            ->using(UserApplicantPermissionPivot::class)
            ->withPivot('applicant_id', 'permission_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApplicantPermission extends Model
{
    use HasFactory;

    protected $table = 'users_applicants_permissions';

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function applicant(){
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }

    public function permission(){
        return $this->belongsTo(UserPermission::class, 'permission_id', 'id');
    }


}

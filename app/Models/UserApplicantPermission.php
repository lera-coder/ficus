<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApplicantPermission extends Model
{
    use HasFactory;

    protected $table = 'users_applicants_permissions';

    public function user(){
        return $this->hasOne(User::class, 'id');
    }

    public function applicant(){
        return $this->hasOne(Applicant::class, 'id');
    }

    public function permission(){
        return $this->hasOne(UserPermission::class, 'id');
    }


}

<?php


namespace App\Repositories;


use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;

class EmailRepository implements EmailRepositoryInterface
{
    public $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function all($n)
    {
        return $this->email->paginate($n);
    }

    public function getById($id)
    {
        return $this->email->findOrFail($id);
    }

    public function activeEmail($user_id)
    {
        return $this->email->where('user_id', $user_id)->where('is_active', 1)->first();
    }

    public static function user(Email $email){
        return $email->user;
    }

    public function getModelByEmail($email){
        return $this->email->where('email', $email)->firstOrFail();
    }
}

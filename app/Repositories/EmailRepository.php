<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Email;
use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmailRepository implements EmailRepositoryInterface
{
    public $model;

    public function __construct(Email $email)
    {
        $this->model = $email;
    }

    /**
     * @param int $n
     * @return LengthAwarePaginator
     */
    public function all(int $n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $user_id
     * @return Email
     */
    public function activeEmail(int $user_id): Email
    {
        return $this->model
            ->where('user_id', $user_id)
            ->where('is_active', 1)
            ->first();
    }

    /**
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function user(int $id): User
    {
        return $this->getById($id)->user;
    }

    /**
     * @param int $id
     * @return Email
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Email
    {
        return $this->model->getModel($id);
    }

    /**
     * @param string $email_address
     * @return Email
     */
    public function getModelByEmail(string $email_address): Email
    {
        return $this->model->where('email', $email_address)->firstOrFail();
    }
}

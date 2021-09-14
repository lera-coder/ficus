<?php


namespace App\Repositories;


use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EmailRepository implements EmailRepositoryInterface
{
    public $model;

    public function __construct(Email $email)
    {
        $this->model = $email;
    }

    /**
     * @param $n
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param $user_id
     * @return Builder|Model|object|null
     */
    public function activeEmail($user_id)
    {
        return $this->model
            ->query()
            ->where('user_id', $user_id)
            ->active()
            ->first();
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function user($id)
    {
        return $this->getById($id)->user;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * @param $email
     * @return Builder|Model
     */
    public function getModelByEmail($email)
    {
        return $this->model->query()->where('email', $email)->firstOrFail();
    }
}

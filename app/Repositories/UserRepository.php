<?php


namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class UserRepository implements UserRepositoryInterface
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $n
     * @return mixed
     */
    public function all($n): Paginator
    {
        return $this->user->query()->paginate($n);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function disactivePhones($id)
    {
        return $this->phones($id)->notActive();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function phones($id)
    {
        return $this->getById($id)->phones;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->user->query()->findOrFail($id);
    }

    /**
     * @param User $user
     * @return string
     */
    public function getFullActivePhone($id)
    {
        return $this->getActivePhoneCountryCode($id)->code . $this->activePhone($id)->phone_number;
    }

    /**
     * @param User $user
     * @return mixed
     */
    protected function getActivePhoneCountryCode($id)
    {
        return $this->activePhone($id)->phoneCountryCode;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function activePhone($id)
    {
        return $this->phones($id)->active()->first();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function network($id)
    {
        return $this->getById($id)->network;
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function token2fa($id)
    {
        return $this->getById($id)->token2fa;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function roles($id)
    {
        return $this->getById($id)->roles;
    }

    /**
     * @param $login
     * @return mixed
     */
    public function getIdViaLogin($login)
    {
        return $this->user->query()->where('login', $login)->first()->id;
    }

    /**
     * @param $id
     * @return bool
     */
    public function disactiveEmails($id)
    {
        $emails = $this->emails($id);
        return (is_null($emails)) ?:
            $emails->notActive()->get();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function emails($id)
    {
        return $this->getById($id)->emails;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function activeEmail($id)
    {
        return $this->emails($id)->active()->first();
    }


    /**
     * @return array
     */
    public function getInterviewerIds():array
    {
        return DB::table('role_user')->whereIn('role_id', [3, 4])->pluck('user_id')->toArray();
    }
}

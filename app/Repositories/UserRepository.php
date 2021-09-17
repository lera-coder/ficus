<?php


namespace App\Repositories;

use App\Exceptions\ModelNotFoundException;
use App\Models\Email;
use App\Models\Network;
use App\Models\Phone;
use App\Models\PhoneCountryCode;
use App\Models\Token2fa;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class UserRepository implements UserRepositoryInterface
{
    public $model;

    public function __construct(User $user)
    {
        $this->model = $user;
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
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function disactivePhones(int $id): Collection
    {
        return $this->phones($id)->where('is_active', 0);
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function phones(int $id): Collection
    {
        return $this->getById($id)->phones;
    }

    /**
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function getById(int $id): User
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return string
     */
    public function getFullActivePhone(int $id): string
    {
        return $this->getActivePhoneCountryCode($id)->code . $this->activePhone($id)->phone_number;
    }

    /**
     * @param int $id
     * @return PhoneCountryCode
     * @throws ModelNotFoundException
     */
    protected function getActivePhoneCountryCode(int $id): PhoneCountryCode
    {
        return $this->activePhone($id)->phoneCountryCode;
    }

    /**
     * @param int $id
     * @return Phone
     * @throws ModelNotFoundException
     */
    public function activePhone(int $id): Phone
    {
        return $this->phones($id)->where('is_active', 1)->first();
    }

    /**
     * @param int $id
     * @return Network
     * @throws ModelNotFoundException
     */
    public function network(int $id): Network
    {
        return $this->getById($id)->network;
    }


    /**
     * @param int $id
     * @return Token2fa
     * @throws ModelNotFoundException
     */
    public function token2fa(int $id): Token2fa
    {
        return $this->getById($id)->token2fa;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function roles(int $id)
    {
        return $this->getById($id)->roles;
    }

    /**
     * @param $login
     * @return int
     */
    public function getIdViaLogin(string $login): int
    {
        return $this->model->query()->where('login', $login)->first()->id;
    }

    /**
     * @param int $id
     * @return Collection|null
     * @throws ModelNotFoundException
     */
    public function disactiveEmails(int $id):?Collection
    {
        $emails = $this->emails($id);
        return (is_null($emails)) ? $emails:
            $emails->where('is_active', 0);
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function emails(int $id): Collection
    {
        return $this->getById($id)->emails;
    }

    /**
     * @param int $id
     * @return Email
     * @throws ModelNotFoundException
     */
    public function activeEmail(int $id): Email
    {
        return $this->emails($id)->where('is_active', 1)->first();
    }


    /**
     * @return array
     */
    public function getInterviewerIds(): array
    {
        return DB::table('role_user')->whereIn('role_id', [3, 4])->pluck('user_id')->toArray();
    }


    /**
     * @return User
     */
    public function me()
    {
        return $this->model->me();
    }


    /**
     * @param $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function search($query){

        $users = DB::table('users')
            ->join('emails', 'users.id', '=', 'emails.user_id')
            ->join('phones', 'users.id', '=', 'phones.user_id')
            ->select('users.*', 'emails.email', 'phones.phone_number')
            ->where('email', 'like', "%{$query}%")
            ->oRwhere('login', 'like', "%{$query}%")
            ->oRwhere('name', 'like', "%{$query}%")
            ->oRwhere('phone_number', 'like', "%{$query}%")
            ->pluck('id')->toArray();

        return DB::table('users')->whereIn('id', array_unique($users));
    }
}

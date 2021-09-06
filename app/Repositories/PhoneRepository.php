<?php


namespace App\Repositories;


use App\Models\Phone;
use App\Repositories\Interfaces\PhoneRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

class PhoneRepository implements PhoneRepositoryInterface
{

    public $phone;

    public function __construct(Phone $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param $user_id
     * @return Builder|Model|object|null
     */
    public function activePhone($user_id)
    {
        return $this->phone
            ->query()
            ->where('user_id', $user_id)
            ->active()
            ->first();
    }


    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n): LengthAwarePaginator
    {
        return $this->phone->query()->paginate($n);
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function user($id)
    {
        return $this->getById($id)->query()->user;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->phone->query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function phoneCountryCode($id)
    {
        return $this->getById($id)->query()->phoneCountryCode;
    }
}

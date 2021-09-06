<?php


namespace App\Services\ModelService\Token2FAService;

use App\Models\Token2fa;
use App\Repositories\Interfaces\Token2FARepositoryInterface;

class Token2FAService implements Token2FAServiceInterface
{
    protected $token2fa_repository;

    public function __construct(Token2FARepositoryInterface $token2fa_repository)
    {
        $this->token2fa_repository = $token2fa_repository;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->token2fa_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->token2fa_repository->getById($id)->destroy();
    }

    /**
     * @param $user_id
     */
    public function create($user_id)
    {
        Token2fa::create([
            'user_id' => $user_id
        ]);
    }
}

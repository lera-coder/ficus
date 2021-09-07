<?php


namespace App\Services\ModelService\EmailService;


use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Exception\JsonException;

class EmailService implements EmailServiceInterface
{
    protected $email_repository;
    protected $user_repository;

    public function __construct(EmailRepositoryInterface $repository, UserRepositoryInterface $user_repository)
    {
        $this->email_repository = $repository;
        $this->user_repository = $user_repository;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $email = $this->email_repository->getById($id)->update($data);

        if ($email->is_active) {
            $email->email_verified_at = null;
        }
        $email->save();

        return $email;

    }

    /**
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy($id)
    {
        try {
            $this->email_repository->model->destroy($id);
        } catch (JsonException $e) {
            return response(['error' => $e->getMessage()], 404);
        }
    }


    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $user = auth()->user();
        return $this->email_repository->model->create([
            'email' => $data['email'],
            'is_active' => $this->user_repository->emails($user->id)->count() == 0,
            'user_id' => $user->id
        ]);
    }


    /**
     * @param $id
     * @return bool
     */
    public function makeActive($id)
    {
        $user = auth()->user();
        $active_email = $this->email_repository->activeEmail($user->id);
        if (!is_null($active_email)) {
            $active_email->is_active = 0;
            $this->email_repository->getById($id)->is_active = 1;
            $user->push();
            return true;
        }
        return false;
    }


}

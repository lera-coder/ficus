<?php


namespace App\Services\ModelService\EmailService;


use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Exception\JsonException;

class EmailService implements EmailServiceInterface
{
    protected $repository;
    protected $user_repository;

    public function __construct(EmailRepositoryInterface $repository, UserRepositoryInterface $user_repository)
    {
        $this->repository = $repository;
        $this->user_repository = $user_repository;
    }

    public function update($id, $data)
    {
        $email = $this->repository->getById($id)->update($data);

        if($email->is_active){
            $email->email_verified_at = null;
        }
        $email->save();

        return $email;

    }

    public function destroy($id)
    {
        try {
            Email::destroy($id);
        }catch (JsonException $e){
            return response(['error'=>$e->getMessage()], 404);
        }
    }

    public function create($credentials, $user_id,)
    {

        return Email::create([
            'email'=>$credentials['email_name'],
            'is_active'=>$this->user_repository->emails($user_id)->count()==0,
            'user_id'=>$user_id
        ]);
    }



    public function makeActive($email_id, $user_id)
    {
        $email = $this->repository->getById($email_id);
        if($email->is_active) return response('This email was already active');

        $old_active_email = $userRepository->activeEmail($user_id)->activeEmail();
        $old_active_email->is_active = false;
        $old_active_email->save();

        $email->is_active = true;
        $email->save();
    }


}

<?php

namespace App\Providers;

use App\Repositories\ApplicantRepository;
use App\Repositories\ApplicantStatusRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmailRepository;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\ApplicantStatusRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use App\Repositories\Interfaces\KnowledgeRepositoryInterface;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use App\Repositories\Interfaces\NetworkRepositoryInterface;
use App\Repositories\Interfaces\PhoneCountryCodeRepositoryInterface;
use App\Repositories\Interfaces\PhoneRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\ProjectStatusRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\TechnologyRepositoryInterface;
use App\Repositories\Interfaces\Token2FARepositoryInterface;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use App\Repositories\Interfaces\UserPermissionsRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WorkerEmailRepositoryInterface;
use App\Repositories\Interfaces\WorkerPhoneRepositoryInterface;
use App\Repositories\Interfaces\WorkerPositionRepositoryInterface;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use App\Repositories\Interfaces\WorkerStatusRepositoryInterface;
use App\Repositories\InterviewRepository;
use App\Repositories\InterviewStatusRepository;
use App\Repositories\KnowledgeRepository;
use App\Repositories\LevelRepository;
use App\Repositories\NetworkRepository;
use App\Repositories\PhoneCountryCodeRepository;
use App\Repositories\PhoneRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ProjectStatusRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TechnologyRepository;
use App\Repositories\Token2FARepository;
use App\Repositories\UserApplicantPermissionRepository;
use App\Repositories\UserPermissionsRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkerEmailRepository;
use App\Repositories\WorkerPhoneRepository;
use App\Repositories\WorkerPositionRepository;
use App\Repositories\WorkerRepository;
use App\Repositories\WorkerStatusRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services of model repositories.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EmailRepositoryInterface::class, EmailRepository::class);
        $this->app->bind(PhoneRepositoryInterface::class, PhoneRepository::class);
        $this->app->bind(ApplicantRepositoryInterface::class, ApplicantRepository::class);
        $this->app->bind(ApplicantStatusRepositoryInterface::class, ApplicantStatusRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(Token2FARepositoryInterface::class, Token2FARepository::class);
        $this->app->bind(KnowledgeRepositoryInterface::class, KnowledgeRepository::class);
        $this->app->bind(TechnologyRepositoryInterface::class, TechnologyRepository::class);
        $this->app->bind(LevelRepositoryInterface::class, LevelRepository::class);
        $this->app->bind(PhoneCountryCodeRepositoryInterface::class, PhoneCountryCodeRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(WorkerRepositoryInterface::class, WorkerRepository::class);
        $this->app->bind(WorkerStatusRepositoryInterface::class, WorkerStatusRepository::class);
        $this->app->bind(WorkerPositionRepositoryInterface::class, WorkerPositionRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(WorkerPhoneRepositoryInterface::class, WorkerPhoneRepository::class);
        $this->app->bind(WorkerEmailRepositoryInterface::class, WorkerEmailRepository::class);
        $this->app->bind(ProjectStatusRepositoryInterface::class, ProjectStatusRepository::class);
        $this->app->bind(NetworkRepositoryInterface::class, NetworkRepository::class);
        $this->app->bind(InterviewRepositoryInterface::class, InterviewRepository::class);
        $this->app->bind(InterviewStatusRepositoryInterface::class, InterviewStatusRepository::class);
        $this->app->bind(UserPermissionsRepositoryInterface::class, UserPermissionsRepository::class);
        $this->app->bind(UserApplicantPermissionRepositoryInterface::class, UserApplicantPermissionRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

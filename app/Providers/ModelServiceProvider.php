<?php

namespace App\Providers;

use App\Services\ModelService\ApplicantService\ApplicantService;
use App\Services\ModelService\ApplicantService\ApplicantServiceInterface;
use App\Services\ModelService\ApplicantStatusService\ApplicantStatusService;
use App\Services\ModelService\ApplicantStatusService\ApplicantStatusServiceInterface;
use App\Services\ModelService\CompanyService\CompanyService;
use App\Services\ModelService\CompanyService\CompanyServiceInterface;
use App\Services\ModelService\EmailService\EmailService;
use App\Services\ModelService\EmailService\EmailServiceInterface;
use App\Services\ModelService\InterviewService\InterviewService;
use App\Services\ModelService\InterviewService\InterviewServiceInterface;
use App\Services\ModelService\KnowledgeService\KnowledgeService;
use App\Services\ModelService\KnowledgeService\KnowledgeServiceInterface;
use App\Services\ModelService\LevelService\LevelService;
use App\Services\ModelService\LevelService\LevelServiceInterface;
use App\Services\ModelService\NetworkService\NetworkService;
use App\Services\ModelService\NetworkService\NetworkServiceInterface;
use App\Services\ModelService\PhoneCountryCodeService\PhoneCountryCodeService;
use App\Services\ModelService\PhoneCountryCodeService\PhoneCountryCodeServiceInterface;
use App\Services\ModelService\PhoneService\PhoneService;
use App\Services\ModelService\PhoneService\PhoneServiceInterface;
use App\Services\ModelService\ProjectService\ProjectService;
use App\Services\ModelService\ProjectService\ProjectServiceInterface;
use App\Services\ModelService\ProjectStatusService\ProjectStatusService;
use App\Services\ModelService\ProjectStatusService\ProjectStatusServiceInterface;
use App\Services\ModelService\RoleService\RoleService;
use App\Services\ModelService\RoleService\RoleServiceInterface;
use App\Services\ModelService\TechnologyService\TechnologyService;
use App\Services\ModelService\TechnologyService\TechnologyServiceInterface;
use App\Services\ModelService\Token2FAService\Token2FAService;
use App\Services\ModelService\Token2FAService\Token2FAServiceInterface;
use App\Services\ModelService\UserService\UserService;
use App\Services\ModelService\UserService\UserServiceInterface;
use App\Services\ModelService\WorkerEmailService\WorkerEmailService;
use App\Services\ModelService\WorkerEmailService\WorkerEmailServiceInterface;
use App\Services\ModelService\WorkerPhoneService\WorkerPhoneService;
use App\Services\ModelService\WorkerPhoneService\WorkerPhoneServiceInterface;
use App\Services\ModelService\WorkerPositionService\WorkerPositionService;
use App\Services\ModelService\WorkerPositionService\WorkerPositionServiceInterface;
use App\Services\ModelService\WorkerService\WorkerService;
use App\Services\ModelService\WorkerService\WorkerServiceInterface;
use App\Services\ModelService\WorkerStatusService\WorkerStatusService;
use App\Services\ModelService\WorkerStatusService\WorkerStatusServiceInterface;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services of working with models.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
        $this->app->bind(PhoneServiceInterface::class, PhoneService::class);
        $this->app->bind(ApplicantServiceInterface::class, ApplicantService::class);
        $this->app->bind(ApplicantStatusServiceInterface::class, ApplicantStatusService::class);
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
        $this->app->bind(KnowledgeServiceInterface::class, KnowledgeService::class);
        $this->app->bind(LevelServiceInterface::class, LevelService::class);
        $this->app->bind(NetworkServiceInterface::class, NetworkService::class);
        $this->app->bind(PhoneCountryCodeServiceInterface::class, PhoneCountryCodeService::class);
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(ProjectStatusServiceInterface::class, ProjectStatusService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(TechnologyServiceInterface::class, TechnologyService::class);
        $this->app->bind(Token2FAServiceInterface::class, Token2FAService::class);
        $this->app->bind(WorkerEmailServiceInterface::class, WorkerEmailService::class);
        $this->app->bind(WorkerPhoneServiceInterface::class, WorkerPhoneService::class);
        $this->app->bind(WorkerPositionServiceInterface::class, WorkerPositionService::class);
        $this->app->bind(WorkerServiceInterface::class, WorkerService::class);
        $this->app->bind(WorkerStatusServiceInterface::class, WorkerStatusService::class);
        $this->app->bind(InterviewServiceInterface::class, InterviewService::class);


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

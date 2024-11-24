<?php

namespace App\Providers;

use App\Repository\AdminRepositoryInterface;
use App\Repository\BankRepositoryInterface;
use App\Repository\BoxRepositoryInterface;
use App\Repository\CartInfoRepositoryInterface;
use App\Repository\CartRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ContactusRepositoryInterface;
use App\Repository\CopouneEventsRepositoryInterface;
use App\Repository\CopouneRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\OrderTicketInfoRepositoryInterface;
use App\Repository\OrderTicketRepositoryInterface;
use App\Repository\PaymentRepositoryInterface;
use App\Repository\PolicyRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\ResetPasswordRepositoryInterface;
use App\Repository\SettingRepositoryInterface;
use App\Repository\subcategoryRepositoryInterface;
use App\Repository\TicketInfoRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Repository\UserRepositoryInterface;

use App\Repository\Eloquent\AdminRepository;
use App\Repository\Eloquent\BankRepository;
use App\Repository\Eloquent\BoxRepository;
use App\Repository\Eloquent\CartInfoRepository;
use App\Repository\Eloquent\CartRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ContactusRepository;
use App\Repository\Eloquent\CopouneEventsRepository;
use App\Repository\Eloquent\CopouneRepository;
use App\Repository\Eloquent\EventRepository;
use App\Repository\Eloquent\OrderRepository;
use App\Repository\Eloquent\OrderTicketInfoRepository;
use App\Repository\Eloquent\OrderTicketRepository;
use App\Repository\Eloquent\PaymentRepository;
use App\Repository\Eloquent\PolicyRepository;
use App\Repository\Eloquent\QuestionRepository;
use App\Repository\Eloquent\ResetPasswordRepository;
use App\Repository\Eloquent\SettingRepository;
use App\Repository\Eloquent\subcategoryRepository;
use App\Repository\Eloquent\TicketInfoRepository;
use App\Repository\Eloquent\TicketRepository;
use App\Repository\Eloquent\UserRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, Repository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);
        $this->app->bind(BoxRepositoryInterface::class, BoxRepository::class);
        $this->app->bind(CartInfoRepositoryInterface::class, CartInfoRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ContactusRepositoryInterface::class, ContactusRepository::class);
        $this->app->bind(CopouneEventsRepositoryInterface::class, CopouneEventsRepository::class);
        $this->app->bind(CopouneRepositoryInterface::class, CopouneRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderTicketInfoRepositoryInterface::class, OrderTicketInfoRepository::class);
        $this->app->bind(OrderTicketRepositoryInterface::class, OrderTicketRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(PolicyRepositoryInterface::class, PolicyRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(ResetPasswordRepositoryInterface::class, ResetPasswordRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(subcategoryRepositoryInterface::class, subcategoryRepository::class);
        $this->app->bind(TicketInfoRepositoryInterface::class, TicketInfoRepository::class);
        $this->app->bind(TicketRepositoryInterface::class, TicketRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
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

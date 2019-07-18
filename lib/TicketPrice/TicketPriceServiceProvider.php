<?php

namespace Ngmy\TicketPrice;

use Illuminate\Support\ServiceProvider;
use Ngmy\TicketPrice\Domain\Model\TicketRepositoryInterface;
use Ngmy\TicketPrice\Infra\CsvTicketRepository;

class TicketPriceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TicketRepositoryInterface::class, CsvTicketRepository::class);
    }
}

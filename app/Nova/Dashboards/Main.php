<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Admins;
use App\Nova\Metrics\NewCustomer;
use App\Nova\Metrics\NewDriver;
use App\Nova\Metrics\Order;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new Order(),
            new NewCustomer(),
            new NewDriver(),
        ];
    }
}

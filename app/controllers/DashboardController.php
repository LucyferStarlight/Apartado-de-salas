<?php   

require_once dirname(__DIR__) . '/Helpers/Session.php';
require_once dirname(__DIR__) . '/Helpers/Auth.php';

class DashboardController
{
     public function index(): void
    {
        Auth::requireLogin();

        require_once dirname(__DIR__) . '/views/dashboard/index.php';
    }
}

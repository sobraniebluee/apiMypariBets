<?php

require __DIR__ . '/app/Services/AppBets.php';
require __DIR__ . '/app/Services/Database.php';

use AppBets\Services\AppBets;

AppBets::run();

require __DIR__ . '/app/Controllers/Accounts.php';
require __DIR__ . '/app/Controllers/AccountData.php';
require __DIR__ . '/app/Controllers/FreeBetsData.php';
require __DIR__ . '/app/Controllers/AccountsStats.php';

require __DIR__ . '/app/Services/RouterBets.php';
require __DIR__ . '/routes/routes.php';



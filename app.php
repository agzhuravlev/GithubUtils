<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

(new \NunoMaduro\Collision\Provider)->register();

$application = new Application();
$application->add(new \App\Command\RemindAboutPullRequests());
$application->run();
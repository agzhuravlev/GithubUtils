<?php

namespace App\Command;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

abstract class BaseCommand extends Command
{
    private $container;


    // не самое подходящее место для инициализации контейнера, но пока так
    protected function getContainer(): ContainerBuilder
    {
        if ($this->container == null) {
            $container = new ContainerBuilder();
            $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
            $loader->load('..\..\config\config.yml');

            $this->container = $container;
        }

        return $this->container;
    }
}
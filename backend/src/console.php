#!/usr/bin/env php
<?php

namespace Console;
use Symfony\Component\Console\Application as BaseApplication;

$dir = __DIR__;

require dirname($dir).'/vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$builder = new ContainerBuilder();
$loader = new YamlFileLoader($builder, new FileLocator($dir));
$loader->load(dirname($dir).'/config/services.yaml');

$builder->compile();


class Application extends BaseApplication
{
    public function __construct(array $commands = [])
    {
        foreach ($commands as $command) {
            $this->add($command);
        }
        dump($commands);
    }
}
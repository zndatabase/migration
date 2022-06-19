<?php

use ZnCore\Base\Helpers\InstanceHelper;
use ZnCore\Base\Libs\ConfigManager\Interfaces\ConfigManagerInterface;
use ZnDatabase\Migration\Domain\Repositories\SourceRepository;

return [
    'definitions' => [],
    'singletons' => [
        'ZnDatabase\Migration\Domain\Interfaces\Services\GenerateServiceInterface' => 'ZnDatabase\Migration\Domain\Services\GenerateService',
        'ZnDatabase\Migration\Domain\Interfaces\Repositories\GenerateRepositoryInterface' => 'ZnDatabase\Migration\Domain\Repositories\File\GenerateRepository',
        SourceRepository::class => function (\Psr\Container\ContainerInterface $container) {
            $definition = [
                'class' => SourceRepository::class,
                '__construct' => [
                    'mainConfigFile' => $_ENV['ELOQUENT_CONFIG_FILE'],
                    ConfigManagerInterface::class => $container->get(ConfigManagerInterface::class),
                ],
            ];
            $instance = InstanceHelper::create($definition);
            return $instance;
//            return new SourceRepository($_ENV['ELOQUENT_CONFIG_FILE']);
        },
    ],
];

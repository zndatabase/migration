<?php

use ZnDatabase\Migration\Domain\Repositories\SourceRepository;

return [
    'definitions' => [],
    'singletons' => [
        'ZnDatabase\Migration\Domain\Interfaces\Services\GenerateServiceInterface' => 'ZnDatabase\Migration\Domain\Services\GenerateService',
        'ZnDatabase\Migration\Domain\Interfaces\Repositories\GenerateRepositoryInterface' => 'ZnDatabase\Migration\Domain\Repositories\File\GenerateRepository',
        SourceRepository::class => function () {
            return new SourceRepository($_ENV['ELOQUENT_CONFIG_FILE']);
        },
    ],
];

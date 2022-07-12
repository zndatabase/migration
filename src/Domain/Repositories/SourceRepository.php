<?php

namespace ZnDatabase\Migration\Domain\Repositories;

use ZnCore\Contract\Common\Exceptions\InvalidConfigException;
use ZnCore\Base\Helpers\LoadHelper;
use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\ConfigManager\Interfaces\ConfigManagerInterface;
use ZnCore\FileSystem\Helpers\FilePathHelper;
use ZnCore\FileSystem\Helpers\FindFileHelper;
use ZnLib\Components\Store\Helpers\StoreHelper;
use ZnDatabase\Migration\Domain\Entities\MigrationEntity;

class SourceRepository
{

    //use ConfigTrait;

    private $configManager;

    public function __construct($mainConfigFile = null, ConfigManagerInterface $configManager)
    {
        $config = StoreHelper::load($mainConfigFile);
//        $config = LoadHelper::loadConfig($mainConfigFile);
        //$config = $this->loadConfig($mainConfigFile);
        $this->config = $config['migrate'] ?? [];

        $this->config['directory'] = isset($this->config['directory']) ? $this->config['directory'] : $configManager->get('ELOQUENT_MIGRATIONS');
        /*if(empty($this->config)) {
            throw new InvalidConfigException('Empty migrtion configuration!');
        }*/
        $this->configManager = $configManager;
    }

    public function getAll()
    {
        $directories = $this->config['directory'];
        if (empty($directories)) {
            return [];
            throw new InvalidConfigException('Empty directories configuration for migrtion!');
        }
        $classes = [];
        foreach ($directories as $dir) {
            $newClasses = self::scanDir(FilePathHelper::prepareRootPath($dir));
            $classes = ArrayHelper::merge($classes, $newClasses);
        }
        return $classes;
    }

    private static function scanDir($dir)
    {
        $files = FindFileHelper::scanDir($dir);
        $classes = [];
        foreach ($files as $file) {
            $classNameClean = FilePathHelper::fileRemoveExt($file);
            $entity = new MigrationEntity;
            $entity->className = 'Migrations\\' . $classNameClean;
            $entity->fileName = $dir . DIRECTORY_SEPARATOR . $classNameClean . '.php';
            $entity->version = $classNameClean;
            include_once($entity->fileName);
            $classes[] = $entity;
        }
        return $classes;
    }

}
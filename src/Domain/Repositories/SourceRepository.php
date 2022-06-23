<?php

namespace ZnDatabase\Migration\Domain\Repositories;

use ZnCore\Contract\Common\Exceptions\InvalidConfigException;
use ZnCore\Base\Helpers\LoadHelper;
use ZnCore\Base\Libs\Arr\Helpers\ArrayHelper;
use ZnCore\Base\Libs\ConfigManager\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FindFileHelper;
use ZnCore\Base\Libs\Store\Helpers\StoreHelper;
use ZnDatabase\Migration\Domain\Entities\MigrationEntity;

class SourceRepository
{

    //use ConfigTrait;

    private $configManager;

    public function __construct($mainConfigFile = null, ConfigManagerInterface $configManager)
    {
        $config = StoreHelper::load($_ENV['ROOT_DIRECTORY'] . '/' . $mainConfigFile);
//        $config = LoadHelper::loadConfig($mainConfigFile);
        //dd($_ENV['ELOQUENT_MIGRATIONS']);
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
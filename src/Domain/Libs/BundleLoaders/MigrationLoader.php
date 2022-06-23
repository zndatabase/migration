<?php

namespace ZnDatabase\Migration\Domain\Libs\BundleLoaders;

use ZnCore\Base\Libs\Arr\Helpers\ArrayHelper;
use ZnCore\Base\Libs\ConfigManager\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BaseLoader;

class MigrationLoader extends BaseLoader
{

    /*public function __construct(ConfigManagerInterface $configManager)
    {
        $this->setConfigManager($configManager);
    }*/

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $i18nextBundles = $this->load($bundle);
            $config = ArrayHelper::merge($config, $i18nextBundles);
        }
//        $_ENV['ELOQUENT_MIGRATIONS'] = $config;
        //if($this->hasConfigManager()) {
            $this->getConfigManager()->set('ELOQUENT_MIGRATIONS', $config);
        //}
        return [];
//        return [$this->getName() => $config];
    }
}

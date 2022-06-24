<?php

namespace ZnDatabase\Migration\Domain\Libs\BundleLoaders;

use ZnCore\Base\App\Loaders\BundleLoaders\BaseLoader;
use ZnCore\Base\Arr\Helpers\ArrayHelper;

class MigrationLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $i18nextBundles = $this->load($bundle);
            $config = ArrayHelper::merge($config, $i18nextBundles);
        }
        $this->getConfigManager()->set('ELOQUENT_MIGRATIONS', $config);
        return [];
    }
}

<?php

use ZnCore\Base\Libs\App\Kernel;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;

DotEnv::init();

$kernel = new Kernel('console');
$container = $kernel->getContainer();
$bundleLoader = new BundleLoader([], ['i18next', 'container', 'console', 'migration']);
$appBundlesConfigFile = FilePathHelper::path($_ENV['BUNDLES_CONFIG_FILE']);

if (file_exists($appBundlesConfigFile)) {
    $bundleLoader->addBundles(include $appBundlesConfigFile);
}
$bundleLoader->addBundles(include __DIR__ . '/bundle.php');
$kernel->setLoader($bundleLoader);

$config = $kernel->loadAppConfig();

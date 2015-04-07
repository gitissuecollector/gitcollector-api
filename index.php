<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: X-Requested-With, Authorization, Content-Type');

require_once 'Slim/Slim.php';
require_once 'Vendors/github-php-client/client/GitHubClient.php';

\Slim\Slim::registerAutoloader();

\Slim\Extensions\Config::init(
    array(
        'BASE_PATH'   => '',
        'CONFIGS_DIR' => 'Config/'
    )
);

$app = new \Slim\Slim();

$app->container->singleton('gitClient', function () {
    return new \GitHubClient();
});

require 'Resources/Get.php';
require 'Resources/Post.php';

$app->run();

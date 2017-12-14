<?php
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require_once __DIR__ . '/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$app = require __DIR__ . '/../app/app.php';

require __DIR__ . '/../app/config/dev.php';
require __DIR__ . '/../app/services.php';
require __DIR__ . '/../app/controllers.php';

$app->run();
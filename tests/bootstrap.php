<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use phpmock\phpunit\PHPMock;

class BootstrapPHPMockHelper { use PHPMock; }
BootstrapPHPMockHelper::defineFunctionMock('TheIconic\NameParser\Part', 'function_exists');

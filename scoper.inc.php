<?php
declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    'prefix' => 'OCA\\RdsNg\\Vendor',
    'finders' => [
        Finder::create()->files()
            ->exclude([
                'test',
                'composer',
                'bin',
                'docs'
            ])
            ->notName('autoload.php')
            ->in("vendor"),
    ],
];

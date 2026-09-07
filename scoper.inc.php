<?php
declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

function createFinderEntry(string $name): Finder
{
    return Finder::create()->files()
        ->exclude([
            'test',
            'composer',
            'bin',
        ])
        ->notName('autoload.php')
        ->in("vendor/{$name}");
}

return [
    'prefix' => 'OCA\\RdsNg\\Vendor',
    'finders' => [
        createFinderEntry('web-token'),
        createFinderEntry('firebase'),
        createFinderEntry('brick'),
        createFinderEntry('spomky-labs'),
    ],
];

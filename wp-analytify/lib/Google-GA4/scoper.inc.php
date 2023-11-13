<?php

declare (strict_types=1);
namespace Analytify;

// scoper.inc.php
use Analytify\Isolated\Symfony\Component\Finder\Finder;
return [
    'prefix' => 'Analytify',
    // string|null
    'output-dir' => null,
    // string|null
    'finders' => [],
    // list<Finder>
    'patchers' => [],
    // list<callable(string $filePath, string $prefix, string $contents): string>
    'exclude-files' => [],
    // list<string>
    'exclude-namespaces' => ['Google\\', 'Grpc\\', 'Composer\\'],
    // list<string|regex>
    'exclude-constants' => [],
    // list<string|regex>
    'exclude-classes' => [],
    // list<string|regex>
    'exclude-functions' => [],
    // list<string|regex>
    'expose-global-constants' => \true,
    // bool
    'expose-global-classes' => \true,
    // bool
    'expose-global-functions' => \true,
    // bool
    'expose-namespaces' => [],
    // list<string|regex>
    'expose-constants' => [],
    // list<string|regex>
    'expose-classes' => [],
    // list<string|regex>
    'expose-functions' => [],
];

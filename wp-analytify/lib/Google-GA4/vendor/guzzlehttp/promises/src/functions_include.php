<?php

namespace Analytify;

// Don't redefine the functions if included multiple times.
if (!\function_exists('Analytify\\GuzzleHttp\\Promise\\promise_for')) {
    require __DIR__ . '/functions.php';
}

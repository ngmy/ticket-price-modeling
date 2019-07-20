<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        'lib',
    ])
;

return PhpCsFixer\Config::create()
    ->setRules([
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
;

// vim: set ft=php:

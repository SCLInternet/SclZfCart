<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('LICENSE')
    ->notName('README.md')
    ->notName('.php_cs')
    ->notName('composer.*')
    ->notName('phpunit.xml*')
    ->notName('*.phar')
    ->exclude('vendor')
    ->in(__DIR__)
    ;

$fixers = array(
    'indentation',
    'linefeed',
    'trailing_spaces',
    'unused_use',
    'visibility',
    'short_tag',
    'braces',
    'include',
    'php_closing_tag',
    'extra_empty_lines',
    'psr0',
    'controls_spaces',
    'elseif',
    'eof_ending',
);

return Symfony\CS\Config\Config::create()
    ->fixers($fixers)
    ->finder($finder)
    ;

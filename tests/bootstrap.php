<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:24 PM
 */

require __DIR__ . '/../autoload.php';

$aophp = new \AOPHP\AOPHP();

$parser = new \AOPHP\DocBlock\Parser(new \AOPHP\Cache\FileSystemDriver());
$parser->parse(new DocBlockTest());
<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 10:40 PM
 */

namespace AOPHP\DocBlock;

/**
 * Class Aspect
 * @package AOPHP\DocBlock
 *
 * @example:
 *      before(class.method)
 *      after(class.method)
 *
 *      ...(*.*)
 *      ...(class.*)
 *      ...(*.method)
 */
class Aspect
{
    const REGEXP = "~(before|after)\(\s*(.+)\.(.+)\s*\)~ui";

    public function __construct($rawAspect)
    {
        echo "Matching: ", $rawAspect, "\n";
        var_dump(preg_match(self::REGEXP, $rawAspect, $matches));
        var_dump($matches);
    }
} 
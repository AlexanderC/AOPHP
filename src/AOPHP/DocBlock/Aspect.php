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
    /**
     * Regexp applied to aspect info string
     */
    const REGEXP = "~(?P<type>before|after)\s*\(\s*(?P<class>[^\s]+)\s*\.\s*(?P<method>[^\s]+)\s*\)~ui";

    const AFTER = 'after';
    const BEFORE = 'before';

    const ANY = "*";

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $method;

    /**
     * @param string $rawAspect
     * @throws \InvalidArgumentException
     */
    public function __construct($rawAspect)
    {
        if(!preg_match(self::REGEXP, $rawAspect, $matches)
            || !isset($matches['type'], $matches['class'], $matches['method'])) {
            throw new \InvalidArgumentException("Unable to parse aspect string");
        }

        $this->type = strtolower($matches['type']);
        $this->class = $matches['class'];
        $this->method = $matches['method'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
} 
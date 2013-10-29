<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/29/13
 * @time 9:46 AM
 */

namespace AOPHP;


use AOPHP\DocBlock\Parser;

class Aspect
{
    /**
     * @var object
     */
    protected $object;

    /**
     * @var array
     */
    protected $blocks = [];

    /**
     * @param object $object
     * @throws \InvalidArgumentException
     */
    public function __construct($object)
    {
        if(!is_object($object)) {
            throw new \InvalidArgumentException(
                "Object provided must me an valid object ({" . gettype($object) . "} given)"
            );
        }

        $this->object = $object;
    }

    /**
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return array
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $this->blocks = $parser->parse($this->object);
    }
} 
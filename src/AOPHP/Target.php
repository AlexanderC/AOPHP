<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/29/13
 * @time 9:46 AM
 */

namespace AOPHP;


class Target
{
    /**
     * @var object
     */
    protected $object;

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
} 
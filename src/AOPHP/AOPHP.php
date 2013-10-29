<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:26 PM
 */

namespace AOPHP;

use AOPHP\Cache\FileSystemDriver;
use AOPHP\Cache\IDriver;
use AOPHP\DocBlock\Parser;
use AOPHP\DocBlock\Block;
use AOPHP\DocBlock\Advice;

class AOPHP
{
    /**
     * @var Cache\IDriver
     */
    protected $cache;

    /**
     * @var DocBlock\Parser
     */
    protected $parser;

    /**
     * @var array
     */
    protected $targets = [];

    /**
     * @var array
     */
    protected $aspects = [];

    /**
     * @return AOPHP
     */
    public static function crete()
    {
        $cache = new FileSystemDriver();
        return new self($cache);
    }

    /**
     * @param IDriver $cache
     */
    public function __construct(IDriver $cache)
    {
        $this->cache = $cache;
        $this->parser = new Parser($cache);
    }

    /**
     * @param Target $target
     * @param string $method
     * @return array
     */
    public function findPointcuts(Target $target, $method)
    {
        $pointcuts = [];

        /** @var $aspect Aspect */
        foreach($this->aspects as $aspect) {
            $pointcuts[] = (new PointCut($target, $aspect, $method))->resolve();
        }

        return $pointcuts;
    }

    /**
     * @param $targetObject
     * @param $method
     * @param array $parameters
     * @return bool|mixed
     * @throws \InvalidArgumentException
     */
    public function advice($targetObject, $method, array $parameters = [])
    {
        if(!is_object($targetObject)) {
            throw new \InvalidArgumentException(
                "Target object provided must me an valid object ({" . gettype($targetObject) . "} given)"
            );
        } elseif(!$this->isTargetObject($targetObject)) {
            throw new \InvalidArgumentException("No such target objects registered");
        }

        $target = $this->targets[spl_object_hash($targetObject)];
        $pointcuts = $this->findPointcuts($target, $method);

        // flag to skip target execution
        $skipExecution = false;

        /** @var $pointcut PointCut */
        foreach($pointcuts as $pointcut) {
            if(false === $pointcut->adviceBefore($parameters)) {
                $skipExecution = true;
                break;
            }
        }

        if(!$skipExecution) {
            $traits = class_uses($targetObject);

            if(array_key_exists('AOPHP\Traits\AOP', $traits)) {
                $result = call_user_func_array([$targetObject, '__aopCallInternal'], [$method, $parameters]);
            } else {
                $result = call_user_func_array([$targetObject, $method], $parameters);
            }

            /** @var $pointcut PointCut */
            foreach($pointcuts as $pointcut) {
                $pointcut->adviceAfter($parameters, $result);
            }

            return $result;
        }

        return false;
    }

    /**
     * @param object $object
     * @return Aspect
     */
    public function createAspect($object)
    {
        $aspect = new Aspect($object);
        $aspect->parse($this->parser);

        return $aspect;
    }

    /**
     * @param object $object
     * @return Target
     */
    public function createTarget($object)
    {
        return new Target($object);
    }

    /**
     * @param Aspect $aspect
     */
    public function addAspect(Aspect $aspect)
    {
        $this->aspects[] = $aspect;
    }

    /**
     * @param Target $target
     */
    public function addTarget(Target $target)
    {
        $this->targets[spl_object_hash($target->getObject())] = $target;
    }

    /**
     * @return array
     */
    public function getAspects()
    {
        return $this->aspects;
    }

    /**
     * @return \AOPHP\Cache\IDriver
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @return array
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * @return \AOPHP\DocBlock\Parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @param object $object
     * @return bool
     */
    public function isTargetObject($object)
    {
        return isset($this->targets[spl_object_hash($object)]);
    }
} 
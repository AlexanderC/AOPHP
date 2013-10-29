<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/29/13
 * @time 10:30 AM
 */

namespace AOPHP;


use AOPHP\DocBlock\Block;
use AOPHP\DocBlock\Advice;

class PointCut
{
    /**
     * @var array
     */
    protected $before = [];

    /**
     * @var array
     */
    protected $after = [];

    /**
     * @var string
     */
    protected $method;

    /**
     * @var Target
     */
    protected $target;

    /**
     * @var Aspect
     */
    protected $aspect;

    /**
     * @param Target $target
     * @param Aspect $aspect
     * @param string $method
     */
    public function __construct(Target $target, Aspect $aspect, $method)
    {
        $this->target = $target;
        $this->aspect = $aspect;
        $this->method = (string) $method;
    }

    /**
     * @return $this
     * @throws \RuntimeException
     */
    public function resolve()
    {
        /** @var $block Block */
        foreach($this->aspect->getBlocks() as $block) {
            /** @var $advice Advice */
            foreach($block->getAdvices() as $advice) {
                if($advice->getClass() === get_class($this->target->getObject())
                    || $advice->getClass() === Advice::ANY) { // now class is matched

                    if($advice->getMethod() === $this->method
                        || $advice->getMethod() === Advice::ANY) { // now method is matched

                        if($advice->getType() === Advice::BEFORE) {
                            $this->before[] = $advice;
                        } elseif($advice->getType() === Advice::AFTER) {
                            $this->after[] = $advice;
                        } else {
                            throw new \RuntimeException("Wrong advice type");
                        }
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAfter()
    {
        return $this->after;
    }

    /**
     * @return \AOPHP\Aspect
     */
    public function getAspect()
    {
        return $this->aspect;
    }

    /**
     * @return array
     */
    public function getBefore()
    {
        return $this->before;
    }

    /**
     * @return \AOPHP\Target
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param array $parameters
     * @return bool
     */
    public function adviceBefore(array & $parameters)
    {
        $continue = true;

        /** @var $advice Advice */
        foreach($this->before as $advice) {
            if(false === (
                $result = call_user_func_array([$this->aspect->getObject(), $advice->getBlock()->getMethod()], [
                    $advice, $parameters
                ])
                )) {
                $continue = false;
                break;
            }
        }

        return $continue;
    }

    /**
     * @param array $parameters
     * @param mixed $result
     */
    public function adviceAfter(array & $parameters, $result)
    {
        /** @var $advice Advice */
        foreach($this->after as $advice) {
            call_user_func_array([$this->aspect->getObject(), $advice->getBlock()->getMethod()], [
                $advice, $parameters, $result
            ]);
        }
    }
} 
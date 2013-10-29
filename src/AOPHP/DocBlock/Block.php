<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:31 PM
 */

namespace AOPHP\DocBlock;


class Block
{
    /**
     * Regular expression DocBlock to be matched to
     */
    const REGEXP = "~(?:\s*\*\s*@aop\s*/\s*((?:before|after)[^\n]*)\s*\n)~umi";

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $rawBlock;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var bool
     */
    protected $isAdvice = false;

    /**
     * @var array
     */
    protected $advices = [];

    /**
     * @param string $class
     * @param string $method
     * @param string $rawBlock
     * @param string $signature
     */
    public function __construct($class, $method, $rawBlock, $signature)
    {
        $this->class = (string) $class;
        $this->method = (string) $method;
        $this->rawBlock = (string) $rawBlock;
        $this->signature = (string) $signature;

        $this->parseAdvices();
    }

    /**
     * @return void
     */
    protected function parseAdvices()
    {
        if(preg_match_all(self::REGEXP, $this->rawBlock, $matches) && count($matches) === 2) {
            foreach($matches[1] as $rawAspect) {
                $this->advices[] = new Advice($rawAspect, $this);
            }

            $this->isAdvice = true;
        }
    }

    /**
     * @return bool
     */
    public function isAdvice()
    {
        return $this->isAdvice;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
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
    public function getRawBlock()
    {
        return $this->rawBlock;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return array
     */
    public function getAdvices()
    {
        return $this->advices;
    }
}
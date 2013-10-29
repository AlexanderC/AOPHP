<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:27 PM
 */

namespace AOPHP\DocBlock;


use AOPHP\Cache\IDriver;

class Parser
{
    /**
     * @var \AOPHP\Cache\IDriver
     */
    protected $cache;

    /**
     * @param IDriver $cache
     */
    public function __construct(IDriver $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param mixed $class
     * @return array
     */
    public function parse($class)
    {
        $reflection = new \ReflectionClass($class);

        $blocks = [];

        foreach($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $block = $this->parseMethod($method);

            if($block instanceof Block) {
                $blocks[] = $block;
            }
        }

        return $blocks;
    }

    /**
     * @param \ReflectionMethod $method
     * @return bool|Block
     */
    protected function parseMethod(\ReflectionMethod $method)
    {
        $docBlock = $method->getDocComment();

        if(false !== $docBlock) {
            $signature = md5((string) $method);

            $block = $this->cache->get($method->getDeclaringClass()->getName(), $method->getName());

            if($block instanceof Block) {
                // check for outdated cache
                if($signature !== $block->getSignature()) {
                    $this->cache->invalidate($block);
                    $block = $this->createAndPersistBlock($method, $docBlock, $signature);
                }
            } else {
                $block = $this->createAndPersistBlock($method, $docBlock, $signature);
            }

            return $block;
        }

        return false;
    }

    /**
     * @param \ReflectionMethod $method
     * @param string $docBlock
     * @param string $signature
     * @return Block|false
     */
    protected function createAndPersistBlock(\ReflectionMethod $method, $docBlock, $signature)
    {
        $block = new Block($method->getDeclaringClass()->getName(), $method->getName(), $docBlock, $signature);

        if(!$block->isAdvice()) {
            return false;
        }

        $this->cache->persist($block);
        return $block;
    }
} 
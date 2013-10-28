<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:38 PM
 */

namespace AOPHP\Cache;


use AOPHP\DocBlock\Block;

interface IDriver
{
    /**
     * @param string $class
     * @param string $method
     * @return \AOPHP\DocBlock\Block
     */
    public function get($class, $method);

    /**
     * @param Block $block
     * @return bool
     */
    public function persist(Block $block);

    /**
     * @param Block $block
     * @return bool
     */
    public function invalidate(Block $block);
} 
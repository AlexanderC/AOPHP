<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:32 PM
 */

class DocBlockTest
{
    /**
     * @param string $text
     * @return $this
     */
    protected function doThings($text)
    {
        echo "Text things is ", $text, "\n";
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    protected function doAnotherThings($text)
    {
        echo "Text another things is ", $text, "\n";
        return $this;
    }

    /**
     * Test DocBlock parser
     *
     * @AOP/before (DocBlockTest.doAnotherThings   )
     * @param array $parameters
     * @AOP/after (  DocBlockTest .* )
     */
    protected function testBlockAfter(array $parameters)
    {

    }

    // Some example of method without docBlock
    protected function withoutAnyDocBlock()
    {   }
}
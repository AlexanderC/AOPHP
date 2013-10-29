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
     * @return string
     */
    public function doThings($text)
    {
        echo "Do text things is ", $text, "\n";
        return 'blablashow';
    }

    /**
     * @param string $text
     * @return string
     */
    public function doAnotherThings($text)
    {
        echo "Do text another things is ", $text, "\n";
        return 'blablashow';
    }

    /**
     * Test this method for the cache invalidating
     *
     * @param \AOPHP\DocBlock\Advice $advice
     * @param array $parameters
     * @param null|mixed $result
     *
     * @AOP/before(DocBlockTest . doThings)
     * @AOP/before(* . doAnotherThings)
     * @AOP/after(DocBlockTest . *)
     */
    public function testBlockAfter(\AOPHP\DocBlock\Advice $advice, array & $parameters, $result = null)
    {
        echo "Calling advice: ", $advice->getRawAspect(), "\n";
        echo "Called using: ", var_export($parameters, true), "\n";
        echo "Target Result: ", var_export($result, true), "\n";
    }

    // Some example of method without docBlock
    protected function withoutAnyDocBlock()
    {   }
}
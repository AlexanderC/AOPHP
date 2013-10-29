<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/29/13
 * @time 12:04 PM
 */

namespace AOPHP\Traits;


use AOPHP\AOPHP;
use AOPHP\Helpers\AOPConst;

trait AOP
{
    /**
     * @var AOPHP
     */
    protected $AOPHP;

    /**
     * @param AOPHP $AOPHP
     * @param int $type
     */
    public function initAOP(AOPHP $AOPHP, $type = AOPConst::AOP_TARGET_AND_ASPECT)
    {
        $this->AOPHP = $AOPHP;

        if($type & AOPConst::AOP_ASPECT) {
            $this->AOPHP->addAspect($this->AOPHP->createAspect($this));
        }

        if($type & AOPConst::AOP_TARGET) {
            $this->AOPHP->addTarget($this->AOPHP->createTarget($this));
        }
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return bool|mixed|void
     */
    public function __call($method, array $arguments)
    {
        // is private or protected
        if(method_exists($this, $method)) {
            return $this->AOPHP->advice($this, $method, $arguments);
        }

        return $this->__onCall($method, $arguments);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __aopCallInternal($method, array $arguments)
    {
        return call_user_func_array([$this, $method], $arguments);
    }

    /**
     * @param string $method
     * @param array $arguments
     */
    protected function __onCall($method, array $arguments)
    {   }
} 
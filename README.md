AOPHP
=====

AOPHP- AOP for PHP

Examples
--------

    For detailed examples see tests/bootstrap.php

```php
<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:24 PM
 */

require __DIR__ . '/../autoload.php';

$AOPHP = \AOPHP\AOPHP::crete();

// see DocBlockTest to understand lib usage
$object = new DocBlockTest();

// add target object (methods called on this)
//$AOPHP->addTarget($AOPHP->createTarget($object));
// add aspect object (advices would be applied before and after calling a target)
//$AOPHP->addAspect($AOPHP->createAspect(clone $object));

// call target method
//$AOPHP->advice($object, 'doThings', ['"Lorem Ipsum dolor sit amet"']);
// call another target method
//$AOPHP->advice($object, 'doAnotherThings', ['"Lorem Ipsum dolor sit amet"']);

$object->doThings("Lorem Ipsum dolor sit amet");
```

License
-------

GNU GPLv2.
Copyright (c) 2013 AlexanderC <self@alexanderc.me>

<?php

namespace DSL\DSLBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DSLBundle extends Bundle {

    public function getParent() 
    {
        return 'FOSUserBundle';
    }
}

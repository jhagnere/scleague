<?php

namespace Self\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SelfUserBundle extends Bundle
{
    public function getParent() {
        return "FOSUserBundle";
    }
}

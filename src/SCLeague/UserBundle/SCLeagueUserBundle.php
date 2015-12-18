<?php

namespace SCLeague\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SCLeagueUserBundle extends Bundle
{
    public function getParent() {
        return "FOSUserBundle";
    }
}

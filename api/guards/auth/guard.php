<?php

namespace Guards;

use Auth\BaseGuard;

class AuthGuard extends BaseGuard
{

    protected $alg = 'jwt';
}

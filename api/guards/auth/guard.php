<?php

namespace Guards;

use Auth\BaseGuard;

class AuthGuard extends BaseGuard
{

    protected $alg = 'H256';

    /* x protected $JWT_SECRET = env('JWT_SECRET','my_secret'); */


    /* If use custom payload
    protected $payload = [
      'username',
      'userId',
      'email',
      'avatar',
      'role'
    ];
    */
}

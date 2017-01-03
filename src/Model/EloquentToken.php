<?php

namespace LWK\ViMbAdmin\Model;

use Illuminate\Database\Eloquent\Model;
use LWK\ViMbAdmin\Traits\Token;
use LWK\ViMbAdmin\Contracts\ViMbAdminToken as ViMbAdminTokenContract;

class EloquentToken extends Model implements ViMbAdminTokenContract
{
    use Token;

}

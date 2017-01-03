<?php

namespace LWK\ViMbAdmin\Model;

use LWK\ViMbAdmin\Traits\Token;
use LWK\ViMbAdmin\Contracts\ViMbAdminToken as ViMbAdminTokenContract;

class JsonToken implements ViMbAdminTokenContract
{
    use Token;

    /**
     * Need to able to set the ID on this one.
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}

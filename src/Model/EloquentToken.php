<?php

namespace LWK\ViMbAdmin\Model;

use Illuminate\Database\Eloquent\Model;
use LWK\ViMbAdmin\Traits\Token;
use LWK\ViMbAdmin\Contracts\ViMbAdminToken as ViMbAdminTokenContract;

class EloquentToken extends Model implements ViMbAdminTokenContract
{
    use Token;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'token', 'expires', 'type'];

    /**
     * Create a new Token with the give values.
     * @param  string   $key
     * @param  string   $token
     * @param  DataTime $expires
     * @return LWK\ViMbAdmin\Contracts\ViMbAdminToken
     */
    static public function createToken($key, $token, $expires, $type)
    {
        $data = [
            'key' => $key,
            'token' => $token,
            'expires' => $expires,
            'type' => $type,
        ];
        return new static($data);
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WxUserModel extends Model
{
    public $table = 'p_wx_users';
    protected $primarykey = 'uid';
}

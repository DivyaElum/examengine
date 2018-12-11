<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouncilMemberModel extends Model
{
     protected $table = 'council_members';

    protected $dates = ['deleted_at'];
}

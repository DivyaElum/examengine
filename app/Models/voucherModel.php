<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class voucherModel extends Model
{
   protected $table = 'voucher';
   
   protected $dates = ['deleted_at'];
}

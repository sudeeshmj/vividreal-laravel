<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable=['first_name','last_name','company_id','email','phone'];

    protected $hidden = ['created_at', 'updated_at'];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}

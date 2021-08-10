<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Mail\MyMail;
use Illuminate\Support\Facades\Mail;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'logo',
        'website',
        'created_at'

    ];

    public function employees(){

        return $this->hasMany(Employee::class, 'company_id','id');
    }
}

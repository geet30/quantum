<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Vaults\{  Methods };
class Vaults extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Methods;

   

}

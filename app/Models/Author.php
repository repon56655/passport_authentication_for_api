<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;
use Laravel\Passport\HasApiTokens;
use App\Models\Book;

class Author extends Model implements AuthenticateContract
{
    use HasFactory, Authenticatable, HasApiTokens;

    public function books(){
        return $this->hasMany(Book::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description"
    ];

    /* Relations */

    public function user() { return $this -> belongsTo(User::class, "userId"); }
    public function products() { return $this -> hasMany(Product::class, "projectId"); }


}

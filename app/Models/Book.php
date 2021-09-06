<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $collection = "books";
    protected $dates      = ["created_at", "updated_at"];
    protected $fillable   = [
        "number",
        "name",
        "release",
        "created_by",
    ];

    public function maker(){
        return $this->belongsTo("App\Models\User", "created_by");
    }
}

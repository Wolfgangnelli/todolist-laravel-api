<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Todo extends Model
{
    use SoftDeletes;
    //automaticamente questo model mapperebbe la tabella todos (che vedo nella migrations)
    //qui nel mio todo devo indicare quali sono i campi che possono essere compilati/assegnabili
    protected $fillable = [
        'todo', 'list_id', 'completed'
    ];
}

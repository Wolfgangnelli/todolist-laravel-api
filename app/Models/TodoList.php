<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    //qusta classe si aspetta che ci sia una tabella col nome todolists
    //se volessi cambiare nome della tabella: protected $table = 'nuovoNome'
    protected $fillable = ['name', 'user_id'];
}

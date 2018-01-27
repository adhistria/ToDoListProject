<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function todolists(){
        return $this->hasMany(ToDoList::class);
    }
    public function getToDoListDsc(){
        $toDoLists = $this->todolists()->getQuery()->orderBy('priority', 'desc')->get();
        return $toDoLists;
    }
    public function getToDoListAsc(){
        $toDoLists = $this->todolists()->getQuery()->orderBy('priority', 'asc')->get();
        return $toDoLists;
    }
    public function showToDoList(){

    }
}

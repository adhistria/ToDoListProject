<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
    //
    protected $fillable =[
        'name','location','timeStart','priority','user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
//    public function getToDoListAsc(){
//        $toDoLists = $this->getToDoListAsc();
//        $toDoLists = $this->comments()->getQuery()->orderBy('created_at', 'desc')->get();
//        return $comments;
//    }
}

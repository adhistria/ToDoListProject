<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\ToDoList;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Request;
use Mockery\Exception;
use App\User;
use Validator;
class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDataSorted(Request $request){
        try{
            $request->fullUrl();
//            return $request->fullUrl();
            $arr = explode('todo/sorted?', $request->fullUrl());

            $important = $arr[1];
            if($important !='asc' && $important!='dsc' ){
                return response()->json(['status'=>'FAIL','message'=>'wrong url','content'=>null]);
            }else{
                $user = JWTAuth::parseToken()->authenticate();
                if($important == 'dsc'){
                    return response()->json(['status'=>'SUCCESS','message'=>'Get To Do List Descending','content'=>$user->getToDoListDsc()]);
                }else{
                    return response()->json(['status'=>'SUCCESS','message'=>'Get To Do List Descending','content'=>$user->getToDoListAsc()]);
                }
            }
        }catch (Exception $e){
            return response()->json(['status'=>'FAIL','message'=>'couldn\'t get data','content'=>$e]);
        }
    }
    public function index()
    {
        //
        try{
            $user = JWTAuth::parseToken()->authenticate();
//            $toDoLists =ToDoList::where('user_id',$user->id)->get();
            return response()->json(['status'=>'SUCCESS','message'=>'ok','content'=>$user->todolists]);
        }catch (Exception $e){
            return response()->json(['status'=>'FAIL','message'=>"couldn't get data",'content'=>$e],400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDoneToDoList(){
        try{
            $user = JWTAuth::parseToken()->authenticate();
            $todollists=$user->todolists;
            $donetodo = [];
            foreach ($todollists as $todollist){
                if($todollist->timeStart< Carbon::now('WIB')){
                    array_push($donetodo,$todollist);
                }
            }
            return response()->json(['status'=>'SUCCESS','message'=>"ok",'content'=>$donetodo],200);
        }catch (Exception $e){
            return response()->json(['status'=>'FAIL','message'=>"couldn't get data",'content'=>$e],400);
        }

//        return Carbon::now('WIB');
    }
    public function inCompleteToDoList(){
        try{
            $user = JWTAuth::parseToken()->authenticate();
            $todollists=$user->todolists;
            $donetodo = [];
            foreach ($todollists as $todollist){
                if($todollist->timeStart > Carbon::now('WIB')){
                    array_push($donetodo,$todollist);
                }
            }
            return response()->json(['status'=>'SUCCESS','message'=>"ok",'content'=>$donetodo],200);
        }catch (Exception $e){
            return response()->json(['status'=>'FAIL','message'=>"couldn't get data",'content'=>$e],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $todolist = new ToDoList();

        try{
            $validator = Validator::make($request->all(), [
                'name'=>'required|min:0|max:500',
                'priority'=>'required|integer|between:0,2',
                'location'=>'required|min:0|max:273',
                'year'=>'required|integer|min:2018|max:3000',
                'month'=>'required|integer|between:1,12',
                'day'=>'required|between:1,31',
                'hour'=>'required|between:1,24',
                'minute'=>'required|between:1,60',
                'second'=>'required|between:1,60'
            ]);
            if ($validator->fails()) {
                return response()->json(['status'=>'FAIL','message'=>"couldn't store data",'content'=>$validator->errors()],400);
            }
            $todolist->name=$request->name;
            $todolist->priority=$request->priority;
            $todolist->location=$request->location;
//            $time = Carbon::createFromTime($request->hour,$request->minute,$request->second);
            $time =Carbon::create($request->year,$request->month,$request->day,$request->hour,$request->minute,$request->second);
            $todolist->timeStart=$time;
            $user = JWTAuth::parseToken()->authenticate();
            $todolist->user_id=$user->id;
            $todolist->save();
            return response()->json(['status'=>'SUCCESS',"message"=>"OK","content"=>null],200);
        }catch (Exception $e){
            return response()->json(['status'=>'FAIL','message'=>"couldn't store data",'content'=>$e],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $toDoList = ToDoList::find($id);
            return response()->json(['status'=>'SUCCESS',"message"=>"OK","content"=>$toDoList],200);
        }catch (Exception $e){
            return  response()->json(['status'=>'FAIL','message'=>"couldn't get data",'content'=>$e],400);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $todolist = ToDoList::find($id);
            if($todolist==null){
                return response()->json(['status'=>'FAIL','message'=>"can't find data",'content'=>null],200);
            }
            $validator = Validator::make($request->all(), [
                'name'=>'required|min:0|max:500',
                'priority'=>'required|integer|between:0,2',
                'location'=>'required|min:0|max:273',
                'year'=>'required|integer|min:2018|max:3000',
                'month'=>'required|integer|between:1,12',
                'day'=>'required|integer|between:1,31',
                'hour'=>'required|integer|between:1,24',
                'minute'=>'required|integer|between:1,60',
                'second'=>'required|integer|between:1,60'
            ]);
            if ($validator->fails()) {
                return response()->json(['status'=>'FAIL','message'=>"couldn't store data",'content'=>$validator->errors()],400);
            }
            $todolist->name=$request->name;
            $todolist->priority=$request->priority;
            $todolist->location=$request->location;
//            $time = Carbon::createFromTime($request->hour,$request->minute,$request->second);
            $time =Carbon::create($request->year,$request->month,$request->day,$request->hour,$request->minute,$request->second);
            $todolist->timeStart=$time;
            $user = JWTAuth::parseToken()->authenticate();
            $todolist->user_id=$user->id;
            $todolist->save();
            return response()->json(['status'=>'SUCCESS',"message"=>"OK","content"=>null],200);
        }catch(Exception $e){
            return response()->json(['status'=>'FAIL','message'=>"couldn't update data",'content'=>$e],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $toDoList = ToDoList::find($id);
            if($toDoList==null){
                return response()->json(['status'=>'SUCCESS','message'=>"can't find data",'content'=>null],200);
            }
            $toDoList->delete();
            return response()->json(['status'=>'SUCCESS','message'=>"OK",'content'=>null],200);
        }catch (Exception $e){
            return response()->json(['status'=>'FAIL','message'=>"couldn't destroy data",'content'=>$e],400);
        }
    }
}

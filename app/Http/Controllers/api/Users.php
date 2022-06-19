<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User ;
use Hash ;
use Datatables;
class Users extends Controller
{

      public function __construct()
    {
       // $this->middleware(['auth:api' ,'can:isAdmin']);

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users =   User::select('id','name' , 'email' , 'type');

    

       return Datatables::of($users)
       ->addColumn('action' , function($data){

      
        $button = "<button id='".$data."' class='btn btn-primary editButton'>Edit <i class='fas fa-pen'></i></button>

        <button id='".$data."' class='btn btn-danger deleteButton'>Delete <i class='fas fa-trash'></i></button>
        " ;

        return $button ;
       })
       ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response('good');
    }

 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $q)
    {
      $v = $this->validate($q , [

        'name'=>'required' ,
        'password'=>'required|min:6' ,
        'email'=>'required|email|unique:users' ,
        'type'=>'required' ,
      ]) ;

      if($v){

        $v['password'] = Hash::make($v['password']);

        

        User::create($v);
        return response('success');  
      }

      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $q, $id)
    {

      
         $v = $this->validate($q , [

        'name'=>'required' ,
        'password'=>'sometimes|nullable|min:6' ,
        'email'=>'required|email|unique:users,email,'.$id ,
        'type'=>'required' ,
      ]) ;

       if($v){

       

        $user =  User::find($id);

        $user->name = $v['name'] ;
       if($v['password']){
            $user->password = Hash::make($v['password']);
        }
        $user->email = $v['email'] ;
        $user->type = $v['type'] ;

        $user->save() ;

        return response('success');  
       }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       if($id){
            User::find($id)->delete();
       }
    }
}

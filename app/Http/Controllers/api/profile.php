<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User ;
use Image ;

class profile extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api');
    }
       public function index(){

        return auth('api')->user() ;
    }

    public function update(Request $q){

    	 $user = auth('api')->user() ;

    

          
        $this->validate($q ,[
            'name' => 'required|string|max:191' ,
            'email' => 'required|email|string|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|nullable|string|min:6' 
        ]);

        if($q->photo){
             $image = $q->photo ;
             $imgInfo = explode(';' , $image)[0];
             $imgType = explode('/',$imgInfo)[1];
             $imgName = time().'.'.$imgType ;
             $img = Image::make($image)->save(public_path('img/'.$imgName));

              if( public_path('img/'.$user->photo) ){
                    @unlink(public_path('img/'.$user->photo));
                }

            $q->photo = $imgName ;
        }else{
            $q->photo = $user->photo ;
        }

      


        $password = isset($q->password) ? bcrypt($q->password) : $user->password ; 
        $user->update([
            'name' => $q->name ,
            'email' => $q->email ,
            'photo' => $q->photo ,
            'pasword' =>  $password
        ]);

    

        
       

        
    }
}

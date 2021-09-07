<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(50)]);
    }


    public function create()
    {
        return view('users.index');
    }


    public function store(User $user)
    {
        
        
        User::create([
            'name' => $user->name ,
            'email' => $user->email ,
            'password' => $user->password ,
            
            

        ]);
        return redirect()->route('users.index')->with('success','User has been added!');
    }

    

}
<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ShowUsers extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MhsController extends Controller
{
    public function index(){
        return view('home_mahasiswa.index');
    }
}

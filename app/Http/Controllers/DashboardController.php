<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Collaborator;
class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index(){
        $admin = User::where('role', 1)->count();
        $user = User::where('role','')->count();
        $company = company::all()->count();
        $collaborator = Collaborator::all()->count();
        return view('dashboard', compact('admin','user','company','collaborator'));
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\General\GeneralServices;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var GeneralServices
     */
    private $generalServices;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GeneralServices $generalServices)
    {
        $this->middleware('auth');
        $this->generalServices = $generalServices;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        //Checks in general service if the user is Super Admin.
        if($this->generalServices->checkSuperAdmin($user))
        {
            $employees = User::count();        
        }else{
            $employees = User::where('company_id',$user->company_id)->count();
        }
        
        return $this->generalServices->generalRoute('home',['user'=>$user, 'employees' =>$employees]);
    }
}
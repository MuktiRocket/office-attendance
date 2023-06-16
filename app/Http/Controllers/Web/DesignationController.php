<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Designation\CreateDesignationRequest;
use App\Models\Designation;
use App\Service\General\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DesignationController extends Controller
{
    /**
     * @var GeneralServices
     */
    private $generalServices;

    public function __construct(GeneralServices $generalServices)
    {
        $this->generalServices = $generalServices;
    }
    
    //List of Designations of any particular company
    public function list()
    {
        $user = Auth::user();
        $designations = Designation::where('company_id',$user->company_id)->get();
        return $this->generalServices->generalRoute('designation.list',['designations'=>$designations]);
    }

    //Create page view.
    public function createDesignationView()
    {
        return $this->generalServices->generalRoute('designation.create');
    }

    //Create new Designation
    public function create(CreateDesignationRequest $request)
    {
        $user = Auth::user();
        try {
            DB::beginTransaction();
            $designation = Designation::create([
                'designation'    =>  $request->designation,
                'company_id'     =>  $user->company_id
            ]);
            DB::commit();
            $request->session()->flash('success', 'Designation is created successfully');
        } catch(\Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', $e->getMessage());
        }
        return back();
    }
}

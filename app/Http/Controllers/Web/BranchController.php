<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\CreateBranchRequest;
use App\Models\Branch;
use App\Service\General\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    /**
     * @var GeneralServices
     */
    protected $generalServices;

    public function __construct(GeneralServices $generalServices)
    {
        $this->generalServices = $generalServices;
    }

    //List of branches with respective employees assigned
    public function list()
    {
        $user = Auth::user();
        $branches = Branch::with('employee')->where('company_id',$user->company_id)->paginate(20);
        return $this->generalServices->generalRoute('branch.list',['branches'=>$branches]);
    }

    //Branch create view page
    public function createBranchView()
    {
        return $this->generalServices->generalRoute('branch.create');
    }

    public function create(CreateBranchRequest $request)
    {
        $user = Auth::user();
        try {
            DB::beginTransaction();
            $branch = Branch::create([
                'branch_name'   =>  $request->branch_name,
                'address'       =>  $request->branch_address,
                'company_id'    =>  $user->company_id
            ]);
            DB::commit();
            $request->session()->flash('success', 'Designation is created successfully');
        } catch(\Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', $e->getMessage());
        }
        return back();
    }

    public function editView($id)
    {
        $id = Crypt::decrypt($id);
        $branch = Branch::find($id);
        return $this->generalServices->generalRoute('branch.edit', ['branch' =>$branch]);
    }

    public function edit(Request $request)
    {
        try {
            DB::beginTransaction();
            Branch::find($request->id)->update([
                'branch_name' => $request->branch_name,
                'address' => $request->branch_address
            ]);
            DB::commit();
            $request->session()->flash('success','Branch updated successfully.');
        } catch (\Exception $ex) {
            DB::rollBack();
            $request->session()->flash('error', $ex->getMessage());
        }
        
        return back();
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Models\Company;
use App\Service\General\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * @var GeneralServices
     */
    private $generalServices;

    public function __construct(GeneralServices $generalServices)
    {
        $this->generalServices = $generalServices;
    }

    //List of all companies.
    public function list(Request $request)
    {
        $companies = Company::paginate(20);
        return $this->generalServices->generalRoute('company.list', ['companies'=>$companies]);
    }

    public function createCompanyView()
    {
        return $this->generalServices->generalRoute('company.create');
    }

    //Create new Company
    public function create(CompanyCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $company = Company::create([
                'name'    =>  $request->company_name
            ]);
            DB::commit();
            $request->session()->flash('success', 'Company is registered successfully');
        } catch(\Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', $e->getMessage());
        }
        return back();
    }
}

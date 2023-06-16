<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeEditRequest;
use App\Http\Requests\Employee\EmployeeRegistrationRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Designation;
use App\Models\User;
use App\Service\General\GeneralServices;
use App\Service\User\UsersServices;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * @var GeneralServices
     */
    private $generalServices;

    /**
     * @var UsersServices
     */
    private $usersServices;

    public function __construct(GeneralServices $generalServices, UsersServices $usersServices)
    {
        $this->generalServices = $generalServices;
        $this->usersServices = $usersServices;
    }

    //List of employees according to logged in User
    public function list(Request $request)
    {
        $loggedInUser = Auth::user();
        $employees = User::query();

        //For SuperAdmin list only Admin and Super Admins.
        if ($this->generalServices->checkSuperAdmin($loggedInUser)) {
            $employees = $employees->whereIn('designation_id', [1, 2]);
        }
        //For all Admins list of the employees.
        else {
            $employees = $employees->where('company_id', $loggedInUser->company_id);
        }
        //Search bar data
        if ($request->has('search_data')) {
            if ($request->search_data != null) {
                $search = $request->search_data;
                if ($search == trim($search) && strpos($search, ' ') !== false) {
                    $search = explode(" ", $search, 2);
                    $employees = $employees->where('first_name', 'LIKE', "%{$search[0]}%")
                        ->orWhere('last_name', 'LIKE', "%{$search[1]}%");
                } else {
                    $employees = $employees->orWhere(function (Builder $query) use ($search) {
                        return $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                }
            }
        }
        $employees = $employees->paginate(20);
        return $this->generalServices->generalRoute('employee.list', ['employees' => $employees, 'request' => $request]);
    }

    //View page for employee creation
    public function createEmployeeView()
    {
        $branches = null;
        $loggedInUser = Auth::user();
        //Only SuperAdmin and Admin role.
        if ($this->generalServices->checkSuperAdmin($loggedInUser)) {
            $designations = $this->usersServices->getDesignations('SA');
        }
        //All designation of the company with Admin.
        else {
            $designations = $this->usersServices->getDesignations('A', $loggedInUser->company_id);
            $branches = Branch::where('company_id', $loggedInUser->company_id)->get();
        }
        return $this->generalServices->generalRoute('employee.create', ['designations' => $designations, 'branches' => $branches]);
    }

    //Create new Employee
    public function createEmployee(EmployeeRegistrationRequest $request)
    {
        try {
            DB::beginTransaction();
            $company_id = $request->company ?? Auth::user()->company_id;
            $user = User::create([
                'first_name'    =>  $request->first_name,
                'last_name'     =>  $request->last_name,
                'email'         =>  $request->email,
                'phone_number'  =>  $request->phone_number,
                'designation_id' =>  $request->designation,
                'employee_id'   =>  $request->employee_id,
                'company_id'    =>  $company_id,
                'branch_id'     =>  $request->branch,
                'password'      =>  bcrypt($request->password)
            ]);
            DB::commit();
            $request->session()->flash('success', 'Employee is created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', $e->getMessage());
        }
        return back();
    }

    /**
     * Search Companies
     * Model Company 
     * */
    public function searchCompany(Request $request)
    {
        try {
            $companies = Company::all();
            return json_encode(['status' => 'success', 'data' => $companies]);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function editView($id)
    {
        $user = Auth::user();
        $id = Crypt::decrypt($id);
        $designations = Designation::get();
        $employee_details = User::with('user_designation')->find($id);
        if (!$this->generalServices->checkSuperAdmin($user)) {
            $branches = Branch::where('company_id', $user->company_id)->get();
        } else {
            $branches = null;
        }
        return $this->generalServices->generalRoute('employee.edit', ['branches' => $branches, 'employee' => $employee_details, 'designations' => $designations]);
    }

    public function edit(EmployeeEditRequest $request)
    {
        try {
            if ($request->password == '') {
                $password = $request->oldPassword;
            } else {
                $password = bcrypt($request->password);
            }
            DB::beginTransaction();
            User::find($request->id)->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                'branch_id' => $request->branch,
                'password'      =>   $password
            ]);
            DB::commit();
            $request->session()->flash('success', 'Employee Details has been updated');
        } catch (\Exception $ex) {
            DB::rollBack();
            $request->session()->flash('error', $ex->getMessage());
        }

        return back();
    }

    public function deactivate($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $user = User::find($id);
            $user->update(['active_status' => 0]);
            return json_encode(['status' => 'success', 'message' => 'Successfully deactivated this account']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $user = User::find($id)->delete();
            return json_encode(['status' => 'success', 'message' => 'Successfully deleted this employee']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function reactivate($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $user = User::find($id);
            $user->update(['active_status' => 1]);
            return json_encode(['status' => 'success', 'message' => 'Successfully reactivated this account']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    //List of employees according to designation
    public function searchEmployee(Request $request)
    {
        try {
            $loggedInUser = Auth::user();
            $employees = User::query();
            if ($request->designation_id !== 'ALL') {
                $employees = $employees->where('designation_id', $request->designation_id);
            }
            $employees = $employees->where('company_id', $loggedInUser->company_id)->get();
            return json_encode(['status' => 'success', 'data' => $employees]);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

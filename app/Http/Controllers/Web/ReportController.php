<?php

namespace App\Http\Controllers\Web;

use App\Exports\EmployeeAttendanceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Report\ReportRequest;
use App\Models\Branch;
use App\Models\User;
use App\Service\General\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * @var GeneralServices
     */
    private $generalServices;

    public function __construct(GeneralServices $generalServices)
    {
        $this->generalServices = $generalServices;
    }
    //Attendance report view page with required data.
    public function attendanceReportView(Request $request)
    {
        $user = Auth::user();
        $employees = User::where('company_id', $user->company_id)->whereNotIn('id', [$user->id]);
        if ($request->ajax()) {
            if ($request->query('branchId') === 'all') {
                $employees = $employees->get();
            } else {
                $employees = $employees->where('branch_id', $request->query('branchId'))->get();
            }
            return json_encode(['status' => 'success', 'data' => $employees]);
        }
        $employees = $employees->get();
        $branches = Branch::where('company_id', $user->company_id)->get();
        return $this->generalServices->generalRoute('reports.attendance_report', ['employees' => $employees, 'branches' => $branches]);
    }

    //Export Attendance to an Excel Report.
    public function attendanceReportExport(ReportRequest $request)
    {
        $employee_id = $request->employee_id;
        $daterange = $request->daterange;
        $from_date = $this->generalServices->getDate(substr($daterange, 0, 10));
        $to_date = $this->generalServices->getDate(substr($daterange, 13, 10));
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new EmployeeAttendanceExport($employee_id, $from_date, $to_date), 'Attendance.xlsx');
    }
}

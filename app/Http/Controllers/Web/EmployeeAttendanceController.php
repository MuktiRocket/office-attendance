<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\CreateAttendanceCategoryRequest;
use App\Models\AttendanceCategory;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeLatLongHistory;
use App\Service\General\GeneralServices;
use App\Service\User\UsersServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeAttendanceController extends Controller
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

    public function attendance()
    {
        $loggedInUser = Auth::user();
        $designations = $this->usersServices->getDesignations('A', $loggedInUser->company_id);
        return $this->generalServices->generalRoute('employee_attendance.attendance', ['designations' => $designations]);
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $all_lat_long = [];
        //Get designations for Admins of any company.
        $designations = $this->usersServices->getDesignations('A', $user->company_id);
        $id = $request->employee_id;
        $daterange = $request->daterange;

        $from_day = substr($daterange, 3, 2);
        $from_month = substr($daterange, 0, 2);
        $from_year = substr($daterange, 6, 4);
        $from_date = date($from_year . '-' . $from_month . '-' . $from_day);

        $to_day = substr($daterange, 16, 2);
        $to_month = substr($daterange, 13, 2);
        $to_year = substr($daterange, 19, 4);
        $to_date = date($to_year . '-' . $to_month . '-' . $to_day);

        try {
            $employee_attendance = EmployeeAttendance::with('employee')
                ->where('user_id', $id)
                ->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59'])
                ->get()
                ->each(function ($attendance) use ($all_lat_long) {
                    array_push($all_lat_long, [
                        floatval($attendance->in_longitude),
                        floatval($attendance->in_latitude)
                    ]);
                    $lat_long_history = EmployeeLatLongHistory::where('attendance_id', $attendance->id)->orderBy('id')->get();
                    foreach ($lat_long_history as $each_lat_long_history) {
                        array_push($all_lat_long, [
                            floatval($each_lat_long_history->longitude),
                            floatval($each_lat_long_history->latitude)
                        ]);
                    }
                    array_push($all_lat_long, [
                        floatval($attendance->out_longitude),
                        floatval($attendance->out_latitude)
                    ]);
                    $attendance->lat_long_history = json_encode($all_lat_long);
                });
            return $this->generalServices->generalRoute('employee_attendance.attendance', ['attendance' => $employee_attendance, 'request' => $request, 'designations' => $designations]);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    //Image Doenload
    public function downloadImage($imageId)
    {
        $attendance = EmployeeAttendance::where('id', $imageId)->firstOrFail();
        $in_image_path = public_path() . '/uploads/users/' . $attendance->in_profile_image;
        return response()->download($in_image_path, $attendance->in_profile_image);
    }

    //List of attendance Categories according to Company
    public function attendanceCategory()
    {
        $user = Auth::user();
        $attendance_categories = AttendanceCategory::where('company_id', $user->company_id)->paginate(20);
        return $this->generalServices->generalRoute('employee_attendance.category_list', ['categories' => $attendance_categories]);
    }

    //Create page view
    public function createAttendanceCategoryView()
    {
        return $this->generalServices->generalRoute('employee_attendance.create_category');
    }

    //Create Attendance categories
    public function createAttendanceCategory(CreateAttendanceCategoryRequest $request)
    {
        $user = Auth::user();
        try {
            DB::beginTransaction();
            $attendance_category = AttendanceCategory::create([
                'category_name'    =>  $request->attendance_category,
                'company_id'     =>  $user->company_id
            ]);
            DB::commit();
            $request->session()->flash('success', 'Attendance Category is created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', $e->getMessage());
        }
        return back();
    }
}

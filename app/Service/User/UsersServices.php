<?php

namespace App\Service\User;

use App\Models\Designation;
use App\Models\EmployeeAttendance;
use App\Models\User;
use Intervention\image\ImageManagerStatic as Image;

class UsersServices
{
    public function makeInAndOutAttendance($request, $user)
    {
        $current_date  = date('Y-m-d');
        $png_url = strtotime(date("Y-m-d H:i:s")) . ".png";
        $path = public_path() . '/uploads/users/' . $png_url;
        \Image::make(file_get_contents($request->profile_image))->save($path);

        $check_attendance = EmployeeAttendance::where('user_id', $user->id)->whereDate('created_at', $current_date)->first();
        if ($check_attendance) {
            $check_attendance->update([
                'out_latitude' => $request->latitude,
                'out_longitude' => $request->longitude,
                'out_profile_image' => $png_url,
                'attendance_given' => 'SIGNED OUT'
            ]);
            $attendance = $check_attendance;
        } else {
            $attendance = EmployeeAttendance::create([
                'user_id' => $user->id,
                'attendance_category' => $request->category_id,
                'in_profile_image' => $png_url,
                'in_latitude' => $request->latitude,
                'in_longitude' => $request->longitude,
                'address' => $request->address,
                'company_id' => $user->company_id,
                'attendance_given' => 'SIGNED IN'
            ]);
        }
        return $attendance;
    }

    /**
     * Get the Designations.
     * 'A' for Admin. Get all the designatins of the particular company with Admin.
     * 'SA' for SuperAdmin. Get only Admin and SuperAdmin designations details.
     */
    public function getDesignations($user_desig, $company_id = null)
    {
        $designation = Designation::query();
        if ($user_desig === 'SA') {
            $designation = $designation->whereIn('id', [1, 2]);
        } elseif ($user_desig === 'A') {
            $designation = $designation->where('id', 2)->orWhere('company_id', $company_id);
        }
        return $designation->get();
    }
}

<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $attendance_category = $this->attendance_category;
        if (!empty($attendance_category)) {
            $attendance_category = [
                'category_id' => $this->category->id ?? '',
                'category_name' => $this->category->category_name ?? ''
            ];
        }


        return [
            'id'            =>   $this->id,
            'in_user_image'    =>   ($this->in_profile_image != '') ? asset('uploads/users/' .$this->in_profile_image ) : '',
            'out_user_image'    =>   ($this->out_profile_image != '') ? asset('uploads/users/' .$this->out_profile_image ) : '',
            'attendance_category' => $attendance_category,
            'in_latitude'     => $this->in_latitude,
            'in_longitude'    => $this->in_longitude,
            'out_latitude'     => $this->out_latitude ?? '',
            'out_longitude'    => $this->out_longitude ?? '',
            'create_at'    => $this->created_at->timestamp,
            'attendance_given'            =>    $this->attendance_given
        ];
    }
}

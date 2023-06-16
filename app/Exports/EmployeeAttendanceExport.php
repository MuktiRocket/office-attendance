<?php

namespace App\Exports;

use App\Models\EmployeeAttendance;
use DateTime;
use DateTimeZone;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeAttendanceExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{

    public function __construct(array $employee, string $start_date, string $end_date)
    {
        $this->start_date = date($start_date);
        $this->end_date = date($end_date);
        $this->employee = $employee;
    }

    public function query()
    {
        return EmployeeAttendance::query()
            ->with('employee', 'category')
            ->whereIn('user_id', $this->employee)
            ->whereBetween('created_at', [$this->start_date.' 00:00:00',$this->end_date.' 23:59:59'])
            ->orderBy('user_id')
            ->orderBy('created_at');
    }

    public function headings(): array
    {
        return [
            'First name',
            'Last name',
            'Status',
            'Date',
            'Address'
        ];
    }

    public function map($employeeAttendance): array
    {
        return[
            $employeeAttendance->employee->first_name,
            $employeeAttendance->employee->last_name,
            $employeeAttendance->category->category_name,
            (new DateTime($employeeAttendance->created_at))->setTimezone(new DateTimeZone('Asia/Kolkata'))->format('d/m/Y'),
            $employeeAttendance->address
        ];
    }
}

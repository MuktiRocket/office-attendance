<?php

namespace App\Service\General;
use Illuminate\Support\Facades\Auth;

class GeneralServices
{
    //Return to view page with parameters and logged in User designation.
    public function generalRoute($routePath, array $params = NULL)
    {
        $params['flag'] = array(
            'checkSuperAdmin' => $this->checkSuperAdmin(Auth::user()),
        );
        return view($routePath, with($params));
    }

    //Checks if the '$user' is Super Admin
    public function checkSuperAdmin($user)
    {
        $flag = false;
        if($user->designation_id === 1){
            $flag = true;
        }
        return $flag;
    }

    //Change date format 'mm/dd/yyyy' to 'yyyy-mm-dd'
    public function getDate(string $date)
    {
        $day = substr($date, 3, 2);
        $month = substr($date,0,2);
        $year = substr($date,6,4);
        $date = date($year.'-'.$month.'-'.$day);
        return $date;
    }
}

?>
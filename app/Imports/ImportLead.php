<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportLead implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $EmployeeData = Employee::where('name', '=', $row[1])->first();

        return new Lead([
            
            'name' => $row[0],
            'employee_id' => $EmployeeData->id,
            'source_from' => $row[2],
            'phonenumber' => $row[3],
        ]);
    }
}

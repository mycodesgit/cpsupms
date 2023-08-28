<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modify;

class ModifyController extends Controller
{
    public function modifyShow($id)
    {
        $modifyRecords = Modify::where('payroll_id', $id)->get(); 
    
        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $modifyRecords,
        ]);
    }

    public function modifyUpdate(Request $request)
    {
        $payrollID = $request->id;

        $columns = [
            'Project' => 'Project',
            'Net_MPC' => 'Net_MPC',
            'Graduate' => 'Graduate',
            'Philhealth' => 'Philhealth',
            'Pag_ibig' => 'Pag_ibig',
            'Gsis' => 'Gsis',
            'Csb' => 'Csb',
        ];
        
        foreach ($columns as $column => $fieldName) {
            $modify = Modify::firstOrNew(['payroll_id' => $payrollID, 'column' => $column]);
            $modify->action = $request->{$fieldName . '_action'};
            $modify->amount = $request->{$fieldName . '_amount'};
            $modify->save();
        }

        return redirect()->back()->with('success', 'Updated successfully');
        
    }
      
}

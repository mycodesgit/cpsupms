<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deduction;
use App\Models\PayrollFile;
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
        $route = $request->curr_route;
        $payrollID = $request->id;
        $payrollID1 = $request->idd;

        if($route == "storepayroll"){
            $columns = [
                'Column1' => 'Column1',
                'Column2' => 'Column2',
                'Column3' => 'Column3',
                'Column4' => 'Column4',
                'Column5' => 'Column5',
                'Column6' => 'Column6',
                'Column7' => 'Column7',
            ];
            
            foreach ($columns as $column => $fieldName) {
                $modify = Modify::firstOrNew(['payroll_id' => $payrollID, 'column' => $column]);
                $modify->action = $request->{$fieldName . '_action'};
                $modify->amount = $request->{$fieldName . '_amount'};
                $modify->save();
            }
        }
        if ($route == "storepayroll-jo") {
            $columns = [
                'Column1' => 'Column1',
                'Column2' => 'Column2',
                'Column3' => 'Column3',
                'Column4' => 'Column4',
                'Column5' => 'Column5'
            ];
        
            foreach ($columns as $column => $fieldName) {
                $modify = Modify::firstOrNew(['payroll_id' => $payrollID, 'column' => $column]);
                $modify->amount = $request->{$fieldName . '_amount'} ?? 0;
                $modify->save();
            }
        
            foreach ($columns as $column => $fieldName) {
                Modify::where(['pay_id' => $payrollID1, 'column' => $column])
                ->update(['label' => $request->{$fieldName . '_label'} ?? '']);
            }

            $deduction = Deduction::where('payroll_id', $payrollID)->first();
            $tax2 = $deduction->tax2;
            if($tax2 != 0.00){
                $pfile = PayrollFile::find($payrollID);
                $modify = Modify::where('payroll_id', $payrollID);

                $totaladd = 0;
                if(isset($modify)){
                    $totaladd = $modify->sum('amount');
                
                    $tax2 = round(($pfile->salary_rate / 2) + ($totaladd) - ($deduction->add_less_abs + $deduction->less_late), 2); 
                    $tax1 = floatval(sprintf("%.2f",$tax2 * 0.01));
                    $tax2 = floatval(sprintf("%.2f",$tax2 * 0.02));

                    Deduction::where('payroll_id', $payrollID)->update([
                        'tax1' => $tax1,
                        'tax2' => $tax2,
                    ]);
                }
            }
        }
        
        return redirect()->back()->with('success', 'Updated successfully');
        
    }
      
}

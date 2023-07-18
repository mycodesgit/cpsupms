<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Payroll Form</title>
    <style>
      /* Default table styling */
      .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
        border-collapse: collapse;
        font-size: 8.3px;
      }
      
      .table td,
      .table th {
        padding: 0.3rem;
        vertical-align: top;
        border-top: 1px solid #000408;
        font-size: 8.3px;
      }
  
      .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #000408;
      }
  
      .table tbody + tbody {
        border-top: 2px solid #000408;
      }
  
      .table-bordered {
        border: 1px solid #000408;
      }
  
      .table-bordered td,
      .table-bordered th {
        border: 1px solid #000408;
      }
  
      .table-bordered thead td,
      .table-bordered thead th {
        border-bottom-width: 2px;
      }
  
      
  
      /* Responsive table styling */
      @media screen and (orientation: landscape) {
        .table-responsive {
          height: 500px; 
        }
        
        .table {
          width: auto;
        }
        
        .table td,
        .table th {
          white-space: nowrap; 
        }
      }

      .div-signature{
       width: 50%; 
       text-align: center;
      }

      .td{
        text-align: center;
      }
  
      </style>
  </head>
  <body>
    <body>
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="table-responsive">
              @foreach($chunkedDatas as $chunk)
              <table class="table table-striped table-bordered landscape-table" style="table-layout: auto; width: 100%; max-width: none;">
                <thead>
                  <tr>
                    <th colspan="19" style="border-bottom: none;">CENTRAL PHILIPPINES STAT UNIVERSITY<br>GENERAL PAYROLL<br><br>{{$dateRangeFormatted}}</th>
                  </tr>
				          <tr>
                    <th colspan="19" style="text-align: left; border-top: none;">We acknowledge receipt of the sum shown opposite our names as full compensation for services rendered for the period stated</th>
                  </tr>
                  <tr>
                    <th>NO.</th>
                    <th>Name</th>
                    <th width="70">Position On Title</th>
                    <th>SG-Step</th>
                    <th>Monthly<br>Salary</th>
                    <th>SSL Salary <br>Differential</th>
                    <th>NBC 451 Salary <br> Differential 2023</th>
                    <th>Step <br>Increment</th>
                    <th>Less <br>Absences </th>
                    <th>Earned For <br>The Period</th>
                    <th>Total<br>GSIS<br>Deductions</th>
                    <th>Total<br>PAG-IBIG<br>Deductions</th>
                    <th>PHIL<br>HEALTH</th>
                    <th>With <br>Holding<br>Tax</th>
                    <th>Total <br>Other<br> Payables</th>
                    <th>Total <br>Overall<br> Deductions</th>
                    <th>Net<br>Ammount<br>Received</th>
                    <th>January<br>1 - 15, 2023</th>
                    <th>January<br>16 - 31, 2023</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @php 
                  $no = 1; 
                  $all_emp_salary=0;
                  $all_total_additional=0;
                  $earn_for_the_period =0;
                  $all_total_gsis_deduction=0;
                  $all_total_pugibig_deduction=0;
                  $all_total_payables=0;
                  $all_total_deduct=0;

                  $all_total_philhealth=0;
                  $all_total_withholdingtax=0;
                  @endphp

                  {{-- sum foreaach --}}
                  @foreach($chunk as $sum)
                    @php 
                      $all_emp_salary += $sum->emp_salary;

                      $all_total_additional += $sum->add_sal_diff + $sum->add_nbc_diff + $sum->add_step_incre;
                      
                      $earn_for_the_period += $sum->add_sal_diff + $sum->add_nbc_diff + $sum->add_step_incre + $all_emp_salary;

                      $all_total_gsis_deduction += $sum->eml + $sum->pol_gfal + $sum->consol + $sum->ed_asst_mpl + $sum->loan + $sum->rlip;
                    
                      $all_total_pugibig_deduction += $sum->mpl + $sum->prem;

                      $all_total_payables += $sum->lbp + $sum->cauyan + $sum->projects + $sum->nsca_mpc + $sum->med_deduction
                      + $sum->grad_guarantor + $sum->cfi + $sum->csb + $sum->fasfeed + $sum->dis_unliquidated; 

                      $all_total_deduct += $sum->eml + $sum->pol_gfal + $sum->consol + $sum->ed_asst_mpl + $sum->loan + $sum->rlip 
                      + $sum->mpl + $sum->prem + $sum->philhealth + $sum->holding_tax + $sum->lbp + $sum->cauyan + $sum->projects + $sum->nsca_mpc + $sum->med_deduction
                      + $sum->grad_guarantor + $sum->cfi + $sum->csb + $sum->fasfeed + $sum->dis_unliquidated; 

                      $all_total_philhealth += $sum->philhealth;
                      $all_total_withholdingtax += $sum->holding_tax;
                    @endphp
                  @endforeach
                  {{-- sum foreaach end --}}

                  @foreach($chunk as $data)
                  <tr>
                    @php 
                    $total_additional = floatval(sprintf("%.2f", $data->add_sal_diff + $data->add_nbc_diff + $data->add_step_incre, 2));
                    
                    $total_gsis_deduction = floatval(sprintf("%.2f", $data->eml + $data->pol_gfal + $data->consol + $data->ed_asst_mpl + $data->loan + $data->rlip, 2));
                    
                    $total_pugibig_deduction = floatval(sprintf("%.2f", $data->mpl + $data->prem, 2));

                    $total_other_payables = floatval(sprintf("%.2f", $data->lbp + $data->projects + $data->nsca_mpc + $data->grad_guarantor + $data->cfi + $data->fasfeed, 2));
                    
                    $total_deduct_other = floatval(sprintf("%.2f",$data->lbp + $data->cauyan + $data->projects + $data->nsca_mpc + $data->med_deduction
                    + $data->grad_guarantor + $data->cfi + $data->csb + $data->fasfeed + $data->dis_unliquidated, 2)); 

                    $total_deduction = floatval(sprintf("%.2f",$data->eml + $data->pol_gfal + $data->consol + $data->ed_asst_mpl + $data->loan + $data->rlip 
                    + $data->mpl + $data->prem + $data->philhealth + $data->holding_tax + $data->lbp + $data->cauyan + $data->projects + $data->nsca_mpc + $data->med_deduction
                    + $data->grad_guarantor + $data->cfi + $data->csb + $data->fasfeed + $data->dis_unliquidated, 2)); 
                    @endphp
                    <td>{{ $no++ }}</td>
                    <td>{{ $data->lname }} {{ $data->fname }}</td>
                    <td>{{ $data->position }}</td>
                    <td></td>
                    <td>{{ number_format($data->emp_salary, 2) }}</td>
                    <td>{{ number_format($data->add_sal_diff, 2) }}</td>
                    <td>{{ number_format($data->add_nbc_diff, 2) }}</td>
                    <td>{{ number_format($data->add_step_incre, 2) }}</td>
                    <td>{{ number_format($data->add_less_abs, 2) }}</td>
                    <td>{{ number_format($total_additional + $data->emp_salary - $data->add_less_abs, 2) }}</td>
                    <td>{{ number_format($total_gsis_deduction, 2)}}</td>
                    <td>{{ number_format($total_pugibig_deduction, 2) }}</td>
                    <td>{{ number_format($data->philhealth, 2) }}</td>
                    <td>{{ number_format($data->holding_tax, 2) }}</td>

                    <td>{{ number_format($total_other_payables, 2); }}</td>

                    <td>{{ number_format($total_deduction, 2); }}</td>
                    <td>{{ number_format($data->emp_salary + $total_additional - $total_deduction, 2); }}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($earn_for_the_period, 2) }}</td>
                    <td>{{ number_format($all_total_gsis_deduction, 2) }}</td>
                    <td>{{ number_format($all_total_pugibig_deduction, 2) }}</td>
                    <td>{{ number_format($all_total_philhealth, 2) }}</td>
                    <td>{{ number_format($all_total_withholdingtax, 2) }}</td>
                    <td>{{ number_format($all_total_payables, 2) }}</td>
                    <td>{{ number_format($all_total_deduct, 2) }}</td>
                    <td>{{ number_format($all_emp_salary + $all_total_additional - $all_total_deduct, 2) }}</td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              @endforeach
              <table class="table table-striped table-bordered landscape-table" style="table-layout: auto; width: 100%; max-width: none;">
                <tbody class="last-page">
                  <tr>
                    <td colspan="4" style="border-right: ;">
                      <div>CERTIFIED CORRECT: Services have been duly rendered as stated.</div><br><br>
                      <div class="div-signature">FREIA  L. VARGAS, Ph.D.</div>
                      <div class="div-signature">Adminstrative Officer V. HRMO III</div><br>
                      <div>NOTED: </div><br>
                      <div class="div-signature">HENRY C. BOLINAS, Ph.D.</div>
                      <div class="div-signature">Chief Administartive Officer</div><br>
                      <div >CERTIFIED: Funds available in the amount of P</div><br><br>
                      <div class="div-signature">ELFRED M. SUMONGSONG, CPA</div>
                      <div class="div-signature">Accountant III</div><br>
                      <div >PREPARED BY:</div><br>
                      <div class="div-signature">CHRISTINE V. TAGUBILIN</div>
                      <div class="div-signature">Admin Aide III-Payroll In-Charge</div><br>
                    </td>
                    <td colspan="3" style="border-left: ; text-align: center;">
                      <br><div><strong>RECAPITULATION</strong></div><br>
                      @foreach($code as $c)
                      @if($c->status == "on") {{ $c->code }} @endif<br>
                      @endforeach
                    </td>
                    <td style="border-right:;"></td>
                    <td colspan="3" style="border-left:;">
                        <br><div><strong>Salaries & Wedges - Civilian</strong></div><br>
                        @foreach($code as $c)
                        @if($c->status == "on") {{ $c->code_name }} @endif<br>
                        @endforeach
                    </td>    
                    <td colspan="4">
                        <br><div><strong>Salaries & Wedges - Civilian</strong></div><br>
                        @foreach($code as $c)
                        @if($c->status == "on") {{ $c->code_name }} @endif<br>
                        @endforeach
                    </td>
                    <td colspan="6">
                      <div>Approved for Payment:</div><br><br><br><br>
                      <div class="div-signature" style="width: 100%;">ALADINO C. MORACA, Ph.D.</div>
                      <div class="div-signature" style="width: 100%;">SUC President II</div><br><br><br>
                      <div>CERTIFIED: That each employee whose name appears above has been paid the amount indicated through direct<br><span style="margin-left: 53px;">credit to their respective accounts.</span></div><br><br><br><br>
                      <div style="width: 100%;">
                        <div style="float: left; width: 50%; text-align: center;">
                          <div> ERNIE C. ONGAO</div>
                          <div>Administrative Officer I/Cashier Designate</div><br>
                        </div>
                        <div style="float: left; width: 50%; text-align: center;">
                          <div>________________</div>
                          <div>Date</div>
                        </div>
                      </div>
                    </td>               
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>    
    </body>    
  </body>
</html>


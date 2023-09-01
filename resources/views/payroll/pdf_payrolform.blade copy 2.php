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
              @if ($pid == 2)
                @php
                    $refTotal = array_fill_keys(['Project', 'Net_MPC', 'Graduate', 'Philhealth', 'Pag_ibig', 'Gsis', 'Csb'], 0);
                    $dedTotal = array_fill_keys(['Project', 'Net_MPC', 'Graduate', 'Philhealth', 'Pag_ibig', 'Gsis', 'Csb'], 0);
                @endphp
        
                @foreach ($modifyref1 as $mody)
                    @if ($mody->action == 'Refund' && array_key_exists($mody->column, $refTotal))
                        @php
                            $refTotal[$mody->column] += $mody->amount;
                            $refTotal[$mody->column] = ($refTotal[$mody->column] >= 1) ? 1 : 0;
                        @endphp
                    @endif
                @endforeach

                @foreach ($modifyded1 as $mody)
                    @if ($mody->action == 'Deduction' && array_key_exists($mody->column, $dedTotal))
                        @php
                            $dedTotal[$mody->column] += $mody->amount;
                            $dedTotal[$mody->column] = ($dedTotal[$mody->column] >= 1) ? 1 : 0;
                        @endphp
                    @endif
                @endforeach
              @endif
        
              <table class="table table-striped table-bordered landscape-table" style="table-layout: auto; width: 100%; max-width: none;">
                <thead>
                  <tr>
                    <th colspan="{{ $pid == 1 ? 15 : 15 + array_sum($refTotal) + array_sum($dedTotal) }}" style="border-bottom: none;">CENTRAL PHILIPPINES STAT UNIVERSITY<br>GENERAL PAYROLL<br><br>{{$pid == 1 ? $firstHalf : $secondHalf}}</th>
                  </tr>
				          <tr>
                    <th colspan="{{ $pid == 1 ? 15 : 15 + array_sum($refTotal) + array_sum($dedTotal) }}" style="text-align: left; border-top: none;">We acknowledge receipt of the sum shown opposite our names as full compensation for services rendered for the period stated</th>
                  </tr>
                  @if ($pid == 2)
                    <tr>
                    <th colspan="{{ $pid == 1 ? 8 : 8 }}"></th>
                        @if(array_sum($refTotal) > 0)<th colspan="{{ $pid == 2 ? array_sum($refTotal) : '' }}">Refund</th>@endif
                        <th colspan="2"></th>
                        @if(array_sum($dedTotal) > 0)<th colspan="{{ $pid == 2 ? array_sum($dedTotal) : '' }}">Deduction</th>@endif
                        <th colspan="4"></th>
                    </tr>
                  @endif
                    <th>NO.</th>
                    <th>Name</th>
                    <th width="70">Designation</th>
                    <th>Gross Income</th>
                    @php
                        $content = $pid == 1 ? $firstHalf : $secondHalf;
                        $formattedContent = preg_replace('/(January|February|March|April|May|June|July|August|September|October|November|December)/', '$1<br>', $content);
                    @endphp
                    <th>Deduction <br>Absent</th>
                    <th>Deduction <br>Late</th>
                      @if ($pid == 2)
                        @php
                            $refTotals = [
                                'Project' => 0,
                                'Net_MPC' => 0,
                                'Graduate' => 0,
                                'Philhealth' => 0,
                                'Pag_ibig' => 0,
                                'Gsis' => 0,
                                'Csb' => 0,
                            ];
                        @endphp
                    
                        @foreach ($modify1 as $mody)
                            @if ($mody->action === 'Refund' && array_key_exists($mody->column, $refTotals))
                                @php
                                    $refTotals[$mody->column] += $mody->amount; 
                                @endphp
                            @endif
                        @endforeach
                    
                        @foreach ($refTotals as $column => $total)
                            @if ($total != 0.00)
                                <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                            @endif
                        @endforeach
                    @endif
                    <th>Earned For <br>The Period</th>
                    @if ($pid == 2)
                        @php
                            $refTotals = [
                                'Project' => 0,
                                'Net_MPC' => 0,
                                'Graduate' => 0,
                                'Philhealth' => 0,
                                'Pag_ibig' => 0,
                                'Gsis' => 0,
                                'Csb' => 0,
                            ];
                        @endphp
                    
                        @foreach ($modify1 as $mody)
                            @if ($mody->action === 'Deduction' && array_key_exists($mody->column, $refTotals))
                                @php
                                    $refTotals[$mody->column] += $mody->amount; 
                                @endphp
                            @endif
                        @endforeach
                    
                        @foreach ($refTotals as $column => $total)
                            @if ($total != 0.00)
                                <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                            @endif
                        @endforeach
                    @endif
                    <th>TAX 1%</th>
                    <th>TAX 2%</th>
                    <th>NSCA MPC</th>
                    <th>Graduate <br> School</th>
                    <th>Project</th>
                    <th>Total Deductions</th>
                    <th>Net<br>Ammount<br>Received</th>
                    <th>Signature</th>
                </tr>
                </thead>
                <tbody>
                  @php
                  $no = 1;
                  $totalgrossincome = 0;
                  $totalalldeduction = 0;
                  $totalnetamout = 0;
                  $totalabsences = 0;
                  $totallate = 0;
                  $totaltax1 = 0;
                  $totaltax2 = 0;
                  $totalnsca_mpc = 0;
                  $totalprojects = 0;
                  $totalgrad_guarantor = 0;
                  $totalnetamountrec = 0;
                  $totalhalft = 0;
                  @endphp
                
                  @foreach ($chunk as $data)
                    @php
                    $saltype = $data->sal_type;

                    $absent = $data->add_less_abs;
                    $late = $data->less_late;
                    $tax1 = $data->tax1;
                    $tax2 = $data->tax2;
                    $projects = $data->projects;
                    $nsca_mpc = $data->nsca_mpc; 
                    $grad_guarantor = $data->grad_guarantor;

                    $grossincome = $data->salary_rate;
                    $total_deduction = $projects + $nsca_mpc + $grad_guarantor + $tax1 + $tax2;
                    $earnperiod = $grossincome - $absent - $late;
                    $netamountrec = ($earnperiod / 2) - $total_deduction;

                    $totalgrossincome += $grossincome;
                    $totalalldeduction += $total_deduction;
                    $totalnetamout += $grossincome - $total_deduction;
                    $totalabsences += $absent;
                    $totallate += $late;
                    $totaltax1 += $tax1;
                    $totaltax2 += $tax2;
                    $totalnsca_mpc += $nsca_mpc;
                    $totalprojects += $projects;
                    $totalgrad_guarantor += $grad_guarantor;
                    $totalnetamountrec += $netamountrec;

                    $totalhalft += $earnperiod - $total_deduction; 

                    $rowEarnSum = 0;

                    $rowEarns = round(($earnperiod / 2) - $total_deduction, 2);
                    $decimalPoint = ($rowEarns * 100) % 100;
                    
                    if ($pid == 1) {
                      
                      $rowEarn = $rowEarns;
                    
                      $rowEarn = isset($rowEarn) ? $rowEarn : null;

                      $rowEarnsArray[] = $rowEarn === null ? '0.00' : $rowEarn;

                      $rowEarnSum = array_sum($rowEarnsArray);
                      
                      $firsthalftotal = round($rowEarnSum, 2);
                    }

                    if ($pid == 2) {
                        if($saltype == 1){
                          $rowEarns = round(($earnperiod / 2) - $total_deduction, 2);
                          $decimalPoint = ($rowEarns * 100) % 100;

                          $rowEarn = $rowEarns / 2;

                          if ($decimalPoint % 2 === 0) {
                              $rowEarn = round($rowEarn, 2);
                          } else {
                              $rowEarn = round($rowEarn, 3);
                              $rowEarn = floor($rowEarn * 100) / 100;
                          }
                        }
                        if($saltype == 3){
                          $rowEarn = $rowEarns;
                        }
                        
                        $rowEarn = isset($rowEarn) ? $rowEarn : 0.00;

                        $rowEarnsArray[] = $rowEarn === null ? '0.00' : $rowEarn;

                        $rowEarnSum = array_sum($rowEarnsArray);

                        $rowtotal = $rowEarn + $data->sumRef - $data->sumDed;
                        $secondhalftotal = round($rowEarnSum + $totalref - $totalded, 2);
                    }
                    @endphp
                    
                    @php
                    $totref = 0;
                    $totded = 0;
                    @endphp
                    
                    @foreach ($modifyref as $moref)
                        @if ($moref->payroll_id == $data->pid)
                            @php 
                              $totref += $moref->amount; 
                              $modtotref = $moref->amount; 
                            @endphp
                        @endif
                    @endforeach
                    
                    @foreach ($modifyded as $moded)
                        @if ($moded->payroll_id == $data->pid)
                            @php 
                              $totded += $moded->amount; 
                              $modtotded = $moded->amount; 
                            @endphp
                        @endif
                    @endforeach
   
                    {{-- Sub Total Columns --}}
                    @php
                    $refTotalCol = array_fill_keys(['Project', 'Net_MPC', 'Graduate', 'Philhealth', 'Pag_ibig', 'Gsis', 'Csb'], 0);
                    @endphp

                    @foreach ($modifyref1 as $mody)
                        @if ($mody->action == 'Refund' && array_key_exists($mody->column, $refTotalCol))
                            @php
                                $refTotalCol[$mody->column] += $mody->amount;
                            @endphp
                        @endif
                    @endforeach

                    @php
                    $dedTotalCol = array_fill_keys(['Project', 'Net_MPC', 'Graduate', 'Philhealth', 'Pag_ibig', 'Gsis', 'Csb'], 0);
                    @endphp

                    @foreach ($modifyded1 as $mody)
                        @if ($mody->action == 'Deduction' && array_key_exists($mody->column, $dedTotalCol))
                            @php
                                $dedTotalCol[$mody->column] += $mody->amount;
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $data->lname }} {{ $data->fname }}</td>
                      <td>{{ $data->emp_pos }}</td>
                      <td>{{ number_format($grossincome, 2) }}</td>
                      <td>{{ number_format($data->add_less_abs, 2) }}</td>
                      <td>{{ number_format($data->less_late, 2) }}</td>
                      <td>{{ number_format($earnperiod, 2) }}</td>
                      <td>{{ number_format($tax1, 2) }}</td>
                      <td>{{ number_format($data->add_less_abs, 2) }}</td>
                      <td>{{ number_format($data->nsca_mpc, 2) }}</td>
                      @if ($pid == 2)
                        @php
                        $dedTotals = [
                            'Project' => 0,
                            'Net_MPC' => 0,
                            'Graduate' => 0,
                            'Philhealth' => 0,
                            'Pag_ibig' => 0,
                            'Gsis' => 0,
                            'Csb' => 0
                        ];
                        $totalDeductionAmount = 0; // Initialize the total deduction amount
                        @endphp
                        
                        @foreach ($modifyded as $mody)
                            @if ($mody->pay_id == $data->payroll_ID && $mody->action == 'Deduction' && array_key_exists($mody->column, $dedTotals))
                                @php
                                    $dedTotals[$mody->column] += $mody->amount;
                                @endphp
                            @endif
                        @endforeach
                        
                        @foreach ($modifyded1 as $mody)
                            @if ($mody->action == 'Deduction' && array_key_exists($mody->column, $dedTotals))
                                @php
                                    $dedTotals[$mody->column] += $mody->amount;
                                @endphp
                            @endif
                        @endforeach
                        
                        @foreach ($modify as $mody)
                            @if ($mody->payroll_id == $data->pid && array_key_exists($mody->column, $dedTotals))
                                @php
                                    $dedTotalAmount = $dedTotals[$mody->column];
                                @endphp
                                @if ($dedTotalAmount != 0.00)
                                    <td>{{ $mody->action === 'Deduction' ? number_format($mody->amount, 2) : '0.00' }}</td>
                                    @if ($mody->action === 'Deduction')
                                        @php
                                            $totalDeductionAmount += $mody->amount; // Add the deduction amount to the total
                                        @endphp
                                    @endif
                                @endif
                            @endif
                        @endforeach
                  
                      @endif
                      <td>{{ $pid == 1 ? number_format($grad_guarantor, 2) : 0 }}</td>
                      <td>{{ $pid == 1 ? number_format($projects, 2) : 0 }}</td>
                      <td>{{ $pid == 1 ? number_format($total_deduction, 2) : 0 }}</td>
                      <td>{{ $pid == 1 ? number_format($rowEarn, 2) : 0 }}</td>
                      <td></td>
                      </tr>
                  @endforeach 
                </tbody>   
                <tfoot>
                  <tr>
                    <td colspan="3"></td>
                    <td>{{ number_format($totalgrossincome,2) }}</td>
                    <td>{{ number_format($totalabsences,2) }}</td>
                    <td>{{ number_format($totallate,2) }}</td>
                    <td>{{ number_format($totalnetamountrec,2)}}</td>
                    <td>{{ number_format($totaltax1,2)}}</td>
                    <td>{{ number_format($totaltax2,2) }}</td>
                    <td>{{ number_format($totalnsca_mpc,2) }}</td>
                    <td>{{ number_format($totalgrad_guarantor,2) }}</td>
                    <td>{{ number_format($totalprojects,2) }}</td>
                    <td>{{ number_format($totalalldeduction,2) }}</td>
                    <td>{{ $pid == 1 ? number_format($firsthalftotal, 2) : number_format($secondhalftotal, 2) }}</td>
                    <td></td>  
                  </tr>  
                </tfoot>         
              @endforeach
              </table>
              <table class="table table-striped table-bordered landscape-table" style="table-layout: auto; width: 100%; max-width: none;">
                <tbody class="last-page">
                  <tr>
                    <td colspan="7"></td>
                    <td colspan="2" style="text-align: center;">RECAPITULATION</td>
                    <td style="text-align: center;">Debit</td>
                    <td style="text-align: center;">Credit</td>
                    <td colspan="6"></td>
                  </tr>
                  <tr>
                    <td colspan="7">
                      <div>CERTIFIED CORRECT: Services have been duly rendered as stated.</div><br><br>
                      <div class="div-signature" style="width: 60%;"><strong>FREIA  L. VARGAS, Ph.D.</strong></div>
                      <div class="div-signature" style="width: 60%;">Adminstrative Officer V. HRMO III</div><br>
                      <div>NOTED: </div><br>
                      <div class="div-signature" style="width: 60%;"><strong>HENRY c. BOLINAS, Ph.D.</strong></div>
                      <div class="div-signature" style="width: 60%;">Chief Administartive Officer</div><br>
                      <div style="width: 30%;" style="width: 60%;">CERTIFIED: Funds available in the amount of P</div><br><br>
                      <div class="div-signature" style="width: 60%;"><strong>ELFRED M. SUMONGSONG, CPA</strong></div>
                      <div class="div-signature" style="width: 60%;">Accountant III</div><br>
                      <div style="width: 25%;" style="width: 60%;">PREPARED BY:</div><br>
                      <div class="div-signature" style="width: 60%;"><strong>CHRISTINE V. TAGUBILIN</strong></div>
                      <div class="div-signature" style="width: 60%;">Admin Aide III-Payroll In-Charge</div><br>
                    </td>
                    <td>
                      <div style="width:100%; text-align: left; float: right;">
                        @foreach($code as $c)
                        @if($c->status == "on") {{ $c->code_name }} @endif<br>
                        @endforeach
                      </div>
                    </td>
                    <td>
                      <div style="width:100%; text-align: left; float: left;">
                        @foreach($code as $c)
                          @if($c->status == "on") {{ $c->code}} @endif<br>
                        @endforeach
                      </div>
                    </td>     
                    <td></td>
                    <td></td>
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
</html>


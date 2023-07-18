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
        font-size:9px;
      }
  
      .table td,
      .table th {
        padding: 0.3rem;
        vertical-align: top;
        border-top: 1px solid #000408;
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
       width: 25%; 
       text-align: center;
      }

      .td{
        text-align: center;
      }
  
      </style>
  </head>
  <body>
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="table-responsive">
            @foreach($chunkedDatas as $chunk)
              <table class="table table-striped table-bordered landscape-table" style="table-layout: auto; width: 100%; max-width: none;">
                <thead>
                  <tr>
                    <th colspan="17" style="border-bottom: none;">CENTRAL PHILIPPINES STAT UNIVERSITY<br>GENERAL PAYROLL<br><br>PART-TIME LOAD<br>For the period of {{$dateRangeFormatted}}</th>
                  </tr>
				          <tr>
                    <th colspan="17" style="text-align: left; border-top: none;">We acknowledge receipt of the sum shown opposite our names as full compensation for services rendered for the period stated</th>
                  </tr>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>No. of<br>working<br> days</th>
                    <th>Rate per<br> day</th>
                    <th>No. of<br> hours</th>
                    <th>No. per<br> hour</th>
                    <th>Full time<br> Load</th>
                    <th>Earned for <br>the period</th>
                    <th>NSCA MPC</th>
                    <th>PROJECT</th>
                    <th>Graduate<br> School</th>
                    <th>tax(1%)</th>
                    <th>tax(2%)</th>
                    <th>Total<br>Deduction</th>
                    <th>Net Amount<br>Received</th>
                    <th>SIGNATURE</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @php 
                    $no = 1; 
                    $totalSalary=0;
                    $totaltax1=0;
                    $totaltax2=0;
                  @endphp

                  {{-- sum foreaach --}}
                  @foreach($chunk as $sum)
                    @php 
                      $totalSalary += $sum->total_salary;  
                      $totaltax1 += $sum->tax1; 
                      $totaltax2 += $sum->tax2; 
                    @endphp
                    
                  @endforeach
                  {{-- sum foreaach end --}}

                  @foreach($chunk as $data)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td><span hidden>{{ $data->lname }}</span>{{ $data->lname }} {{ $data->fname }}</td>
                    <td>{{ $data->position }}</td>
                    <td class="td">{{ $data->number_days }}</td>
                    <td class="td">{{ $data->emp_salary }}</td>
                    <td class="td">{{ $data->number_hours }}</td>
                    <td></td>
                    <td></td>
                    <td class="td">{{ number_format($data->total_salary, 2) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="td">{{ number_format($data->tax1, 2) }}</td>
                    <td class="td">{{ number_format($data->tax2, 2) }}</td>
                    <td class="td">{{ number_format($data->tax1+$data->tax2, 2) }}</td>
                    <td class="td">{{ number_format($data->total_salary - $data->tax1 - $data->tax2, 2) }}</td>
                    <td></td>
                  </tr>
                  @endforeach
                  <tr>
                    <td colspan="7"></td>
                    <td></td>
                    <td class="td">{{ number_format($totalSalary, 2) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="td">{{ number_format($totaltax1, 2) }}</td>
                    <td class="td">{{ number_format($totaltax2, 2) }}</td>
                    <td class="td">{{ number_format($totaltax1 + $totaltax2, 2) }}</td>
                    <td class="td">{{ number_format($totalSalary - $totaltax1 - $totaltax2, 2) }}</td>
                    <td></td>
                  </tr>
                </tbody>
          
              </table>
              @if(!$loop->last && ($loop->iteration % 10 == 0))
                  <div class="page-break"></div>
              @endif
              @endforeach
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


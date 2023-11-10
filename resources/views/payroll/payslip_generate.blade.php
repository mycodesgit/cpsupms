<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Pay Slip Form</title>
  <style>
    body {
      font-size: 9px;
      display: none;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .col-quarter {
      width: 100%;
      box-sizing: border-box;
      padding: 0 5px;
    }

    .table {
      width: 100%;
      max-width: 100%;
      margin-bottom: 1rem;
      background-color: transparent;
      border-collapse: collapse;
      font-family: calibri;
      border: 2px solid black;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

  </style>
</head>
<body>
@php
$payslipsPerPage = 4;
$payslipCount = count($payslip);
$totalPages = ceil($payslipCount / $payslipsPerPage);
@endphp

@for ($page = 1; $page <= $totalPages; $page++)
  <div class="container">
    @php
    $startIndex = ($page - 1) * $payslipsPerPage;
    $endIndex = min($startIndex + $payslipsPerPage, $payslipCount);

    @endphp

    @for ($i = $startIndex; $i < $endIndex; $i++)
      <div class="col-quarter">
        <table>
          <th>
          
          <table class="table table-striped table-bordered landscape-table" style="table-layout: auto; width: 100%; max-width: none;">

            <!-- Iterate through each payslip in the current chunk -->
            @php
            $pay = $payslip[$i];
            $dateTime = new DateTime($pay->payroll_dateStart);
            $formattedDate = $dateTime->format('M, Y');
            @endphp
              <thead>
              <tr>
                <th colspan="4" style="border-bottom: none;">Republic of the Philippines<br>CENTRAL PHILIPPINES STATE UNIVERSITY<br>Kabankalan City, Negros Occidental </th>
              </tr>
              <tr>
                <th colspan="4" style="border-top: none; border-bottom: none;"><span style="font-size: 18px; font-weight: 800px; font">PAY SLIP</span><br>For the month of {{ $formattedDate }}</th>
              </tr>
              <tr>
                <th colspan="4" style="border-top: none; border-bottom: none;"><span style="float: left;">{{ $pay->lname }} {{ $pay->fname }} {{ $pay->mname }}</span><br></th>
              </tr>
              <tr>
                <th colspan="4" style="border-top: none; border-bottom: none;">
                  <span style="float: left;">Basic Monthly&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>SSL 4 Differential<br>Less: Deductions&nbsp;&nbsp;</span><span style="float: right;">{{ number_format($pay->salary_rate + $pay->add_sal_diff + $pay->add_nbc_diff + $pay->add_step_diff, 2) }}</span>
                </th>
              </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="3" width="25%"></td>
                  <td width="25%" style="color: white;">.</td>
                </tr>
                <tr>
                  <td colspan="3" width="25%"></td>
                  <td width="25%" style="color: white;">.</td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%"></td>
                  <td width="25%"></td>
                  <td width="25%" style="color: white;">.</td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GSIS OULI</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GSIS Cash Advance</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GSIS Emergency Loan</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GSIS Policy Loan</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->pol_gfal, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GSIS CONSOL</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->consol, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GSIS HIP/CEAP</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->csb, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GSIS Educ. Asst</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->ed_asst_mpl, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GSIS RLIP</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->rlip, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">Disallowance</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->dis_unliquidated, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">Pag-IBIG Premium</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->prem, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">Pag-IBIG MPL</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->mpl, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">Withholding Tax</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->holding_tax, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">PhilHealth</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->philhealth, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">Medical</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->medical_deduction, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">CSB</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->csb, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">LBP</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->lbp, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">Projects</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->projects, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">FASFED</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->fasfeed, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">NSCA MPC</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->nsca_mpc, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">CFI</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->cfi, 2) }}</td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td width="25%">GRAD SCH/GUAR.</td>
                  <td width="25%" style="border-bottom: 1px solid #97a8b9;">{{ number_format($pay->grad_guarantor, 2) }}</td>
                  <td width="25%"></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td width="25%" style="font-weight: 800px;"><strong>TOTAL DEDUCTIONS</strong></td>
                  <td width="25%"></td>
                  <td width="25%"></td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%" style="font-weight: 800px;"><strong>NET TAKE HOME PAY</strong></td>
                  <td width="25%"></td>
                  <td width="25%"></td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td colspan="3" style="text-align: right;">Certified Corret:</td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: center;">PAYROLL IN-CHARGE</td>
                </tr>
              </tfoot>
          </table>
          </th>
          <th>
    
          </th>
        </table>
      </div>
    @endfor
  </div>

  @if ($page < $totalPages)
    <!-- Add page break after each page -->
    <div style="page-break-after: always;"></div>
  @endif
@endfor
</body>
</html>

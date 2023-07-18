<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Pay Slip Form</title>
  <style>
    body {
      font-size: 10px;
      display: none;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .col-quarter {
      width: 50%;
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

    @media (max-width: 768px) {
      .col-quarter {
        width: 50%;
      }
      body{
        display: block;
      }
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
        <table class="table table-striped table-bordered landscape-table" style="table-layout: auto; width: 100%; max-width: none;">
          <!-- Iterate through each payslip in the current chunk -->
          @php
          $pay = $payslip[$i];
          @endphp
            <thead>
            <tr>
              <th colspan="4" style="border-bottom: none;">Republic of the Philippines<br>CENTRAL PHILIPPINES STATE UNIVERSITY<br>Kabankalan City, Negros Occidental </th>
            </tr>
            <tr>
              <th colspan="4" style="border-top: none; border-bottom: none;"><span style="font-size: 18px; font-weight: 800px; font">PAY SLIP</span><br>For the month of june 2023</th>
            </tr>
            <tr>
              <th colspan="4" style="border-top: none; border-bottom: none;"><span style="float: left;">Basic Monthly&emsp;&nbsp;<br>SSL 4 Differential<br>Less: Deductions</span><span style="float: right;">167,254.00</span></th>
            </tr>
            </thead>
            <tbody>
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
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">GSIS CONSOL</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">GSIS HIP/CEAP</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">GSIS Educ. Asst</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">GSIS RLIP</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">Disallowance</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">Pag-IBIG Premium</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">Pag-IBIG MPL</td>
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
                <td width="25%">Withholding Tax</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">PhilHealth</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">Medical</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">CSB</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">LBP</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">Projects</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">FASFED</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">NSCA MPC</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">CFI</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">GRAD</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"></td>
                <td width="25%">SCH/GUARANTOR</td>
                <td width="25%" style="border-bottom: 1px solid #97a8b9;"></td>
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
<script>
  window.print();

  window.onafterprint = function() {
    window.close(); // Close the window after printing or when print dialog is closed
  };
</script>

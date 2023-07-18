@extends('layouts.master')

@section('body')
<div class="container-fluid">
    <div class="row" style="padding-top: 100px;">
        <div class="col-lg-12">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="card-title">
                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-importPayrollsTwo">
                                    <i class="fas fa-plus"></i> Add New
                                </button>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-codes">
                                    <i class="fas fa-plus"></i> Code
                                </button>
                                <a id="open-pdf"  href="{{ route('pdf', [$payrollID, $statID]) }}" target="_blank" class="btn btn-info btn-sm">
                                    <i class="fas fa-print"></i> Print Payroll
                                </a>
                            </h3>
                        </div>
                        <div class="col-md-8">
                            <ol class="breadcrumb float-md-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Payroll</li>
                                @foreach($currentcamp as $c)
                                    @php
                                        $encryptedId = encrypt($c->id);
                                    @endphp
                                    <li class="breadcrumb-item"><a href="{{ route('viewPayroll', $encryptedId) }}">{{ $c->campus_abbr }}</a></li>
                                @endforeach
                                <li class="breadcrumb-item active">{{ $empStat }} Payroll</li>
                            </ol>                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-y: auto;
                        overflow-x: auto; ">
                        <table id="example1" class="table table-bordered table-hover table-pay">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Biometric ID</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    @if($empStat == "Job Order" || $empStat == "Part-time")
                                        <th>Rate per day</th>
                                    @elseif($empStat == "Regular")
                                        <th>Monthly Salary</th>
                                    @endif
                                    <th>Rate per Hour</th>
                                    <th>No. of Hours</th>
                                    <th>Earn for the period</th>
                                    @if($empStat == "Job Order" || $empStat == "Part-time" || $empStat == "Part-time/JO")
                                    
                                    <th>Tax (1%)</th>
                                        <th>Tax (2%)</th>
                                    @else
                                        <th>Total Additionals</th>
                                        <th>Total Deduction</th>
                                    @endif
                                    <th>Net amount Received</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @foreach ($pfiles as $p)
                                    @php 
                                        $total_add = floatval(sprintf("%.2f",$p->add_sal_diff + $p->add_nbc_diff + $p->add_step_incre, 2)); 
                                        
                                        $total_deduct = floatval(sprintf("%.2f",$p->eml + $p->pol_gfal + $p->consol + $p->ed_asst_mpl + $p->loan + $p->rlip + $p->gfal + $p->computer 
                                        + $p->mpl + $p->prem + $p->philhealth + $p->holding_tax + $p->lbp + $p->cauyan + $p->projects + $p->nsca_mpc + $p->med_deduction
                                        + $p->grad_guarantor + $p->cfi + $p->csb + $p->fasfeed + $p->dis_unliquidated + $p->add_less_abs, 2));

                                        $Rrate_per_day = $p->salary_rate / $days;
                                        $Rrate_per_hour = $Rrate_per_day / 8;
                                        $Ramount = $Rrate_per_hour * $p->number_hours;
                                        
                                        $Jrate_per_hour = $p->salary_rate / 8;

                                        $RamountReg = $p->salary_rate + $total_add - $p->add_less_abs;
                                    @endphp
                                    <tr id="tr-data" class="tr-data tr-{{ $p->pid }}">
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $p->emp_id }}</td>
                                        <td>{{ $p->lname }} {{ $p->fname }} {{ $p->mname }}</td>
                                        <td>{{ $p->position }}</td>
                                        <td>{{ number_format($p->salary_rate, 2) }}</td>
                                        @if($empStat == "Job Order" || $empStat == "Part-time" || $empStat == "Part-time/JO")
                                            @if($empStat != "Part-time/JO")
                                            <td>{{ number_format($Jrate_per_hour, 2) }}</td>
                                            @endif
                                            <td>{{ number_format($p->number_hours, 2) }}</td>
                                            <td class="text-danger">{{ number_format($p->total_salary, 2) }}</td>
                                            <td>{{ $p->tax1 }}</td>
                                            <td id="tax2-{{ $p->pid }}">{{ number_format($p->tax2, 2) }}</td>
                                        @else
                                            <td>{{ number_format($Rrate_per_hour, 2) }}</td>
                                            <td>{{ number_format($p->number_hours, 2) }}</td>
                                            <td class="text-danger">{{ number_format($RamountReg, 2) }}</td>
                                            <td id="addition-{{ $p->pid }}">{{ number_format($total_add, 2); }}</td>
                                            <td id="deduct-{{ $p->pid }}">{{ number_format($total_deduct, 2); }}</td>
                                        @endif
                                        @if($empStat == "Job Order" || $empStat == "Part-time" || $empStat == "Part-time/JO")
                                            <td id="net-{{ $p->pid }}" class="text-danger">{{ number_format($p->total_salary - $p->tax1 - $p->tax2, 2) }}</td>
                                        @else
                                            <td id="net-{{ $p->pid }}" class="text-danger">{{ number_format($Ramount + $total_add - $total_deduct, 2) }}</td>
                                        @endif
                                        <td>
                                        @if($empStat == "Regular")
                                            <button value="{{ $p->pid }}" type="button" class="btn btn-info btn-sm additional" title="additionals">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                         @endif
                                            <button value="{{ $p->pid }}" type="button" class="btn btn-info btn-sm deductions" title="deductions">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </button>
                                            <button value="{{ $p->pid }}" type='button' class='btn btn-danger btn-sm deletePayrollFiles'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@include('payroll.modals')
<!-- /End Modal -->
@endsection
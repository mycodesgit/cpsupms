@php $curr_route = request()->route()->getName(); @endphp
<script>
    function start(val){
        document.getElementById("dateEnd").value="";
        document.getElementById("dateEnd").setAttribute("min", val); 
    }
    
    function calculateDays() {
        const stat = document.getElementById("stat-name").value;
        const inputDateStart = document.getElementById("dateStart").value;
        const inputDateEnd = document.getElementById("dateEnd").value;

        const date1 = new Date(inputDateStart);
        const date2 = new Date(inputDateEnd);

        // Calculate the number of days between the two dates
        const millisecondsPerDay = 1000 * 60 * 60 * 24; // number of milliseconds in one day
        const timeDiff = Math.abs(date2.getTime() - date1.getTime());
        const numDays = Math.ceil(timeDiff / millisecondsPerDay); // round up to include both start and end dates

        let numWeekdays = 0;
        for (let i = 0; i < numDays; i++) {
            const currentDate = new Date(date1.getTime() + i * millisecondsPerDay);
            if (currentDate.getDay() !== 0 && currentDate.getDay() !== 6) { // 0 is Sunday, 6 is Saturday
                numWeekdays++;
            }
        }

        const totalDays = numDays;
        // console.log(date1.toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' }), date2.toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' })); // Output: "March 09, 2023", "March 15, 2023"
        // console.log(totalDays); // includes weekends
        var regular = totalDays + 1;
        if(inputDateStart != "" && inputDateEnd != ""){
            if(stat == "1"){
                document.getElementById("working-days").value=regular;
            }
            else{
                document.getElementById("working-days").value=numWeekdays;
            }
        }
    }


    $(".add-formpayroll").submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        
        $.ajax({
            type:"POST",
            url:"{{ route('createPayroll') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){
                 console.log(response);
                if(response.status == 200){
                    $('.add-formpayroll')[0].reset();
                    $('#modal-addpayroll').modal('hide');
                    toastr.options = {
                         "closeButton":true,
                         "progressBar":true,
                        'positionClass': 'toast-bottom-right',
                    }
                    toastr.success("Successfully Added");
                    // $('.tablepayroll').DataTable().ajax.reload();
                    console.log(response);
                    setInterval(function () {
                        location.reload();
                    }, 2000);
                }
                if(response.status == 400){
                    $.each(response.error, function (prefix, val) { 
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                }
            }
        });
    });
    
    //Delete
    $(document).on('click', '.payroll-delete', function(e){
        var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    type: "GET",
                    url: "{{ route('deletePayroll', ':id') }}".replace(':id', id),
                    success: function (response) {  
                        $("#tr-"+id).fadeOut(1000);
                        Swal.fire({
                        title:'Deleted!',
                        text:'Your file has been deleted.',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 1000
                        });
                    }
                });
            }
        })
    });

    $(document).on('click', '.deletePayrollFiles', function(e){
        var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    type: "GET",
                    url: "{{ route('deletePayrollFiles', ':id') }}".replace(':id', id),
                    success: function (response) {  
                        $(".tr-"+id).fadeOut(1000);
                        Swal.fire({
                        title:'Deleted!',
                        text:'Your file has been deleted.',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 1000
                        });
                    }
                });
            }
        })
    });

    $(document).on('click', '.deductions, .ad', function(e) {
        e.preventDefault();
        var cat = $(this).val();
        var id = $(this).attr("id");
        var date = $(this).attr("data-date");

        const dateSpan = document.querySelector('.date-deduct');
        dateSpan.textContent = date;
        $("#payroll_id").val(id);
        
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        if(cat == 1){
            $('#modal-deductions').modal('show');
            $.ajax({
                type: "POST",
                url: "{{ route('deductions-edit') }}",
                data: {
                    id: id,
                    cat: cat
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response){
                    console.log(response);
                    if(response.status == 200){
                        var deductions = response.data;
                        $("#tax_one").val(deductions[0].tax1);
                        $("#tax_two").val(deductions[0].tax2);
                        $("#catd").val(cat);
                        $("#eml").val(deductions[0].eml);
                        $("#pol_gfal").val(deductions[0].pol_gfal);
                        $("#consol").val(deductions[0].consol);
                        $("#ed_asst_mpl").val(deductions[0].ed_asst_mpl);
                        $("#loan").val(deductions[0].loan);
                        $("#rlip").val(deductions[0].rlip);
                        $("#gfal").val(deductions[0].gfal);
                        $("#mpl").val(deductions[0].mpl);
                        $("#computer").val(deductions[0].computer);
                        $("#prem").val(deductions[0].prem);
                        $("#calam_loan").val(deductions[0].calam_loan);
                        $("#mp2").val(deductions[0].mp2);
                        $("#philhealth").val(deductions[0].philhealth);
                        $("#holding_tax").val(deductions[0].holding_tax);
                        $("#lbp").val(deductions[0].lbp);
                        $("#cauyan").val(deductions[0].cauyan);
                        $("#projects").val(deductions[0].projects);
                        $("#nsca_mpc").val(deductions[0].nsca_mpc);
                        $("#med_deduction").val(deductions[0].med_deduction);
                        $("#grad_guarantor").val(deductions[0].grad_guarantor);
                        $("#cfi").val(deductions[0].cfi);
                        $("#csb").val(deductions[0].csb);
                        $("#fasfeed").val(deductions[0].fasfeed);
                        $("#dis_unliquidated").val(deductions[0].dis_unliquidated);
                        $("#add_less_abs").val(deductions[0].add_less_abs);
                        $("#less_late").val(deductions[0].less_late);
                    }
                    
                }
            });
        }
        if(cat == 2){
            $('#modal-modification').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ route('modifyShow', ':id') }}".replace(':id', id),
                success: function(response) {
                    $('.form-row.modify-show').empty();
                    response.data.forEach(function(mody) {

                        var formElement = `
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-clipboard"></i>
                                        </span>
                                    </div>
                                    <input type="hidden" name="id" id="id" value="${mody.payroll_id}">
                                    <input type="text" name="${mody.column}" step="any" min="0" value="${mody.column}" class="form-control float-right" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group text-center custom-input-group">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn ${mody.action === 'Refund' ? 'active' : ''}" onclick="toggleActive(1)">
                                            <input type="radio" style="padding-left: 4px;" name="${mody.column}_action" id="option_b${mody.id}" value="Refund" ${mody.action === 'Refund' ? 'checked' : ''}> &emsp;&emsp;Refund &emsp;&emsp;
                                        </label>
                                        <label class="btn ${mody.action === 'Deduction' ? 'active' : ''}" onclick="toggleActive(2)">
                                            <input type="radio" name="${mody.column}_action" id="option_b${mody.id}" value="Deduction" autocomplete="off" ${mody.action === 'Deduction' ? 'checked' : ''}> &emsp;Deduction&emsp;
                                        </label>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-clipboard"></i>
                                        </span>
                                    </div>
                                    <input type="number" id="add_step_incre" name="${mody.column}_amount" step="any" min="0" onchange="if (this.value <= 0) {this.value = '0.00';}" value="${mody.amount}" class="form-control float-right">
                                </div>
                            </div>
                        `;

                        $('.form-row.modify-show').append(formElement);
                    });
                }
            });

        }

    });

    $(document).on('click', '.additional', function(e){    
        e.preventDefault();
        var cat = $(this).val();
        var id = $(this).attr("id");
        var date = $(this).attr("data-date");
        var modes = $(this).attr("data-modes");
        // const dateSpan = document.querySelector('.date-add');
        // dateSpan.textContent = date;

        $("#payroll_idd").val(id);
        $('#modal-additional').modal('show');

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "POST",
            url: "{{ route('deductions-edit') }}",
            data: {
                id: id,
                cat: cat,
                modes: modes,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response){
                var deductions = response.data;
                $("#cat").val(cat);
                $("#add_sal_diff").val(deductions[0].add_sal_diff);
                $("#add_nbc_diff").val(deductions[0].add_nbc_diff);
                $("#add_step_incre").val(deductions[0].add_step_incre);
                // console.log(response);
            }
            
        });
    });

    $(".additional-update").submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        
        $.ajax({
            type:"POST",
            url:"{{ route('additional-update') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.status == 200){

                    $('#addition-'+response.id).text(response.addition);
                    $('#deduct-'+response.id).text(response.deduct);
                    $('#net-'+response.id).text(response.net);

                    toastr.options = {
                        "closeButton":true,
                        "progressBar":true,
                        "positionClass": 'toast-bottom-right',
                    }
                    toastr.success("Successfully Update Deductions");
                    $('#modal-additional').modal('hide');

                    // console.log(response);
                }
                else{

                }

            }
        });
    });

    function updateCode(input) {
    const id = input.id;
    const code = input.value;
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $.ajax({
        type: "GET",
        url: "{{ route('update-code') }}",
        data: {
            id: id,
            code: code,
            type: 'code'
            },
            success: function(response){
                // console.log(response);
                toastr.options = {
                    "closeButton":true,
                    "progressBar":true,
                    "positionClass": 'toast-bottom-right',
                }
                toastr.success("Update Successfully");
            }
        });
    }

    function updateCheckbox(input) {
    const id = input.id;
    const status = input.value;
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $.ajax({
        type: "GET",
        url: "{{ route('update-code') }}",
        data: {
            id: id,
            status: status,
            type: 'checkbox'
            },
            success: function(response){
                console.log(response);
                toastr.options = {
                    "closeButton":true,
                    "progressBar":true,
                    "positionClass": 'toast-bottom-right',
                }
                toastr.success("Update Successfully");
            }
        });
        
    }
       
</script>

<script>
    $(document).ready(function() {
        $('#J-work').hide();
    });

    function dayHours(val){
        $('#input-nh').val("");
        if(val == "Days"){
            $('#J-work').show();
            $('#nh').html('No. of Working Days');
            $('#input-nh')
            .attr('placeholder', 'No. of Working Days')
            .attr('min', '1');
            //.attr('max', {{ $days ?? '' }});
        }
        if(val == "Hours"){
            $('#J-work').show();
            $('#nh').html('No. of Working Hours');
            $('#input-nh')
            .attr('placeholder', 'No. of Working Hours')
            .attr('min', '1')
            .attr('max', '');
        }
    }
</script>

<script>
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function calculateDays1(startDate, endDate) {
        const oneDay = 24 * 60 * 60 * 1000;
        const totalDays = Math.floor((endDate - startDate) / oneDay) + 1;
        document.getElementById('working-days').value = totalDays;
    }

    function checkStat(val) {
        if (val == 1 || val == 4) {
            const firstDayOfMonth = new Date();
            firstDayOfMonth.setDate(1);
            document.getElementById('dateStart').value = formatDate(firstDayOfMonth);

            const lastDayOfMonth = new Date();
            lastDayOfMonth.setMonth(lastDayOfMonth.getMonth() + 1);
            lastDayOfMonth.setDate(0);
            document.getElementById('dateEnd').value = formatDate(lastDayOfMonth);

            calculateDays1(firstDayOfMonth, lastDayOfMonth);
        }
        else{
            document.getElementById('dateStart').value = "";
            document.getElementById('dateEnd').value = "";
            document.getElementById('working-days').value = "";
        }
    }
</script>
@if($curr_route == 'storepayroll' || $curr_route == 'storepayroll-jo')
    <script>
        function navigateToPage(selectedValue) {
            const targetPageUrl = `{{ route("storepayroll", [":payrollID", ":statID", ":offID"]) }}`;
            const formattedUrl = targetPageUrl
                .replace(':payrollID', encodeURIComponent({{ $payrollID }}))
                .replace(':statID', encodeURIComponent({{ $statID }}))
                .replace(':offID', encodeURIComponent(selectedValue)); 

            window.location.href = formattedUrl;
        }

    document.addEventListener('DOMContentLoaded', () => {
    const elementsWithClass = document.querySelectorAll(".firstHalf");
    const elementsWithClass1 = document.querySelectorAll(".secondtHalf");

    let sum = 0;

    elementsWithClass.forEach(element => {
        const valueText = element.textContent.trim().replace(',', ''); 
        const value = parseFloat(valueText);
        
        if (!isNaN(value)) {
            sum += value;
        }
    });

    let sum1 = 0;

    elementsWithClass1.forEach(element => {
        const valueText1 = element.textContent.trim().replace(',', '');
        const value1 = parseFloat(valueText1);
        
        if (!isNaN(value1)) {
            sum1 += value1;
        }    
    });

    var sumtotal = sum + sum1;

    const totalElement = document.getElementById("firstHalfTotal");
    const totalElement1 = document.getElementById("secondtHalfTotal");
    const totalElement2 = document.getElementById("grandtotalnet");

    totalElement.textContent = sum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    totalElement1.textContent = sum1.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    totalElement2.textContent = sumtotal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    //Modifies

    const totalRef = document.querySelectorAll(".totalRef");
    const totalDed = document.querySelectorAll(".totalDed");

    let sumRef = 0;

    totalRef.forEach(element => {
        const valueText3 = element.textContent.trim().replace(',', ''); 
        const value = parseFloat(valueText3);
        
        if (!isNaN(value)) {
            sumRef += value;
        }
    });

    let sumDed = 0;

    totalDed.forEach(element => {
        const valueText4 = element.textContent.trim().replace(',', ''); 
        const value = parseFloat(valueText4);
        
        if (!isNaN(value)) {
            sumDed += value;
        }
    });

    const sumtotalRef = document.getElementById("totalRefundAll");
    const sumtotalDed = document.getElementById("totalDeductAll");
    const sumtotalRef1 = document.getElementById("totalRefundAll1");
    const sumtotalDed1 = document.getElementById("totalDeductAll1");

    sumtotalRef.textContent = sumRef.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    sumtotalDed.textContent = sumDed.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    sumtotalRef1.textContent = sumRef.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    sumtotalDed1.textContent = sumDed.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

});
</script>
@endif
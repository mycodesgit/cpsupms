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

    $(document).on('click', '.deductions', '.ad', function(e){    
        e.preventDefault();
        var id = $(this).val();
        $("#payroll_id").val(id);
        $('#modal-deductions').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ route('deductions-edit', ':id') }}".replace(":id", id),
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response.status == 200){
                    if(response.empstat == 'Job Order'){
                        var deductions = response.data;
                        var tax2 = deductions[0].tax2;
                        if(tax2 != 0){
                            $("#tax2").val("0.02").change();
                        } 
                    }
                    else{
                        var deductions = response.data;
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
                    }
                }
                
            }
        });
    });

    $(document).on('click', '.additional', function(e){    
        e.preventDefault();
        var id = $(this).val();
        $("#payroll_idd").val(id);
        $('#modal-additional').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ route('deductions-edit', ':id') }}".replace(":id", id),
            dataType: 'json',
            success: function(response){
                var deductions = response.data;
                $("#add_sal_diff").val(deductions[0].add_sal_diff);
                $("#add_nbc_diff").val(deductions[0].add_nbc_diff);
                $("#add_step_incre").val(deductions[0].add_step_incre);
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
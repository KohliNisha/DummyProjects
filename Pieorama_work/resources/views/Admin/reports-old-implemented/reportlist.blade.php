@extends('layouts.Admin.appadmin')
@section('content')
<style type="text/css">
  .page-title .page-title-icon {
    display: inline-block;
    width: 70px;
    height: 36px;
    border-radius: 4px;
    text-align: center;
    box-shadow: 0px 3px 8.3px 0.7px rgba(163, 93, 255, 0.35);
}
.col-md-4 {
    flex: 0 0 33.33333%;
    max-width: 20.33333%;
}
.bg-gradient-danger {
    background: transparent;
}
.text-white {
    color: black !important;
}
.btn {
    font-size: 1rem;
    line-height: 1;
    font-family: "ubuntu-bold", sans-serif;
    cursor: pointer;
}
.active {
    background: #dae0e6;
    color: #009cdf;
}
#week-picker {
    position: relative;
    bottom: 0;
    display: none;
}

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
    <script type="text/javascript">
$(function() {
    var startDate;
    var endDate;
    
    var selectCurrentWeek = function() {
        setTimeout(function(){
            $('#week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active');
        },1);
    }

    $('#selectDate').on('click', function(){
      $('#week-picker').show();
    
    });    
    $('#week-picker').datepicker( {
        showOtherMonths: true,
        dateFormat: "yy-mm-dd",
        selectOtherMonths: true,
        onSelect: function(dateText, inst) { 
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            $('#startDate').val($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
            $('#endDate').val($.datepicker.formatDate( dateFormat, endDate, inst.settings ));
            
           selectCurrentWeek();
           // $('#week-picker').hide();            
     
            
            
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
           selectCurrentWeek();
        }
    });
    
    $('.ui-datepicker-calendar tr').on('mouseover', function(e) { 
        $(this).find('td a').addClass('ui-state-hover'); 
       e.stopPropagation();
    });
    $('.ui-datepicker-calendar tr').on('mouseleave', function(e) { 
        $(this).find('td a').removeClass('ui-state-hover'); 
       e.stopPropagation();
    });
});

</script>
<script type="text/javascript">
  $(document).ready(function() {

    $('#example').DataTable( {
      
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf'
        ]
    } );
} );
  $(function(){
    $("#datepicker").datepicker({
        // minDate: 0,
        // maxDate: "+1M +5D"
         maxDate: 0,
         changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd"
    });
});
  $(function(){
    $("#datepicker1").datepicker({
        // minDate: 0,
        // maxDate: "+1M +5D"
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
         dateFormat: "yy-mm-dd"
    });
});

 $(function(){
    $("#datepicker3").datepicker({
        // minDate: 0,
        // maxDate: "+1M +5D"
         maxDate: 0,
         changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm"
    });
});
  $(function(){
    $("#datepicker4").datepicker({
        // minDate: 0,
        // maxDate: "+1M +5D"
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
         dateFormat: "yy-mm"
    });
});


  $(document).ready(function () {
  $('button').click(function () {
   $('button').removeClass( "active" );
    $(this).addClass("active");
     $('.data').hide();


    
   })

  $("#custom").click(function(){
     $('.monthly-data').hide();
     $('.status-data').hide();
     $('.week-data').hide();
    $('.custom-date').show();
   })
  $("#monthly").click(function(){
     $('.custom-date').hide();
      $('.status-data').hide();
     $('.week-data').hide();
    $('.monthly-data').show();
      //$('.custom-date').show();
   })
  $("#status").click(function(){
     $('.custom-date').hide();
      $('.week-data').hide();
    $('.monthly-data').hide();
    $('.status-data').show();
      //$('.custom-date').show();
   })
  $("#selectDate").click(function(){
     $('.custom-date').hide();
      $('.status-data').hide();
       $('.monthly-data').hide();
     $('.week-data').show();
   
      //$('.custom-date').show();
   })



    
  })

</script>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
            
               <h4 class="card-title">Loan Report</h4>
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>

          <div class="card">
            <div class="card-body">

                   <div class="template-demo">
                      <a href="/admin/clientreports"> <button type="button" class="btn btn-secondary btn-fw">Client Report</button></a> 
                      <a href="/admin/loanreports"> <button type="button" class="btn btn-primary btn-fw">Loan Report</button></a>
                      <!-- <a href="/admin/walletreports"> <button type="button" class="btn btn-success btn-fw">Wallet Report</button></a> -->
                      <a href="/admin/repaymentreports"><button type="button" class="btn btn-secondary btn-fw">Repayment</button></a>
                      <a href="/admin/queryreports"><button type="button" class="btn btn-secondary btn-fw">Query Report</button></a>
                    </div>
                 </div>
              <div class="card-body">
                   
           <div class="row" style="margin-left: 60px;">
                <div class="col-md-3" id="custom"> <button class="font-weight-normal mb-3 btn btn-default ">Custom Date </button> </div>
              <form method="post"> @csrf <input type="hidden" value="user" name="alluser"> <div class="col-md-3" id="all"><button type="submit" class="font-weight-normal mb-3 btn btn-default"> All User</button></div> </form>
                <div class="col-md-3" id="monthly"><button class="font-weight-normal mb-3 btn btn-default">Monthly Report</button></div>
                <div class="col-md-3" id="selectDate"><button class="font-weight-normal mb-3 btn btn-default">Weekly Report</button></div>
                <!--  <div class="col-md-2" id="status"><button class="font-weight-normal mb-3 btn btn-default">Status</button></div> -->
                  
                    

                    </div>
                    <!-- custom date -->
                    <div class="custom-date" style="display: none; margin-left: 60px;">
                        <form class="forms-sample" method="post">
                        @csrf                      <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Start Date</label>
                      <div class="col-sm-9">
                        <input type="text" readonly="readonly" name="start_date" class="form-control" id="datepicker" placeholder="DD/MM/YYYY">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-2 col-form-label">End Date</label>
                      <div class="col-sm-9">
                        <input type="text" name="end_date" class="form-control" id="datepicker1" placeholder="DD/MM/YYYY">
                      </div>
                    </div>
                   
                   
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label"></label>
                      <div class="col-sm-9">
                         <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                    <!-- <a href="http://127.0.0.1:8000/admin/emails" class="btn btn-light">Cancel</a> -->
                      </div>
                    </div>
                   
                  </form>
                        </div>
                         <!-- custom date -->



                         <!-- monthly data -->


                          <div class="monthly-data" style="display: none; margin-left: 60px;">
                      <form class="forms-sample" method="post">
                        @csrf                      <div class="form-group row">
                      <label for="exampleInputUsername1" class="col-sm-2 col-form-label">Month</label>
                       <input type="hidden" value="01" name="start_date">
                  
                    
                      <div class="col-sm-9">
                        <select class="form-control" name="start_month">
                        <option>select month</option>
                        @for ( $i=1; $i<=12; $i++ )
                        <option >{{$i}} </option>

                         @endfor


                        
                      </select>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-2 col-form-label" >Year</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="start_year">
                        <option>select year</option>
                         @for ( $i=2018; $i<=date('Y'); $i++ )
                        <option >{{$i}} </option>

                         @endfor
                        
                      </select>
                      </div>
                    </div>
                   
                   
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label"></label>
                      <div class="col-sm-9">
                         <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                    <!-- <a href="http://127.0.0.1:8000/admin/emails" class="btn btn-light">Cancel</a> -->
                      </div>
                    </div>
                   
                  </form>
                        </div>



                         <!-- monthly data -->



                         <!-- week data -->


                          <div class="week-data week-picker" style="display: none; margin-left: 60px;">
                            <div type="text" id="week-picker"></div>
                      
                       
                      <form class="forms-sample" method="post">
                        @csrf
                          <div class="form-group row">
                            <label for="exampleInputUsername1" class="col-sm-2 col-form-label">Start Date</label>
                          
                    <div class="col-md-9">
                      
                      <input type="text" name="start_week" id="startDate" class="form-control"  placeholder="MM/YYYY">
                    </div>
                  </div>
                  <div class="form-group row">
                     <label for="exampleInputEmail1" class="col-sm-2 col-form-label">End Date</label>
                    <div class=" col-md-9">
                     
                      <input type="text" name="end_week" id="endDate" class="form-control"placeholder="MM/YYYY">
                    </div>
                  </div>
                    
                    <div class="form-group row">
                        <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label"></label>
                       <div class=" col-md-9">
                   <input type="submit" class="btn btn-gradient-primary mr-2" value="Submit">
                 </div>
                 </div>
                    
                   </form>
                         </div>

                        <div class="col-md-2"></div>
                        </div>
                        </div>



                         <!-- week data -->

                         <!-- status data -->


                         <!--  <div class="status-data" style="display: none;">
                       <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                      <form class="forms-sample" method="post">
                        @csrf
                          <div class="row">
                          
                    <div class="col-md-6">
                      <label for="exampleInputUsername1">Status</label>
                      <select class="form-control" name="status">
                        <option>select status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                      </select>
                      
                    </div>
                    
                    <br/>
                    <br>
                   <input type="submit" class="btn btn-gradient-primary mr-2" value="Submit">
                     </div>
                   </form>
                         </div>

                        <div class="col-md-2"></div>
                        </div>
                        </div> -->



                         <!-- status data -->

                         







                        <div class="data" >
                      @if(isset($data))  
                     
                        <table class="table display" id="example">
                     <thead>  <tr>
                        <th> S.N</th>
                       
                      
                        <th> Name </th>
                        <th> Email </th>
                        <th> Phone Number</th>
                       
                       

                      </tr>
                    </thead>


                    <tbody>
                   
                    @foreach($data as $key=>$loan) 
                      <tr>
                        <td>  {{++$key}} </td>
                     
                       
                        <td>  {{$loan->title.' '. $loan->first_name.' '.$loan->last_name}} </td>
                        <td>  {{$loan->email}} </td> 
                       
                       
                        <td>  
                        {{$loan->phone_number}}                    
                      
                      </td>
                        
                      </tr>
                           
                      @endforeach
                    </tbody>
                  </table>
                <!--  <a href="/admin/exportExcel/"> <button>download</button></a> -->
                  @endif
                </div>
                       



                     </div>
                    </div>

                    
           </div>


          <div class="row">
            
           
          </div>
        
        
        </div>
      <script type="text/javascript">

  $(document).ready(function() {
  window.history.pushState(null, "", window.location.href);        
  window.onpopstate = function() {
      window.history.pushState(null, "", window.location.href);
  };
  });
  </script>


  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dataTables.jqueryui.min.css') }}">
  <link href="{{ asset('css/newcss/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> 
  <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script> 
  <script src="{{ asset('js/dataTables.jqueryui.min.js')}}"></script>
  <script src="{{ asset('js/newjs/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('js/newjs/jszip.min.js')}}"></script>
  <script src="{{ asset('js/newjs/pdfmake.min.js')}}"></script>
  <script src="{{ asset('js/newjs/vfs_fonts.js')}}"></script>
  <script src="{{ asset('js/newjs/buttons.html5.min.js')}}"></script>
@endsection

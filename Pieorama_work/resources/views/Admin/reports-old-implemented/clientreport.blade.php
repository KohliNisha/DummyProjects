@extends('layouts.Admin.appadmin')
@section('content')
<style type="text/css">
 .center {
  margin: auto;
  width: 36%;  
  padding: 10px;
}
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

.btncolor { color: #5b5f63;}

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
  $('.ttnclass').click(function () {
   //$('button').removeClass( "active" );
   // $(this).addClass("active");
     $('.data').hide();


    
   })

  $("#custom").click(function(){
     $('.monthly-data').hide();
     $('.status-data').hide();
     $('.week-data').hide();
     $('.allreport').hide();     
     $('.custom-date').show();
   })
  $("#monthly").click(function(){
    $('.custom-date').hide();
    $('.status-data').hide();
    $('.week-data').hide();
    $('.allreport').hide();
    $('.monthly-data').show();
      //$('.custom-date').show();
   })
  $("#status").click(function(){
    $('.custom-date').hide();
    $('.week-data').hide();
    $('.monthly-data').hide();
    $('.allreport').hide();
    $('.status-data').show();
      //$('.custom-date').show();
   })
  $("#selectDate").click(function(){
    $('.custom-date').hide();
    $('.status-data').hide();
    $('.monthly-data').hide();
    $('.allreport').hide();
    $('.week-data').show();
   
      //$('.custom-date').show();
   })



    
  })

</script>

   
        <div class="content-wrapper">

<div class="page-header">
      <h3 class="page-title">
     Client Report
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <!-- <a href="{!! url('/admin/create-template'); !!}" class="btn btn-gradient-info btn-rounded btn-sm">Add New</a> -->
          </li>
        </ol>
      </nav>
    </div>







     <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                   <div class="template-demo">
                      <a href="/admin/clientreports"> <button type="button" class="btn btn-primary btn-fw">Client Report</button></a> 
                      <a href="/admin/loanreports"> <button type="button" class="btn btn-secondary btn-fw">Loan Report</button></a>
                     <!--  <a href="/admin/walletreports"> <button type="button" class="btn btn-success btn-fw">Wallet Report</button></a> -->
                      <a href="/admin/repaymentreports"><button type="button" class="btn btn-secondary btn-fw">Repayment</button></a>
                      <a href="/admin/queryreports"><button type="button" class="btn btn-secondary btn-fw">Query Report</button></a>
                    </div>
                 </div>

             <hr/>    

       <div class="card-body" style="padding-top: 0px;">
         <div class="template-demo">
            <button type="button" id="custom" class="btn btn-gradient-secondary">Custom Date Report</button>  
            <button type="button"  id="selectDate" class="btn btn-gradient-secondary">Weekly Report</button>          
            <button type="button"  id="monthly" class="btn btn-gradient-secondary">Monthly Report</button>            
            <form method="post" style="display: inline;"> @csrf <input type="hidden" value="user" name="alluser"> <button type="submit" style="margin-top: 20px;" class="btn btn-gradient-secondary">All Users Report</button></form>
          </div>

        <hr/>


             <!-- <div class="col-md-3 ttnclass" id="custom"> <button class="btncolor font-weight-normal mb-3 btn btn-default ">Custom Date </button> </div>
               <div class="col-md-3 ttnclass" id="all"> <form method="post"> @csrf <input type="hidden" value="user" name="alluser"> <button type="submit" class=" btncolor font-weight-normal mb-3 btn btn-default"> All User</button></form></div> 
                <div class="col-md-3 ttnclass" id="monthly"><button class="btncolor font-weight-normal mb-3 btn btn-default">Monthly Report</button></div>
                <div class="col-md-3 ttnclass" id="selectDate"><button class=" btncolor font-weight-normal mb-3 btn btn-default">Weekly Report</button></div> -->
                <!--  <div class="col-md-2" id="status"><button class="font-weight-normal mb-3 btn btn-default">Status</button></div> -->
           
                    

               
                    <!-- custom date -->
                    <div class="custom-date" style="display: none; ">
                      <div class="col-md-12"><h4 id="">Custom Date Report</h4></div> 
                       <hr>
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
                        <input type="text" readonly="readonly" name="end_date" class="form-control" id="datepicker1" placeholder="DD/MM/YYYY">
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


                   <div class="monthly-data" style="display: none;">
                   <div class="col-md-12"><h4 id="">Monthly Report</h4></div> 
                   <hr>

                      <form class="forms-sample" method="post">
                        @csrf                      <div class="form-group row">
                      <label for="exampleInputUsername1" class="col-sm-2 col-form-label">Month</label>
                       <input type="hidden" value="01" name="start_date">
                  
                    
                      <div class="col-sm-9">
                        <select class="form-control" name="start_month">
                        <option>select month</option>
                        @for ( $i=1; $i<=12; $i++ )
                        <option value="{{$i}}" > @if($i== 1)
                            January
                        @endif
                        @if($i== 2)
                        Feburary
                        @endif
                        @if($i== 3)
                        March
                        @endif
                        @if($i== 4)
                        April
                        @endif
                        @if($i== 5)
                        May
                        @endif
                        @if($i== 6)
                        June
                        @endif
                        @if($i== 7)
                        July
                        @endif
                        @if($i== 8)
                        August
                        @endif
                        @if($i== 9)
                        Septmber
                        @endif
                        @if($i== 10)
                        October
                        @endif
                        @if($i== 11)
                        November
                        @endif
                        @if($i== 12)
                        December
                        @endif
                        </option>

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


                <div class="week-data week-picker" style="display: none;">
                   <div class="col-md-12"><h4 id="">Weekly Report</h4></div> 
                    <hr>
                    <div type="text" class="center" id="week-picker"></div>
            
             
                      <form class="forms-sample" method="post">
                        @csrf
                          <div class="form-group row">
                            <label for="exampleInputUsername1" class="col-sm-2 col-form-label">Start Date</label>
                          
                    <div class="col-md-9">
                      
                      <input type="text" readonly="readonly" name="start_week" id="startDate" class="form-control"  placeholder="MM/YYYY">
                    </div>
                  </div>
                  <div class="form-group row">
                     <label for="exampleInputEmail1" class="col-sm-2 col-form-label">End Date</label>
                    <div class=" col-md-9">
                     
                      <input type="text" readonly="readonly" name="end_week" id="endDate" class="form-control"placeholder="MM/YYYY">
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

                         





                  

                    <div class="data allreport"  >
                            
                      @if(isset($data))  

                       <div class="col-md-12"><h4 id="">Report</h4></div> 
                       <hr>
                     
                        <table class="table display table-bordered table-striped" id="example">
                     <thead>  <tr>
                        <th> S.N</th>
                       
                      
                        <th> Name </th>
                        <th> Email </th>
                        <th> Address Code </th> 
                        <th> Phone Number</th>
                         <th> P.Offers</th>
                         <th> Created_at </th>
                          <th> Status</th>
                       
                       

                      </tr>
                    </thead>


                    <tbody>
                   
                    @foreach($data as $key=>$loan) 
                      <tr>
                        <td>  {{++$key}} </td>
                     
                       
                        <td>  {{$loan->title.' '. $loan->first_name.' '.$loan->last_name}} </td>
                        <td>  {{$loan->email}} </td> 
                      <td>  {{$loan->digital_address_code}} </td>  
                          <td>  
                        {{$loan->phone_code.' '.$loan->phone_number}}                    
                      
                      </td>
                         <td>  
                        @if($loan->promotional_offers ==1)
                        Yes
                        @else
                        No
                        @endif



                                           
                      
                      </td>
                       
                       
                       
                       <td>  {{date('Y/m/d', strtotime($loan->created_at))}} </td> 
                        <td>    @if($loan->status =='0')                          
                        <label class='badge badge-warning cursor'  >Inactive</label>
                        @endif
                        
                        @if($loan->status =='1')                        
                        <label><label class='badge badge-success cursor' >Active</label></a></label> 
                        @endif

                       <!--  -->
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

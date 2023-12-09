<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\PieChannel;
use App\Models\PieVideo;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::guard('admin')->check()) {
             return redirect()->route("admin.login");
         }
         return view('Admin.report.reportlist');
     }
    public function reportlist(Request $request){  
       try{
            if (!Auth::guard('admin')->check()) {
                return redirect()->route("admin.login");
            }
             if($request->isMethod('post'))  
            {           
                if($request->start_date && $request->end_date) {
                     $data=PieVideo::whereBetween('created_at',[$request->start_date,$request->end_date])->get();
                   }
                 // echo "<pre/>"; print_r($data[0]['loanapplicationfun']['first_name']); die; 
                  if($request->alluser) {
                      $data=PieVideo::get();
                   }          
                if(isset($request->status)) {              
                     $data=PieVideo::where('status',$request->status)->get();                  
                 }                            
                 if($request->start_date && $request->start_month && $request->start_year) {
                     $start = $request->start_year.'-'.$request->start_month.'-'.$request->start_date;                
                    $end = $request->start_year.'-'.$request->start_month.'-'.'31';  
                     $data=PieVideo::whereBetween('created_at',[$start,$end])->get();
                 }
                 if($request->start_week && $request->end_week ) {                     
                     $data=PieVideo::whereBetween('created_at',[$request->start_week,$request->end_week])->get();
                 }        
                     
            }
            
            if(!empty($data)){
                 return view('Admin.report.reportlist',compact('data'));    
          //  return view('Admin.report.channelreport')->with(['data' => $data]); 
        }else{
             return view('Admin.report.reportlist');    
           
        }
              
         
            }  catch (\Exception $e) {
                return ['success' => 0, 'message' => [$e->getMessage()]];
            }
    }

    public function clientreport(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
         if($request->isMethod('post'))  
        {
            //dd($request->all());
            if($request->start_date && $request->end_date) {
                 $data=User::where('is_deleted',0)->where('user_role',2)->whereBetween('created_at',[$request->start_date,$request->end_date])->get();
               }               
            if($request->alluser) { 
              $data=User::where('is_deleted',0)->where('user_role',2)->get();
            }      
            if(isset($request->status)) {
                 $data=User::where('is_deleted',0)->where('user_role',2)->where('status',$request->status)->get();    
             }
            
             if($request->start_date && $request->start_month && $request->start_year) {  
                 $start = $request->start_year.'-'.$request->start_month.'-'.$request->start_date;                
                 //$startmonth = $request->start_month +1;
                 $end = $request->start_year.'-'.$request->start_month.'-'.'31';  
                 $data=User::where('is_deleted',0)->where('user_role',2)->whereBetween('created_at',[$start,$end])->get();
             }

             if($request->start_week && $request->end_week ) {  
                $data=User::where('is_deleted',0)->where('user_role',2)->whereBetween('created_at',[$request->start_week,$request->end_week])->get();
             }
             
        } 
        if(!empty($data)){
            return view('Admin.report.clientreport',compact('data')); 
        }else{
            return view('Admin.report.clientreport'); 
        }        
               
    }




     public function channelreport(Request $request){
         try{
            if (!Auth::guard('admin')->check()) {
                return redirect()->route("admin.login");
            }
             if($request->isMethod('post'))  
            {           
                if($request->start_date && $request->end_date) {
                     $data=PieChannel::whereBetween('created_at',[$request->start_date,$request->end_date])->get();
                   }

                 // echo "<pre/>"; print_r($data[0]['loanapplicationfun']['first_name']); die; 
                  if($request->alluser) {
                      $data=PieChannel::get();
                   }          
                if(isset($request->status)) {              
                     $data=PieChannel::where('status',$request->status)->get();                  
                 }                            
                 if($request->start_date && $request->start_month && $request->start_year) {
                     $start = $request->start_year.'-'.$request->start_month.'-'.$request->start_date;                
                    $end = $request->start_year.'-'.$request->start_month.'-'.'31';  
                     $data=PieChannel::whereBetween('created_at',[$start,$end])->get();
                 }
                 if($request->start_week && $request->end_week ) {                     
                     $data=PieChannel::whereBetween('created_at',[$request->start_week,$request->end_week])->get();
                 }        
                     
            }
            if(!empty($data)){
                 return view('Admin.report.channelreport',compact('data'));    
          //  return view('Admin.report.channelreport')->with(['data' => $data]); 
        }else{
             return view('Admin.report.channelreport');    
           
        }
              
         
            }  catch (\Exception $e) {
                return ['success' => 0, 'message' => [$e->getMessage()]];
            }    
        }








    public function queryreport(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
         if($request->isMethod('post'))  
        {
            if($request->start_date && $request->end_date) {
                 $data=ContactUs::whereBetween('created_at',[$request->start_date,$request->end_date])->get();
               }               
            if($request->alluser) { 
                $data=ContactUs::all();
            }      
            if(isset($request->status)) {
                 $data=ContactUs::where('status',$request->status)->get(); 
            }
            
             if($request->start_date && $request->start_month && $request->start_year) { 
                 $start = $request->start_year.'-'.$request->start_month.'-'.$request->start_date;                
                 $end = $request->start_year.'-'.$request->start_month.'-'.'31';  
                 $data=ContactUs::whereBetween('created_at',[$start,$end])->get();
             }

            if($request->start_week && $request->end_week ) {        
            $data=ContactUs::whereBetween('created_at',[$request->start_week,$request->end_week])->get();
            }

        }
         return view('Admin.report.queryreport',compact('data'));      
    }




    public function walletreport(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
       return view('Admin.report.walletreport',[]);
    }


}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Auth;
use Validator;
use App\Helpers\Helper;
class EmailController extends Controller
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
    	// if (!Auth::guard('admin')->check()) {
        //     return redirect()->route("admin.login");
        // }
        return view('Admin.emails.emails');
    }
    public function emaillist(){ 
        if (!Auth::guard('admin')->check()) {
        return redirect()->route("admin.login");
        }
        $emails = EmailTemplate::orderBy('id', 'desc')->get();
        return view('Admin.emails.emaillist',compact('emails'));
    }

    public function addnewmail(Request $request){
        if (!Auth::guard('admin')->check()) {
        return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'subject' => 'required',  
                'replace_vars' => 'required',             
                'body' => 'required',                
            ]);
            if($validator->fails()) {
                //return back()->withErrors($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
            $slug = Helper::slugify($request->title);
            $email = new EmailTemplate();
            $email->title= $request->title;
            $email->subject= $request->subject;
            $email->replace_vars= $request->replace_vars;
            $email->body= $request->body;
            $email->slug= $slug;
            if($email->save()){
                return redirect('admin/emails')->with('message', 'Email template has been created successfully!');
            }else{
                return redirect()->back()->with('error', 'Internal error occurred!');
            }
        }
        return view('Admin.emails.addnewemail',[]);
    }
    public function updatemail(Request $request,$id)
    {
        
        if (!Auth::guard('admin')->check()) {
         return redirect()->route("admin.login");
        }
        if(!empty($id)){
            if( $request->isMethod('post') ) {
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'subject' => 'required',  
                    'replace_vars' => 'required',             
                    'body' => 'required',                
                ]);
                if($validator->fails()) {
                    //return back()->withErrors($validator->errors());
                    return back()->withInput()->withErrors($validator->errors());
                } 
                //$slug = Helper::slugify($request->title);
                $title = $request->title;
                $subject=$request->subject;
                $replace_vars=$request->replace_vars;
                $body = $request->body;
                $updateData = ['title'=>$title,'subject'=>$subject,'replace_vars'=>$replace_vars,'body'=>$body];
                $success = EmailTemplate::where('id',$id)->update($updateData);
                return redirect('admin/emails')->with('message', 'Email template has been updated successfully!');
            }
            $email = EmailTemplate::where('id',$id)->first();
            if(!empty($email)){
                return view('Admin.emails.updatemail',compact('email'));
            }else{
                return redirect('admin/emails');
            }
            
        }else{
            return redirect('admin/emails');
        }  
    }

    public function deletetemplate(Request $request,$id)
    {
        EmailTemplate::where('id',$id)->delete();
        return redirect('admin/emails')->with('message', 'Email template has been deleted successfully!');
    }

    public function viewtemplate(Request $request,$slug)
    {
       $html_body1 = EmailTemplate::select('body')->where('slug',$slug)->first();
       $html_body= $html_body1->body;
       return view('emails.common',compact('html_body'));
    }
}

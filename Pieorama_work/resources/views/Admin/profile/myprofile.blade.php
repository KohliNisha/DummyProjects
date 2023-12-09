@extends('layouts.site.app')
@section('content')

    <div class="dashboardSearch">
        <div class="container">
            <div class="searchInner clearfix">
                <div class="searchColm">
                    <span class="hd">Search By</span>
                    <div class="searchBy"><input type="text" placeholder="Type funding location here..." class="inputSearch"> <a href="#" class="detect">Detect</a></div>
                </div>
                <div class="searchColm">
                    <span class="hd">Search For</span>
                    <div class="searchFor"><input type="text" placeholder="Search by School / College / University Name" class="inputSearch"></div>
                </div>
                <div class="searchBtnCov"><input type="button" value="SEARCH"></div>
            </div>
        </div>
    </div>
    <!--End Search Part -->
    <!--Start Middle Part -->
    <section class="dbMidCon">
        <div class="maindbHd">
            <div class="container">Profile</div>
        </div>
        <?php //dd($user->toArray()); ?>
        <div class="container clearfix">
            @include('layouts.donar.donarprofile')
            <div class="dbRgt">
                    <div class="dbWhtBox padd30">
                        <div class="profileViewHd"><img src="{{ asset('images/pi_icon.png') }}" alt=""> Personal Informations</div>
                        <div class="formField">
                            <span class="fieldHd">First Name</span>
                            <span class="fieldAns">{{isset($user->first_name)?$user->first_name:'N/A'}}</span>
                        </div>
                        <div class="formField">
                            <span class="fieldHd">Last Name</span>
                            <span class="fieldAns">{{isset($user->last_name)?$user->last_name:'N/A'}}</span>
                        </div>
                        <div class="formField">
                            <span class="fieldHd">Email ID</span>
                            <span class="fieldAns">{{isset($user->email)?$user->email:'N/A'}}</span>
                        </div>
                        <div class="formField">
                            <span class="fieldHd">Mobile Number</span>
                            <span class="fieldAns">{{isset($user->phone_code)?$user->phone_code:'+'}} {{isset($user->phone_number)?$user->phone_number:'N/A'}}</span>
                        </div><br>
                        <div class="profileViewHd"><img src="images/location_icon.png" alt=""> Address Informations</div>
                        <div class="formField">
                            <span class="fieldHd">Address</span>
                            <span class="fieldAns">36 West Inan Spring Ave. Houston</span>
                        </div>
                        <div class="formField">
                            <span class="fieldHd">City</span>
                            <span class="fieldAns">Houston</span>
                        </div>
                        <div class="formField">
                            <span class="fieldHd">State</span>
                            <span class="fieldAns">Delaware</span>
                        </div>
                        <div class="formField">
                            <span class="fieldHd">Country</span>
                            <span class="fieldAns">America</span>
                        </div>
                        <div class="formField">
                            <span class="fieldHd">Zip</span>
                            <span class="fieldAns">94027</span>
                        </div>
                        <div class="mt10"><input type="button" value="EDIT" class="formBtnSmll"> <input type="button" value="CANCEL" class="cancelBtn ml10"></div>
                    </div>
                </div>
            
        </div>
    </section>

@endsection
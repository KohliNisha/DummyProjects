@extends('layouts.site.app')
@section('content')
<style>
.ErrorBoxm {display:block;margin-bottom:20px; border:1px solid #ebccd1; background:#f2dede; padding:20px; color:#a94442; font-size:14px;width: 100%}
.ErrorBoxm span {display:block; padding-bottom:5px; font-weight:700;}
</style>
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
            <div class="container">{{ isset($pageTitle)?$pageTitle:''}}
            </div>
        </div>
        <div class="container clearfix">
            @include('layouts.donar.donarprofile')
            <div class="dbRgt">
                    <div class="dbWhtBox padd30">
                    @if(session()->has('message'))
                    <div class="SuccessBox">
                        {{ session()->get('message') }}
                    </div>
                @endif
					@if ($errors->any())
                    <div class="ErrorBoxm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
        <form method="POST" autocomplete="off" action="{{ route('site.changepassword') }}" id="changepassworddata">
                        @csrf
                        <div class="formField ">
                            <span class="fieldHd">Current Password</span>
                            <input type="password" name="current_password" class="editFormInput " value="">
                        </div>
                        <div class="formField">
                            <span class="fieldHd">New Password</span>
                            <input type="password" name="new_password" class="editFormInput" value="">
                        </div>
                        <div class="formField">
                            <span class="fieldHd">Re-enter Password</span>
                            <input type="password" name="re_enter_password" class="editFormInput" value="">
                        </div>
                        <div class="mt10">
                            <button type="submit" class="formBtnSmll">UPDATE</button>
                            <input type="button" value="CANCEL" class="cancelBtn ml10"></div>
                        </form>
                    </div>
                </div>
        </div>
    </section>
@endsection


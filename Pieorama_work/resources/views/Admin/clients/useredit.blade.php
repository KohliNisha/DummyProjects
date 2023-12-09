@extends('layouts.Admin.appadmin')
@section('content')
<style type="text/css">
 sup, .error {color: red;}
 #library_file-error {display: block !important;
 padding-top: 5px !important;
 }
</style>
<script type="text/javascript">
$(document).ready(function(){
   $(".userlink").addClass("active");
});
kmr btn-info
</script>
<div class="content-wrapper">
  <div class="page-header">
      <h3 class="page-title">  Edit User </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/users'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li>
        </ol>
      </nav>
    </div>
          <div class="row">
       <!------->
       <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 <h4 class="card-title">Edit user</h4>  
                  <hr/><br/> 
                  @if ($errors->any())
                  <div class="alert alert-danger fadeout">
                  @foreach ($errors->all() as $error)
                  {{$error}}
                  @endforeach
                  </div>
                  @endif
                  @if(session()->has('message'))
                  <div class="alert alert-success fadeout">
                  {{ session()->get('message') }}
                  </div>
                  @endif

                  <form class="forms-inline" autocomplete="off" method="post" id="AudioForm" action="" enctype="multipart/form-data">
                  @csrf 
              
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Update Profile <sup>*   Max size 5MB</sup></label>
                        <div class="col-sm-9">
                           <?php if(!empty($profile->profile_image)){?>
                              <img src="{{$profile->profile_image}}" id="profile_image" alt="image" height="200" style="padding-left: 10px;     width: 293px; height: 142px;">
                            <?php }else{?>
                              <img src="{{ asset('images/nouserimage.png') }}" height="200">
                            <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">                       
                        <div class="col-sm-9">   
                         <input type="file" name="profile_image" class="" id="library_file" class="form-control" style="padding-top: 70px;" />             
                        </div>
                     
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">First Name <sup >*</sup></label>
                        <div class="col-sm-9">
                            <input type="text" name="first_name" maxlength="256"  value="{{ old('first_name', $profile->first_name) }}" placeholder="First Name" class="form-control"  >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Last Name </label>
                         <div class="col-sm-9">
                            <input type="text" name="last_name" maxlength="256"  value="{{ old('last_name', $profile->last_name) }}" placeholder="Last Name" class="form-control"  >
                        </div>
                      </div>
                    </div>
                  </div>

                   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email <sup >*</sup></label>
                        <div class="col-sm-9">
                            <input type="text" name="email" maxlength="256"  value="{{ old('email', $profile->email) }}" placeholder="Email Address" class="form-control"  >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">DOB <sup >*</sup></label>
                         <div class="col-sm-9">
                            <?php  
                               $dob = date("d-m-Y", strtotime($profile->date_of_birth));
                             ?>
                           <input class="form-control" id="datepicker" readonly="readonly" name= "date_of_birth" placeholder="dd-mm-yyyy"  value="{{ old('date_of_birth', $dob) }}">

                        </div>
                      </div>
                    </div>
                  </div>


                   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Gender <sup >*</sup></label>
                        <div class="col-sm-9">
                          <?php
                            if($profile->gender == 1) { 
                               $genderget = "Male"; 
                             }else if ($profile->gender == 2)  {
                                $genderget = "Female"; 
                              } else {
                                $genderget = $profile->gender ;
                              }
                           ?>

                          <input class="form-control" id="gender" name= "gender" placeholder="Gender"  value="{{ old('gender', $genderget) }}">
                           
                            <!-- <select class="form-control" name="gender" id="" style="height: 49px;">
                                <option value="" disabled="" selected="" >Choose gender</option>
                                <option value="1" <?php if($profile->gender == 1) { echo "selected"; } ?>>Male</option>
                                <option value="2"  <?php if($profile->gender == 2) { echo "selected"; } ?>>Female</option>                             
                              </select> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group row">

                        <label class="col-sm-6 col-form-label">Phone No. <sup >*</sup></label>
                         <div class="col-sm-6 ">
                            <select class="form-control" style="color: #272827;" name="phone_code" style="height: 49px;">
                                <?php /*if($profile->phone_code !=""){ ?>
                                <option selected="" value="<?php echo $profile->phone_code ?>" selected="<?php echo $profile->phone_code ?>">(+<?php echo $profile->phone_code ?>)</option>
                               <?php } else {*/ ?>
                                <option value="" selected="" disabled="">Country Code</option>
                              <?php /*}*/ ?>

                                <option data-countryCode="DZ" <?php if($profile->phone_code ==213){ echo "selected"; } ?> value="213">Algeria (+213)</option>
                                <option data-countryCode="AD" <?php if($profile->phone_code ==376){ echo "selected"; } ?> value="376">Andorra (+376)</option>
                                <option data-countryCode="AO"  <?php if($profile->phone_code ==244){ echo "selected"; } ?> value="244">Angola (+244)</option>
                                <option data-countryCode="AI"  <?php if($profile->phone_code ==1264){ echo "selected"; } ?> value="1264">Anguilla (+1264)</option>
                                <option data-countryCode="AG"  <?php if($profile->phone_code ==1268){ echo "selected"; } ?> value="1268">Antigua &amp; Barbuda (+1268)</option>
                                <option data-countryCode="AR"  <?php if($profile->phone_code ==54){ echo "selected"; } ?> value="54">Argentina (+54)</option>
                                <option data-countryCode="AM"  <?php if($profile->phone_code ==374){ echo "selected"; } ?> value="374">Armenia (+374)</option>
                                <option data-countryCode="AW"  <?php if($profile->phone_code ==297){ echo "selected"; } ?> value="297">Aruba (+297)</option>
                                <option data-countryCode="AU"  <?php if($profile->phone_code ==61){ echo "selected"; } ?> value="61">Australia (+61)</option>
                                <option data-countryCode="AT"  <?php if($profile->phone_code ==43){ echo "selected"; } ?> value="43">Austria (+43)</option>
                                <option data-countryCode="AZ"  <?php if($profile->phone_code ==994){ echo "selected"; } ?> value="994">Azerbaijan (+994)</option>
                                <option data-countryCode="BS"  <?php if($profile->phone_code ==1242){ echo "selected"; } ?> value="1242">Bahamas (+1242)</option>
                                <option data-countryCode="BH"  <?php if($profile->phone_code ==973){ echo "selected"; } ?> value="973">Bahrain (+973)</option>
                                <option data-countryCode="BD"  <?php if($profile->phone_code ==880){ echo "selected"; } ?> value="880">Bangladesh (+880)</option>
                                <option data-countryCode="BB"  <?php if($profile->phone_code ==1246){ echo "selected"; } ?> value="1246">Barbados (+1246)</option>
                                <option data-countryCode="BY"  <?php if($profile->phone_code ==375){ echo "selected"; } ?> value="375">Belarus (+375)</option>
                                <option data-countryCode="BE"  <?php if($profile->phone_code ==32){ echo "selected"; } ?> value="32">Belgium (+32)</option>
                                <option data-countryCode="BZ"  <?php if($profile->phone_code ==501){ echo "selected"; } ?> value="501">Belize (+501)</option>
                                <option data-countryCode="BJ"  <?php if($profile->phone_code ==229){ echo "selected"; } ?> value="229">Benin (+229)</option>
                                <option data-countryCode="BM"  <?php if($profile->phone_code ==1441){ echo "selected"; } ?> value="1441">Bermuda (+1441)</option>
                                <option data-countryCode="BT" <?php if($profile->phone_code ==975){ echo "selected"; } ?>  value="975">Bhutan (+975)</option>
                                <option data-countryCode="BO"  <?php if($profile->phone_code ==591){ echo "selected"; } ?> value="591">Bolivia (+591)</option>
                                <option data-countryCode="BA" <?php if($profile->phone_code ==387){ echo "selected"; } ?>  value="387">Bosnia Herzegovina (+387)</option>
                                <option data-countryCode="BW"  <?php if($profile->phone_code ==267){ echo "selected"; } ?> value="267">Botswana (+267)</option>
                                <option data-countryCode="BR"  <?php if($profile->phone_code ==55){ echo "selected"; } ?> value="55">Brazil (+55)</option>
                                <option data-countryCode="BN" <?php if($profile->phone_code ==673){ echo "selected"; } ?>  value="673">Brunei (+673)</option>
                                <option data-countryCode="BG" <?php if($profile->phone_code ==359){ echo "selected"; } ?>  value="359">Bulgaria (+359)</option>
                                <option data-countryCode="BF" <?php if($profile->phone_code ==226){ echo "selected"; } ?>  value="226">Burkina Faso (+226)</option>
                                <option data-countryCode="BI" <?php if($profile->phone_code ==257){ echo "selected"; } ?>  value="257">Burundi (+257)</option>
                                <option data-countryCode="KH" <?php if($profile->phone_code ==855){ echo "selected"; } ?>  value="855">Cambodia (+855)</option>
                                <option data-countryCode="CM" <?php if($profile->phone_code ==237){ echo "selected"; } ?>  value="237">Cameroon (+237)</option>
                                <option data-countryCode="CA" <?php if($profile->phone_code ==1){ echo "selected"; } ?>  value="1">Canada (+1)</option>
                                <option data-countryCode="CV" <?php if($profile->phone_code ==238){ echo "selected"; } ?>  value="238">Cape Verde Islands (+238)</option>
                                <option data-countryCode="KY" <?php if($profile->phone_code ==1345){ echo "selected"; } ?>  value="1345">Cayman Islands (+1345)</option>
                                <option data-countryCode="CF" <?php if($profile->phone_code ==236){ echo "selected"; } ?>  value="236">Central African Republic (+236)</option>
                                <option data-countryCode="CL"  <?php if($profile->phone_code ==56){ echo "selected"; } ?> value="56">Chile (+56)</option>
                                <option data-countryCode="CN" <?php if($profile->phone_code ==86){ echo "selected"; } ?>  value="86">China (+86)</option>
                                <option data-countryCode="CO" <?php if($profile->phone_code ==57){ echo "selected"; } ?>  value="57">Colombia (+57)</option>
                                <option data-countryCode="KM" <?php if($profile->phone_code ==269){ echo "selected"; } ?>  value="269">Comoros (+269)</option>
                                <option data-countryCode="CG" <?php if($profile->phone_code ==242){ echo "selected"; } ?>  value="242">Congo (+242)</option>
                                <option data-countryCode="CK"  <?php if($profile->phone_code ==682){ echo "selected"; } ?> value="682">Cook Islands (+682)</option>
                                <option data-countryCode="CR"  <?php if($profile->phone_code ==506){ echo "selected"; } ?> value="506">Costa Rica (+506)</option>
                                <option data-countryCode="HR"  <?php if($profile->phone_code ==385){ echo "selected"; } ?> value="385">Croatia (+385)</option>
                                <option data-countryCode="CU"  <?php if($profile->phone_code ==53){ echo "selected"; } ?> value="53">Cuba (+53)</option>
                                <option data-countryCode="CY" <?php if($profile->phone_code ==90392){ echo "selected"; } ?>  value="90392">Cyprus North (+90392)</option>
                                <option data-countryCode="CY" <?php if($profile->phone_code ==357){ echo "selected"; } ?>  value="357">Cyprus South (+357)</option>
                                <option data-countryCode="CZ" <?php if($profile->phone_code ==42){ echo "selected"; } ?>  value="42">Czech Republic (+42)</option>
                                <option data-countryCode="DK"  <?php if($profile->phone_code ==45){ echo "selected"; } ?> value="45">Denmark (+45)</option>
                                <option data-countryCode="DJ" <?php if($profile->phone_code ==253){ echo "selected"; } ?>  value="253">Djibouti (+253)</option>
                                <option data-countryCode="DM" <?php if($profile->phone_code ==1809){ echo "selected"; } ?>  value="1809">Dominica (+1809)</option>
                                <option data-countryCode="DO" <?php if($profile->phone_code ==1809){ echo "selected"; } ?>  value="1809">Dominican Republic (+1809)</option>
                                <option data-countryCode="EC" <?php if($profile->phone_code ==593){ echo "selected"; } ?>  value="593">Ecuador (+593)</option>
                                <option data-countryCode="EG"  <?php if($profile->phone_code ==20){ echo "selected"; } ?> value="20">Egypt (+20)</option>
                                <option data-countryCode="SV" <?php if($profile->phone_code ==503){ echo "selected"; } ?>  value="503">El Salvador (+503)</option>
                                <option data-countryCode="GQ" <?php if($profile->phone_code ==240){ echo "selected"; } ?>  value="240">Equatorial Guinea (+240)</option>
                                <option data-countryCode="ER"  <?php if($profile->phone_code ==291){ echo "selected"; } ?> value="291">Eritrea (+291)</option>
                                <option data-countryCode="EE" <?php if($profile->phone_code ==372){ echo "selected"; } ?>  value="372">Estonia (+372)</option>
                                <option data-countryCode="ET" <?php if($profile->phone_code ==251){ echo "selected"; } ?>  value="251">Ethiopia (+251)</option>
                                <option data-countryCode="FK"  <?php if($profile->phone_code ==500){ echo "selected"; } ?> value="500">Falkland Islands (+500)</option>
                                <option data-countryCode="FO"  <?php if($profile->phone_code ==298){ echo "selected"; } ?> value="298">Faroe Islands (+298)</option>
                                <option data-countryCode="FJ"  <?php if($profile->phone_code ==679){ echo "selected"; } ?> value="679">Fiji (+679)</option>
                                <option data-countryCode="FI"  <?php if($profile->phone_code ==358){ echo "selected"; } ?> value="358">Finland (+358)</option>
                                <option data-countryCode="FR" <?php if($profile->phone_code ==33){ echo "selected"; } ?>  value="33">France (+33)</option>
                                <option data-countryCode="GF" <?php if($profile->phone_code ==594){ echo "selected"; } ?>  value="594">French Guiana (+594)</option>
                                <option data-countryCode="PF" <?php if($profile->phone_code ==689){ echo "selected"; } ?>  value="689">French Polynesia (+689)</option>
                                <option data-countryCode="GA" <?php if($profile->phone_code ==241){ echo "selected"; } ?>  value="241">Gabon (+241)</option>
                                <option data-countryCode="GM" <?php if($profile->phone_code ==220){ echo "selected"; } ?>  value="220">Gambia (+220)</option>
                                <option data-countryCode="GE" <?php if($profile->phone_code ==7880){ echo "selected"; } ?>  value="7880">Georgia (+7880)</option>
                                <option data-countryCode="DE" <?php if($profile->phone_code ==49){ echo "selected"; } ?>  value="49">Germany (+49)</option>
                                <option data-countryCode="GH" <?php if($profile->phone_code ==233){ echo "selected"; } ?>  value="233">Ghana (+233)</option>
                                <option data-countryCode="GI" <?php if($profile->phone_code ==350){ echo "selected"; } ?>  value="350">Gibraltar (+350)</option>
                                <option data-countryCode="GR" <?php if($profile->phone_code ==30){ echo "selected"; } ?>  value="30">Greece (+30)</option>
                                <option data-countryCode="GL" <?php if($profile->phone_code ==299){ echo "selected"; } ?>  value="299">Greenland (+299)</option>
                                <option data-countryCode="GD" <?php if($profile->phone_code ==1473){ echo "selected"; } ?>  value="1473">Grenada (+1473)</option>
                                <option data-countryCode="GP" <?php if($profile->phone_code ==590){ echo "selected"; } ?>  value="590">Guadeloupe (+590)</option>
                                <option data-countryCode="GU" <?php if($profile->phone_code ==671){ echo "selected"; } ?>  value="671">Guam (+671)</option>
                                <option data-countryCode="GT" <?php if($profile->phone_code ==502){ echo "selected"; } ?>  value="502">Guatemala (+502)</option>
                                <option data-countryCode="GN" <?php if($profile->phone_code ==224){ echo "selected"; } ?>  value="224">Guinea (+224)</option>
                                <option data-countryCode="GW" <?php if($profile->phone_code ==245){ echo "selected"; } ?>  value="245">Guinea - Bissau (+245)</option>
                                <option data-countryCode="GY" <?php if($profile->phone_code ==592){ echo "selected"; } ?>  value="592">Guyana (+592)</option>
                                <option data-countryCode="HT" <?php if($profile->phone_code ==509){ echo "selected"; } ?>  value="509">Haiti (+509)</option>
                                <option data-countryCode="HN" <?php if($profile->phone_code ==504){ echo "selected"; } ?>  value="504">Honduras (+504)</option>
                                <option data-countryCode="HK" <?php if($profile->phone_code ==852){ echo "selected"; } ?>  value="852">Hong Kong (+852)</option>
                                <option data-countryCode="HU" <?php if($profile->phone_code ==36){ echo "selected"; } ?>  value="36">Hungary (+36)</option>
                                <option data-countryCode="IS" <?php if($profile->phone_code ==354){ echo "selected"; } ?>  value="354">Iceland (+354)</option>
                                <option data-countryCode="IN" <?php if($profile->phone_code ==91){ echo "selected"; } ?>  value="91">India (+91)</option>
                                <option data-countryCode="ID"  <?php if($profile->phone_code ==62){ echo "selected"; } ?> value="62">Indonesia (+62)</option>
                                <option data-countryCode="IR" <?php if($profile->phone_code ==98){ echo "selected"; } ?>  value="98">Iran (+98)</option>
                                <option data-countryCode="IQ" <?php if($profile->phone_code ==964){ echo "selected"; } ?>  value="964">Iraq (+964)</option>
                                <option data-countryCode="IE"  <?php if($profile->phone_code ==353){ echo "selected"; } ?> value="353">Ireland (+353)</option>
                                <option data-countryCode="IL"  <?php if($profile->phone_code ==972){ echo "selected"; } ?> value="972">Israel (+972)</option>
                                <option data-countryCode="IT"  <?php if($profile->phone_code ==39){ echo "selected"; } ?> value="39">Italy (+39)</option>
                                <option data-countryCode="JM" <?php if($profile->phone_code ==1876){ echo "selected"; } ?>  value="1876">Jamaica (+1876)</option>
                                <option data-countryCode="JP" <?php if($profile->phone_code ==81){ echo "selected"; } ?>  value="81">Japan (+81)</option>
                                <option data-countryCode="JO" <?php if($profile->phone_code ==962){ echo "selected"; } ?>  value="962">Jordan (+962)</option>
                                <option data-countryCode="KZ" <?php if($profile->phone_code ==7){ echo "selected"; } ?>  value="7">Kazakhstan (+7)</option>
                                <option data-countryCode="KE" <?php if($profile->phone_code ==254){ echo "selected"; } ?>  value="254">Kenya (+254)</option>
                                <option data-countryCode="KI" <?php if($profile->phone_code ==686){ echo "selected"; } ?>  value="686">Kiribati (+686)</option>
                                <option data-countryCode="KP" <?php if($profile->phone_code ==850){ echo "selected"; } ?>  value="850">Korea North (+850)</option>
                                <option data-countryCode="KR" <?php if($profile->phone_code ==82){ echo "selected"; } ?>  value="82">Korea South (+82)</option>
                                <option data-countryCode="KW" <?php if($profile->phone_code ==965){ echo "selected"; } ?>  value="965">Kuwait (+965)</option>
                                <option data-countryCode="KG" <?php if($profile->phone_code ==996){ echo "selected"; } ?>  value="996">Kyrgyzstan (+996)</option>
                                <option data-countryCode="LA"  <?php if($profile->phone_code ==856){ echo "selected"; } ?> value="856">Laos (+856)</option>
                                <option data-countryCode="LV" <?php if($profile->phone_code ==371){ echo "selected"; } ?>  value="371">Latvia (+371)</option>
                                <option data-countryCode="LB" <?php if($profile->phone_code ==961){ echo "selected"; } ?>  value="961">Lebanon (+961)</option>
                                <option data-countryCode="LS"  <?php if($profile->phone_code ==266){ echo "selected"; } ?>  value="266">Lesotho (+266)</option>
                                <option data-countryCode="LR" <?php if($profile->phone_code ==231){ echo "selected"; } ?>  value="231">Liberia (+231)</option>
                                <option data-countryCode="LY" <?php if($profile->phone_code ==218){ echo "selected"; } ?>  value="218">Libya (+218)</option>
                                <option data-countryCode="LI" <?php if($profile->phone_code ==417){ echo "selected"; } ?>  value="417">Liechtenstein (+417)</option>
                                <option data-countryCode="LT" <?php if($profile->phone_code ==370){ echo "selected"; } ?>  value="370">Lithuania (+370)</option>
                                <option data-countryCode="LU" <?php if($profile->phone_code ==352){ echo "selected"; } ?>  value="352">Luxembourg (+352)</option>
                                <option data-countryCode="MO"  <?php if($profile->phone_code ==853){ echo "selected"; } ?> value="853">Macao (+853)</option>
                                <option data-countryCode="MK" <?php if($profile->phone_code ==389){ echo "selected"; } ?>  value="389">Macedonia (+389)</option>
                                <option data-countryCode="MG" <?php if($profile->phone_code ==261){ echo "selected"; } ?>  value="261">Madagascar (+261)</option>
                                <option data-countryCode="MW" <?php if($profile->phone_code ==265){ echo "selected"; } ?>  value="265">Malawi (+265)</option>
                                <option data-countryCode="MY" <?php if($profile->phone_code ==60){ echo "selected"; } ?>  value="60">Malaysia (+60)</option>
                                <option data-countryCode="MV" <?php if($profile->phone_code ==960){ echo "selected"; } ?>  value="960">Maldives (+960)</option>
                                <option data-countryCode="ML" <?php if($profile->phone_code ==223){ echo "selected"; } ?>  value="223">Mali (+223)</option>
                                <option data-countryCode="MT" <?php if($profile->phone_code ==356){ echo "selected"; } ?>  value="356">Malta (+356)</option>
                                <option data-countryCode="MH" <?php if($profile->phone_code ==692){ echo "selected"; } ?>  value="692">Marshall Islands (+692)</option>
                                <option data-countryCode="MQ" <?php if($profile->phone_code ==596){ echo "selected"; } ?>  value="596">Martinique (+596)</option>
                                <option data-countryCode="MR" <?php if($profile->phone_code ==222){ echo "selected"; } ?>  value="222">Mauritania (+222)</option>
                                <option data-countryCode="YT" <?php if($profile->phone_code ==269){ echo "selected"; } ?>  value="269">Mayotte (+269)</option>
                                <option data-countryCode="MX" <?php if($profile->phone_code ==52){ echo "selected"; } ?>  value="52">Mexico (+52)</option>
                                <option data-countryCode="FM"  <?php if($profile->phone_code ==691){ echo "selected"; } ?> value="691">Micronesia (+691)</option>
                                <option data-countryCode="MD"  <?php if($profile->phone_code ==373){ echo "selected"; } ?> value="373">Moldova (+373)</option>
                                <option data-countryCode="MC" <?php if($profile->phone_code ==377){ echo "selected"; } ?>  value="377">Monaco (+377)</option>
                                <option data-countryCode="MN" <?php if($profile->phone_code ==976){ echo "selected"; } ?>  value="976">Mongolia (+976)</option>
                                <option data-countryCode="MS" <?php if($profile->phone_code ==1664){ echo "selected"; } ?>  value="1664">Montserrat (+1664)</option>
                                <option data-countryCode="MA"  <?php if($profile->phone_code ==212){ echo "selected"; } ?>  value="212">Morocco (+212)</option>
                                <option data-countryCode="MZ"  <?php if($profile->phone_code ==258){ echo "selected"; } ?> value="258">Mozambique (+258)</option>
                                <option data-countryCode="MN" <?php if($profile->phone_code ==95){ echo "selected"; } ?>  value="95">Myanmar (+95)</option>
                                <option data-countryCode="NA"  <?php if($profile->phone_code ==264){ echo "selected"; } ?> value="264">Namibia (+264)</option>
                                <option data-countryCode="NR" <?php if($profile->phone_code ==674){ echo "selected"; } ?>  value="674">Nauru (+674)</option>
                                <option data-countryCode="NP" <?php if($profile->phone_code ==977){ echo "selected"; } ?>  value="977">Nepal (+977)</option>
                                <option data-countryCode="NL" <?php if($profile->phone_code ==31){ echo "selected"; } ?>  value="31">Netherlands (+31)</option>
                                <option data-countryCode="NC" <?php if($profile->phone_code ==687){ echo "selected"; } ?>  value="687">New Caledonia (+687)</option>
                                <option data-countryCode="NZ" <?php if($profile->phone_code ==64){ echo "selected"; } ?>  value="64">New Zealand (+64)</option>
                                <option data-countryCode="NI" <?php if($profile->phone_code ==505){ echo "selected"; } ?>  value="505">Nicaragua (+505)</option>
                                <option data-countryCode="NE" <?php if($profile->phone_code ==227){ echo "selected"; } ?>  value="227">Niger (+227)</option>
                                <option data-countryCode="NG" <?php if($profile->phone_code ==234){ echo "selected"; } ?>  value="234">Nigeria (+234)</option>
                                <option data-countryCode="NU" <?php if($profile->phone_code ==683){ echo "selected"; } ?>  value="683">Niue (+683)</option>
                                <option data-countryCode="NF" <?php if($profile->phone_code ==672){ echo "selected"; } ?>  value="672">Norfolk Islands (+672)</option>
                                <option data-countryCode="NP" <?php if($profile->phone_code ==670){ echo "selected"; } ?>  value="670">Northern Marianas (+670)</option>
                                <option data-countryCode="NO" <?php if($profile->phone_code ==47){ echo "selected"; } ?>  value="47">Norway (+47)</option>
                                <option data-countryCode="OM" <?php if($profile->phone_code ==968){ echo "selected"; } ?>  value="968">Oman (+968)</option>
                                <option data-countryCode="PW" <?php if($profile->phone_code ==680){ echo "selected"; } ?>  value="680">Palau (+680)</option>
                                <option data-countryCode="PA"  <?php if($profile->phone_code ==507){ echo "selected"; } ?> value="507">Panama (+507)</option>
                                <option data-countryCode="PG" <?php if($profile->phone_code ==675){ echo "selected"; } ?>  value="675">Papua New Guinea (+675)</option>
                                <option data-countryCode="PY"  <?php if($profile->phone_code ==595){ echo "selected"; } ?> value="595">Paraguay (+595)</option>
                                <option data-countryCode="PE" <?php if($profile->phone_code ==51){ echo "selected"; } ?>  value="51">Peru (+51)</option>
                                <option data-countryCode="PH" <?php if($profile->phone_code ==63){ echo "selected"; } ?>  value="63">Philippines (+63)</option>
                                <option data-countryCode="PL" <?php if($profile->phone_code ==48){ echo "selected"; } ?>  value="48">Poland (+48)</option>
                                <option data-countryCode="PT" <?php if($profile->phone_code ==351){ echo "selected"; } ?>  value="351">Portugal (+351)</option>
                                <option data-countryCode="PR" <?php if($profile->phone_code ==1787){ echo "selected"; } ?>  value="1787">Puerto Rico (+1787)</option>
                                <option data-countryCode="QA"  <?php if($profile->phone_code ==974){ echo "selected"; } ?> value="974">Qatar (+974)</option>
                                <option data-countryCode="RE" <?php if($profile->phone_code ==262){ echo "selected"; } ?>  value="262">Reunion (+262)</option>
                                <option data-countryCode="RO" <?php if($profile->phone_code ==40){ echo "selected"; } ?>  value="40">Romania (+40)</option>
                                <option data-countryCode="RU" <?php if($profile->phone_code ==7){ echo "selected"; } ?>  value="7">Russia (+7)</option>
                                <option data-countryCode="RW" <?php if($profile->phone_code ==250){ echo "selected"; } ?>  value="250">Rwanda (+250)</option>
                                <option data-countryCode="SM" <?php if($profile->phone_code ==378){ echo "selected"; } ?>  value="378">San Marino (+378)</option>
                                <option data-countryCode="ST" <?php if($profile->phone_code ==239){ echo "selected"; } ?>  value="239">Sao Tome &amp; Principe (+239)</option>
                                <option data-countryCode="SA" <?php if($profile->phone_code ==966){ echo "selected"; } ?>  value="966">Saudi Arabia (+966)</option>
                                <option data-countryCode="SN" <?php if($profile->phone_code ==221){ echo "selected"; } ?>  value="221">Senegal (+221)</option>
                                <option data-countryCode="CS" <?php if($profile->phone_code ==381){ echo "selected"; } ?>  value="381">Serbia (+381)</option>
                                <option data-countryCode="SC" <?php if($profile->phone_code ==248){ echo "selected"; } ?>  value="248">Seychelles (+248)</option>
                                <option data-countryCode="SL" <?php if($profile->phone_code ==232){ echo "selected"; } ?>  value="232">Sierra Leone (+232)</option>
                                <option data-countryCode="SG" <?php if($profile->phone_code ==65){ echo "selected"; } ?>  value="65">Singapore (+65)</option>
                                <option data-countryCode="SK" <?php if($profile->phone_code ==421){ echo "selected"; } ?>  value="421">Slovak Republic (+421)</option>
                                <option data-countryCode="SI" <?php if($profile->phone_code ==386){ echo "selected"; } ?>  value="386">Slovenia (+386)</option>
                                <option data-countryCode="SB" <?php if($profile->phone_code ==677){ echo "selected"; } ?>  value="677">Solomon Islands (+677)</option>
                                <option data-countryCode="SO"  <?php if($profile->phone_code ==252){ echo "selected"; } ?> value="252">Somalia (+252)</option>
                                <option data-countryCode="ZA" <?php if($profile->phone_code ==27){ echo "selected"; } ?>  value="27">South Africa (+27)</option>
                                <option data-countryCode="ES" <?php if($profile->phone_code ==34){ echo "selected"; } ?>  value="34">Spain (+34)</option>
                                <option data-countryCode="LK" <?php if($profile->phone_code ==94){ echo "selected"; } ?>  value="94">Sri Lanka (+94)</option>
                                <option data-countryCode="SH" <?php if($profile->phone_code ==290){ echo "selected"; } ?>  value="290">St. Helena (+290)</option>
                                <option data-countryCode="KN"  <?php if($profile->phone_code ==1869){ echo "selected"; } ?> value="1869">St. Kitts (+1869)</option>
                                <option data-countryCode="SC"  <?php if($profile->phone_code ==1758){ echo "selected"; } ?> value="1758">St. Lucia (+1758)</option>
                                <option data-countryCode="SD"  <?php if($profile->phone_code ==249){ echo "selected"; } ?> value="249">Sudan (+249)</option>
                                <option data-countryCode="SR"  <?php if($profile->phone_code ==597){ echo "selected"; } ?> value="597">Suriname (+597)</option>
                                <option data-countryCode="SZ"  <?php if($profile->phone_code ==268){ echo "selected"; } ?>  value="268">Swaziland (+268)</option>
                                <option data-countryCode="SE" <?php if($profile->phone_code ==46){ echo "selected"; } ?>  value="46">Sweden (+46)</option>
                                <option data-countryCode="CH" <?php if($profile->phone_code ==41){ echo "selected"; } ?>  value="41">Switzerland (+41)</option>
                                <option data-countryCode="SI"  <?php if($profile->phone_code ==963){ echo "selected"; } ?> value="963">Syria (+963)</option>
                                <option data-countryCode="TW" <?php if($profile->phone_code ==886){ echo "selected"; } ?>  value="886">Taiwan (+886)</option>
                                <option data-countryCode="TJ" <?php if($profile->phone_code ==7){ echo "selected"; } ?>  value="7">Tajikstan (+7)</option>
                                <option data-countryCode="TH" <?php if($profile->phone_code ==66){ echo "selected"; } ?>  value="66">Thailand (+66)</option>
                                <option data-countryCode="TG" <?php if($profile->phone_code ==228){ echo "selected"; } ?>  value="228">Togo (+228)</option>
                                <option data-countryCode="TO" <?php if($profile->phone_code ==676){ echo "selected"; } ?>  value="676">Tonga (+676)</option>
                                <option data-countryCode="TT" <?php if($profile->phone_code ==1868){ echo "selected"; } ?>  value="1868">Trinidad &amp; Tobago (+1868)</option>
                                <option data-countryCode="TN"  <?php if($profile->phone_code ==216){ echo "selected"; } ?> value="216">Tunisia (+216)</option>
                                <option data-countryCode="TR" <?php if($profile->phone_code ==90){ echo "selected"; } ?>  value="90">Turkey (+90)</option>
                                <option data-countryCode="TM"  <?php if($profile->phone_code ==7){ echo "selected"; } ?> value="7">Turkmenistan (+7)</option>
                                <option data-countryCode="TM" <?php if($profile->phone_code ==993){ echo "selected"; } ?>  value="993">Turkmenistan (+993)</option>
                                <option data-countryCode="TC" <?php if($profile->phone_code ==1649){ echo "selected"; } ?>  value="1649">Turks &amp; Caicos Islands (+1649)</option>
                                <option data-countryCode="TV"  <?php if($profile->phone_code ==688){ echo "selected"; } ?>  value="688">Tuvalu (+688)</option>
                                <option data-countryCode="UG"  <?php if($profile->phone_code ==256){ echo "selected"; } ?> value="256">Uganda (+256)</option>
                                 <option data-countryCode="GB"  <?php if($profile->phone_code ==44){ echo "selected"; } ?>  value="44">UK (+44)</option> 
                                <option data-countryCode="UA" <?php if($profile->phone_code ==380){ echo "selected"; } ?>  value="380">Ukraine (+380)</option>
                                <option data-countryCode="AE"  <?php if($profile->phone_code ==971){ echo "selected"; } ?>  value="971">United Arab Emirates (+971)</option>
                                <option data-countryCode="UY"  <?php if($profile->phone_code ==598){ echo "selected"; } ?>  value="598">Uruguay (+598)</option>
                                <option data-countryCode="US"  <?php if($profile->phone_code ==1){ echo "selected"; } ?>  value="1">USA (+1)</option>
                                <option data-countryCode="UZ"  <?php if($profile->phone_code ==8){ echo "selected"; } ?>  value="8">Uzbekistan (+8)</option>
                                <option data-countryCode="VU"  <?php if($profile->phone_code ==678){ echo "selected"; } ?>  value="678">Vanuatu (+678)</option>
                                <option data-countryCode="VA" <?php if($profile->phone_code ==379){ echo "selected"; } ?>  value="379">Vatican City (+379)</option>
                                <option data-countryCode="VE"  <?php if($profile->phone_code ==58){ echo "selected"; } ?>  value="58">Venezuela (+58)</option>
                                <option data-countryCode="VN"  <?php if($profile->phone_code ==84){ echo "selected"; } ?> value="84">Vietnam (+84)</option>
                                <option data-countryCode="VG"  <?php if($profile->phone_code ==1284){ echo "selected"; } ?>  value="84">Virgin Islands - British (+1284)</option>
                                <option data-countryCode="VI"  <?php if($profile->phone_code ==1340){ echo "selected"; } ?>  value="84">Virgin Islands - US (+1340)</option>
                                <option data-countryCode="WF"  <?php if($profile->phone_code ==681){ echo "selected"; } ?> value="681">Wallis &amp; Futuna (+681)</option>
                                <option data-countryCode="YE" <?php if($profile->phone_code ==969){ echo "selected"; } ?>  value="969">Yemen (North)(+969)</option>
                                <option data-countryCode="YE" <?php if($profile->phone_code ==967){ echo "selected"; } ?>  value="967">Yemen (South)(+967)</option>
                                <option data-countryCode="ZM"  <?php if($profile->phone_code ==260){ echo "selected"; } ?> value="260">Zambia (+260)</option>
                                <option data-countryCode="ZW"  <?php if($profile->phone_code ==263){ echo "selected"; } ?> value="263">Zimbabwe (+263)</option>
                                                           
                              </select>
                        </div>
                      </div>
                    </div>

                     <div class="col-md-2">
                      <div class="form-group row">                     
                         <div class="col-sm-12">

                            <input type="text" name="phone_number" maxlength="256"  value="{{ old('phone_number', $profile->phone_number) }}" placeholder="Phone no." class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>



                  <p class="card-description"> Address </p>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Address 1 <sup >*</sup></label>
                        <div class="col-sm-9">
                            <input type="text" name="address_1" maxlength="256" 
                              value="{{{ isset($address->address_1) ? $address->address_1 : old('address_1') }}}" placeholder="Address 1" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Address 2 </label>
                         <div class="col-sm-9">
                            <input type="text" name="address_2" maxlength="256"  value="{{{ isset($address->address_2) ? $address->address_2 : old('address_2') }}}" placeholder="Address 2" class="form-control"  >
                        </div>
                      </div>
                    </div>
                  </div>

                   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">City </label>
                        <div class="col-sm-9">
                            <input type="text" name="city" maxlength="256"  value="{{{ isset($address->city) ? $address->city : old('city') }}}" placeholder="City" class="form-control"  >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">State </label>
                         <div class="col-sm-9">
                            <input type="text" name="state" maxlength="256"  value="{{{ isset($address->state) ? $address->state : old('state') }}}" placeholder="State" class="form-control"  >
                        </div>
                      </div>
                    </div>
                  </div>


                   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Postcode </label>
                        <div class="col-sm-9">
                            <input type="text" name="pin_code" maxlength="256"  value="{{{ isset($address->pin_code) ? $address->pin_code : old('pin_code') }}}
                            " placeholder="Postcode" class="form-control"  >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Country <sup >*</sup></label>
                         <div class="col-sm-9">
                              <select class="form-control" name="country" style="height: 49px;">
                                    <?php if($address){
                                     if($address->country !="") { ?>
                                     <option value="<?php echo $address->country ; ?>"><?php echo $address->country ; ?></option>
                                    <?php  } } else { ?>
                                      <option value="" selected="selected" disabled="disabled">Choose Country</option>
                                    <?php  } ?>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antartica">Antarctica</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Bouvet Island">Bouvet Island</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Congo">Congo, the Democratic Republic of the</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                                    <option value="Croatia">Croatia (Hrvatska)</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="East Timor">East Timor</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="France Metropolitan">France, Metropolitan</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Territories">French Southern Territories</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                                    <option value="Holy See">Holy See (Vatican City State)</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran">Iran (Islamic Republic of)</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
                                    <option value="Korea">Korea, Republic of</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Lao">Lao People's Democratic Republic</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macau">Macau</option>
                                    <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia">Micronesia, Federated States of</option>
                                    <option value="Moldova">Moldova, Republic of</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russia">Russian Federation</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                                    <option value="Saint LUCIA">Saint LUCIA</option>
                                    <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia (Slovak Republic)</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
                                    <option value="Span">Spain</option>
                                    <option value="SriLanka">Sri Lanka</option>
                                    <option value="St. Helena">St. Helena</option>
                                    <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria">Syrian Arab Republic</option>
                                    <option value="Taiwan">Taiwan, Province of China</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania">Tanzania, United Republic of</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks and Caicos">Turks and Caicos Islands</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Viet Nam</option>
                                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                    <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                                    <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                                    <option value="Western Sahara">Western Sahara</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                              </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <br/>
                    <div class="form-group row">       
                       <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                       <button type="submit" class="btn btn-primary mr-2 submit">Update</button>
                       <button type="reset" class="btn btn-gradient-light mr-2">Reset</button>  
                       </div>
                        <div class="col-sm-4"></div>             
                    </div>               
                  </form>
                  <span style="color: red;">*</span><span style="font-size: 13px;"> Required field</span>
                </div>
              </div>
            </div>
            
       <!----->           
            
          </div>
       
<script src="{{ asset('js/admin/js/jquery.validate.js')}}"></script>
<script src="{{ asset('js/admin/js/additional-methods.min.js')}}"></script>
<script>
$("#AudioForm").validate({
    rules: {
         first_name: {
           required: true,
           maxlength: 255
        },  
        last_name: {
           maxlength: 255
        }, 
        email: {
             required: true,
             email: true             
          },
        date_of_birth: {
           required: true,
           maxlength: 255
        }, 
        phone_number: {
           maxlength: 15
        },   
        address_1: {
           required: true,
        }, 
        country: {
           required: true,
        }, 
        library_file: {
           extension: "mp3"
        }         
    },
    submitHandler: function(form){
        $('.submit').attr('disabled', 'disabled');
        $(".submit").html('Please wait..');
        form.submit();
    }
});

$('#library_file').bind('change', function() {
  var file_size = $('#library_file')[0].files[0].size;
  if(file_size>5097152) {
    swal("File size should not be greater than 5MB");
    $('#library_file').val('');
    return false;
  } 
  return true;
});

 $( document ).ready(function() { 
     $("#datepicker").datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      maxDate:0,
      yearRange: '-100:+100',
     });
 }); 


function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#profile_image').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}



$('#library_file').bind('change', function() {
//$("#library_file").change(function() {
  readURL(this);
});

</script>
<!--  jQuery added for the date picker-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
@endsection

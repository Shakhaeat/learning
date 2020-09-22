<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\StudentBasicProfile; //model class
use App\UserGroup; //model class
use App\Rank; //model class
use App\StudentAppointment; //model class
use App\Wing; //model class
use App\Course; //model class
use App\CommissioningCourse; //model class
use App\Religion; //model class
use App\ArmsService; //model class
use App\Unit; //model class
use App\Formation; //model class
use App\StudentBrotherSister; //model class
use App\StudentOthers; //model class
use App\Country; //model class
use App\Division; //model class
use App\District; //model class
use App\Thana; //model class
use App\StudentPermanentAddress; //model class
use App\StudentCivilEducation; //model class
use App\StudentServiceRecord; //model class
use App\StudentAwardRecord; //model class
use App\StudentPunishmentRecord; //model class
use App\StudentRelativeInDefence; //model class
use App\StudentNextKin; //model class
use App\StudentMedicalDetails; //model class
use App\StudentWinterCollectiveTraining; //model class
use Session;
use Response;
use Redirect;
use Auth;
use File;
use PDF;
use URL;
use Hash;
use DB;
use Helper;
use Illuminate\Http\Request;

class StudentProfileController extends Controller {

    public function __construct() {
        Validator::extend('complexPassword', function($attribute, $value, $parameters) {
            $password = $parameters[1];

            if (preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[!@#$%^&*()])(?=\S*[\d])\S*$/', $password)) {
                return true;
            }
            return false;
        });
    }

    public function index(Request $request) {
        $studentInfoData = User::leftJoin('student_basic_profile', 'student_basic_profile.user_id', '=', 'users.id')
                ->leftJoin('rank', 'rank.id', '=', 'users.rank_id')
                ->leftJoin('unit', 'unit.id', '=', 'student_basic_profile.unit_id')
                ->leftJoin('religion', 'religion.id', '=', 'student_basic_profile.religion_id')
                ->leftJoin('formation', 'formation.id', '=', 'student_basic_profile.formation_id')
                ->leftJoin('student_appointment', 'student_appointment.id', '=', 'users.appointment_id')
                ->leftJoin('arms_service', 'arms_service.id', '=', 'student_basic_profile.arms_service_id')
                ->leftJoin('course', 'course.id', '=', 'student_basic_profile.course_id')
                ->leftJoin('commissioning_course', 'commissioning_course.id', '=', 'student_basic_profile.commissioning_course_id')
                ->select('users.id as user_id', 'users.email', 'users.photo', 'users.phone', 'users.full_name', 'users.official_name'
                        , 'users.username', DB::raw("CONCAT(rank.code, ' ', users.full_name, ' (', users.official_name, ')') as student_name")
                        , 'users.appointment_id as student_appointment_id', 'course.name as course_name', 'arms_service.name as arms_service_name'
                        , 'commissioning_course.name as commissioning_course_name', 'unit.name as unit_name', 'religion.name as religion_name'
                        , 'formation.name as formation_name', 'student_basic_profile.*'
                )
                ->where('users.group_id', Auth::user()->group_id)
                ->where('users.status', '1')
                ->where('users.id', Auth::user()->id)
                ->first();
        $brotherSisterInfoData = StudentBrotherSister::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : 0)
                ->select('id', 'user_id', 'brother_sister_info')
                ->first();
        $civilEducationInfoData = StudentCivilEducation::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : 0)
                ->select('id', 'user_id', 'civil_education_info')
                ->first();
        $serviceRecordInfoData = StudentServiceRecord::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : 0)
                ->select('id', 'user_id', 'service_record_info')
                ->first();
        $awardRecordInfoData = StudentAwardRecord::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : 0)
                ->select('id', 'user_id', 'award_record_info')
                ->first();
        $punishmentRecordInfoData = StudentPunishmentRecord::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : 0)
                ->select('id', 'user_id', 'punishment_record_info')
                ->first();
        $defenceRelativeInfoData = StudentRelativeInDefence::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : 0)
                ->select('id', 'user_id', 'student_relative_info')
                ->first();
//        echo '<pre>'; print_r($awardRecordInfoData); exit;
        $othersInfoData = StudentOthers::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : 0)
                ->select('id', 'user_id', 'visited_countries_id', 'special_quality', 'professional_computer', 'swimming')
                ->first();

//        echo '<pre>';        print_r($studentInfoData); exit;
        $religionList = ['0' => __('label.SELECT_RELIGION_OPT')] + Religion::pluck('name', 'id')->toArray();
        $appointmentList = ['0' => __('label.SELECT_APPT_OPT')] + StudentAppointment::pluck('code', 'id')->toArray();
        $armsServiceList = ['0' => __('label.SELECT_ARMS_SERVICE_OPT')] + ArmsService::pluck('code', 'id')->toArray();
        $unitList = ['0' => __('label.SELECT_UNIT_OPT')] + Unit::pluck('code', 'id')->toArray();
        $formationList = ['0' => __('label.SELECT_FORMATION_OPT')] + Formation::pluck('code', 'id')->toArray();
        $maritalStatusList = ['0' => __('label.SELECT_MARITAL_STATUS_OPT')] + Helper::getMaritalStatus();
        $swimmingList = ['0' => __('label.SELECT_SWIMMER_OPT')] + Helper::getSwimming();
        $countriesVisitedList = Country::pluck('name', 'id')->toArray();
        $courseList = ['0' => __('label.SELECT_COURSE_OPT')] + Course::pluck('name', 'id')->toArray();

        //Division District Thana for student permanent address
        $addressInfo = StudentPermanentAddress::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : '0')
                        ->select('id', 'division_id', 'district_id', 'thana_id', 'address_details')->first();
  

        $divisionList = ['0' => __('label.SELECT_DIVISION_OPT')] + Division::pluck('name', 'id')->toArray();
        $districtList = ['0' => __('label.SELECT_DISTRICT_OPT')] + District::where('division_id', !empty($addressInfo->division_id) ? $addressInfo->division_id : 0)->pluck('name', 'id')->toArray();
        $thanaList = ['0' => __('label.SELECT_THANA_OPT')] + Thana::where('district_id', !empty($addressInfo->district_id) ? $addressInfo->district_id : 0)->pluck('name', 'id')->toArray();

        //Division District Thana for next kin
        $nextKinAddressInfo = StudentNextKin::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : '0')
                        ->select('id', 'name', 'relation','division_id', 'district_id', 'thana_id', 'address_details')->first();
        $nextKinDistrictList = ['0' => __('label.SELECT_DISTRICT_OPT')] + District::where('division_id', !empty($nextKinAddressInfo->division_id) ? $nextKinAddressInfo->division_id : 0)->pluck('name', 'id')->toArray();
        $nextKinThanaList = ['0' => __('label.SELECT_THANA_OPT')] + Thana::where('district_id', !empty($nextKinAddressInfo->district_id) ? $nextKinAddressInfo->district_id : 0)->pluck('name', 'id')->toArray();

        $studentMedicalDetails = StudentMedicalDetails::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : '0')
                        ->select('id', 'category', 'blood_group','date_of_birth', 'ht_ft', 'ht_inch', 'weight', 'over_under_weight', 'any_disease')->first();
        
        $studentWinterTrainingInfoData = StudentWinterCollectiveTraining::where('user_id', !empty($studentInfoData->user_id) ? $studentInfoData->user_id : '0')
                        ->select('id', 'participated_no', 'training_info')->first();
        
        return view('studentProfile.index')->with(compact('studentInfoData', 'religionList', 'appointmentList', 'armsServiceList'
                                , 'unitList', 'formationList', 'maritalStatusList', 'brotherSisterInfoData', 'countriesVisitedList'
                                , 'swimmingList', 'othersInfoData', 'addressInfo', 'divisionList', 'districtList', 'thanaList'
                                , 'civilEducationInfoData', 'serviceRecordInfoData', 'awardRecordInfoData','punishmentRecordInfoData'
                                , 'defenceRelativeInfoData','courseList', 'nextKinAddressInfo', 'nextKinDistrictList', 'nextKinThanaList'
                                , 'studentMedicalDetails', 'studentWinterTrainingInfoData')
                );
    }
//
//    public function editProfile(Request $request) {
//        $studentInfo = User::leftJoin('student_basic_profile', 'student_basic_profile.user_id', '=', 'users.id')
//                ->leftjoin('rank', 'rank.id', '=', 'users.rank_id')
//                ->leftjoin('unit', 'unit.id', '=', 'student_basic_profile.unit_id')
//                ->leftjoin('religion', 'religion.id', '=', 'student_basic_profile.religion_id')
//                ->leftjoin('formation', 'formation.id', '=', 'student_basic_profile.formation_id')
//                ->leftjoin('appointment', 'appointment.id', '=', 'users.appointment_id')
//                ->leftjoin('arms_service', 'arms_service.id', '=', 'student_basic_profile.arms_service_id')
//                ->leftJoin('course', 'course.id', '=', 'student_basic_profile.course_id')
//                ->leftJoin('commissioning_course', 'commissioning_course.id', '=', 'student_basic_profile.commissioning_course_id')
//                ->select('users.id as user_id', 'users.email', 'users.photo', 'users.phone'
//                        , DB::raw("CONCAT(rank.code, ' ', users.full_name, ' (', users.official_name, ')') as student_name")
//                        , 'appointment.name', 'course.name as course_name', 'arms_service.name as arms_service_name'
//                        , 'commissioning_course.name as commissioning_course_name', 'unit.name as unit_name', 'religion.name as religion_name'
//                        , 'formation.name as formation_name', 'student_basic_profile.*'
//                )
//                ->where('student_basic_profile.user_id', $request->user_id)
//                ->first();
//        return response()->json(['studentInfo' => $studentInfo]);
//    }

    public function updateProfile(Request $request) {

        $rules = [
            'full_name' => 'required',
            'official_name' => 'required',
            'username' => 'required',
            'appointment_id' => 'required|not_in:0',
            'email' => 'email',
        ];

        $messages = [
            'not_in' => __('label.APPOINMENT_ERROR'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }

        //Start:: User table update
        $userStudent = User::find($request->user_id);
        $userStudent->full_name = $request->full_name;
        $userStudent->official_name = $request->official_name;
        $userStudent->username = $request->username;
        $userStudent->email = $request->email;
        $userStudent->phone = $request->phone;
        $userStudent->appointment_id = $request->appointment_id;
        
                $height = (($request->ht_ft * 12) + $request->ht_inch) * 0.0254;
        $bmi = ($request->weight / ($height * $height));
        if ($bmi > 18.5 && $bmi < 25) {
            $studentMedical = '2';
        } elseif ($bmi < 18.5) {
            $studentMedical= '1';
        } elseif ($bmi >= 25) {
            $studentMedical = '3';
        }
        //End:: User table update
        //Start:: Student Basic Profile update
        DB::beginTransaction();
        try {
            if ($userStudent->save()) {
                $studentArr = [
                    'commanding_officer_name' => $request->commanding_officer_name,
                    'commanding_officer_contact_no' => $request->commanding_officer_contact_no,
                    'commisioning_date' => !empty($request->commisioning_date) ? Helper::dateFormatConvert($request->commisioning_date) : null,
                    'anti_date_seniority' => $request->anti_date_seniority,
                    'course_position' => $request->course_position,
                    'position_out' => $request->position_out,
                    'nationality' => $request->nationality,
                    'birth_place' => $request->birth_place,
                    'religion_id' => $request->religion_id,
                    'arms_service_id' => $request->arms_service_id,
                    'unit_id' => $request->unit_id,
                    'formation_id' => $request->formation_id,
                    'ht_ft' => $request->ht_ft,
                    'ht_inch' => $request->ht_inch,
                    'weight' => $request->weight,
                    'medical_categorize' => $request->medical_categorize,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ];
                StudentBasicProfile::where('user_id', $request->user_id)->update($studentArr);
                StudentMedicalDetails::where('user_id', $request->user_id)->update(['over_under_weight' => $studentMedical]);
            }
            DB::commit();
            //Session::flash('success', __('label.STUDENT_PROFILE_UPDATED_SUCCESSFULLY'));
            return response()->json(['success' => __('label.STUDENT_PROFILE_UPDATED_SUCCESSFULLY')]);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => __('label.STUDENT_PROFILE_COULD_NOT_BE_UPDATED')]);
        }

        //End:: Student Basic Profile update
        //End updateProfile function     
    }

    public function updateProfilePhoto(Request $request) {
        $userStudent = User::find($request->user_id);

        $rules = [
            'photo' => 'required|image|mimes:jpeg,png,jfif,jpg,gif,webp|max:1024',
        ];

        $messages = [
            'image.max' => 'The :attribute should not exeed from 1MB.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }

        //Update with Folder
        if (!empty($request->file('photo'))) {
            $filePath = public_path("uploads/user/" . $userStudent->photo);
            if (File::exists($filePath))
                File::delete($filePath);
        }

        //Photo update and upload
        $file = $request->file('photo');
        if (!empty($file)) {
            $fileName = uniqid() . "_" . Auth::user()->id . "." . $file->getClientOriginalExtension();
            $uploadSuccess = $file->move('public/uploads/user', $fileName);
        }

        $userStudent->photo = !empty($fileName) ? $fileName : '';
        if ($userStudent->save()) {
            return response()->json(['success' => __('label.STUDENT_PROFILE_PHOTO_UPDATED_SUCCESSFULLY')]);
        }

        //End:: updateProfilePhoto function
    }

    public function updatePassword(Request $request) {
        $userStudent = User::find($request->user_id);
        $rules = [
            'password' => 'required|same:conf_password',
        ];

        $messages = [
            'password.complex_password' => __('label.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION'),
        ];
        if (!empty($request->password)) {
            $rules['password'] = 'complex_password:,' . $request->password;
            $rules['conf_password'] = 'same:password';
        }
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }

        if (!empty($request->password)) {
            $userStudent->password = Hash::make($request->password);
        }
        if ($userStudent->save()) {
            return response()->json(['success' => __('label.STUDENT_PROFILE_PASSWORD_PHOTO_UPDATED_SUCCESSFULLY')]);
        }

        //End:: updatePassword function
    }

    public function updateFamilyInfo(Request $request) {
        $rules = [
            'father_name' => 'required',
            'father_occupation' => 'required',
            'father_address' => 'required',
            'mother_name' => 'required',
            'mother_occupation' => 'required',
            'mother_address' => 'required',
        ];

        $messages = [
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $studentPrevBasicInfo = StudentBasicProfile::select('id')->where('user_id', $request->user_id)->first();
        $studentBasicProfile = !empty($studentPrevBasicInfo->id) ? StudentBasicProfile::find($studentPrevBasicInfo->id) : new StudentBasicProfile;

        $studentBasicProfile->user_id = $request->user_id;
        $studentBasicProfile->father_name = $request->father_name;
        $studentBasicProfile->father_occupation = $request->father_occupation;
        $studentBasicProfile->father_address = $request->father_address;
        $studentBasicProfile->mother_name = $request->mother_name;
        $studentBasicProfile->mother_occupation = $request->mother_occupation;
        $studentBasicProfile->mother_address = $request->mother_address;

        if ($studentBasicProfile->save()) {
            return response()->json(['success' => __('label.STUDENT_FAMILY_INFO_UPDATED_SUCCESSFULLY')]);
        }
        //END:: updateFamilyInfo function
    }

    public function updateMaritalStatus(Request $request) {
        $rules = [
            'marital_status' => 'not_in:0',
        ];

        $messages = [
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $studentPrevBasicInfo = StudentBasicProfile::select('id')->where('user_id', $request->user_id)->first();
        $studentBasicProfile = !empty($studentPrevBasicInfo->id) ? StudentBasicProfile::find($studentPrevBasicInfo->id) : new StudentBasicProfile;
//        echo '<pre>';        print_r($studentBasicProfile); exit;

        $studentBasicProfile->marital_status = $request->marital_status;
        if ($request->marital_status == '1') {
            $rules = [
                //'marital_status' => 'not_in:0',
                'date_of_marriage' => 'required',
                'spouse_name' => 'required',
            ];

            $messages = [
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
            }

            $studentBasicProfile->date_of_marriage = Helper::dateFormatConvert($request->date_of_marriage);
            $studentBasicProfile->spouse_name = $request->spouse_name;
            $studentBasicProfile->spouse_occupation = $request->spouse_occupation;
            $studentBasicProfile->spouse_work_address = $request->spouse_work_address;
        } else {
            $studentBasicProfile->date_of_marriage = null;
            $studentBasicProfile->spouse_name = null;
            $studentBasicProfile->spouse_occupation = null;
            $studentBasicProfile->spouse_work_address = null;
        }
        if ($studentBasicProfile->save()) {
            return response()->json(['success' => __('label.STUDENT_MARITAL_STATUS_UPDATED_SUCCESSFULLY')]);
        }
        //End updateMaritialStatus function
    }

    public function rowAddForBrotherSister() {
        $html = view('studentProfile.brotherSisterRowAdd')
                ->render();
        return response()->json(['html' => $html]);

        ////End rowAdd function
    }

    public function updateBrotherSisterInfo(Request $request) {
        //echo '<pre>';print_r($request->all());exit;
        $studentBrotherSisterInfo = StudentBrotherSister::select('id')->where('user_id', $request->user_id)->first();
        $studentBrotherSisterProfile = !empty($studentBrotherSisterInfo->id) ? StudentBrotherSister::find($studentBrotherSisterInfo->id) : new StudentBrotherSister;

        //Check Validation for Brother/Sister Information
        $rules = $messages = [];
        if (!empty($request->brother_sister)) {
            $row = 1;
//            if (count(array_filter($request->brother_sister)) == 0) {
//                return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => __('label.INPUT_FIELD_EMPTY_MESSAGE')), 401);
//            }

            foreach ($request->brother_sister as $key => $brotherSister) {
                $rules['brother_sister.' . $key . '.name'] = 'required';
                $rules['brother_sister.' . $key . '.relation'] = 'required';

                $messages['brother_sister.' . $key . '.name.required'] = __('label.NAME_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['brother_sister.' . $key . '.relation.required'] = __('label.RELATION_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);

                $row++;
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }


        $brotherSisterInfo = json_encode($request->brother_sister);
        $studentBrotherSisterProfile->user_id = $request->user_id;
        $studentBrotherSisterProfile->brother_sister_info = $brotherSisterInfo;
        $studentBrotherSisterProfile->updated_at = date('Y-m-d H:i:s');
        $studentBrotherSisterProfile->updated_by = Auth::user()->id;

        //Update Brother/Sister Info in student_brother_sister_profile
        if ($studentBrotherSisterProfile->save()) {
            return response()->json(['success' => __('label.STUDENT_BROTHER_SISTER_INFO_UPDATED')]);
        } else {
            return response()->json(['failed' => __('label.STUDENT_BROTHER_SISTER_INFO_COULD_NOT_BE_UPDATED')]);
        }
    }

    public function updateStudentOthersInfo(Request $request) {
        $rules = [
            'swimming' => 'required|not_in:0',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }

        $studentOthersInfo = StudentOthers::select('id')->where('user_id', $request->user_id)->first();
        $studentOthersProfile = !empty($studentOthersInfo->id) ? StudentOthers::find($studentOthersInfo->id) : new StudentOthers;

        $othersInfo = json_encode($request->visited_countries_id);
        $studentOthersProfile->user_id = $request->user_id;
        $studentOthersProfile->visited_countries_id = $othersInfo;
        $studentOthersProfile->special_quality = $request->special_quality;
        $studentOthersProfile->swimming = $request->swimming;
        $studentOthersProfile->professional_computer = $request->professional_computer;
        $studentOthersProfile->updated_at = date('Y-m-d H:i:s');
        $studentOthersProfile->updated_by = Auth::user()->id;

        if ($studentOthersProfile->save()) {
            return response()->json(['success' => __('label.STUDENT_BROTHER_SISTER_INFO_UPDATED')]);
        }
        //End updateStudentOthersInfo function
    }

    //For Districts
    public function getDistrict(Request $request) {
        $districtList = ['0' => __('label.SELECT_DISTRICT_OPT')] + District::where('division_id', $request->division_id)
                        ->pluck('name', 'id')->toArray();
        $thanaList = ['0' => __('label.SELECT_THANA_OPT')];
        $htmldistrict = view('studentProfile.districts')->with(compact('districtList'))->render();
        $htmlThana = view('studentProfile.thana')->with(compact('thanaList'))->render();
        return response()->json(['html' => $htmldistrict, 'htmlThana' => $htmlThana]);
        //End getDistrict function
    }

    //For Thana
    public function getThana(Request $request) {
        $thanaList = ['0' => __('label.SELECT_THANA_OPT')] + THANA::where('district_id', $request->district_id)->pluck('name', 'id')->toArray();
        $htmlThana = view('studentProfile.thana')->with(compact('thanaList'))->render();
        return response()->json(['html' => $htmlThana]);
        //End getThana function
    }

    public function updatePermanentAddress(Request $request) {
        //echo '<pre>';        print_r($request->all()); exit;
        $rules = [
            'division_id' => 'required|not_in:0',
            'district_id' => 'required|not_in:0',
            'thana_id' => 'required|not_in:0',
        ];

        $messages = [
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $studentPermanentAddress = StudentPermanentAddress::select('id')->where('user_id', $request->user_id)->first();
        $studentPermanentAddressInfo = !empty($studentPermanentAddress->id) ? StudentPermanentAddress::find($studentPermanentAddress->id) : new StudentPermanentAddress;
        $studentPermanentAddressInfo->user_id = $request->user_id;
        $studentPermanentAddressInfo->division_id = $request->division_id;
        $studentPermanentAddressInfo->district_id = $request->district_id;
        $studentPermanentAddressInfo->thana_id = $request->thana_id;
        $studentPermanentAddressInfo->address_details = $request->address_details;
        $studentPermanentAddressInfo->updated_at = date('Y-m-d H:i:s');
        $studentPermanentAddressInfo->updated_by = Auth::user()->id;

        if ($studentPermanentAddressInfo->save()) {
            return response()->json(['success' => __('label.STUDENT_PERMANENT_ADDRESS_UPDATED')]);
        }
        //End updatePermanentAddress function
    }

    public function rowAddForCivilEducation() {
        $html = view('studentProfile.civilEducationRowAdd')
                ->render();
        return response()->json(['html' => $html]);

        ////End rowAdd function
    }

    public function updateCivilEducationInfo(Request $request) {
        //Check Validation for Civil Education Information
        $rules = $messages = [];
        if (!empty($request->civil_education)) {
            $row = 1;

            foreach ($request->civil_education as $key => $civilEducation) {
                $rules['civil_education.' . $key . '.institute_name'] = 'required';
                $rules['civil_education.' . $key . '.examination'] = 'required';
                $rules['civil_education.' . $key . '.result'] = 'required';
                $rules['civil_education.' . $key . '.year'] = 'required';

                $messages['civil_education.' . $key . '.institute_name.required'] = __('label.INSTITUTE_NAME_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['civil_education.' . $key . '.examination.required'] = __('label.EXAMINATION_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['civil_education.' . $key . '.result.required'] = __('label.RESULT_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['civil_education.' . $key . '.year.required'] = __('label.RELATION_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);

                $row++;
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $civilEducationInfo = StudentCivilEducation::select('id')->where('user_id', $request->user_id)->first();
        $civilEducationProfile = !empty($civilEducationInfo->id) ? StudentCivilEducation::find($civilEducationInfo->id) : new StudentCivilEducation;



        $civilEducation = json_encode($request->civil_education);
        $civilEducationProfile->user_id = $request->user_id;
        $civilEducationProfile->civil_education_info = $civilEducation;
        $civilEducationProfile->updated_at = date('Y-m-d H:i:s');
        $civilEducationProfile->updated_by = Auth::user()->id;

        //Update student civil education
        if ($civilEducationProfile->save()) {
            return response()->json(['success' => __('label.CIVIL_EDUCATION_INFO_UPDATED')]);
        }
        //End updateCivilEducationInfo function
    }

    public function rowAddForServiceRecord() {
        $appointmentList = ['0' => __('label.SELECT_APPT_OPT')] + StudentAppointment::pluck('code', 'id')->toArray();
        $unitList = ['0' => __('label.SELECT_UNIT_OPT')] + Unit::pluck('code', 'id')->toArray();

        $html = view('studentProfile.serviceRecordRowAdd')->with(compact('appointmentList', 'unitList'))
                ->render();
        return response()->json(['html' => $html]);

        ////End rowAdd function
    }
    
    public function updateServiceRecordInfo(Request $request) {
        //Check Validation for Service Record Information
        $rules = $messages = [];
        if (!empty($request->service_record)) {
            $row = 1;

            foreach ($request->service_record as $srKey => $serviceRecord) {
                $rules['service_record.' . $srKey . '.unit'] = 'not_in:0';
                $rules['service_record.' . $srKey . '.appointment'] = 'not_in:0';
                $rules['service_record.' . $srKey . '.year'] = 'required';

                $messages['service_record.' . $srKey . '.unit.not_in'] = __('label.UNIT_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['service_record.' . $srKey . '.appointment.not_in'] = __('label.APPOINTMENT_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['service_record.' . $srKey . '.year.required'] = __('label.YEAR_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);

                $row++;
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        
        $serviceEducationInfo = StudentServiceRecord::select('id')->where('user_id', $request->user_id)->first();
        $serviceEducationProfile = !empty($serviceEducationInfo->id) ? StudentServiceRecord::find($serviceEducationInfo->id) : new StudentServiceRecord;

        $serviceRecord = json_encode($request->service_record);
        $serviceEducationProfile->user_id = $request->user_id;
        $serviceEducationProfile->service_record_info = $serviceRecord;
        $serviceEducationProfile->updated_at = date('Y-m-d H:i:s');
        $serviceEducationProfile->updated_by = Auth::user()->id;

        //Update student service record
        if ($serviceEducationProfile->save()) {
            return response()->json(['success' => __('label.SERVICE_RECORD_INFO_UPDATED')]);
        }
        //End updateServiceRecordInfo function
    }

    public function rowAddForAwardRecord() {
        $html = view('studentProfile.awardRecordRowAdd')
                ->render();
        return response()->json(['html' => $html]);

        ////End rowAdd function
    }
    
     public function updateAwardRecordInfo(Request $request) {
        //Check Validation for Award Record Information
        $rules = $messages = [];
        if (!empty($request->award_record)) {
            $row = 1;

            foreach ($request->award_record as $key => $awardRecord) {
                $rules['award_record.' . $key . '.award'] = 'required';
                $rules['award_record.' . $key . '.reason'] = 'required';
                $rules['award_record.' . $key . '.year'] = 'required';

                $messages['award_record.' . $key . '.award.required'] = __('label.AWARD_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['award_record.' . $key . '.reason.required'] = __('label.REASON_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['award_record.' . $key . '.year.required'] = __('label.YEAR_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);

                $row++;
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $awardRecordInfo = StudentAwardRecord::select('id')->where('user_id', $request->user_id)->first();
        $awardRecordProfile = !empty($awardRecordInfo->id) ? StudentAwardRecord::find($awardRecordInfo->id) : new StudentAwardRecord;



        $awardRecord = json_encode($request->award_record);
        $awardRecordProfile->user_id = $request->user_id;
        $awardRecordProfile->award_record_info = $awardRecord;
        $awardRecordProfile->updated_at = date('Y-m-d H:i:s');
        $awardRecordProfile->updated_by = Auth::user()->id;

        //Update student award record
        if ($awardRecordProfile->save()) {
            return response()->json(['success' => __('label.AWARD_RECORD_INFO_UPDATED')]);
        }
        //End updateAwardRecordInfo function
    }
    
    public function rowAddForPunishmentRecord() {
        $html = view('studentProfile.punishmentRecordRowAdd')
                ->render();
        return response()->json(['html' => $html]);

        ////End rowAdd function
    }
    
     public function updatePunishmentRecordInfo(Request $request) {
        //Check Validation for Punishment Record Information
        $rules = $messages = [];
        if (!empty($request->punishment_record)) {
            $row = 1;

            foreach ($request->punishment_record as $key => $punishmentRecord) {
                $rules['punishment_record.' . $key . '.punishment'] = 'required';
                $rules['punishment_record.' . $key . '.reason'] = 'required';
                $rules['punishment_record.' . $key . '.year'] = 'required';

                $messages['punishment_record.' . $key . '.punishment.required'] = __('label.PUNISHMENT_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['punishment_record.' . $key . '.reason.required'] = __('label.REASON_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['punishment_record.' . $key . '.year.required'] = __('label.YEAR_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);

                $row++;
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $punishmentRecordInfo = StudentPunishmentRecord::select('id')->where('user_id', $request->user_id)->first();
        $punishmentRecordProfile = !empty($punishmentRecordInfo->id) ? StudentPunishmentRecord::find($punishmentRecordInfo->id) : new StudentPunishmentRecord;



        $punishmentRecord = json_encode($request->punishment_record);
        $punishmentRecordProfile->user_id = $request->user_id;
        $punishmentRecordProfile->punishment_record_info = $punishmentRecord;
        $punishmentRecordProfile->updated_at = date('Y-m-d H:i:s');
        $punishmentRecordProfile->updated_by = Auth::user()->id;

        //Update student punishment record
        if ($punishmentRecordProfile->save()) {
            return response()->json(['success' => __('label.PUNISHMENT_RECORD_INFO_UPDATED')]);
        }
        //End updatePunishmentRecordInfo function
    }
    public function rowAddForDefenceRelative() {
        $courseList = ['0' => __('label.SELECT_COURSE_OPT')] + Course::pluck('name', 'id')->toArray();
        $html = view('studentProfile.defenceRelativeRowAdd')->with(compact('courseList'))
                ->render();
        return response()->json(['html' => $html]);

        ////End rowAddForDefenceRelative function
    }
    
     public function updateDefenceRelativeInfo(Request $request) {
        //Check Validation for Punishment Record Information
        $rules = $messages = [];
        if (!empty($request->defence_relative)) {
            $row = 1;

            foreach ($request->defence_relative as $key => $defenceRelative) {
                $rules['defence_relative.' . $key . '.course'] = 'not_in:0';
                $rules['defence_relative.' . $key . '.institute'] = 'required';
                $rules['defence_relative.' . $key . '.grading'] = 'required';
                $rules['defence_relative.' . $key . '.year'] = 'required';

                $messages['defence_relative.' . $key . '.course.not_in'] = __('label.COURSE_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['defence_relative.' . $key . '.institute.required'] = __('label.INSTITUTE_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['defence_relative.' . $key . '.grading.required'] = __('label.GRADING_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['defence_relative.' . $key . '.year.required'] = __('label.YEAR_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);

                $row++;
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $defenceRecordInfo = StudentRelativeInDefence::select('id')->where('user_id', $request->user_id)->first();
        $defenceRecordProfile = !empty($defenceRecordInfo->id) ? StudentRelativeInDefence::find($defenceRecordInfo->id) : new StudentRelativeInDefence;



        $defenceRecord = json_encode($request->defence_relative);
        $defenceRecordProfile->user_id = $request->user_id;
        $defenceRecordProfile->student_relative_info = $defenceRecord;
        $defenceRecordProfile->updated_at = date('Y-m-d H:i:s');
        $defenceRecordProfile->updated_by = Auth::user()->id;

        //Update student punishment record
        if ($defenceRecordProfile->save()) {
            return response()->json(['success' => __('label.PUNISHMENT_RECORD_INFO_UPDATED')]);
        }
        //End updatePunishmentRecordInfo function
    }
    
    public function updateNextKin(Request $request) {
        //echo '<pre>';        print_r($request->all()); exit;
        $rules = [
            'kin_name' => 'required',
            'kin_relation' => 'required',
            'kin_division_id' => 'not_in:0',
            'kin_district_id' => 'not_in:0',
            'kin_thana_id' => 'not_in:0',
        ];

        $messages = [
            'kin_name.required' => 'The name field is required',
            'kin_relation.required' => 'The relation field is required',
            'kin_division_id.not_in' => 'The division field is required',
            'kin_district_id.not_in' => 'The district field is required',
            'kin_thana_id.not_in' => 'The thana field is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $studentNextKin = StudentNextKin::select('id')->where('user_id', $request->user_id)->first();
        $studentNextKinInfo = !empty($studentNextKin->id) ? StudentNextKin::find($studentNextKin->id) : new StudentNextKin;
        $studentNextKinInfo->user_id = $request->user_id;
        $studentNextKinInfo->name = $request->kin_name;
        $studentNextKinInfo->relation = $request->kin_relation;
        $studentNextKinInfo->division_id = $request->kin_division_id;
        $studentNextKinInfo->district_id = $request->kin_district_id;
        $studentNextKinInfo->thana_id = $request->kin_thana_id;
        $studentNextKinInfo->address_details = $request->kin_address_details;
        $studentNextKinInfo->updated_at = date('Y-m-d H:i:s');
        $studentNextKinInfo->updated_by = Auth::user()->id;

        if ($studentNextKinInfo->save()) {
            return response()->json(['success' => __('label.STUDENT_NEXT_KIN_INFO_UPDATED')]);
        }
        //End updatePermanentAddress function
    }
    public function updateMedicalDetails(Request $request) {
        //echo '<pre>';        print_r($request->all()); exit;
        $rules = [
            'category' => 'required',
            'blood_group' => 'required',
            'date_of_birth' => 'required',
        ];

        $messages = [
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $studentMedicalDetails = StudentMedicalDetails::select('id')->where('user_id', $request->user_id)->first();
        $studentBasicInfo = StudentBasicProfile::select('id','ht_ft', 'ht_inch', 'weight')->where('user_id', $request->user_id)->first();
//        echo '<pre>';        print_r($studentBasicInfo); exit;
        $studentMedicalDetailsInfo = !empty($studentMedicalDetails->id) ? StudentMedicalDetails::find($studentMedicalDetails->id) : new StudentMedicalDetails;
        $studentMedicalDetailsInfo->user_id = $request->user_id;
        $studentMedicalDetailsInfo->category = $request->category;
        $studentMedicalDetailsInfo->blood_group = $request->blood_group;
        $studentMedicalDetailsInfo->date_of_birth = !empty($request->date_of_birth) ? Helper::dateFormatConvert($request->date_of_birth) : null;
        $studentBasicInfo->ht_ft = $request->ht_ft;
        $studentBasicInfo->ht_inch = $request->ht_inch;
        $studentBasicInfo->weight = $request->weight;
        
//        $height = (($request->ht_ft * 12) + $request->ht_inch)*0.0254;
//        $bmi =($request->weight/($height*$height));
//        if($bmi >18.5 && $bmi < 25 ){
//            $studentMedicalDetailsInfo->over_under_weight = 2;
//        }elseif ($bmi < 18.5) {
//            $studentMedicalDetailsInfo->over_under_weight = 1;
//        }elseif ($bmi >= 25) {
//            $studentMedicalDetailsInfo->over_under_weight = 3;
//        }
        $studentMedicalDetailsInfo->over_under_weight = $request->over_under_weight;
        $studentMedicalDetailsInfo->any_disease = $request->any_disease;
        $studentMedicalDetailsInfo->updated_at = date('Y-m-d H:i:s');
        $studentMedicalDetailsInfo->updated_by = Auth::user()->id;

        if ($studentMedicalDetailsInfo->save() && $studentBasicInfo->save()) {
            return response()->json(['success' => __('label.STUDENT_MEDICAL_DETAILS_INFO_UPDATED')]);
        }
        //End updateMedicalDetails function
    }
    public function updateWinterTraining(Request $request) {
        //echo '<pre>';        print_r($request->all()); exit;
        //Check Validation for Punishment Record Information
        
        $rules = $messages = [];
        $rules['participated_no'] = 'required';
        if (!empty($request->winter_training)) {
            $row = 1;

            foreach ($request->winter_training as $key => $winterTraining) {
                $rules['winter_training.' . $key . '.exercise'] = 'required';
                $rules['winter_training.' . $key . '.year'] = 'required';
               
                $messages['winter_training.' . $key . '.exercise.required'] = __('label.EXERCISE_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                $messages['winter_training.' . $key . '.year.required'] = __('label.YEAR_INPUT_FIELD_EMPTY_MESSAGE', ["counter" => $row]);
                
                $row++;
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => __('label.VALIDATION_ERROR'), 'message' => $validator->errors()), 400);
        }
        $studentWinterTraining = StudentWinterCollectiveTraining::select('id')->where('user_id', $request->user_id)->first();
        $studentWinterTrainingInfo = !empty($studentWinterTraining->id) ? StudentWinterCollectiveTraining::find($studentWinterTraining->id) : new StudentWinterCollectiveTraining;
        
        $winterTraining = json_encode($request->winter_training);
        $studentWinterTrainingInfo->user_id = $request->user_id;
        $studentWinterTrainingInfo->participated_no = $request->participated_no;
        $studentWinterTrainingInfo->training_info = $winterTraining;
        $studentWinterTrainingInfo->updated_at = date('Y-m-d H:i:s');
        $studentWinterTrainingInfo->updated_by = Auth::user()->id;

        if ($studentWinterTrainingInfo->save()) {
            return response()->json(['success' => __('label.STUDENT_WINTER_TRAINING_INFO_UPDATED')]);
        }
        //End updatePermanentAddress function
    }

//End class
}

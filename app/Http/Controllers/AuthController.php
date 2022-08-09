<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {

         $requestData = $request->all();
         $validator = Validator::make($requestData,[
             'first_name' => 'required',
             'last_name' => 'required',
             'civil_id' => 'nullable|required_without:passport_id|unique:users,civil_id',
             'passport_id' => 'nullable|required_without:civil_id|unique:users,passport_id',
             'email' => 'email|required|unique:users|regex:/(.+)@(.+)\.(.+)/i',
             'phone' => 'required|unique:users',
             'whatsapp_number' => 'required',
             'dob' => 'required',
             'age' => 'required',
             'gender' => 'required',
//             'file' => 'required',

             'password' => 'required|min:8|max:20|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|confirmed'
        ],['dob.required'=>'Date Of Birth is required','file.required'=>'Civil Id or Passport copy is required ',
         'password.regex'=>'Passwords must be at least 8 characters long and contain at least Uppercase letters , Lowercase letters , Numbers and Non-alphnumeric characters']);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $upload_path = public_path('uploads');
        $generated_new_name = '';
        $PPgenerated_new_name = '';
        if($request->file) {

            $file_name = $request->file->getClientOriginalName();
            $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move($upload_path, $generated_new_name);
        }

        if($request->profile_picture) {
            $pfile_name = $request->profile_picture->getClientOriginalName();
            $PPgenerated_new_name = time() . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move($upload_path, $PPgenerated_new_name);
        }
        $requestData['file']=$generated_new_name;
        $requestData['profile_picture']=$PPgenerated_new_name                                                                                   ;
        $requestData['name'] = $requestData['first_name'].' '.$requestData['last_name'];
        $requestData['password'] = Hash::make($requestData['password']);
        $requestData['otp'] = $this->generateOtpUniqueNumber();

        $user = User::create($requestData);
        session(['userId'=>$user->id]);
         (sendsmsRegotp($user));

        return response([ 'status' => true, 'message' => 'User successfully register.' ], 200);
    }
    public function generateOtpUniqueNumber()
    {
        $bookingUniqueNumber = rand(100000, 999999);
        $booking = User::where('otp', $bookingUniqueNumber)->first();

        if (!$booking) {
            return $bookingUniqueNumber;
        }

        $this->generateBookingUniqueNumber();
    }
    public function login(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'civil_id' => 'required',
            'password' => 'required'
        ],['civil_id.required'=>'Civil Id or Passport is required ']);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if(User::where('passport_id',$request->civil_id)->first())
        {
            $requestData['passport_id'] = $request->civil_id;
            unset($requestData['civil_id']);

        }
        if(! auth()->attempt($requestData)){
            return response()->json(['errors' => 'Wrong Civil Id / Passport or Password'], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user], 200);
    }

    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function resendotp(Request $request)
    {
        $phone = User::where('id',session('userId'))->first();
        if(!$phone)
        {
            return ['status'=>0,'message'=>'User not found'];
        }
        $otp = User::where('id',session('userId'))->update(['otp'=>$this->generateOtpUniqueNumber()]);
        $phone = User::where('id',session('userId'))->first();

        (sendsmsRegotp($phone));
        return ['status'=>1,'message'=>'OTP Sent Successfully.'];
    }
    public function updateprofile(Request $request)
    {
        $requestData = $request->all();
         $validator = Validator::make($requestData,[

            'email' => 'required|unique:users,email,'.Auth::id().'|regex:/(.+)@(.+)\.(.+)/i',
            'phone' => 'required|unique:users,phone,'.Auth::id(),

        ],['dob.required'=>'Date Of Birth is required','file.required'=>'Civil Id or Passport copy is required ']);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $user = User::find(Auth::id());
        $upload_path = public_path('uploads');
        $generated_new_name = '';
        $PPgenerated_new_name = null;
         if($request->hasFile('profile_picture')) {
            $pfile_name = $request->profile_picture->getClientOriginalName();
            $PPgenerated_new_name = time() . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move($upload_path, $PPgenerated_new_name);
        }
        $user->update_phone = $request->phone;
        $user->update_email = $request->email;
        $user->update_profile_picture = $user->profile_picture;
        if($PPgenerated_new_name)
        {
            $user->update_profile_picture = $PPgenerated_new_name;
        }
        $user->update_otp = $this->generateOtpUniqueNumber();
        $user->save();
        $user->refresh();
        session(['userUpdateId'=>$user->id]);

        if($user->update_phone && ($user->update_phone!=$user->phone))
        {
            sendupdatephonesms($user);

        }
        else
        {
            sendupdatesms($user);
        }
        return response([ 'status' => true, 'message' => 'User successfully updated.' ], 200);

    }
    public function resendupdateotp(Request $request)
    {
        $phone = User::where('id',session('userUpdateId'))->first();
        if(!$phone)
        {
            return ['status'=>0,'message'=>'User not found'];
        }
        $otp = User::where('id',session('userUpdateId'))->update(['otp'=>$this->generateOtpUniqueNumber()]);
        $user = User::where('id',session('userUpdateId'))->first();
        if($user->update_phone && ($user->update_phone!=$user->phone))
        {
            sendupdatephonesms($user);

        }
        else
        {
            sendupdatesms($user);
        }
        return response([ 'status' => true, 'message' => 'User successfully updated.' ], 200);

    }
    public function resetlink(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[

            'phone' => 'required',

        ],['dob.required'=>'Date Of Birth is required','file.required'=>'Civil Id or Passport copy is required ']);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
         $user = User::where('phone',$request->phone)->first();
        if($user)
        {
            $user->reset_password_otp = $this->generateOtpUniqueNumber();
            $user->save();
            $user->refresh();
            session(['setPasswordUser'=>$user->id]);
            sendsmsForgetPassotp($user);
            return ['status'=>1,'message'=>'Otp Sent '];

        }
        return response()->json([
            'errors' => 'Invalid Mobile No'
        ], 402);
    }
    public function setPassword(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[

            'otp' => 'required',
            'password' => 'required|min:8|max:20|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|confirmed'

        ],['dob.required'=>'Date Of Birth is required','file.required'=>'Civil Id or Passport copy is required ',
        'password.regex'=>'Passwords must be at least 8 characters long and contain at least Uppercase letters , Lowercase letters , Numbers and Non-alphnumeric characters'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $phone = User::where('reset_password_otp',$request->otp)->first();
        if(!$phone)
        {
            return response()->json([
                'errors' => 'Wrong OTP'
            ], 402);
         }
        $phone->reset_password_otp = null;
        $phone->password = bcrypt($request->password);
        $phone->save();
        return ['status'=>1,'message'=>'password saved'];
    }
    public function checkotp(Request $request)
    {
        $phone = User::where('otp',$request->otp)->first();
        if(!$phone)
        {
            return ['status'=>0,'message'=>'Wrong OTP '];
        }
        $phone->email_verified_at = Carbon::now();
        $phone->otp = null;
        $phone->save();
        return ['status'=>1,'message'=>'OTP found'];

    }
    public function checkupdateotp(Request $request)
    {
        $phone = User::where('update_otp',$request->otp)->first();
        if(!$phone)
        {
            return ['status'=>0,'message'=>'Wrong OTP '];
        }
        $userId = $phone->id;
        $phone->phone = $phone->update_phone;
        $phone->email =$phone->update_email;
        $phone->profile_picture = $phone->update_profile_picture;
        $phone->update_phone = null;
        $phone->update_email = null;
        $phone->update_profile_picture = null;
        $phone->update_otp = null;
        $phone->save();
        $user = User::find($userId);
        return ['status'=>1,'message'=>'OTP found','user'=>$user];

    }
}

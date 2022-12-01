<?php

namespace App\Http\Controllers\API\Auth;

use App\Repositories\SMS;
use Illuminate\Http\Response;
use App\Http\Requests\OTPRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ReSendOtpRequest;
use App\Http\Requests\RegistrationRequest;
use App\Repositories\VerificationCodeRepository;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepo;
    /**
     * @var VerificationCodeRepository
     */
    private $verificationCodeRepo;

    public function __construct(UserRepository $userRepo, VerificationCodeRepository $verificationCodeRepository)
    {
        $this->userRepo = $userRepo;
        $this->verificationCodeRepo = $verificationCodeRepository;
    }

    public function register(RegistrationRequest $request)
    {
        $contact = \formatMobile($request->mobile);

        $user = $this->userRepo->registerUser($request);

        $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($contact);

        #todo create an event send otp to mobile

        $user->assignRole('customer');

        $user->update([
            'mobile_verified_at' => now()
        ]);

        // (new SMS())->sendSms($contact, $verificationCode->otp, app()->environment('production'));

        $message = !app()->environment('production') ? 'Registration successfully complete (OTP = ' . $verificationCode->otp . ')' : 'Registration successfully complete';

        return $this->json($message , [
            'user' => new UserResource($user),
            'access' => $this->userRepo->getAccessToken($user)
        ]);
    }

    public function mobileVerify(OTPRequest $request)
    {
        $contact = \formatMobile($request->contact);
        $user = $this->userRepo->findByContact($contact);
        $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($contact);

        if (!is_null($user) && $verificationCode->otp == $request->otp) {
            $verificationCode->delete();
            $user->update([
                'mobile_verified_at' => now()
            ]);
            return $this->json('Mobile verification complete', [
                'user' => new UserResource($user)
            ]);
        }
        return $this->json('Invalid OTP or contact!', [], Response::HTTP_BAD_REQUEST);
    }

    public function login(LoginRequest $request)
    {
        if ($user = $this->authenticate($request)) {
            return $this->json('Log In Successful', [
                'user' => new UserResource($user),
                'access' => $this->userRepo->getAccessToken($user)
            ]);
        }
        return $this->json('Credential is invalid!', [], Response::HTTP_BAD_REQUEST);
    }

    public function logout()
    {
        $user = auth()->user();
        if ($user) {
            $user->token()->revoke();
            return $this->json('Logged out successfully!');
        }
        return $this->json('No Logged in user found', [], Response::HTTP_UNAUTHORIZED);
    }

    private function authenticate(LoginRequest $request)
    {
        $user = $this->userRepo->findActiveByContact($request->contact);

        if (!is_null($user) && Hash::check($request->password, $user->password)) {
            return $user;
        }

        return false;
    }

    public function resendOTP(ReSendOtpRequest $request)
    {
        $contact = \formatMobile($request->contact);
        $user = $this->userRepo->findByContact($contact);

        if($user){
            $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($contact);
            $message = !app()->environment('production') ? 'Verification code is resent success to your contact (OTP = ' . $verificationCode->otp . ')' : 'Verification code is resent success to your contact';

            // (new SMS())->sendSms($contact, $verificationCode->otp, app()->environment('production'));

            return $this->json($message);
        }

        return $this->json('Sorry, your contact is not found!');
    }
}

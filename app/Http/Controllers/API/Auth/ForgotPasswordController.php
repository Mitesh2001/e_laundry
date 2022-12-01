<?php

namespace App\Http\Controllers\API\Auth;

use App\Repositories\SMS;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Repositories\VerificationCodeRepository;
use App\Http\Requests\ForgotPasswordOtpVerifyRequest;

class ForgotPasswordController extends Controller
{
    /**
     * @var VerificationCodeRepository
     */
    private $verificationCodeRepo;

    private $userRepo;

    public function __construct(VerificationCodeRepository $verificationCodeRepo, UserRepository $userRepo)
    {
        $this->verificationCodeRepo = $verificationCodeRepo;
        $this->userRepo = $userRepo;
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $mobile = formatMobile($request->mobile);

        $user = $this->userRepo->findByContact($mobile);

        if (!$user) {
            return $this->json('Sorry! No user found with this mobile.', [], Response::HTTP_BAD_REQUEST);
        }

        $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($user->mobile);

        (new SMS())->sendSms($mobile, $verificationCode->otp, app()->environment('production'));

        #todo create an event send otp to mobile

        $message = !app()->environment('production') ? 'We sent otp to your mobile (OTP = ' . $verificationCode->otp . ')' : 'We sent otp to your mobile';

        return $this->json($message);
    }

    public function verifyOtp(ForgotPasswordOtpVerifyRequest $request)
    {
        $mobile = formatMobile($request->mobile);

        $user = $this->userRepo->findByContact($mobile);

        if (!$user) {
            return $this->json('Sorry! No user found with this mobile.', [], Response::HTTP_BAD_REQUEST);
        }

        $verificationCode = $this->verificationCodeRepo->checkCode($request->mobile, $request->otp);

        if (!$verificationCode){
            return $this->json('Invalid OTP', [], Response::HTTP_BAD_REQUEST);
        }

        return $this->json('Otp matched successfully!', [
            'token' => $verificationCode->token
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $verifyCode = $this->verificationCodeRepo->checkByToken($request->token);

        if (!$verifyCode) {
            return $this->json('Invalid token', [], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepo->findByContact($verifyCode->contact);

        if (!$user) {
            return $this->json('Sorry! No user found with this mobile.', [], Response::HTTP_BAD_REQUEST);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $verifyCode->delete();

        return $this->json('Password reset successfully!');
    }
}

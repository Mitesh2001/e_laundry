<?php

namespace App\Repositories;

use App\Models\VerificationCode;

class VerificationCodeRepository extends Repository
{
    public function model()
    {
        return VerificationCode::class;
    }

    public function findOrCreateByContact($mobile): VerificationCode
    {
        $verificationCode = $this->model()::where('contact', $mobile)->first();

        if (!$verificationCode) {
            $verificationCode = $this->model()::create([
                'contact' => $mobile,
                'otp' => $this->generateUniqueOtp(),
                'token' => $this->generateUniqueToken(),
            ]);
        }

        return $verificationCode;
    }

    public function checkCode($mobile, $otp): ?VerificationCode
    {
        return $this->model()::where(['contact' => $mobile, 'otp' => $otp])
            ->latest()
            ->first();
    }

    public function checkByToken($token)
    {
        return $this->model()::where('token', $token)->latest()->first();
    }

    private function generateUniqueOtp(): int
    {
        do {
            $otp = mt_rand(1000, 9999);
        } while ($this->query()->where('otp', $otp)->exists());

        return $otp;
    }

    private function generateUniqueToken()
    {
        do {
            $token = $this->generateToken();
        } while ($this->query()->where('token', $token)->exists());

        return $token;
    }

    private function generateToken()
    {
        return hash_hmac(
            'sha256',
            uniqid(rand(100000000, 100000000000000), true),
            substr(md5(mt_rand()), 500000000, 700000000000)
        );
    }
}

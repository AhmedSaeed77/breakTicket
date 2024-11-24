<?php

namespace App\Http\Services\api;
use Laravel\Socialite\Facades\Socialite;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Resources\api\SocialResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialLoginService
{
    use GeneralTrait;

    public function redirect($provider)
    {
        $link = Socialite::with($provider)->stateless()->redirect()->getTargetUrl();
        return $this->returnData('data',$link);
    }

    public function Callback($provider)
    {
        $userSocial = Socialite::with($provider)->stateless()->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();
        if($user)
        {
            $token = $users->createToken($userSocial->getEmail())->plainTextToken;
            $url = 'https://halaticket.com';
            return $this->returnData(['data' => $url,'token' => $token]);
        }
        else
        {
            $user = User::create([
                                    'name'          => $userSocial->getName(),
                                    'email'         => $userSocial->getEmail(),
                                    'phone'         => $userSocial->getPhone(),
                                    'provider_id'   => $userSocial->getId(),
                                    'provider'      => $provider,
                                ]);
            
            $token =  $user->createToken($userSocial->getEmail())->plainTextToken;
            $url = 'https://halaticket.com';
            return $this->returnData(['data' => $url,'token' => $token]);
        }
    }

    public function checkSocial(Request $request)
    {
        return $this->socialService->Callback($provider);
        $user = $request->user();
        
        if ($user) 
        {
            $token =  $user->createToken('myapptoken')->plainTextToken;
            return $this->returnData(['token' => $token]);
        }
        else
        {
            return  response()->json(['access-denied',403]);
        }

    }

}

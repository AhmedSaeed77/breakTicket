<?php

namespace App\Http\Services\api;

use App\Repository\UserRepositoryInterface;
use App\Repository\ResetPasswordRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\OrderTicketRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Traits\GeneralTrait;
use App\Http\Resources\api\UserResource;
use App\Http\Resources\api\UserInfoResource;
use App\Http\Requests\api\UserRequest;
use App\Http\Requests\api\UserLoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\api\UserResetRequest;
use App\Http\Requests\api\UpdateProfileRequest;
use Mail;
use Auth;
use App\Http\Mail\NotifyMail;
use App\Http\Requests\api\UserConfirmRequest;
use App\Http\Requests\api\UserChangePasswordDashboardRequest;

class UserService
{
    use GeneralTrait;
    protected UserRepositoryInterface $userRepository;
    protected ResetPasswordRepositoryInterface $resetpasswordRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected OrderTicketRepositoryInterface $orderticketRepository;
    protected TicketRepositoryInterface $ticketRepository;
    public function __construct(
        UserRepositoryInterface $userRepository ,
        ResetPasswordRepositoryInterface $resetpasswordRepository ,
        OrderRepositoryInterface $orderRepository ,
        OrderTicketRepositoryInterface $orderticketRepository ,
        TicketRepositoryInterface $ticketRepository ,
    )
    {
        $this->userRepository = $userRepository;
        $this->resetpasswordRepository = $resetpasswordRepository;
        $this->orderRepository = $orderRepository;
        $this->orderticketRepository = $orderticketRepository;
        $this->ticketRepository = $ticketRepository;
    }
    public function register(UserRequest $request)
    {
        try
        {
            $existingUser = $this->userRepository->checkItem('email',$request->email);
            if($existingUser)
            {
                return $this->returnError(422,__('site.Email_IS_Exist'));
            }
            $existingUser = $this->userRepository->checkItem('phone',$request->phone);
            if($existingUser)
            {
                return $this->returnError(422,__('site.Phone_IS_Exist'));
            }
            $data = array_merge($request->input());
            $user = $this->userRepository->create($data);
            $token = $user->createToken('myapptoken')->plainTextToken;
            $user_data = new UserResource($user);
            return $this->returnData('data',['user_data' => $user_data , 'token' => $token] , __('site.User_Is_Registered'));
        }
        catch (\Exception $e)
        {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function login(UserLoginRequest $request)
    {
        try
        {
            $user = $this->userRepository->checkItem('email',$request->email);
            if (!$user || !Hash::check($request->password,$user->password))
            {
                return $this->returnError('',__('site.Invalid_email_or_password'));
            }
            $token = $user->createToken('myapptoken')->plainTextToken;
            $user_data = new UserResource($user);
            return $this->returnData('data',['user_data' => $user_data , 'token' => $token], __('site.User_Is_Login'));
        }
        catch (\Exception $e)
        {
            return response()->json($e->getMessage(), 401);
        }
    }

    public function reset(UserResetRequest $request)
    {
        try
        {
            $user = $this->userRepository->checkItem('email',$request->email);
            if($user)
            {
                $randomNumber = random_int(1000, 9999);
                $details = [
                                'title' => 'Reset',
                                'body' =>  $randomNumber,
                            ];

                Mail::to($request->email)->send(new NotifyMail($details));
                $this->resetpasswordRepository->deleteItem('user_id',$user->id);
                $this->resetpasswordRepository->create(['user_id' => $user->id, 'reset' => $randomNumber]);
                return $this->returnData('data',__('site.Email_Send'), __('site.Email_Send'));
            }
            else
            {
                return $this->returnError('',__('site.Email_Not_Found'));
            }
        }
        catch (\Exception $e)
        {
            return response()->json($e->getMessage(), 401);
        }
    }

    public function resetUserconfirm(UserConfirmRequest $request)
    {
        try
        {
            $reset = $this->resetpasswordRepository->checkItem('reset',$request->confirm);
            if($reset)
            {
                return $this->returnData('data',__('site.code_Is_Confirm'), __('site.code_Is_Confirm'));
            }
            else
            {
                return $this->returnError('',__('site.code_Not_Confirm'));
            }
        }
        catch (\Exception  $e)
        {
            return response()->json($e->getMessage(), 401);
        }
    }

    public function changePassword(UserChangePasswordDashboardRequest $request)
    {
        try
        {
            $user = $this->userRepository->checkItem('email',$request->email);
            if($user)
            {
                $this->userRepository->update($user->id,['password' => Hash::make($request->newpassword)]);
                $this->resetpasswordRepository->deleteItem('user_id',$user->id);
                return $this->returnData('data',__('site.password_Is_Changed'));
            }
            return $this->returnError('',__('site.User_Not_Found'));
        }
        catch (\Exception  $e)
        {
            return response()->json($e->getMessage(), 401);
        }
    }

    public function getuserprofile()
    {
        $user = $this->userRepository->getById(Auth::user()->id);
        return $this->returnData('data',$user);
    }

    public function updateprofile(UpdateProfileRequest $request)
    {
        $user = $this->userRepository->getById(Auth::user()->id);
        if(is_null($user))
        {
            return $this->returnError('',__('site.User_Not_Found'));
        }
        if($request->oldpassword)
        {
            if(!Hash::check($request->oldpassword,$user->password))
            {
                return $this->returnError('',__('site.Old_Password_Not_Confirm'),__('site.Old_Password_Not_Confirm'));
            }
        }
        if($request->newpassword == $request->confirmpassword)
        {
            $user->userRepository->update($request->input(),['password' => Hash::make($request->newpassword)]);
            return $this->returnData('data',$user,__('site.User_Profile_Updated'));
        }
        else
        {
            return $this->returnError('',__('site.Not_Confirm'),__('site.Not_Confirm'));
        }
        return $this->returnData('data',$user,__('site.User_Profile_Updated'));
    }

    public function updatechangepassword(UserChangePasswordDashboardRequest $request)
    {
        $user = $this->userRepository->getById(Auth::user()->id);
        if(is_null($user))
        {
            return $this->returnError('',__('site.User_Not_Found'));
        }
        if($request->oldpassword)
        {
            if(!Hash::check($request->oldpassword,$user->password))
            {
                return $this->returnError('',__('site.Old_Password_Not_Confirm'),__('site.Old_Password_Not_Confirm'));
            }
        }
        if($request->newpassword == $request->confirmpassword)
        {
            $user->userRepository->update(['password' => Hash::make($request->newpassword)]);
            return $this->returnData('data',$user,__('site.Password_changed'));
        }
        else
        {
            return $this->returnError('',__('site.Not_Confirm'),__('site.Not_Confirm'));
        }
        return $this->returnData('data',$user,__('site.User_Profile_Updated'));
    }

    public function getuserinfo()
    {
        $user = $this->userRepository->getById(Auth::user()->id);

//        $newordercount = OrderTicket::where('from_user', $user->id)
//                                        ->whereHas('order', function ($query) {
//                                            $query->where(['is_adminAccepted' =>  1 , 'is_userAccepted' => 0]);
//                                        })
//                                        ->count();

//        $ordertickets = OrderTicket::where('from_user', $user->id)
//                                ->whereHas('order', function ($query) {
//                                    $query->where(['is_adminAccepted' => 1, 'is_userAccepted' => 2]);
//                                })
//                                ->get();

        $newordercount = $this->orderticketRepository->getCountNewOrders('from_user',$user->id);
        $ordertickets = $this->orderticketRepository->getOrdersTickets('from_user',$user->id);
        $sumsalles = 0;
        foreach($ordertickets as $orderticket)
        {
            $ticket = $this->ticketRepository->getById($orderticket->ticket_id);
            if($ticket)
            {
                $sumsalles += $orderticket->quantity * $ticket->price;
            }
        }

//        $wallets = OrderTicket::where('from_user', $user->id)
//                                ->where('is_convert',0)
//                                ->whereHas('order', function ($query) {
//                                    $query->where(['is_adminAccepted' => 1, 'is_userAccepted' => 2]);
//                                })
//                                ->with(['order.payments' => function ($query) {
//                                    $query->where('is_accepted', 1);
//                                }])
//                                ->get();
        $wallets = $this->orderticketRepository->getAllWalet('from_user', $user->id);
        $summoney = 0;
        foreach($wallets as $wallet)
        {
            $ticket = $this->ticketRepository->getById($wallet->ticket_id);
            if($ticket)
            {
                $summoney += $wallet->quantity * $ticket->price;
            }
        }
        $user->newordercount = $newordercount;
        $user->sallescount = $sumsalles;
        $user->wallet = $summoney;
        $user_data = new UserInfoResource($user);
        return $this->returnData('data',$user_data, __('site.User_Info'));
    }
}

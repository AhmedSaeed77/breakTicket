<?php

namespace App\Http\Services\api;
use App\Repository\BankRepositoryInterface;
use App\Traits\GeneralTrait;
use App\Http\Requests\api\BankRequest;
use App\Http\Resources\api\BankResource;
use Auth;

class BankService
{
    use GeneralTrait;
    protected BankRepositoryInterface $bankRepository;
    public function __construct(BankRepositoryInterface $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function getBankAccount()
    {
        $bank = $this->bankRepository->first('user_id',Auth::user()->id);
        $bank_data = new BankResource($bank);
        return $this->returnData('data',$bank_data);
    }

    public function store(BankRequest $request)
    {
        $user = Auth::user();
        $data = array_merge($request->input(),['user_id' => $user->id]);
        $bank = $this->bankRepository->first('user_id',Auth::user()->id);
        if($bank)
        {
            $bank_data = $this->bankRepository->update($bank->id,$data);
            return $this->returnData('data',$bank_data,__('site.Bank_Acccount_Updated'));
        }
        else
        {
            $bank_data = new BankResource($this->bankRepository->create($data));
            return $this->returnData('data',$bank_data,__('site.Bank_Acccount_Created'));
        }
    }

    public function update(BankRequest $request)
    {
        $bank = $this->bankRepository->first('user_id',Auth::user()->id);
        $this->bankRepository->update($bank->id,$request->input());
        $bank_data = new BankResource($bank);
        return $this->returnData('data',$bank_data);
    }
}

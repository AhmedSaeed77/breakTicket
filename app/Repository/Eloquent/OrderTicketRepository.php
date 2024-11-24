<?php

namespace App\Repository\Eloquent;

use App\Models\OrderTicket;
use App\Repository\OrderTicketRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderTicketRepository extends Repository implements OrderTicketRepositoryInterface
{
    protected Model $model;

    public function __construct(OrderTicket $model)
    {
        parent::__construct($model);
    }

    public function getwalletforuser($coloumn,$value)
    {
        return $this->model::query()->select(['*'])->where($coloumn, $value)
                                ->whereHas('order', function ($query) {
                                    $query->where(['is_adminAccepted' => 1, 'is_userAccepted' => 1]);
                                })
                                ->with(['order.payments' => function ($query) {
                                    $query->where('is_accepted', 1);
                                }])
                                ->get()
                                ->sum(function ($orderTicket) {
                                    return $orderTicket->order->payments->sum('price');
                                });
    }

    public function getordersticketsusersales($coloumn,$value)
    {
        return $this->model::query()->select(['*'])->where($coloumn, $value)
                ->whereHas('order', function ($query) {
                    $query->where(['is_adminAccepted' =>  1 , 'is_userAccepted' => 2]);
                })
                ->get();
    }

    public function sumItems($coloumn,$value,$columnsum)
    {
        return $this->model::query()->where($coloumn,$value)->sum($columnsum);
    }

    public function filterorder1($coloumn,array $arr=[])
    {
        return $this->model::query()->select(['*'])->whereIn($coloumn, $arr)->pluck('order_id')->toArray();
    }

    public function getCountNewOrders($coloumn,$value)
    {
        return $this->model::query()->where($coloumn, $value)->whereHas('order', function ($query) {
                        $query->where(['is_adminAccepted' =>  1 , 'is_userAccepted' => 0]);
                    })
                    ->count();
    }
    public function getOrdersTickets($coloumn,$value)
    {
        return $this->model::query()->where($coloumn, $value)->whereHas('order', function ($query) {
            $query->where(['is_adminAccepted' =>  1 , 'is_userAccepted' => 0]);
        })
            ->get();
    }

    public function getAllWalet($coloumn,$value)
    {
        return $this->model::query()->where($coloumn, $value)
            ->where('is_convert',0)
            ->whereHas('order', function ($query) {
                $query->where(['is_adminAccepted' => 1, 'is_userAccepted' => 2]);
            })
            ->with(['order.payments' => function ($query) {
                $query->where('is_accepted', 1);
            }])
            ->get();
    }
}

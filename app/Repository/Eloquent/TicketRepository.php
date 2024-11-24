<?php

namespace App\Repository\Eloquent;

use App\Models\Ticket;
use App\Repository\TicketRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TicketRepository extends Repository implements TicketRepositoryInterface
{
    protected Model $model;

    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }

    public function getAllQuantityForTicket($column1,$id,$column2)
    {
        return $this->model::query()->where($column1, $id)->select($column2)->groupBy($column2)->get();
    }
    public function filterticket($event,$event_id,$subcategory_id = null,$quantity = null,$is_adjacent = null)
    {
        return $this->model::query()->with(['tickests_Info' => function ($query) {
                                $query->where('is_canceled', 0);
                                $query->where('is_salled', 0);
                            }])
            ->where('is_accepted',2)
            // ->where('is_selled',0)
            ->where('quantity','!=',0)
            ->when($event != null, function ($query) use ($event) {
                return $query->where('event_id', $event->id);
            })
            ->when($subcategory_id != null, function ($query) use ($subcategory_id) {
                return $query->where('subcategory_id', $subcategory_id);
            })
            ->when($quantity != null, function ($query) use ($quantity) {
                return $query->where('quantity', $quantity);
            })
            ->when($is_adjacent != null, function ($query) use ($is_adjacent) {
                return $query->where('is_adjacent', $is_adjacent);
            })
            ->has('tickests_Info', '>=', 1)
            ->orderBy('is_selled', 'asc')
            ->orderBy('totalprice', 'asc')->get();
    }
    public function getSpecificTicket($column,$value)
    {
        return $this->model::query()->with(['tickests_Info' => function ($query) {
                            $query->where('is_canceled', 0);
                        }])->where($column,$value)->first();
    }

}

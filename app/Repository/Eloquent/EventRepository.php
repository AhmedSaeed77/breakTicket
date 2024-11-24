<?php

namespace App\Repository\Eloquent;

use App\Models\Event;
use App\Repository\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventRepository extends Repository implements EventRepositoryInterface
{
    protected Model $model;

    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function getAllEvents($columns = ['*'],array $relations = [] ,$orderBy = 'desc' ,int $perPage = 10,$search = '')
    {
        return $this->model::query()->select($columns)->with($relations)->orderBy('id' , $orderBy)->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name_en', 'like', $searchTerm)
                ->orWhere('name_ar', 'like', $searchTerm);
        })
        ->paginate($perPage);
    }

    public function getOneEvent($column1,$value1,$column2,$value2,$column3,$value3)
    {
        return $this->model::query()->where($column1, $value1)->orWhere($column2, $value2)->orWhere($column3, $value3)->first();
    }
    public function getAllEventSite()
    {
        $currentDateTime = now();
        return $this->model::query()->leftJoin('tickets', 'events.id', '=', 'tickets.event_id')
            ->where('is_active',1)
            ->where(function ($query) use ($currentDateTime) {
                $query->whereDate('event_date', '>=', $currentDateTime->toDateString())
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('event_date', $currentDateTime->toDateString())
                            ->whereTime('event_time', '>=', $currentDateTime->toTimeString());
                    });
            })
            ->with(['tickets' => function ($query) {
                $query->orderBy('price', 'asc');
            }])
            ->select('events.*', DB::raw('MIN(tickets.price) as min_price'))
            ->groupBy('events.id', 'events.name_en', 'events.name_ar', 'events.place_ar',
                'events.place_en', 'events.belong_ar', 'events.belong_en', 'events.event_date',
                'events.event_time', 'events.image','events.cat_id','events.created_at',
                'events.updated_at','events.is_popular','events.coverimage','events.blogimage',
                'events.commission','events.is_active','slug_en','slug_ar')
            ->orderBy('min_price', 'asc')
            ->get();
    }
    public function getAllEventsSiteSearch($data)
    {
        return $this->model::query()->where('name_en', 'like', '%' . $data . '%')
            ->orWhere('name_ar', 'like', '%' . $data . '%')
            ->orWhere('event_date', 'like', '%' . $data . '%')
            ->orWhere('event_time', 'like', '%' . $data . '%')
            ->orWhere('place_en', 'like', '%' . $data . '%')
            ->orWhere('place_ar', 'like', '%' . $data . '%')
            ->orWhere('belong_en', 'like', '%' . $data . '%')
            ->orWhere('belong_ar', 'like', '%' . $data . '%')
            ->get();
    }
    public function getAllPopularEvents()
    {
        $currentDateTime = now();
        return $this->model::query()->leftJoin('tickets', 'events.id', '=', 'tickets.event_id')
            ->where('is_active',1)
            ->where('events.is_popular','=',1)->where(function ($query) use ($currentDateTime) {
                $query->whereDate('event_date', '>=', $currentDateTime->toDateString())
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('event_date', $currentDateTime->toDateString())
                            ->whereTime('event_time', '>=', $currentDateTime->toTimeString());
                    });
            })
            ->with(['tickets' => function ($query) {
                $query->orderBy('price', 'asc');
            }])
            ->select('events.*', DB::raw('MIN(tickets.price) as min_price'))
            ->groupBy('events.id', 'events.name_en', 'events.name_ar', 'events.place_ar',
                'events.place_en', 'events.belong_ar', 'events.belong_en', 'events.event_date',
                'events.event_time', 'events.image','events.cat_id','events.created_at',
                'events.updated_at','events.is_popular','events.coverimage','events.blogimage',
                'events.commission','events.is_active','slug_en','slug_ar')
            ->orderBy('min_price', 'asc')
            ->get();
    }
    public function getAllEventsByCategory($id)
    {
        $currentDateTime = now();
        return $this->model::query()->leftJoin('tickets', 'events.id', '=', 'tickets.event_id')
            ->where('is_active',1)
            ->where('events.cat_id',$id)->where(function ($query) use ($currentDateTime) {
                $query->whereDate('event_date', '>=', $currentDateTime->toDateString())
                    ->orWhere(function ($query) use ($currentDateTime) {
                        $query->whereDate('event_date', $currentDateTime->toDateString())
                            ->whereTime('event_time', '>=', $currentDateTime->toTimeString());
                    });
            })
            ->with(['tickets' => function ($query) {
                $query->orderBy('price', 'asc');
            }])
            ->select('events.*', DB::raw('MIN(tickets.price) as min_price'))
            ->groupBy('events.id', 'events.name_en', 'events.name_ar', 'events.place_ar',
                'events.place_en', 'events.belong_ar', 'events.belong_en', 'events.event_date',
                'events.event_time', 'events.image','events.cat_id','events.created_at',
                'events.updated_at','events.is_popular','events.coverimage','events.blogimage',
                'events.commission','events.is_active','slug_en','slug_ar')
            ->orderBy('is_popular', 'desc')
            ->orderBy('min_price', 'asc')
            ->get();
    }
    public function getOneEventSite($id)
    {
        return $this->model::query()->with('tickets.tickests_Info')->where('id',$id)
            ->orWhere('slug_ar',$id)->orWhere('slug_en',$id)->first();
    }
    public function getEventSearch($data)
    {
        return $this->model::query()->where('is_active', 1)->where(function ($query) use ($data) {
            $query->where(function ($q) use ($data) {
                $q->where('name_en', 'like', "%$data%")
                    ->orWhere('name_ar', 'like', "%$data%")
                    ->orWhere('event_date', 'like', "%$data%")
                    ->orWhere('event_time', 'like', "%$data%")
                    ->orWhere('place_en', 'like', "%$data%")
                    ->orWhere('place_ar', 'like', "%$data%")
                    ->orWhere('belong_en', 'like', "%$data%")
                    ->orWhere('belong_ar', 'like', "%$data%");
            });

            // Handle the equivalence of 'ى' and 'ي', 'أ' and 'ا'
            $query->orWhere(function ($q) use ($data) {
                $pattern = preg_replace('/[يى]/u', '[يى]', $data);
                $pattern = preg_replace('/[اأ]/u', '[اأ]', $pattern);
                $pattern = preg_replace('/[هة]/u', '[هة]', $pattern);

                $q->where('name_ar', 'REGEXP', $pattern)
                    ->orWhere('place_ar', 'REGEXP', $pattern)
                    ->orWhere('belong_ar', 'REGEXP', $pattern);
            });
        })
        ->get();
    }
    public function getEventFilter($category_id,$data,$rank)
    {
        $currentDateTime = now();
        return $this->model->query()->where('is_active',1)->where(function ($query) use ($currentDateTime) {
            $query->whereDate('event_date', '>=', $currentDateTime->toDateString())
                ->orWhere(function ($query) use ($currentDateTime) {
                    $query->whereDate('event_date', $currentDateTime->toDateString())
                        ->whereTime('event_time', '>=', $currentDateTime->toTimeString());
                });
        })
            ->when($category_id, function ($query) use ($category_id) {
                return $query->where('events.cat_id', $category_id);
            })
            ->when($data, function ($query) use ($data) {
//                $data = $request->input('data');
                return $query->where(function ($query) use ($data) {
                    $query->where('events.name_en', 'like', '%' . $data . '%')
                        ->orWhere('events.name_ar', 'like', '%' . $data . '%');
                });
            })
            ->when($rank, function ($query) use ($rank) {
                $direction = $rank == 1 ? 'asc' : 'desc';
                return $query->orderBy('event_date', $direction);
            })
            ->select('events.*')
            ->groupBy('events.id', 'events.name_en', 'events.name_ar', 'events.place_ar',
                'events.place_en', 'events.belong_ar', 'events.belong_en', 'events.event_date',
                'events.event_time', 'events.image', 'events.cat_id', 'events.created_at',
                'events.updated_at', 'events.is_popular', 'events.coverimage','events.blogimage',
                'events.commission','events.is_active','slug_en','slug_ar')
            ->get();
    }
}

<?php

namespace App\Repository;

interface EventRepositoryInterface extends RepositoryInterface
{
    public function getAllEvents();
    public function getOneEvent($column1,$value1,$column2,$value2,$column3,$value3);
    public function getAllEventSite();
    public function getAllEventsSiteSearch($data);
    public function getAllPopularEvents();
    public function getAllEventsByCategory($id);
    public function getOneEventSite($id);
    public function getEventSearch($data);
    public function getEventFilter($category_id,$data,$rank);

}

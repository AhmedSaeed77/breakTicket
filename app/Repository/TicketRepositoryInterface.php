<?php

namespace App\Repository;

interface TicketRepositoryInterface extends RepositoryInterface
{
    public function getAllQuantityForTicket($column1,$id,$column2);
    public function filterticket($event,$event_id,$subcategory_id,$quantity,$is_adjacent);
    public function getSpecificTicket($column,$value);

}

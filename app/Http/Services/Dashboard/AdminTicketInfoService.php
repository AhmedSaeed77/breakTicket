<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\AdminTicketInfoRequest;
use App\Repository\TicketInfoRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class AdminTicketInfoService
{
    use GeneralTrait;
    protected TicketInfoRepositoryInterface $ticketinfoRepository;
    public function __construct(TicketInfoRepositoryInterface $ticketinfoRepository)
    {
        $this->ticketinfoRepository = $ticketinfoRepository;
    }

    public function create($id)
    {
        $id = $id;
        return view('dashboard.adminticketsinfo.create',compact('id'));
    }

    public function store(AdminTicketInfoRequest $request,$id)
    {
        if($request->hasFile('image'))
        {
            $image = $this->handle('image', 'ticketinfo');
            $data = array_merge($request->input(),['image' => $image , 'ticket_id' => $id]);
            $this->ticketinfoRepository->create($data);
        }
        return redirect()->route('adminticket.show',$id)->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function edit($ticket_id,$id)
    {
        $ticket_info = $this->ticketinfoRepository->getById($id);
        return view('dashboard.adminticketsinfo.edit' , ['ticket_info' => $ticket_info , 'ticket_id' => $ticket_id]);
    }

    public function update(AdminTicketInfoRequest $request,$ticket_id,$id)
    {
        $ticket_info = $this->ticketinfoRepository->getById($id);
        if($request->hasFile('image'))
        {
            $image = $this->handle('image', 'ticketinfo');
            $data = array_merge($request->input(),["image"=>$image]);
            $this->ticketinfoRepository->update($ticket_info->id,$data);
        }
        $this->ticketinfoRepository->update($ticket_info->id,$request->input());
        return redirect()->route('adminticket.show',$ticket_id)->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function delete($ticket_id,$id)
    {
        $this->ticketinfoRepository->delete($id);
        return redirect()->route('adminticket.show',$ticket_id)->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }

}

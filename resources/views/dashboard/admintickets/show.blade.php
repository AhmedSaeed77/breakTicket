@extends('dashboard.core.app')
@section('title', __('titles.Ticket_Details'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Ticket_Details')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Ticket_Details -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Ticket_Details')</h3>
                            <div class="card-tools justify d-flex">
                                <!-- @if($ticket->is_accepted != 'Accepted')
                                <form action="{{ route('ticket.accept') }}" method="post">
                                    @csrf
                                    <input name="ticket_id" type="hidden" value="{{ $ticket->id }}">
                                    <button type="submit" class="btn btn-dark">@lang('dashboard.Accept')</button>
                                </form>
                                @endif
                                @if($ticket->is_accepted != 'Not Accepted')
                                <form action="{{ route('ticket.reject') }}" method="post">
                                    @csrf
                                    <input name="ticket_id" type="hidden" value="{{ $ticket->id }}">
                                    <button type="submit" class="btn btn-danger">@lang('dashboard.Reject')</button>
                                </form>
                                @endif -->
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">


                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Event_Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{$ticket->event->name_en}}</span>

                                                </div>
                                            </div>
                                        </div>
{{--                                        <div class="col-12 col-sm-4">--}}
{{--                                            <div class="info-box bg-dark">--}}
{{--                                                <div class="info-box-content">--}}
{{--                                                    <span class="info-box-text text-center">@lang('dashboard.Box_Name')</span>--}}
{{--                                                    <span class="info-box-number text-center mb-0">{{$ticket->box->name_en}}</span>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Subcategory_Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{$ticket->subcategory->name_en}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.User_Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{$ticket->admin->name}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Price')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $ticket->price }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <a class="col-12 col-sm-4" href="" >
                                                <div class="info-box bg-dark">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-center">@lang('dashboard.Quantity')</span>
                                                        <span class="info-box-number text-center mb-0">{{$ticket->quantity}}</span>

                                                    </div>
                                                </div>
                                        </a>

                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Salled')</span>
                                                    <span class="info-box-number text-center mb-0">{{$ticket->is_selled}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.is_adjacent')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $ticket->is_adjacent }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <a class="col-12 col-sm-4" href="" >
                                                <div class="info-box bg-dark">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-center">@lang('dashboard.is_direct_sale')</span>
                                                        <span class="info-box-number text-center mb-0">{{$ticket->is_direct_sale}}</span>

                                                    </div>
                                                </div>
                                        </a>

                                        <a class="col-12 col-sm-4" href="" >
                                                <div class="info-box bg-dark">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-center">@lang('dashboard.is_accepted')</span>
                                                        <span class="info-box-number text-center mb-0">{{$ticket->is_accepted}}</span>

                                                    </div>
                                                </div>
                                        </a>

                                        <a class="col-12 col-sm-4" href="" >
                                                <div class="info-box bg-dark">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-center">@lang('dashboard.category')</span>
                                                        <span class="info-box-number text-center mb-0">{{$ticket->event->category->name}}</span>

                                                    </div>
                                                </div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- Event Boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Ticket_Info')</h3>
                        </div>
                        <div class="card-tools">
                            @if($ticket->quantity > $ticket->tickests_Info->count())
                                <a href="{{ route('info.create',$ticket->id) }}" class="btn  btn-dark">@lang('dashboard.Create')</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Row')</th>
                                    <th>@lang('dashboard.Chair_Number')</th>
                                    <th>@lang('dashboard.Image')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($ticket->tickests_Info->reverse() as $key => $info)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{$info->row}}</td>
                                        <td>{{$info->chair_number}}</td>
                                        <td><img src="{{ !is_null($info->image) ? url($info->image) : '' }}" style="width: 100px;" /></td>
                                        <td>
                                            <div class="operations-btns" style="">

                                                <a href="{{ route('info.edit',[$ticket->id,$info['id']]) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a>

                                                <button class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#delete-modal{{$key}}">@lang('dashboard.Delete')</button>
                                                <div id="delete-modal{{$key}}" class="modal fade modal2 " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content float-left">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">@lang('dashboard.confirm_delete')</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>@lang('dashboard.sure_delete')</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" data-dismiss="modal" class="btn btn-dark waves-effect waves-light m-l-5 mr-1 ml-1">
                                                                    @lang('dashboard.close')
                                                                </button>
                                                                <form action="{{ route('info.destroy',[$ticket->id,$info['id']]) }}" method="post">
                                                                    @csrf
                                                                    {{method_field('DELETE')}}
                                                                    <button type="submit" class="btn btn-danger">@lang('dashboard.Delete')</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    @include('dashboard.core.includes.no-entries', ['columns' => 6])
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

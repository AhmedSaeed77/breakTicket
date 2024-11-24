@extends('dashboard.core.app')
@section('title', __('titles.Ticket_Details'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.order_Details')</h1>
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
                            <h3 class="card-title">@lang('dashboard.order_Details')</h3>
                            <div class="card-tools justify d-flex">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.order_number')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $order->order_number }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.from')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $order->user_name }}</span>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.totalprice')</span>
                                                    <span class="info-box-number text-center mb-0">{{$order->totalprice}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.payed')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $order->payed }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <a class="col-12 col-sm-4" href="" >
                                                <div class="info-box bg-dark">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-center">@lang('dashboard.is_userAccepted')</span>
                                                        <span class="info-box-number text-center mb-0">{{$order->is_userAccepted}}</span>

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
                            <h3 class="card-title">@lang('dashboard.User_Ticket')</h3>
                        </div>
                        <div class="card-tools">
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Event_Name')</th>
{{--                                    <th>@lang('dashboard.Box_Name')</th>--}}
                                    <th>@lang('dashboard.Subcategory_Name')</th>
                                    <!-- <th>@lang('dashboard.User_Name')</th> -->
                                    <th>@lang('dashboard.Price')</th>
                                    <th>@lang('dashboard.TotalPrice')</th>
                                    <th>@lang('dashboard.Quantity')</th>
                                    <th>@lang('dashboard.is_accepted')</th>
                                    <th>@lang('dashboard.is_salled')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($tickets as $key => $ticket)
                                    <tr>
                                    <td>{{ $key + 1 }}</td>
                                        @if(app()->getLocale()=='en')
                                            <td>{{ $ticket->event->name_en }}</td>
                                        @else
                                            <td>{{ $ticket->event->name_ar }}</td>
                                        @endif
{{--                                        @if(app()->getLocale()=='en')--}}
{{--                                            <td>{{ $ticket->box->name_en }}</td>--}}
{{--                                        @else--}}
{{--                                            <td>{{ $ticket->box->name_ar }}</td>--}}
{{--                                        @endif--}}
                                        @if(app()->getLocale()=='en')
                                            <td>{{ $ticket->subcategory->name_en }}</td>
                                        @else
                                            <td>{{ $ticket->subcategory->name_ar }}</td>
                                        @endif
                                        <!-- <td>{{ $ticket->admin->name }}</td> -->
                                        <td>{{ $ticket->price }}</td>
                                        <td>{{ $ticket->totalprice }}</td>
                                        <td>{{ $ticket->quantity }}</td>
                                        <td>{{ $ticket->is_accepted }}</td>
                                        <td>{{ $ticket->is_selled }}</td>
                                        <td>
                                            @if($ticket->quantity > $ticket->checkquantity)
                                                <div class="operations-btns" style="">
                                                    <a href="{{ route('ticketuser.edit',[$order->id,$ticket->id]) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a>
                                                </div>
                                            @else
                                                <div class="operations-btns" style="">
                                                    <p>@lang('dashboard.AllTicketSalled')</p>
                                                </div>
                                            @endif
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

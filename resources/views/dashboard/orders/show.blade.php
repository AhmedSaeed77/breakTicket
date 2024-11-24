@extends('dashboard.core.app')
@section('title', __('titles.Event Details'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Orders')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Event Details -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.order_Details')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <!-- <div class="col-md-2">

                                </div> -->
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.order_number')</span>
                                                    <span class="info-box-number text-center mb-0">{{$order->order_number}}</span>

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
                                                    <span class="info-box-number text-center mb-0">{{$order->payed}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Copoune')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $order->copoune->copoune ?? '' }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.is_adminAccepted')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $order->is_adminAccepted }}</span>

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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.order_Details')</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.FromUser')</th>
                                    <th>@lang('dashboard.ToUser')</th>
                                    <th>@lang('dashboard.Quantity')</th>
                                    <th>@lang('dashboard.Price')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($order->order_tickets as $key => $ticket)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $ticket->event_name }}</td>
                                        <td>{{ $ticket->from_name }}</td>
                                        <td>{{ $ticket->to_name }}</td>
                                        <td>{{ $ticket->quantity }}</td>
                                        <td>{{ $ticket->newprice }}</td>
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.order_Details')</h3>
                        </div >
                            <div class="card-tools">
                                <div class="card-body">
                                    <form action="{{ route('orders.update' , $order->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
{{--                                        <div class="form-group col-6">--}}
{{--                                            <label for="exampleInputName1"> @lang('dashboard.is_adminAccepted')</label>--}}
{{--                                            @if(app()->getLocale()=='en')--}}
{{--                                                <input name="is_adminAccepted" type="checkbox" class="form-control" id="exampleInputName1" @if($order->is_adminAccepted == 'Accepted') checked @endif>--}}
{{--                                            @else--}}
{{--                                                <input name="is_adminAccepted" type="checkbox" class="form-control" id="exampleInputName1" @if($order->is_adminAccepted == 'مقبول') checked @endif>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
                                        <div class="form-group col-6">
                                            <label for="exampleInputName1"> @lang('dashboard.is_userAccepted')</label>
                                            @if(app()->getLocale()=='en')
                                                <input name="is_userAccepted" type="checkbox" class="form-control" id="exampleInputName1" @if($order->is_userAccepted == 'Accepted') checked @endif>
                                            @else
                                                <input name="is_userAccepted" type="checkbox" class="form-control" id="exampleInputName1" @if($order->is_userAccepted == 'مقبول') checked @endif>
                                            @endif
                                        </div>
                                    </div>


                                    <!-- <div class="row">
                                        <div class="form-group col-6">
                                            <label for="exampleInputName1"> @lang('dashboard.is_finished')</label>
                                            <input name="is_finished" type="checkbox" class="form-control" id="exampleInputName1" @if($order->is_finished == 'Finished') checked @endif>
                                        </div>
                                    </div> -->

                                    <button type="submit" class="btn btn-dark">@lang('dashboard.Edit')</button>
                                </form>
                                </div>
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

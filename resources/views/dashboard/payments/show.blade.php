@extends('dashboard.core.app')
@section('title', __('titles.Event Details'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Payments')</h1>
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
                            <h3 class="card-title">@lang('dashboard.Payment_Details')</h3>
                            <div class="card-tools justify d-flex">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if($payment->image != null)
                                <div class="col-md-2">
                                    <img src="{{ $payment->image }}" width="150px" />
                                </div>
                                @endif
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.type')</span>
                                                    <span class="info-box-number text-center mb-0">{{$payment->type}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.order')</span>
                                                    <span class="info-box-number text-center mb-0">{{$payment->order->order_number}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Price')</span>
                                                    <span class="info-box-number text-center mb-0">{{$payment->price}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.payed')</span>
                                                    <span class="info-box-number text-center mb-0">{{$payment->is_accepted}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.User_Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{$payment->user->name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if($payment->name)
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{$payment->name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($payment->accountnumber)
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.AccountNumber')</span>
                                                    <span class="info-box-number text-center mb-0">{{$payment->accountnumber}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
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

             <!-- Event Boxes -->
             <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Payment_Details')</h3>
                        </div >
                            <div class="card-tools">
                                <div class="card-body">
                                    <form action="{{ route('payments.update' , $payment->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="exampleInputName1"> @lang('dashboard.payed')</label>
                                            @if(app()->getLocale() == 'en')
                                                <input name="is_accepted" type="checkbox" class="form-control" id="exampleInputName1" @if($payment->is_accepted == 'Payed') checked @endif>
                                            @else
                                                <input name="is_accepted" type="checkbox" class="form-control" id="exampleInputName1" @if($payment->is_accepted == 'مدفوع') checked @endif>
                                            @endif
                                        </div>
                                    </div>
                                        @if(app()->getLocale() == 'ar')
                                            @if($payment->is_accepted != 'مدفوع')
                                                <button type="submit" class="btn btn-dark">@lang('dashboard.Edit')</button>
                                            @endif
                                        @else
                                            @if($payment->is_accepted != 'Payed')
                                                <button type="submit" class="btn btn-dark">@lang('dashboard.Edit')</button>
                                            @endif
                                        @endif
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

@section('js_addons')
<script>
        $(document).ready(function() {
            var specialcommission = $('#specialcommission');
            var special = $('#special').find(':checked');
            var special_val = special.val();
            if (special_val == 'on')
            {
                specialcommission.show();
            }
            else
            {
                specialcommission.hide();
            }

            $('#special').on('change', function() {
                var special = $(this).find(':checked');
                var special_val = special.val();
                if (special_val == 'on')
                {
                    specialcommission.show();
                }
                else
                {
                    specialcommission.hide();
                }
            });

        });
    </script>

@endsection

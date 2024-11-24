@extends('dashboard.core.app')
@section('title', __('titles.Show_Sales'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Show_Sales')</h1>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <style>
            .card-header::after, .card-body::after, .card-footer::after{
                display: none;
            }
        </style>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-space-between d-flex" style="justify-content: space-between">
                            <h3 class="card-title">@lang('dashboard.Show_Sales')</h3>
                            <h3>{{ $totalprice }}</h3>
                        </div>

                        <div class="card-tools">

                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.order_number')</th>
                                    <th>@lang('dashboard.Event_Name')</th>
{{--                                    <th>@lang('dashboard.Box_Name')</th>--}}
                                    <th>@lang('dashboard.Subcategory_Name')</th>
                                    <!-- <th>@lang('dashboard.PriceBeforeCommission')</th>
                                    <th>@lang('dashboard.PriceAfterCommission')</th> -->
                                    <th>@lang('dashboard.Quantity')</th>
{{--                                    <th>@lang('dashboard.totalprice')</th>--}}
                                    <th>@lang('dashboard.totalPriceBeforeComission')</th>
                                    <th>@lang('dashboard.totalPriceAfterCommission')</th>
                                    <th>@lang('dashboard.is_convert')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders_tickets as $key => $ticket)
                                    <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $ticket->order->order_number }}</td>
                                        @if(app()->getLocale()=='en')
                                            <td>{{ $ticket->event->name_en }}</td>
                                        @else
                                            <td>{{ $ticket->event->name_ar }}</td>
                                        @endif
{{--                                        @if(app()->getLocale()=='en')--}}
{{--                                            <td>{{ $ticket->box_name }}</td>--}}
{{--                                        @else--}}
{{--                                            <td>{{ $ticket->box_name }}</td>--}}
{{--                                        @endif--}}
                                        @if(app()->getLocale()=='en')
                                            <td>{{ $ticket->subcategory_name }}</td>
                                        @else
                                            <td>{{ $ticket->subcategory_name }}</td>
                                        @endif
                                        <!-- <td>{{ $ticket->ticket->price }}</td>
                                        <td>{{ $ticket->ticket->totalprice }}</td> -->
                                        <td>{{ $ticket->quantity }}</td>
                                        <td>{{ $ticket->ticket->price * $ticket->quantity }}</td>
                                        <td>{{ $ticket->newprice }}</td>
{{--                                        <td>{{ $ticket->newprice }}</td>--}}
                                        <td>{{ $ticket->is_convert }}</td>
                                        <td>
                                            @if(app()->getLocale()=='en')
                                            @if($ticket->is_convert == 'Not Converted')
                                            <button class="btn btn-secondary waves-effect waves-light" data-toggle="modal" data-target="#delete-modal{{$key}}">@lang('dashboard.Edit')</button>
                                            <div id="delete-modal{{$key}}" class="modal fade modal2 " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content float-left">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">@lang('dashboard.confirm_Edit')</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>@lang('dashboard.sure_convert')</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" data-dismiss="modal" class="btn btn-dark waves-effect waves-light m-l-5 mr-1 ml-1">
                                                                @lang('dashboard.close')
                                                            </button>
                                                            <form action="{{route('ticket.convert' , $ticket['id'])}}" method="post">
                                                                @csrf

                                                                <button type="submit" class="btn btn-secondary">@lang('dashboard.Edit')</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @else
                                                @if($ticket->is_convert == 'لم يتم التحويل بعد')
                                                    <button class="btn btn-secondary waves-effect waves-light" data-toggle="modal" data-target="#delete-modal{{$key}}">@lang('dashboard.Edit')</button>
                                                    <div id="delete-modal{{$key}}" class="modal fade modal2 " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content float-left">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">@lang('dashboard.confirm_Edit')</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>@lang('dashboard.sure_convert')</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-dark waves-effect waves-light m-l-5 mr-1 ml-1">
                                                                        @lang('dashboard.close')
                                                                    </button>
                                                                    <form action="{{route('ticket.convert' , $ticket['id'])}}" method="post">
                                                                        @csrf

                                                                        <button type="submit" class="btn btn-secondary">@lang('dashboard.Edit')</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    @include('dashboard.core.includes.no-entries', ['columns' => 6])
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

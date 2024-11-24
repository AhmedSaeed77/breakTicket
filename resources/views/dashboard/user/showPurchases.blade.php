@extends('dashboard.core.app')
@section('title', __('titles.Show_Purchases'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Show_Purchases')</h1>
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
                            <h3 class="card-title">@lang('dashboard.Show_Purchases')</h3>
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
                                    <th>@lang('dashboard.Price')</th>
                                    <th>@lang('dashboard.TotalPrice')</th>
                                    <th>@lang('dashboard.Quantity')</th>
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
                                        <td>{{ $ticket->ticket->totalprice }}</td>
                                        <td>{{ $ticket->newprice }}</td>
                                        <td>{{ $ticket->quantity }}</td>
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

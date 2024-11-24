@extends('dashboard.core.app')
@section('title', __('titles.Event Details'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Users')</h1>
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
                            <h3 class="card-title">@lang('dashboard.User_Details')</h3>
                            <div class="card-tools justify d-flex">
                                <!-- <form action="{{ route('user.update' , $user->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input name="special" type="checkbox" class="form-control" id="exampleInputName1" @if($user->special == 'Special') checked @endif>
                                    <button type="submit" class="btn btn-dark">@lang('dashboard.Special')</button>
                                </form> -->

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <!-- <div class="col-md-2">
                                    <img src="{{ $user->image }}" width="150px" />
                                </div> -->
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{$user->name}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Email')</span>
                                                    <span class="info-box-number text-center mb-0">{{$user->email}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Phone')</span>
                                                    <span class="info-box-number text-center mb-0">{{$user->phone}}</span>
                                                </div>
                                            </div>
                                        </div>
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
            {{-- Wallet --}}
            @if($user->bank)
                <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.User_Details')</h3>
                            <div class="card-tools justify d-flex">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        @if($user->bank->user)
                                        <div class="col-12 col-sm-3">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $user->bank->user }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bank->bank_name)
                                        <div class="col-12 col-sm-3">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.bank_name')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $user->bank->bank_name }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bank->bank_iban)
                                        <div class="col-12 col-sm-6">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.bank_iban')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $user->bank->bank_iban }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bank->bank_swiftcode)
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.bank_swiftcode')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $user->bank->bank_swiftcode }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                            <div class="col-12 col-sm-4">
                                                <div class="info-box bg-dark">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-center">@lang('dashboard.wallet')</span>
                                                        <span class="info-box-number text-center mb-0">{{ $user->wallet }}</span>
                                                    </div>
                                                </div>
                                            </div>

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
            @endif
            <!-- Event Boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.User_Details')</h3>
                        </div >
                        <div class="card-tools">
                            <div class="card-body">
                                <!-- <a href="{{ route('box.create',$user->id) }}" class="btn  btn-dark">@lang('dashboard.Create')</a> -->
                                <form action="{{ route('user.update' , $user->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-6" id="special">
                                            <label for="exampleInputName1"> @lang('dashboard.commission')</label>
                                            <input name="is_commission" type="checkbox" class="form-control" id="exampleInputName1" @if($user->is_commission == 1) checked @endif>
                                        </div>
                                        <div class="form-group col-6" id="specialcommission">
                                            <label for="exampleInputName1"> @lang('dashboard.commission')</label>
                                            <input name="commission" type="decimal" class="form-control" id="exampleInputName1" value = "{{ $user->commission }}">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="exampleInputName1"> @lang('dashboard.Special')</label>
                                            @if(app()->getLocale()=='en')
                                                <input name="special" type="checkbox" class="form-control" id="exampleInputName1" @if($user->special == 'Special') checked @endif>
                                            @else
                                                <input name="special" type="checkbox" class="form-control" id="exampleInputName1" @if($user->special == 'مميز') checked @endif>
                                            @endif
                                        </div>
{{--                                        <div class="form-group col-6">--}}
{{--                                            <label for="exampleInputName1"> @lang('dashboard.AcceptRejectSales')</label>--}}
{{--                                            <input name="acceptreject" type="checkbox" class="form-control" id="exampleInputName1" @if($user->acceptreject == 1) checked @endif>--}}
{{--                                        </div>--}}
                                    </div>
                                    <!-- <div class="row">
                                        <div class="form-group col-6">
                                            <label for="exampleInputName1"> @lang('dashboard.CancelTicket')</label>
                                            <input name="canceltiket" type="checkbox" class="form-control" id="exampleInputName1" @if($user->canceltiket == 1) checked @endif>
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Tickets')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach($user->tickets as $ticket)
                                            @foreach($ticket->tickests_Info as $image)
                                            <div class="col-12 col-sm-4">
                                                <img src="{{ $image->image }}" width="175px" />
                                            </div>
                                            @endforeach
                                        @endforeach
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



            <!-- <div class="row">
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
                                        <td>{{ $ticket->price }}</td>
                                        <td>{{ $ticket->totalprice }}</td>
                                        <td>{{ $ticket->quantity }}</td>
                                        <td>{{ $ticket->is_accepted }}</td>
                                        <td>{{ $ticket->is_selled }}</td>
                                        <td>
                                            <div class="operations-btns" style="">
                                                <a href="{{ route('ticketuser.edit',[$user->id,$ticket->id]) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a>
                                            </div>
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
            </div> -->

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

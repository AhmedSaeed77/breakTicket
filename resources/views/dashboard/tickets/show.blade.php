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
                                @if(app()->getLocale()=='en')
                                    @if($ticket->is_accepted !== 'Accepted')
                                        <form action="{{ route('ticket.accept') }}" method="post">
                                            @csrf
                                            <input name="ticket_id" type="hidden" value="{{ $ticket->id }}">
                                            <button type="submit" class="btn btn-dark">@lang('dashboard.Accept')</button>
                                        </form>
                                    @endif
                                    @if($ticket->is_accepted !== 'Not Accepted')
                                        <form action="{{ route('ticket.reject') }}" method="post">
                                            @csrf
                                            <input name="ticket_id" type="hidden" value="{{ $ticket->id }}">
                                            <button type="submit" class="btn btn-danger">@lang('dashboard.Reject')</button>
                                        </form>
                                    @endif
                                @else
                                    @if($ticket->is_accepted !== 'مقبولة')
                                        <form action="{{ route('ticket.accept') }}" method="post">
                                            @csrf
                                            <input name="ticket_id" type="hidden" value="{{ $ticket->id }}">
                                            <button type="submit" class="btn btn-dark">@lang('dashboard.Accept')</button>
                                        </form>
                                    @endif
                                    @if($ticket->is_accepted !== 'مرفوضة')
                                        <form action="{{ route('ticket.reject') }}" method="post">
                                            @csrf
                                            <input name="ticket_id" type="hidden" value="{{ $ticket->id }}">
                                            <button type="submit" class="btn btn-danger">@lang('dashboard.Reject')</button>
                                        </form>
                                    @endif
                                @endif


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
                                                    <span class="info-box-number text-center mb-0">{{$ticket->user->name}}</span>

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


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Ticket_Details')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach($ticket->tickests_Info as $image)
                                            <div class="col-12 col-sm-4">
                                                <div >
{{--                                                    <div class="info-box-content">--}}
{{--                                                        <span class="info-box-text text-center">@lang('dashboard.Event_Name')</span>--}}
                                                        <img src="{{ $image->image }}" width="175px" />
{{--                                                    </div>--}}
                                                </div>
                                            </div>
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

            <!-- Event Boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Ticket_Details')</h3>
                        </div >
                            <div class="card-tools">
                                <div class="card-body">

                                    <form action="{{ route('ticket.chanagedirectsale') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <input name="ticket_id" type="hidden" value="{{ $ticket->id }}">
                                            <label for="exampleInputName1"> @lang('dashboard.is_direct_sale')</label>
                                            @if(app()->getLocale()=='en')
                                                <input name="is_direct_sale" type="checkbox" class="form-control" id="exampleInputName1" @if($ticket->is_direct_sale == 'Direct Sale') checked @endif>
                                            @else
                                                <input name="is_direct_sale" type="checkbox" class="form-control" id="exampleInputName1" @if($ticket->is_direct_sale == 'بيع مباشر') checked @endif>
                                            @endif
                                        </div>
                                    </div>
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

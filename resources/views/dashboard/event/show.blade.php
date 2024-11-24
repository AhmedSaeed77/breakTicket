@extends('dashboard.core.app')
@section('title', __('titles.Event Details'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.events')</h1>
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
                            <h3 class="card-title">@lang('dashboard.Event Details')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-2">
                                    <img src="{{ $event->image }}" width="150px" />
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{$event->name_en}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Name')</span>
                                                    <span class="info-box-number text-center mb-0">{{$event->name_ar}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Date')</span>
                                                    <span class="info-box-number text-center mb-0">{{$event->event_date}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Time')</span>
                                                    <span class="info-box-number text-center mb-0">{{$event->event_time}}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-dark">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center">@lang('dashboard.Place En')</span>
                                                    <span class="info-box-number text-center mb-0">{{ $event->place_en }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <a class="col-12 col-sm-4" href="" >
                                                <div class="info-box bg-dark">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-center">@lang('dashboard.belong En')</span>
                                                        <span class="info-box-number text-center mb-0">{{$event->belong_en}}</span>

                                                    </div>
                                                </div>
                                        </a>

                                        <a class="col-12 col-sm-4" href="" >
                                                <div class="info-box bg-dark">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-center">@lang('dashboard.category')</span>
                                                        <span class="info-box-number text-center mb-0">{{$event->category->name}}</span>

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
                                    <th>@lang('dashboard.Subcategory_Name')</th>
                                    <th>@lang('dashboard.FromUser')</th>
                                    <th>@lang('dashboard.Price')</th>
                                    <th>@lang('dashboard.totalprice')</th>
                                    <th>@lang('dashboard.Quantity')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($event->tickets as $key => $ticket)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $ticket->subcategory->name }}</td>
                                        @if($ticket->user_id)
                                            <td>{{ $ticket->user->name }}</td>
                                        @else
                                            @php $admin = \App\Models\Admin::find($ticket->admin_id);@endphp
                                            <td>{{ $admin->name }}</td>
                                        @endif
                                        <td>{{ $ticket->price }}</td>
                                        <td>{{ $ticket->totalprice }}</td>
                                        <td>{{ $ticket->quantity }}</td>

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
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            <h3 class="card-title">@lang('dashboard.Event Boxes')</h3>--}}
{{--                        </div>--}}
{{--                        <div class="card-tools">--}}
{{--                            <a href="{{ route('box.create',$event->id) }}" class="btn  btn-dark">@lang('dashboard.Create')</a>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <table class="table table-bordered">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th style="width: 10px">#</th>--}}
{{--                                    <th>@lang('dashboard.Name')</th>--}}
{{--                                    <th>@lang('dashboard.Name')</th>--}}
{{--                                    <th>@lang('dashboard.Operations')</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @forelse($event->boxes as $key => $box)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{ $key + 1 }}</td>--}}
{{--                                        <td>{{$box->name_en}}</td>--}}
{{--                                        <td>{{$box->name_ar}}</td>--}}
{{--                                        <td>--}}
{{--                                            <div class="operations-btns" style="">--}}

{{--                                                <a href="{{ route('box.edit',[$event->id,$box['id']]) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a>--}}

{{--                                                <button class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#delete-modal{{$key}}">@lang('dashboard.Delete')</button>--}}
{{--                                                <div id="delete-modal{{$key}}" class="modal fade modal2 " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">--}}
{{--                                                    <div class="modal-dialog">--}}
{{--                                                        <div class="modal-content float-left">--}}
{{--                                                            <div class="modal-header">--}}
{{--                                                                <h5 class="modal-title">@lang('dashboard.confirm_delete')</h5>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="modal-body">--}}
{{--                                                                <p>@lang('dashboard.sure_delete')</p>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="modal-footer">--}}
{{--                                                                <button type="button" data-dismiss="modal" class="btn btn-dark waves-effect waves-light m-l-5 mr-1 ml-1">--}}
{{--                                                                    @lang('dashboard.close')--}}
{{--                                                                </button>--}}
{{--                                                                <form action="{{ route('box.destroy',[$event->id,$box['id']]) }}" method="post">--}}
{{--                                                                    @csrf--}}
{{--                                                                    {{method_field('DELETE')}}--}}
{{--                                                                    <button type="submit" class="btn btn-danger">@lang('dashboard.Delete')</button>--}}
{{--                                                                </form>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @empty--}}
{{--                                    @include('dashboard.core.includes.no-entries', ['columns' => 6])--}}
{{--                                @endforelse--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                        <!-- /.card-body -->--}}
{{--                    </div>--}}
{{--                    <!-- /.card -->--}}
{{--                </div>--}}
{{--                <!-- /.col -->--}}
{{--            </div>--}}
            <!-- Event subcategory -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Event subcategory')</h3>
                        </div>
                        <div class="card-tools">
                            <a href="{{ route('subcategory.create',$event->id) }}" class="btn  btn-dark">@lang('dashboard.Create')</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($event->subcategories as $key => $subcategory)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{$subcategory->name_en}}</td>
                                        <td>{{$subcategory->name_ar}}</td>
                                        <td>
                                            <div class="operations-btns" style="">

{{--                                                <a href="{{ route('subcategory.edit',[$event->id,$subcategory['id']]) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a>--}}

                                                <button class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#delete-modal2{{$key}}">@lang('dashboard.Delete')</button>
                                                <div id="delete-modal2{{$key}}" class="modal fade modal2 " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                                                                <form action="{{ route('subcategory.destroy',[$event->id,$subcategory['id']]) }}" method="post">
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

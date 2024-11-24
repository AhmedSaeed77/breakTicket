@extends('dashboard.core.app')
@section('title', __('titles.Users_Tickets'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Users_Tickets')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Users_Tickets')</h3>
                            <div class="card-tools">

                                    <!-- <a href="{{ url('ticket/create') }}" class="btn  btn-dark">@lang('dashboard.Create')</a> -->


                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Event_Name')</th>
{{--                                    <th>@lang('dashboard.Box_Name')</th>--}}
                                    <th>@lang('dashboard.Subcategory_Name')</th>
                                    <th>@lang('dashboard.User_Name')</th>
                                    <th>@lang('dashboard.Price')</th>
                                    <th>@lang('dashboard.TotalPrice')</th>
                                    <th>@lang('dashboard.is_accepted')</th>
                                    <th>@lang('dashboard.is_salled')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($tickets as $key => $ticket)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        @if($ticket->event_id != null)
                                            @if(app()->getLocale()=='en')
                                                <td>{{ $ticket->event->name_en }}</td>
                                            @else
                                                <td>{{ $ticket->event->name_ar }}</td>
                                            @endif
                                        @else
                                            <td>{{ $ticket->event_name }}</td>
                                        @endif
{{--                                        @if($ticket->box_id != null)--}}
{{--                                            @if(app()->getLocale()=='en')--}}
{{--                                                <td>{{ $ticket->box->name_en }}</td>--}}
{{--                                            @else--}}
{{--                                                <td>{{ $ticket->box->name_ar }}</td>--}}
{{--                                            @endif--}}
{{--                                        @else--}}
{{--                                            <td>{{ $ticket->box_name }}</td>--}}
{{--                                        @endif--}}
                                        @if($ticket->subcategory_id != null)
                                            @if(app()->getLocale()=='en')
                                                <td>{{ $ticket->subcategory->name_en }}</td>
                                            @else
                                                <td>{{ $ticket->subcategory->name_ar }}</td>
                                            @endif
                                        @else
                                        <td>{{ $ticket->subcategory_name }}</td>
                                        @endif
                                        <td>{{ $ticket->user->name }}</td>
                                        <td>{{ $ticket->price }}</td>
                                        <td>{{ $ticket->totalprice }}</td>
                                        <td>{{ $ticket->is_accepted }}</td>
                                        <td>{{ $ticket->is_selled }}</td>
                                        <td>
                                            <div class="operations-btns" style="">
                                                <a href="{{ route('userticket.show', $ticket['id']) }}" class="btn  btn-secondary">@lang('dashboard.Show')</a>
                                                <!-- <a href="{{ route('userticket.edit', $ticket['id']) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a> -->

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
                                                                <form action="{{route('userticket.destroy' , $ticket['id'])}}" method="post">
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
                        <div class="card-footer">
                            {{ $tickets->links() }}
                        </div>
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

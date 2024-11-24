@extends('dashboard.core.app')
@section('title', __('titles.copounes'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.copounes')</h1>
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
                            <h3 class="card-title">@lang('dashboard.copounes')</h3>
                            <div class="card-tools">
                                <a href="{{ url('copounes/create') }}" class="btn  btn-dark">@lang('dashboard.Create')</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Copoune')</th>
                                    <th>@lang('dashboard.Counter')</th>
                                    <th>@lang('dashboard.Discount')</th>
                                    <!-- <th>@lang('dashboard.Event_Name')</th> -->
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($copounes as $key => $copoune)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $copoune->copoune }}</td>
                                        <td>{{ $copoune->counter }}</td>
                                        <td>{{ $copoune->presentage }} </td>
                                        <!-- <td>
                                            @foreach($copoune->events as $event)
                                                {{ $event->name }} ,
                                            @endforeach
                                        </td> -->
                                        <td>
                                            <div class="operations-btns" style="">
                                                
                                                    <a href="{{ route('copounes.edit', $copoune['id']) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a>
                                           
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
                                                                    <form action="{{route('copounes.destroy' , $copoune['id'])}}" method="post">
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
                            {{ $copounes->links() }}
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
@extends('dashboard.core.app')
@section('title', __('titles.events'))
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Orders')</h3>
                            <div class="card-tools">
                                <!-- <a href="" class="btn  btn-dark">@lang('dashboard.Create')</a> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('orders.index')}}">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <input value="{{request('search') ?? ""}}" name="search" type="search" class="form-control" placeholder="@lang('dashboard.search_with_order_number')">
                                    </div>
                                    <div class="form-group col-3">
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.filter')</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.order_number')</th>
                                    <th>@lang('dashboard.ToUser')</th>
                                    <th>@lang('dashboard.totalprice')</th>
                                    <th>@lang('dashboard.payed')</th>
                                    <th>@lang('dashboard.is_adminAccepted')</th>
                                    <th>@lang('dashboard.is_userAccepted')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->user_name }}</td>
                                        <td>{{ $order->totalprice }}</td>
                                        <td>{{ $order->payed }}</td>
                                        <td>{{ $order->is_adminAccepted }}</td>
                                        <td>{{ $order->is_userAccepted }}</td>
                                        <td>
                                            <div class="operations-btns" style="">
                                                <a href="{{ route('orders.show', $order['id']) }}" class="btn  btn-secondary">@lang('dashboard.Show')</a>
                                                <!-- <a href="{{ route('orders.edit', $order['id']) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a> -->

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
                                                                <form action="{{route('orders.destroy' , $order['id'])}}" method="post">
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
                            {{ $orders->links() }}
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

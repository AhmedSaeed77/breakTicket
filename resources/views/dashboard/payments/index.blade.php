@extends('dashboard.core.app')
@section('title', __('titles.events'))
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Payments')</h3>
                            <div class="card-tools">
                                <!-- <a href="" class="btn  btn-dark">@lang('dashboard.Create')</a> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('payments.index')}}">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <select id="payment_type" name="search" class="form-control">
                                            <option
                                                @selected(request('type') == "ALL") value="2">@lang('dashboard.payment_methods')</option>
                                            <option
                                                @selected(request('type') == "bank")  value="0">@lang('dashboard.bankPayment')</option>
                                            <option
                                                @selected(request('type') == "elctronic") value="1">@lang('dashboard.electronicPayment')</option>
                                        </select>
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
                                    <th>@lang('dashboard.type')</th>
                                    <th>@lang('dashboard.Image')</th>
                                    <th>@lang('dashboard.User_Name')</th>
                                    <th>@lang('dashboard.order')</th>
                                    <th>@lang('dashboard.Price')</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.AccountNumber')</th>
                                    <th>@lang('dashboard.payed')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($payments as $key => $payment)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $payment->type }}</td>
                                        <td><img src="{{ !is_null($payment->image) ? url($payment->image) : '' }}" style="width: 100px;" /></td>
                                        <td>{{ $payment->user->name }}</td>
                                        <td>{{ $payment->order->order_number }}</td>
                                        <td>{{ $payment->price }}</td>
                                        <td>{{ $payment->name }}</td>
                                        <td>{{ $payment->accountnumber }}</td>
                                        <td>{{ $payment->is_accepted }}</td>
                                        <td>
                                            <div class="operations-btns" style="">
                                                <a href="{{ route('payments.show', $payment['id']) }}" class="btn  btn-secondary">@lang('dashboard.Show')</a>
                                                <!-- <a href="{{ route('payments.edit', $payment['id']) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a> -->
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
                            {{ $payments->links() }}
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

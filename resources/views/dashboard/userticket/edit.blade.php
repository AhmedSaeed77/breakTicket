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
            <!-- Event Boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.Ticket_Details')</h3>
                        </div >
                            <div class="card-tools">
                                <div class="card-body">
                                
                                    <form action="{{ route('ticketuser.store',$order_id) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <input name="ticket_id" type="hidden" value="{{ $ticket->id }}">
                                            <label for="exampleInputName1"> @lang('dashboard.Add')</label>
                                            <input name="add" type="checkbox" class="form-control" id="exampleInputName1" >
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="exampleInputName1"> @lang('dashboard.Quantity')</label>
                                            <input name="counter" type="number" class="form-control" id="exampleInputName1" >
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

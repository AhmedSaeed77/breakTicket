@extends('dashboard.core.app')
@section('title', __('dashboard.Edit') . " " . __('dashboard.Admin_Info_Tickets'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Admin_Info_Tickets')</h1>
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
                        <form action="{{  route('info.update' , [$ticket_id,$ticket_info->id]) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">{{__('dashboard.Edit') . " " . __('dashboard.Admin_Info_Tickets')}}</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Row')</label>
                                        <input name="row" type="decimal" class="form-control" id="exampleInputName1" value="{{ $ticket_info->row }}" placeholder="" required>
                                    </div>
                                    
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Chair_Number')</label>
                                        <input name="chair_number" type="decimal" class="form-control" id="exampleInputName1" value="{{ $ticket_info->chair_number }}" placeholder="" required>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Image')</label>
                                        <input name="image" type="file" class="form-control" id="exampleInputName1"  value="{{ $ticket_info->image }}" placeholder="">
                                    </div>
                                </div>

                                <hr>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">@lang('dashboard.Edit')</button>
                            </div>
                        </form>
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

@section('js_addons')
    <script>
        $(document).ready(function () {
            $('select[name="event_id"]').on('change', function () {
                var event_id = $(this).val();
                if (event_id) {
                    $.ajax({
                        url: "{{ URL::to('boxes') }}/" + event_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="box_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="box_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                            console.log(data);
                        },
                    });
                    
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });

    </script>

<script>
        $(document).ready(function () {
            $('select[name="event_id"]').on('change', function () {
                var event_id = $(this).val();
                if (event_id) {
                    $.ajax({
                        url: "{{ URL::to('subcategories') }}/" + event_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="subcategory_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="subcategory_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                            console.log(data);
                        },
                    });
                    
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });

    </script>
@endsection
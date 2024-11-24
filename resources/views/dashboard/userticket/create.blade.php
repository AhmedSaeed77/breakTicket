@extends('dashboard.core.app')
@section('title', __('dashboard.Create') . " " . __('dashboard.Add_User_Tickets'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Add_User_Tickets')</h1>
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
                        <form action="{{ route('ticketuser.store' , $id) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">{{__('dashboard.Add_User_Tickets')}}</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.events')</label>
                                        <select name="event_id"  class="form-control" id="exampleInputName1" required >
                                            <option selected disabled>Choose type</option>
                                            @foreach($events as $event)
                                                @if(app()->getLocale() == 'en')
                                                    <option value="{{ $event->id }}">{{ $event->name_en }}</option>
                                                @else
                                                    <option value="{{ $event->id }}">{{ $event->name_ar }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.Box')</label>
                                        <select name="box_id" class="form-control" id="exampleInputName1" required >
                                            <option selected disabled>Choose type</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Subcategory')</label>
                                        <select name="subcategory_id"  class="form-control" id="exampleInputName1" required >
                                            <option selected disabled>Choose type</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Price')</label>
                                        <input name="price" type="decimal" class="form-control" id="exampleInputName1" value="{{ old('price') }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Quantity')</label>
                                        <input name="quantity" type="decimal" class="form-control" id="exampleInputName1" value="{{ old('quantity') }}" placeholder="" required>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.is_adjacent')</label>
                                        <input name="is_adjacent" type="checkbox" class="form-control" id="exampleInputName1" >
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.is_direct_sale')</label>
                                        <input name="is_direct_sale" type="checkbox" class="form-control" id="exampleInputName1" >
                                    </div>
                                </div>

                                <hr>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">@lang('dashboard.Create')</button>
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
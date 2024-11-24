@extends('dashboard.core.app')
@section('title', __('dashboard.Create') . " " . __('dashboard.Event Boxes'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Event Boxes')</h1>
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
                        <form action="{{ route('box.store',$id) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">{{__('dashboard.Create') . " " . __('dashboard.Event Boxes')}}</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                <input name="event_id" type="hidden" class="form-control" id="exampleInputName1" value="">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Name Ar')</label>
                                        <input name="name_ar" type="text" class="form-control" id="exampleInputName1" value="{{ old('name_ar') }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Name En')</label>
                                        <input name="name_en" type="text" class="form-control" id="exampleInputName1" value="{{ old('name_en') }}" placeholder="" required>
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
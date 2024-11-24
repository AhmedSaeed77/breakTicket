@extends('dashboard.core.app')
@section('title', __('dashboard.Create') . " " . __('dashboard.events'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection


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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('event.update' , $event['id']) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">{{__('dashboard.Edit') . " " . __('dashboard.events')}}</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Name Ar')</label>
                                        <input name="name_ar" type="text" class="form-control" id="exampleInputName1" value="{{ $event->name_ar }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Name En')</label>
                                        <input name="name_en" type="text" class="form-control" id="exampleInputName1" value="{{ $event->name_en }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Place Ar')</label>
                                        <input name="place_ar" type="text" class="form-control" id="exampleInputName1" value="{{ $event->place_ar }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Place En')</label>
                                        <input name="place_en" type="text" class="form-control" id="exampleInputName1" value="{{ $event->place_en }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.belong Ar')</label>
                                        <input name="belong_ar" type="text" class="form-control" id="exampleInputName1" value="{{ $event->belong_ar }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.belong En')</label>
                                        <input name="belong_en" type="text" class="form-control" id="exampleInputName1" value="{{ $event->belong_en }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Date')</label>
                                        <input name="event_date" type="date" class="form-control" id="exampleInputName1" value="{{ $event->event_date }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Time')</label>
                                        <input name="event_time" type="time" class="form-control" id="exampleInputName1" value="{{ $event->event_time }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.categories')</label>
                                        <select name="cat_id"  class="form-control" id="exampleInputName1" required >
                                            <option selected disabled>Choose type</option>
                                            @foreach($categories as $category)
                                                @if(app()->getLocale() == 'en')
                                                    <option @if($category->id == $event->cat_id) selected @endif value="{{ $category->id }}">{{ $category->name_en }}</option>
                                                @else
                                                    <option @if($category->id == $event->cat_id) selected @endif value="{{ $category->id }}">{{ $category->name_ar }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.commission')</label>
                                        <input name="commission" type="decimmal" class="form-control" id="exampleInputName1"value="{{ $event->commission }}" required >
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.Image')</label>
                                        <input name="image" type="file" class="form-control" id="exampleInputName1" placeholder="" >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.BlogImage')</label>
                                        <input name="blogimage" type="file" class="form-control" id="exampleInputName1" placeholder=""  >
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.CoverImage')</label>
                                        <input name="coverimage" type="file" class="form-control" id="exampleInputName1" placeholder=""  >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.is_popular')</label>
                                        <input name="is_popular" type="checkbox" class="form-control" id="exampleInputName1" @if($event->is_popular == 1) checked = "active" @endif>
                                    </div>
                                    <!-- @if($event->coverimage)
                                        <img src="{{ url($event->coverimage) }}" style="width: 100px;"/>
                                    @endif -->
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Active')</label>
                                        <input name="is_active" type="checkbox" class="form-control" id="exampleInputName1" @if($event->is_active == 1) checked = "active" @endif>
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
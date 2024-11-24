@extends('dashboard.core.app')
@section('title', __('dashboard.Create') . " " . __('dashboard.copounes'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection


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
                        <form action="{{ url('copounes') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">{{__('dashboard.Create') . " " . __('dashboard.copounes')}}</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Copoune')</label>
                                        <input name="copoune" type="text" class="form-control" id="exampleInputName1" value="{{ old('copoune') }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Counter')</label>
                                        <input name="counter" type="number" class="form-control" id="exampleInputName1" value="{{ old('counter') }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.Discount')</label>
                                        <input name="presentage" type="decimal" class="form-control" id="exampleInputName1" value="{{ old('presentage') }}" placeholder="" required >
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.events')</label>
                                        <select name="event_id" id="cobone_type" class="form-control" id="exampleInputName1" required >
                                            <option selected disabled>Choose type</option>
                                            <option value="1">@lang('dashboard.for_all_events')</option>
                                            <option value="0">@lang('dashboard.for_specific_events')</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-6" id="curriculum_curriculum_info">
                                        <label for="exampleInputName1">@lang('dashboard.events')</label>
                                        <select name="event_id[]"  class="form-control" multiple="multiple" id="" required >
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
    $(document).ready(function(){
        var curriculum_curriculum_info = $('#curriculum_curriculum_info');
            curriculum_curriculum_info.hide();          
            $('#cobone_type').on('change', function() {
            var type = $(this).val();    
            console.log(type); 
            if(type === '0'){
            curriculum_curriculum_info.show();    
            }else{
            curriculum_curriculum_info.hide();  
            }       
        });
        
    });
    </script>
@endsection
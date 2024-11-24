@extends('dashboard.core.app')
@section('title', __('dashboard.Create') . " " . __('dashboard.Event subcategory'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Event subcategory')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card container">
                        <form class="container mb-30 pt-5 " action="{{ route('subcategory.store',$id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="photo">@lang('dashboard.Event subcategory')</label>
                                <div id="kt_docs_repeater_basic">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="kt_docs_repeater_basic">
                                            <div data-repeater-item>
                                                <div class="form-group row align-items-center">
                                                    <div class="col">
                                                        <label class="form-label">@lang('dashboard.Name Ar')</label>
                                                        <input type="text"  name="name_ar"class="form-control"  required>
                                                    </div>

                                                    <div class="col">
                                                        <label class="form-label">@lang('dashboard.Name En')</label>
                                                        <input type="text"  name="name_en" class="form-control"  required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-outline-danger mt-3 mt-md-8">
                                                            <i class="la la-trash-o"></i>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form group-->
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-outline-success">
                                            <i class="la la-plus"></i>Add
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-dark">@lang('dashboard.Create')</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                {{--                        <form action="{{ route('subcategory.store',$id) }}" method="post" autocomplete="off" enctype="multipart/form-data">--}}
                {{--                            <div class="card-header">--}}
                {{--                                <h3 class="card-title">{{__('dashboard.Create') . " " . __('dashboard.Event subcategory')}}</h3>--}}
                {{--                            </div>--}}
                {{--                            <div class="card-body">--}}
                {{--                                @csrf--}}
                {{--                                <div class="row">--}}
                {{--                                <input name="event_id" type="hidden" class="form-control" id="exampleInputName1" value="">--}}
                {{--                                    <div class="form-group col-6">--}}
                {{--                                        <label for="exampleInputName1"> @lang('dashboard.Name Ar')</label>--}}
                {{--                                        <input name="name_ar" type="text" class="form-control" id="exampleInputName1" value="{{ old('name_ar') }}" placeholder="" required>--}}
                {{--                                    </div>--}}

                {{--                                    <div class="form-group col-6">--}}
                {{--                                        <label for="exampleInputName1"> @lang('dashboard.Name En')</label>--}}
                {{--                                        <input name="name_en" type="text" class="form-control" id="exampleInputName1" value="{{ old('name_en') }}" placeholder="" required>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <hr>--}}
                {{--                            </div>--}}
                {{--                            <!-- /.card-body -->--}}
                {{--                            <div class="card-footer">--}}
                {{--                                <button type="submit" class="btn btn-dark">@lang('dashboard.Create')</button>--}}
                {{--                            </div>--}}
                {{--                        </form>--}}
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('js_addons')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"
            integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('#kt_docs_repeater_basic').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
@endsection

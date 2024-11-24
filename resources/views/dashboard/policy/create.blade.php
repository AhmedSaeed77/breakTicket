@extends('dashboard.core.app')
@section('title', __('dashboard.Create') . " " . __('dashboard.Policies'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Policies')</h1>
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
                        <form action="{{ url('policy') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">{{__('dashboard.Create') . " " . __('dashboard.Policies')}}</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Title_Ar')</label>
                                        <textarea class="form-control" name="title_ar" id="form-control" required></textarea>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Title_En')</label>
                                        <textarea class="form-control" name="title_en" id="form-control" required></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.Description_Ar')</label>
                                        <textarea class="form-control summernote" name="description_ar" id="form-control summernote" required></textarea>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.Description_En')</label>
                                        <textarea class="form-control summernote" name="description_en" id="form-control summernote" required></textarea>
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

<!-- <script src="{{url('/')}}/admin/plugins/summernote/summernote-bs4.min.js"></script> -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    // Summernote
    $('.summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
@endsection
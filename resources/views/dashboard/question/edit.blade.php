@extends('dashboard.core.app')
@section('title', __('dashboard.Edit') . " " . __('dashboard.Question'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Question')</h1>
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
                        <form action="{{ route('commonquestion.update' , $question['id']) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">{{__('dashboard.Edit') . " " . __('dashboard.Question')}}</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Question_Ar')</label>
                                        <textarea class="form-control" name="question_ar" id="form-control" required>{{ $question->question_ar }}</textarea>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Question_En')</label>
                                        <textarea class="form-control" name="question_en" id="form-control" required>{{ $question->question_en }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.Answer_Ar')</label>
                                        <textarea class="form-control summernote" name="answer_ar" id="form-control" required>{!! $question->answer_ar !!}</textarea>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.Answer_En')</label>
                                        <textarea class="form-control summernote" name="answer_en" id="form-control" required>{!! $question->answer_en !!}</textarea>
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
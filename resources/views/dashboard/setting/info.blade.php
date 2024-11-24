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
                    <h1>@lang('dashboard.Settings')</h1>
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
                        <form action="{{ route('setting.update') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">{{__('dashboard.Edit') . " " . __('dashboard.Settings')}}</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Name Ar')</label>
                                        <input name="name_ar" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->name_ar }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Name En')</label>
                                        <input name="name_en" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->name_en }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Address Ar')</label>
                                        <input name="address_ar" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->address_ar }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Address En')</label>
                                        <input name="address_en" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->address_en }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.BankName')</label>
                                        <input name="bankname" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->bankname }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.AccountName')</label>
                                        <input name="accountname" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->accountname }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.AccountNumber')</label>
                                        <input name="accountnumber" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->accountnumber }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.IbanNumber')</label>
                                        <input name="ibannumber" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->ibannumber }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Email')</label>
                                        <input name="email" type="email" class="form-control" id="exampleInputName1" value="{{ $setting->email }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Phone')</label>
                                        <input name="phone" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->phone }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.WhatsApp')</label>
                                        <input name="whatsapp_phone" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->whatsapp_phone }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Instagram')</label>
                                        <input name="inst" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->inst }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Twitter')</label>
                                        <input name="tw" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->tw }}" placeholder="" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">@lang('dashboard.Facebook')</label>
                                        <input name="fb" type="text" class="form-control" id="exampleInputName1" placeholder="" value="{{ $setting->fb }}" required>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.LinkedIn')</label>
                                        <input name="linkedin" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->linkedin }}" placeholder="" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.Snapchat')</label>
                                        <input name="snapchat" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->snapchat }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.YouTube')</label>
                                        <input name="youtube" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->youtube }}" placeholder="" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.tiktok')</label>
                                        <input name="tiktok" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->tiktok }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.mainemail')</label>
                                        <input name="mainemail" type="text" class="form-control" id="exampleInputName1" value="{{ $setting->mainemail }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.HomeCover')</label>
                                        <input name="homecover" type="file" class="form-control" id="exampleInputName1" placeholder="" >
                                        @if($setting->homecover)
                                            <img src="{{ url($setting->homecover) }}"/>
                                        @endif
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1"> @lang('dashboard.sitelogo')</label>
                                        <input name="sitelogo" type="file" class="form-control" id="exampleInputName1" placeholder="" >

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.About_En')</label>
                                        <textarea class="form-control summernote" name="about_en" id="form-control summernote">
                                            {!! $setting->about_en !!}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.About_Ar')</label>
                                        <textarea class="form-control summernote" name="about_ar" id="form-control summernote">
                                            {!! $setting->about_ar !!}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.Message_En')</label>
                                        <textarea class="form-control summernote" name="message_en" id="form-control summernote">
                                            {!! $setting->message_ar !!}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.Message_Ar')</label>
                                        <textarea class="form-control summernote" name="message_ar" id="form-control summernote">
                                            {!! $setting->message_ar !!}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.Vision_En')</label>
                                        <textarea class="form-control summernote" name="vision_en" id="form-control summernote">
                                            {!! $setting->vision_en !!}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1"> @lang('dashboard.Vision_Ar')</label>
                                        <textarea class="form-control summernote" name="vision_ar" id="form-control summernote">
                                            {!! $setting->vision_ar !!}
                                        </textarea>
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

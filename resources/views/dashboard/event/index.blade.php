@extends('dashboard.core.app')
@section('title', __('titles.events'))
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
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.events')</h3>
                            <div class="card-tools">
                                <a href="{{ url('event/create') }}" class="btn  btn-dark">@lang('dashboard.Create')</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('event.index')}}">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <input value="{{request('search') ?? ""}}" name="search" type="search" class="form-control" placeholder="@lang('dashboard.search_with_name')">
                                    </div>
                                    <div class="form-group col-3">
                                        <button type="submit" class="btn btn-dark">@lang('dashboard.filter')</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Name')</th>
                                    @if(app()->getLocale()=='en')
                                        <th>@lang('dashboard.Place En')</th>
                                    @else
                                        <th>@lang('dashboard.Place Ar')</th>
                                    @endif
                                    <th>@lang('dashboard.commission')</th>
                                    <th>@lang('dashboard.category')</th>
                                    <th>@lang('dashboard.Date')</th>
                                    <th>@lang('dashboard.Time')</th>
                                    <th>@lang('dashboard.Image')</th>
                                    <th>@lang('dashboard.Active')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($events as $key => $event)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{$event->name}}</td>
                                        <td>{{$event->place}}</td>
                                        <td>{{$event->commission}}</td>
                                        @if(app()->getLocale()=='en')
                                            <td>{{$event->category->name_en}}</td>
                                        @else
                                            <td>{{$event->category->name_ar}}</td>
                                        @endif
                                        <td>{{$event->event_date}}</td>
                                        <td>{{$event->event_time}}</td>
                                        <td><img src="{{ !is_null($event->image) ? url($event->image) : '' }}" style="width: 100px;" /></td>
                                        <td>
                                            <div
                                                class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input active"
                                                    data-id="{{ $event->id }}" id="customSwitch{{ $key }}"
                                                    {{ $event->is_active == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customSwitch{{ $key }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="operations-btns" style="">
                                                <a href="{{ route('event.show', $event['id']) }}" class="btn  btn-secondary">@lang('dashboard.Show')</a>
                                                <a href="{{ route('event.edit', $event['id']) }}" class="btn  btn-dark">@lang('dashboard.Edit')</a>
                                                <!-- @if($event->is_active == 1)
                                                    <a href="{{ route('eventstatus', $event['id']) }}" class="btn  btn-secondary">@lang('dashboard.unActive')</a>
                                                @else
                                                    <a href="{{ route('eventstatus', $event['id']) }}" class="btn  btn-secondary">@lang('dashboard.Active')</a>
                                                @endif -->

                                                <button class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#delete-modal{{$key}}">@lang('dashboard.Delete')</button>
                                                <div id="delete-modal{{$key}}" class="modal fade modal2 " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content float-left">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">@lang('dashboard.confirm_delete')</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>@lang('dashboard.sure_delete')</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" data-dismiss="modal" class="btn btn-dark waves-effect waves-light m-l-5 mr-1 ml-1">
                                                                    @lang('dashboard.close')
                                                                </button>
                                                                <form action="{{route('event.destroy' , $event['id'])}}" method="post">
                                                                    @csrf
                                                                    {{method_field('DELETE')}}
                                                                    <button type="submit" class="btn btn-danger">@lang('dashboard.Delete')</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    @include('dashboard.core.includes.no-entries', ['columns' => 6])
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            {{ $events->links() }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

        @foreach ($events as $i => $user)
        <div class="modal fade" id="reason{{ $user->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('dashboard.Are_You_Sure_UnActive')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <input type="text" name="reason{{ $user->id }}" class="form-control"
                            placehoder="@lang('site.Enter') @lang('site.reason for un active')" /> -->
                    <!-- </div> -->
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default cancelUnActive" data-dismiss="modal">@lang('dashboard.Cancel')</button>
                        <button type="button" class="btn btn-primary saveReason"
                            data-id="{{ $user->id }}">@lang('dashboard.unActive')</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach

        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js_addons')
<script>
       let clickedInput;
        $('.active').on('click', function(e) {
            clickedInput = e.target
            var id = $(this).attr('data-id');
            if ($(this).prop('checked') == false) {
                $('#reason' + id).modal();
            } else {
                active(id);
            }
        });
        $(".cancelUnActive").on('click', function() {
            $(clickedInput).prop('checked', true)
        });

        $(".saveReason").on('click', function() {
            var id = $(this).attr('data-id');
            active(id);
            $('#reason' + id).modal('hide');
        });


        function active(id) {
            var reason = $("input[name='reason" + id + "']").val();
            $.ajax({
                url: "{{ url(app()->getLocale() . '/users/active') . '/' }}" + id,
                type: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    reason: reason
                },
                success: function(data) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: "@lang('site.recored updated successfully.')",
                        showConfirmButton: false,
                        timer: 1500,
                    })
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: "@lang('site.error')",
                        showConfirmButton: false,
                        timer: 1500,
                    })

                }
            });
        }
    </script>
@endsection

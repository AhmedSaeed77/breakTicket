@php use Illuminate\Support\Facades\Session; @endphp
    <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('dashboard.core.tags.head')
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to do the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('dashboard.core.includes.navbar')

    @include('dashboard.core.includes.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    @include('dashboard.core.includes.control-sidebar')

    @include('dashboard.core.includes.footer')
</div>
<!-- ./wrapper -->

@include('dashboard.core.tags.scripts')

@if(Session::has('error'))
    @include('dashboard.core.alerts.error', ['message' => Session::get('error')])
@elseif(Session::has('success'))
    @include('dashboard.core.alerts.success', ['message' => Session::get('success')])
@endif
@foreach($errors->all() as $message)
    @include('dashboard.core.alerts.error', compact('message'))
@endforeach
</body>
</html>

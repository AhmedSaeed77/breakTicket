@extends('dashboard.core.app')
@section('title', __('titles.Home'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.Home')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                 <div class="col-md-3 col-sm-6 col-12">
                     <div class="info-box">
                         <span class="info-box-icon bg-dark"><i class="far fa-building"></i></span>

                         <div class="info-box-content">
                             <span class="info-box-text">@lang('dashboard.events')</span>
                             <span class="info-box-number">{{ App\Models\Event::count() }}</span>
                         </div>
                         <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                 </div>
                 <!-- /.col -->
                 <div class="col-md-3 col-sm-6 col-12">
                     <div class="info-box">
                         <span class="info-box-icon bg-dark"><i class="far fa-user"></i></span>

                         <div class="info-box-content">
                             <span class="info-box-text">@lang('dashboard.Users')</span>
                             <span class="info-box-number">{{ App\Models\User::count() }}</span>
                         </div>
                         <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                 </div>
                 <!-- /.col -->
                 <div class="col-md-3 col-sm-6 col-12">
                     <div class="info-box">
                         <span class="info-box-icon bg-dark"><i class="fas fa-ticket-alt"></i></span> 

                         <div class="info-box-content"> 
                             <span class="info-box-text">@lang('dashboard.Tickets')</span> 
                             <span class="info-box-number">{{ App\Models\Ticket::count() }}</span> 
                         </div> 
                         <!-- /.info-box-content --> 
                     </div> 
                     <!-- /.info-box --> 
                 </div> 
                 <!-- /.col --> 
                 <div class="col-md-3 col-sm-6 col-12"> 
                     <div class="info-box"> 
                         <span class="info-box-icon bg-dark"><i class="fas fa-credit-card"></i></span> 

                         <div class="info-box-content"> 
                             <span class="info-box-text">@lang('dashboard.Payments')</span> 
                             <span class="info-box-number">{{ App\Models\Payment::count() }}</span> 
                         </div> 
                         <!-- /.info-box-content --> 
                     </div> 
                     <!-- /.info-box --> 
                 </div> 
                 <!-- /.col --> 

                 
            </div>

            <div class="row">
                 <div class="col-md-3 col-sm-6 col-12">
                     <div class="info-box">
                         <span class="info-box-icon bg-dark"><i class="fas fa-shopping-cart"></i></i></span>

                         <div class="info-box-content">
                             <span class="info-box-text">@lang('dashboard.Orders')</span>
                             <span class="info-box-number">{{ App\Models\Order::count() }}</span>
                         </div>
                         <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                 </div>
                 <!-- /.col -->
                 <div class="col-md-3 col-sm-6 col-12">
                     <div class="info-box">
                         <span class="info-box-icon bg-dark"><i class="fas fa-tags"></i></span>

                         <div class="info-box-content">
                             <span class="info-box-text">@lang('dashboard.Copoune')</span>
                             <span class="info-box-number">{{ App\Models\Copoune::count() }}</span>
                         </div>
                         <!-- /.info-box-content -->
                     </div>
                     <!-- /.info-box -->
                 </div>
                 <!-- /.col -->
                    
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

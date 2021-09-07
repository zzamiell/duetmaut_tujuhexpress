@extends('layouts.app', [
    'namePage' => 'Dashboard',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'home',
    'backgroundImage' => asset('now') . "/img/bg14.jpg",
])

@section('content')
  <div class="panel-header panel-header-lg">
    <div class="col-md-12 ml-auto mr-auto">
      <div class="p-3 mb-2 bg-gradient-primary text-white">
    <h1>{{ 'UNDER DEVELOPMENT' }}</h1>
  </div>
</div>
  <div class="content">
    
           
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>
@endpush
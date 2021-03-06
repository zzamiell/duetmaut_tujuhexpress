@extends('layouts.app', [
    'namePage' => 'Orders',
    'class' => 'sidebar-mini',
    'activePage' => 'Orders',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> Order List </h4>

            <div class="card">

              @if(session('access_menu'))
                @foreach(session('access_menu') as $menu)
                    @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/orders/index)-orders-create')
                      <a class="btn btn-success" href="{{ route('orders.create')}}">Add Order</a>
                    @endif

                    @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/orders/index)-orders-import')
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                        Import Order
                      </button>
                    @endif

                    @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/orders/index)-orders-update')
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
                        Mass Order Update
                      </button>
                    @endif

                    @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/orders/index)-orders-export')
                      @if(session('user_role_id') == 1)
                      <a 
                        class="btn btn-success" 
                        href="#">
                        Export
                      </a>
                      @else
                      <a 
                        class="btn btn-success" 
                        href="#">
                        Export
                      </a>
                      @endif
                    @endif
                @endforeach
              @endif

              <!-- <a href="javascript:void(0)" onclick="openFilterModal()" class="btn btn-danger waves-effect waves-light"><i class="fa fa-file-pdf-o">Filter 2</i> </a> -->
              <div class="card-body">
              <!-- Filter Section -->
              <form action="{{ route('orders.filter') }}" method="GET" enctype="multipart/form-data">
                <div class="row">
                      <div class="col-md-6">
                        {{ csrf_field() }}
                        <!--Begin input tanggal pembuatan awal -->
                        <div class="input-group {{ $errors->has('tanggal_awal') ? ' has-danger' : '' }}">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="now-ui-icons arrows-1_minimal-down"></i>
                            </div>
                          </div>
                          <input
                            class="form-control {{ $errors->has('tanggal_awal') ? ' is-invalid' : '' }}"
                            min="{{date('Y-m-d', strtotime('-3 month'))}}"
                            max="{{date('Y-m-d', strtotime('+3 month'))}}"
                            placeholder="{{ __('Tanggal Awal Pembuatan (yyyy-MM-dd)') }}"
                            type="date" 
                            name="tanggal_awal"
                            value="{{ $tanggal_awal ?? '' }}"
                            id="tanggal_awal" autofocus>
                          @if ($errors->has('tanggal_awal'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                              <strong>{{ $errors->first('tanggal_awal') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-6">
                        <!--Begin input tanggal pembuatan akhir -->
                        <div class="input-group {{ $errors->has('tanggal_akhir') ? ' has-danger' : '' }}">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="now-ui-icons arrows-1_minimal-up"></i>
                            </div>
                          </div>
                          <input
                            class="form-control {{ $errors->has('tanggal_akhir') ? ' is-invalid' : '' }}"
                            min="{{date('Y-m-d', strtotime('-3 month'))}}"
                            max="{{date('Y-m-d', strtotime('+3 month'))}}"
                            placeholder="{{ __('Tanggal Akhir Pembuatan (yyyy-MM-dd)') }}"
                            type="date" name="tanggal_akhir"
                            value="{{ $tanggal_akhir ?? '' }}"
                            id="tanggal_akhir" autofocus>
                          @if ($errors->has('tanggal_akhir'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                              <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="orderStatusSelection">Order Status</label>
                          <select name="order_status" class="form-control" id="orderStatusSelection">
                            <option value="all" @if(app('request')->input('order_status') == "all") selected @endif>All</option>
                            <option value="info_received" @if(app('request')->input('order_status') == "info_received") selected @endif>Info Received</option>
                            <option value="pending" @if(app('request')->input('order_status') == "pending") selected @endif>Pending</option>
                            <option value="in_transit" @if(app('request')->input('order_status') == "in_transit") selected @endif>In Transit</option>
                            <option value="completed" @if(app('request')->input('order_status') == "completed") selected @endif>Completed</option>
                            <option value="fail_shipper" @if(app('request')->input('order_status') == "fail_shipper") selected @endif>Fail Shipper</option>
                            <option value="fail_courier" @if(app('request')->input('order_status') == "fail_courier") selected @endif>Fail Courier</option>
                            <option value="fail_recipient" @if(app('request')->input('order_status') == "fail_recipient") selected @endif>Fail Recipient</option>
                            <option value="fail_attempt_1" @if(app('request')->input('order_status') == "fail_attempt_1") selected @endif>Faile Attempt</option>
                            <option value="cancel" @if(app('request')->input('order_status') == "cancel") selected @endif>Cancel</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <input type="submit" value="check" class="btn btn-primary"/>
                      </div>
                    </div>

                </form>
              </div>
              <!-- /Filter Section -->
          <div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>

        @endif
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <form action="/orders/index" method="get">
                        {{ csrf_field() }}
                        <div class="input-group mb-3">
                            <input type="text" name="cari" class="form-control" placeholder="TX-210914000001">
                            <div class="input-group-append">
                              <input type="submit" class="input-group-text" id="basic-addon2" value="Cari Orders">
                            </div>
                          </div>
                        </form>
                    </div>
            </div>
            <hr>
          <div class="table-responsive">
            <table id="abdi" class="table">
              <thead class=" text-primary">
                  <th>Expected Delivery Date</th>
                <th>
                  Date Request
                </th>
                <th>
                  AWB
                </th>
                <th>
                  Ref ID
                </th>
                <th>
                  Account Name
                </th>
                <th>
                  Service Type
                </th>

                <th>
                  Total Fee
                </th>
                <th>
                  Status
                </th>

              </thead>
              <tbody>

                @foreach ($orders as $key => $order )
                <tr>
                  <td>{{ date('d M Y H:i:s',strtotime($order['expected_delivery_date'])) }}</td>
                  <td>{{ date('d M Y',strtotime($order['date_requested'])) }}</td>
                  <td>{{ $order['awb'] }}</td>
                  <td>{{ $order['ref_id'] }}</td>
                  <td>{{ $order['account_name'] }}</td>

                  <td>{{ $order['service_type'] }}</td>
                  <td>{{ $order['total_fee'] }}</td>
                  <td><a class="btn btn-primary" href="/orders/show/{{$order['id']}}/{{$order['awb']}}">{{ $order['order_status']}}</a>
                    {{ csrf_field() }}</td>

                </tr>
                @endforeach

              </tbody>
            </table>

            <div class="row">
              <div class="col-5">
              <ul class="pagination">
                <?php if($total_page > 0) { ?>
                  <li class="page-item {{$current_page == 1 ? 'disabled' : ''}}"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.($current_page-1)}}">Previous</a></li>
                  <?php for ($i=1; $i<=3 ; $i++){ ?>
                    <li class="page-item {{$i == $current_page ? 'active' : ''}}"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.$i}}" id="current_page_id">{{$i}}</a></li>
                  <?php } ?>
                  
                  <?php for ($i=1; $i<=$total_page ; $i++) { 
                    if($current_page!=1){
                      if($current_page!=2){
                        if($current_page!=3){
                          if($i==$current_page){                        
                    ?>
                      <li class="page-item {{$i == $current_page ? 'active' : ''}}"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.$i}}" id="current_page_id">{{$i}}</a></li>
                    <?php }
                        }
                      }
                    }
                    } ?>

                      <li class="page-item"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.$current_page}}">..</a></li>
                      <li class="page-item {{$total_page == $current_page ? 'active' : ''}}"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.$total_page}}">{{$total_page}}</a></li>
                      <li class="page-item {{$current_page == $total_page ? 'disabled' : ''}}"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.($current_page+1)}}">Next</a></li>
                <?php } else { ?>
                  <li class="page-item {{$current_page == 1 ? 'disabled' : ''}}"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.($current_page)}}">Previous</a></li>
                  <li class="page-item"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.$current_page}}">0</a></li>
                  <li class="page-item {{$current_page == 1 ? 'disabled' : ''}}"><a class="page-link" href="{{'?max_page='.$max_page.'&page='.($current_page)}}">Next</a></li>
                <?php } ?>                  
              </ul>
                  
              </div>
              <div class="col-4"></div>
              <div class="col-1"><strong><p>Total Data </p></strong></div>
              <div class="col-2">
                  <div class="form-group form-group-marginless">
                      <div class="input-group">
                          <select onchange="onChangeTotalData()" class="form-control kt-select2 init-select2" name="max_page" id="max_page">
                              <option value="10" @if($max_page == "10") selected @endif>10</option>
                              <option value="50" @if($max_page == "50") selected @endif>50</option>
                              <option value="100" @if($max_page == "100") selected @endif>100</option>
                              <option value="200" @if($max_page == "200") selected @endif>200</option>
                          </select>
                      </div>
                  </div>
                  
              </div>
          </div>

            <hr>
            <div class="text-center">
                
            </div>
            </div>
                <!-- Modal -->
                <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Upload CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <form action="{{ route('orders.import') }}" method="POST" enctype="multipart/form-data">
                          {{ csrf_field() }}
                            <input type="file" name="import_file" />

                            <input type="submit" value="import" class="btn btn-primary"/>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Mass Update CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <form action="{{ route('orders.importupdate') }}" method="POST" enctype="multipart/form-data">
                          {{ csrf_field() }}
                            <input type="file" name="import_update_file" />

                            <input type="submit" value="import" class="btn btn-primary"/>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <!-- <div class="modal-body"> -->
                        <form action="{{ route('orders.filter') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <!--Begin input tanggal pembuatan awal -->
                            <div class="input-group {{ $errors->has('tanggal_awal') ? ' has-danger' : '' }}">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="now-ui-icons arrows-1_minimal-down"></i>
                                </div>
                              </div>
                              <input class="form-control {{ $errors->has('tanggal_awal') ? ' is-invalid' : '' }}" 
                              min="{{date('Y-m-d', strtotime('-3 month'))}}" 
                              max="{{date('Y-m-d', strtotime('+3 month'))}}" 
                              placeholder="{{ __('Tanggal Awal Pembuatan (yyyy-MM-dd)') }}" 
                              type="date" 
                              name="tanggal_awal" 
                              id="tanggal_awal"
                              value="{{ old('tanggal_awal') }}" required autofocus>
                              @if ($errors->has('tanggal_awal'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                  <strong>{{ $errors->first('tanggal_awal') }}</strong>
                                </span>
                              @endif
                            </div>

                            <!--Begin input tanggal pembuatan akhir -->
                            <div class="input-group {{ $errors->has('tanggal_akhir') ? ' has-danger' : '' }}">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="now-ui-icons arrows-1_minimal-up"></i>
                                </div>
                              </div>
                              <input class="form-control {{ $errors->has('tanggal_akhir') ? ' is-invalid' : '' }}" min="{{date('Y-m-d', strtotime('-3 month'))}}" max="{{date('Y-m-d', strtotime('+3 month'))}}" placeholder="{{ __('Tanggal Akhir Pembuatan (yyyy-MM-dd)') }}" 
                              type="date" 
                              id="tanggal_akhir"
                              name="tanggal_akhir" 
                              value="{{ old('tanggal_akhir') }}" 
                              required autofocus>
                              @if ($errors->has('tanggal_akhir'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                  <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                                </span>
                              @endif
                            </div>

                            <div class="form-group">
                              <label for="exampleFormControlSelect1">Order Status</label>
                              <select name="order_status" class="form-control" id="exampleFormControlSelect1">
                                <option value="all">All</option>
                                <option value="info_received">Info Received</option>
                                <option value="pending">Pending</option>
                                <option value="in_transit">In Transit</option>
                                <option value="completed">Completed</option>
                                <option value="fail_shipper">Fail Shipper</option>
                                <option value="fail_courier">Fail Courier</option>
                                <option value="fail_recipient">Fail Recipient</option>
                                <option value="fail_attempt_1">Faile Attempt</option>
                              </select>
                            </div>

                            <input type="submit" value="check" class="btn btn-primary"/>

                        </form>

                      </div> -->
                    </div>
                  </div>
                </div>





              </div>
            </div>
          </div>
        </div>
      </div>
@include('orders.action')
@endsection
@push('js')
  <script type="text/javascript">
          $('#datatable').DataTable();
          $('#autoWidth').true();

          // set value before loading
          // tanggal awal
          $('#tanggal_awal').value(date('Y-m-d', strtotime('-3 month')));
          $('#tanggal_akhir').value(date('Y-m-d'));
          console.log( "ready ON LOAD !" );
      });
      function openFilterModal(){
          console.log("==> hello");
          $("#filterModalLabel").modal('show');
      }

      function onChangeTotalData() {
          var params = new window.URLSearchParams(window.location.search);
          var page = Number(params.get('page')) === 0 ? 1 : Number(params.get('page'));

          console.log("onchange......");
          console.log(base_url);
      }

      document.onreadystatechange = function () {

          if (document.readyState == "interactive") {
              // Initialize your application or run some code.
              console.log( "ready ON LOAD vanilla js!" );
              document.getElementById('tanggal_awal').value(date('Y-m-d', strtotime('-3 month')));
          }
      }

      

  // $(document).ready(function(){
  //           setDatePicker()
  //           setDateRangePicker(".startdate", ".enddate")
  //           setMonthPicker()
  //           setYearPicker()
  //           setYearRangePicker(".startyear", ".endyear")
  // })

  </script>
@endpush

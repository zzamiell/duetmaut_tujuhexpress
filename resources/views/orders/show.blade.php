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
          <h4 class="card-title"> {{ $orders->awb }} {{ ' / ' }} {{ $orders->ref_id }} {{ ' / ' }} {{ $orders->account_name }}</h4>
        </div>



        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>

        @endif

            <div class="card-body">

                <div class="card">
                    <h6 class="card-header">Order Detials</h6>
                    <div class="card-body">
                      <p class="card-text">


                            <div class="row">
                                <div class="col-md-7 pr-1">

                                        <label>{{__("Date Created: ")}}</label>
                                        {{ $orders->date_requested }} <br><hr>
                                        <label>{{__("Service Order:")}}</label>
                                        {{ $orders->service_order }} <br><hr>
                                        <label>{{__("Service Type: ")}}</label>
                                        {{ $orders->service_type }} <br><hr>
                                        <label>{{__("Weight: ")}}</label>
                                        {{ $orders->weight }} {{ ' kg' }}<br><hr>
                                        <label>{{__("Value of Goods: ")}}</label>
                                        {{ $orders->value_of_goods }}  <br><hr>
                                        <label>{{__("Insurance: ")}}</label>
                                        {{ $orders->is_insured }}<br><hr>
                                        <label>{{__("COD: ")}}</label>
                                        {{ $orders->is_cod }}<br><hr>
                                        <label>{{__("Delivery Fee: ")}}</label>
                                        {{ $orders->delivery_fee }}<br><hr>
                                        <label>{{__("Cod Fee: ")}}</label>
                                        {{ $orders->cod_fee }}<br><hr>
                                        <label>{{__("Total Fee: ")}}</label>
                                        {{ $orders->total_fee }} <br><hr>
                                        <label>{{__("Status: ")}}</label>
                                        {{ $orders->order_status }}<br><hr>
                                        @foreach ($OrdersLog as $log )
                                        <label> {{ $log['order_status'].' : ' }}</label>
                                        {{ date('Y-m-d H:i:s',strtotime($log['created_at'])) }} <br>

                                        @endforeach
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                          Edit Order
                                        </button>
                                 </div>


                                        <!--Pickup Delivery Details Table -->
                                          <table class="table">
                                            <thead>
                                              <tr>
                                                  <strong>
                                                <th scope="col"></th>
                                                <th scope="col">Shipper</th>
                                                <th scope="col">Recipient</th>
                                                  </strong>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <th scope="row">Name</th>
                                                <td>{{ $orders->shipper_name }}</td>
                                                <td>{{ $orders->recipient_name }}</td>

                                              </tr>
                                              <tr>
                                                <th scope="row">Contact</th>
                                                <td>{{ $orders->shipper_phone }}</td>
                                                <td>{{ $orders->recipient_phone }}</td>

                                              </tr>
                                              <tr>
                                                <th scope="row">Address</th>
                                                <td>{{ $orders->shipper_address }}</td>
                                                <td>{{ $orders->recipient_address}} </td>

                                              </tr>

                                              <tr>
                                                <th scope="row">Zip Code</th>
                                                <td>{{ $orders->shipper_postal_code }}</td>
                                                <td>{{ $orders->recipient_postal_code }} </td>

                                              </tr>

                                              <tr>
                                                <th scope="row">Area</th>
                                                <td>{{ $orders->shipper_area }}</td>
                                                <td>{{ $orders->recipient_area }} </td>

                                              </tr>

                                              <tr>
                                                <th scope="row">District</th>
                                                <td>{{ $orders->shipper_district }}</td>
                                                <td>{{ $orders->recipient_district }} </td>

                                              </tr>
                                            </tbody>
                                          </table>

                                          <!-- Modal -->
                                          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Change Order Status {{ $orders->awb }}</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                          </div>

                                          <div class="modal-body">
                                                  <form action="{{ route('update',$orders->awb)}}" method="POST">
                                                    {{ csrf_field() }}

                                                <input type="hidden" name="awb" value="{{ $orders->awb }}">
                                                <input type="hidden" name="id" value="{{ $orders->awb }}">


                                      <div class="row">
                                        <div class="col-7 pr-1">
                                            <div class="form-group">
                                                <label>{{__(" Status")}}</label>
                                                <select name="order_status" required="">

                                                  @foreach ($OrderStatus as $status )
                                                    <option value="{{ $status['name'] }}" @if (isset($orders->order_status) &&
                                                      $orders->order_status==$status['name'] )
                                                      selected=""@endif> {{ $status['name'] }}</option>

                                                  @endforeach
                                                </select>

                                            </div>

                                        </div>
                                    </div>










                                  </div>
                                  <div class="modal-footer">
                                    <div class="right">
                                      <button type="submit" class="btn btn-primary">Submit</button>

                                    </div>

                                </div>
                              </div>

                            </div>


      </div>

    </div>

    </div>
  </div>
</div>

@endsection

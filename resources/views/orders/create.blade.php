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
            <h4 class="card-title"> Add Order </h4>
          </div>
          <div class="card-body">

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('orders.store')}}" method="POST">
                @csrf

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__(" Ref ID")}}</label>
                        <input type="string" name="ref_id" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                    <div class="form-group">
                        <label>{{__("Account Name")}}</label>
                        <input type="string" name="account_name" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">

                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Service Order")}}</label>
                        <input type="string" name="service_order" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Service Type")}}</label>
                        <input type="string" name="service_type" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Name")}}</label>
                        <input type="string" name="shipper_name" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Phone")}}</label>
                        <input type="string" name="shipper_phone" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Address")}}</label>
                        <input type="string" name="shipper_address" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Zip Code")}}</label>
                        <input type="string" name="shipper_postal_code" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Area")}}</label>
                        <input type="string" name="shipper_area" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper District")}}</label>
                        <input type="string" name="shipper_district" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Name")}}</label>
                        <input type="string" name="recipient_name" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Phone")}}</label>
                        <input type="string" name="recipient_phone" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Address")}}</label>
                        <input type="string" name="recipient_address" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Zip Code")}}</label>
                        <input type="string" name="recipient_postal_code" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Area")}}</label>
                        <input type="string" name="recipient_area" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient District")}}</label>
                        <input type="string" name="recipient_district" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Weight")}}</label>
                        <input type="string" name="weight" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Value of Goods")}}</label>
                        <input type="string" name="value_of_goods" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <!--<div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Status")}}</label>
                        <input type="string" name="order_status" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>-->

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Insured?")}}</label>
                        <input type="string" name="is_insured" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Cod?")}}</label>
                        <input type="string" name="is_cod" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Delivery Fee")}}</label>
                        <input type="string" name="delivery_fee" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("COD Fee")}}</label>
                        <input type="string" name="cod_fee" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Insurance Fee")}}</label>
                        <input type="string" name="insurance_fee" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Total Fee")}}</label>
                        <input type="string" name="total_fee" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>



                 <div class="right">
                <button type="submit" class="btn btn-primary">Submit</button>

              </div>

          </div>
      </form>


          </div>
        </div>
      </div>

      </div>
    </div>
  </div>
@endsection

@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header">
                    <h6>New Billing</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form autocomplete="off" method="POST" action="{{ route('billing.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group-item border-0 mb-0">
                                            <div class="row align-item-center">

                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>BillNo <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ $billno }}"
                                                            class="form-control" name="billno" id="billno" readonly
                                                            style="background-color: lightgrey">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Date <span class="text-danger">*</span></label>
                                                        <input type="date" value="{{ $today }}"
                                                            class="form-control" name="date" id="date" required
                                                            style="background-color: lightgrey">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Time <span class="text-danger">*</span></label>
                                                        <input type="time" value="{{ $timenow }}"
                                                            class="form-control" name="time" id="time" required
                                                            style="background-color: lightgrey">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Delivery Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="delivery_date"
                                                            id="delivery_date" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Delivery Time <span class="text-danger">*</span></label>
                                                        <input type="time" class="form-control" name="delivery_time"
                                                            id="delivery_time" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Customer <span class="text-danger">*</span></label>
                                                        <select
                                                            class="form-control  select js-example-basic-single billing_customerid"
                                                            name="customer_id" id="customer_id" required>
                                                            <option value="" selected disabled class="text-muted">
                                                                Select Customer </option>
                                                            @foreach ($customers as $customers_arr)
                                                                <option value="{{ $customers_arr->id }}">
                                                                    {{ $customers_arr->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="form-group-item">
                                            <div class="table-responsive no-pagination">
                                                <table class="table table-center table-hover">
                                                    <thead
                                                        style="background: linear-gradient(320deg, #DDCEFF 0%, #DBECFF 100%);">
                                                        <tr>
                                                            <th style="width:25%">Product</th>
                                                            <th style="width:10%">Qty</th>
                                                            <th style="width:15%">Rate / Qty</th>
                                                            <th style="width:15%">Total</th>
                                                            <th style="width:10%" class="no-sort">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="billingold_products">
                                            </div>
                                            <tbody class="billing_products">

                                                <tr>
                                                    <td>
                                                        <input type="hidden" id="billingproducts_id"
                                                            name="billingproducts_id[]" />
                                                        <input type="hidden" class="form-control customer_product_id"
                                                            id="customer_product_id1" name="customer_product_id[]" />
                                                        <select
                                                            class="form-control  billing_product_id select js-example-basic-single"
                                                            name="billing_product_id[]" id="billing_product_id1" required>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" class="form-control billing_qty"
                                                            id="billing_qty" name="billing_qty[]" placeholder="Qty" />
                                                    </td>

                                                    <td><input type="text" class="form-control billing_rateperqty"
                                                            id="billing_rateperqty" name="billing_rateperqty[]"
                                                            placeholder="Rate / Qty" />
                                                    </td>

                                                    <td><input type="text" class="form-control billing_total"
                                                            id="billing_total" name="billing_total[]" placeholder="total"
                                                            readonly />
                                                    </td>

                                                    <td class="align-items-center">
                                                        <button class=" btn additemplus_button addbillingproducts"
                                                            type="button" id="" value="Add"><i
                                                                class="fe fe-plus-circle"></i></button>
                                                        <button class=" btn additemminus_button remove-billingtr"
                                                            type="button" id="" value="Add"><i
                                                                class="fe fe-minus-circle"></i></button>
                                                    </td>
                                                </tr>

                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align:right;font-size:15px;">Total</td>
                                                    <td><input type="text" class="form-control total_amount"
                                                            name="total_amount" id="total_amount" readonly></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12" hidden>
                                            <div class="form-group">
                                                <label>Discount Type<span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control  select js-example-basic-single billingdiscount_type"
                                                    name="billingdiscount_type" id="billingdiscount_type" required>
                                                    <option value="none"> Select </option>
                                                    <option value="Percentage" >Percentage(%)</option>
                                                    <option value="Fixed" selected>Fixed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-12" hidden>
                                            <div class="form-group">
                                                <label>Term<span class="text-danger">*</span></label>
                                                <select class="form-control  payment_term" name="payment_term"
                                                    id="payment_term" required>
                                                    <option value="Term I" selected>Term I</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-item border-0 p-0 py-3">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <div class="form-group-bank">
                                                    <div class="form-group notes-form-group-info">
                                                        <label>Notes <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" placeholder="Enter Notes" name="billing_note" id="billing_note" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <div class="form-group-bank">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label>Discount Amount<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control billingdiscount"
                                                                name="discount" id="discount" placeholder="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label>Payment Method<span class="text-danger">*</span></label>
                                                            <select
                                                                class="form-control  select js-example-basic-single payment_method"
                                                                name="payment_method" id="payment_method" required>
                                                                <option value="" disabled selected> Select </option>
                                                                <option value="GPay">GPay</option>
                                                                <option value="Cash">Cash</option>
                                                                <option value="PhonePay">PhonePay</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <div class="form-group-bank">
                                                    <div class="invoice-total-box">

                                                        <div class="invoice-total-footer">
                                                            <h4>Total <span class="billing_totalamount"> </span></h4>
                                                        </div>
                                                        <div class="invoice-total-footer">
                                                            <h4>Discount <span class="billing_discount"> </span></h4>
                                                            <input type="hidden"
                                                                class="form-control billing_discountamount"
                                                                name="billing_discountamount" id="billing_discountamount">

                                                        </div>
                                                        <div class="invoice-total-footer">
                                                            <h4 style="color:green;">Grand Total
                                                                <span class="billing_grandtotal"> </span>
                                                            </h4>
                                                            <input type="hidden"
                                                                class="form-control billing_grandtotalamount"
                                                                name="billing_grandtotalamount"
                                                                id="billing_grandtotalamount">
                                                        </div>
                                                        <hr>
                                                        <div class="invoice-total-footer" style="display: flex">
                                                            <h4>Paid Amount</h4>
                                                            <input type="text" class="form-control billing_paidamount"
                                                                required name="billing_paidamount" id="billing_paidamount"
                                                                placeholder="Enter Payable Amount">
                                                        </div>
                                                        <div class="invoice-total-footer">
                                                            <h4 style="color:red;">Balance<span class="billing_balance">
                                                                </span></h4>
                                                            <input type="hidden"
                                                                class="form-control billing_balanceamount"
                                                                name="billing_balanceamount" id="billing_balanceamount">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end" style="margin-top:3%">
                                        <input type="submit" class="btn btn-primary" />
                                        <a href="{{ route('billing.index') }}" class="btn btn-cancel btn-danger">Cancel</a>
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

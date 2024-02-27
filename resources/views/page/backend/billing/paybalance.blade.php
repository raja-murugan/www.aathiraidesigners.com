<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

        <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
                <h6 class="mb-0" style="color:red;">Pay Balance</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span class="align-center" aria-hidden="true">&times;</span>
            </button>
        </div>
        <form autocomplete="off" method="POST"
            action="{{ route('billing.paybalance', ['id' => $Billing_datas['id']]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>
                            <input style="background: #e0ddeb;" type="date" class="form-control"
                                value="{{ $today }}" name="pb_date">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Customer Name <span class="text-danger">*</span></label>
                            <input style="background: #e0ddeb;" type="text" class="form-control"
                                value="{{ $Billing_datas['customer'] }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input style="background: #e0ddeb;" type="text" class="form-control "
                                value="{{ $Billing_datas['phone_number'] }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Grand Total</label>
                            <input style="background: #e0ddeb;" type="text" class="form-control"
                                name="pb_grand_total" id="pb_grand_total" value="{{ $Billing_datas['grand_total'] }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Total Paid Amount</label>
                            <input style="background: #e0ddeb;" type="text" class="form-control"
                                name="pb_totalpaidamount" id="pb_totalpaidamount"
                                value="{{ $Billing_datas['total_paid_amount'] }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Total Balance Amount</label>
                            <input style="background: #e0ddeb;" type="text" class="form-control" style="color:red;"
                                name="pb_totalbalanceamount" id="pb_totalbalanceamount{{ $Billing_datas['id'] }}"
                                value="{{ $Billing_datas['total_balance_amount'] }}" readonly>
                        </div>
                    </div>


                    <div class="row mb-4">
                        <div class="form-group">
                            <label> Payment Activities </label>
                            <div class="row">
                                @foreach ($Billing_datas['billing_payment_arr'] as $index => $term_arr)
                                    @if ($term_arr['billing_id'] == $Billing_datas['id'])
                                        <div class="col-lg-4 col-md-4">
                                            <input type="text" style="background: #e0ddeb;" class="form-control term"
                                                readonly id="term" value="{{ $term_arr['payment_term'] }}">
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <input type="text" readonly style="background: #e0ddeb;"
                                                class="form-control " id=""
                                                value="{{ $term_arr['payment_paid_amount'] }}">
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <input type="text" readonly style="background: #e0ddeb;"
                                                class="form-control paymentmethod" id="paymentmethod"
                                                value="{{ $term_arr['payment_method'] }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('.paybalance' + {{ $Billing_datas['id'] }}).each(function() {
                                $(this).on('click', function(e) {

                                    e.preventDefault();
                                    var $this = $(this),
                                        booking_id = $this.attr('data-id');
                                    //alert(booking_id);


                                    $(document).on("keyup", '#pb_paidamount' + {{ $Billing_datas['id'] }},
                                        function() {
                                            var payable_amount = $(this).val();

                                            var balance_amount = $('#pb_totalbalanceamount' +
                                                {{ $Billing_datas['id'] }}).val();
                                            console.log(balance_amount);

                                            if (Number(payable_amount) > Number(balance_amount)) {
                                                alert('You are entering Maximum Amount of Balance');
                                                $('#pb_paidamount' + {{ $Billing_datas['id'] }}).val('');
                                            }
                                        });
                                });
                            });
                        });
                    </script>

                    <hr>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Term</label>
                            <select class="form-control select " name="pb_term" id="pb_term" required>
                                <option value="" disabled selected hiddden>Select </option>
                                <option value="Term II">Term II</option>
                                <option value="Term III">Term III</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select class="form-control select " name="pb_paymentmethod" id="pb_paymentmethod" required>
                                <option value="" disabled selected> Select </option>
                                <option value="GPay">GPay</option>
                                <option value="Cash">Cash</option>
                                <option value="PhonePay">PhonePay</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Payable Amount</label>
                            <input type="text" class="form-control pb_paidamount" name="pb_paidamount"
                                id="pb_paidamount{{ $Billing_datas['id'] }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Save</button>
                <button type="button" class="btn btn-cancel btn-danger" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
            </div>
        </form>
    </div>
</div>

@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">


      <div class="page-header">
         <div class="content-page-header">
            <h6>Update  Payoff</h6>
         </div>
      </div>


      <div class="row">
         <div class="col-sm-12">


            <div class="card">
               <div class="card-body">

                     <form autocomplete="off" method="POST"  action="{{ route('payoff.update', ['id' => $id, 'month' => $month, 'year' => $year]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
   

                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group-item border-0 mb-0">
                                 <div class="row align-item-center">
                                 
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                       <div class="form-group">
                                          <label >Employee <span class="text-danger">*</span></label>
                                          <input type="text" value="{{$employeedata->name}}" class="form-control"  readonly style="text-transform:uppercase;">
                                       </div>
                                    </div>  
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                       <div class="form-group">
                                          <label >Salary Amount <span class="text-danger">*</span></label>
                                          <input type="text" value="{{$totalsalary}}" class="form-control payoffedit_total" name="payoffedit_total"  readonly style="color: #dc3545; font-weight: 700;">
                                       </div>
                                    </div>  
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                       <div class="form-group">
                                          <label >Paid Amount<span class="text-danger">*</span></label>
                                          <input type="text" value="{{$paidsalary}}" name="payoffedit_totalpaid" class="form-control payoffedit_totalpaid" required readonly style="color: green; font-weight: 700;">
                                       </div>
                                    </div> 
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                       <div class="form-group">
                                          <label >Balance Amount<span class="text-danger">*</span></label>
                                          <input type="text" value="{{$balancesalary}}" name="payoffedit_totalbal" class="form-control payoffedit_totalbal" required readonly style="color: red; font-weight: 700;">
                                       </div>
                                    </div> 
                                                   
                                 </div>
                              </div>

                                          <br/>

                                             <div class="form-group-item">
                                                <div class="table-responsive no-pagination">
                                                   <table class="table table-center table-hover">
                                                      <thead  style="background: linear-gradient(320deg, #DDCEFF 0%, #DBECFF 100%);">
                                                         <tr>
                                                            <th style="width:20%">Date</th>
                                                            <th style="width:20%">Amount</th>
                                                            <th style="width:30%">Note</th>
                                                            <th style="width:10%" class="no-sort">Action</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody class="payoffeditdata">
                                                        @if(count($GetPayoffData) > 0)
                                                      @foreach ($GetPayoffData as $index => $GetPayoffDatas)
                                                         <tr>

                                                            <td><input type="hidden" name="payoffdata_id[]" value="{{ $GetPayoffDatas->id }}" />
                                                                <input type="date" class="form-control payoffedit_date" id="payoffedit_date"  name="payoffedit_date[]"  value="{{ $GetPayoffDatas->date }}"/></td>

                                                            <td><input type="text" class="form-control payoffedit_amount" id="payoffedit_amount" name="payoffedit_amount[]"  value="{{ $GetPayoffDatas->paidsalary }}"/></td>

                                                            <td><input type="text" class="form-control payoffedit_note" id="payoffedit_note" name="payoffedit_note[]"  value="{{ $GetPayoffDatas->note }}"/>
                                                            </td>

                                                            <td class="align-items-center">
                                                                  <button class="btn additemplus_button addpayoffeditfields" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>
                                                                  <button class="btn additemminus_button remove-payoffedit" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button>
                                                            </td>
                                                         </tr>
                                                         @endforeach
                                                         @endif
                                                      </div>
                                                   </table>
                                                </div>
                                             </div>

                                                   






                           </div>
                        </div>













                           <div class="text-end" style="margin-top:3%">
                                          <input type="submit" class="btn btn-primary" />
                                          <a href="{{ route('payoff.index') }}" class="btn btn-cancel btn-danger" >Cancel</a>
                           </div>
                       
      

                     </form>

               </div>
            </div>

         </div>
      </div>



   </div>
</div>


@endsection


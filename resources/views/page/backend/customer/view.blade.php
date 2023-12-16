<div class="modal-dialog modal-dialog-centered modal-xl">
   <div class="modal-content">


            <div class="modal-body">
               <div class="content container-fluid">

               <div class="page-header">
						<div class="content-page-header">
							<h5>Customer Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span class="align-center" aria-hidden="true">&times;</span>
                        </button>
						</div>
                  
					</div>


               <div class="card customer-details-group">
						<div class="card-body">
							<div class="row align-items-center">					
								<div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<div class="customer-details">
										<div class="d-flex align-items-center">
											<span class="customer-widget-img d-inline-flex">
												<img class="rounded-circle" src="{{ asset('assets/customer_photo/' . $customer_data['customer_photo']) }}" alt="">
											</span>
											<div class="customer-details-cont">
												<h6>{{$customer_data['name']}}</h6>
												<p>Staff - {{$customer_data['employee']}}</p>
											</div>
										</div>
									</div> 
								</div>
								<div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<div class="customer-details">
										<div class="d-flex align-items-center">
											<span class="customer-widget-icon d-inline-flex">
												<i class="fe fe-mail"></i>
											</span>
											<div class="customer-details-cont">
												<h6>Email Address</h6>
												<p>{{$customer_data['email_id']}}</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<div class="customer-details">
										<div class="d-flex align-items-center">
											<span class="customer-widget-icon d-inline-flex">
												<i class="fe fe-phone"></i>
											</span>
											<div class="customer-details-cont">
												<h6>Phone Number</h6>
												<p>{{$customer_data['phonenumber']}}</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<div class="customer-details">
										<div class="d-flex align-items-center">
											<span class="customer-widget-icon d-inline-flex">
												<i class="fe fe-airplay"></i>
											</span>
											<div class="customer-details-cont">
												<h6>Alternate Phone No</h6>
												<p>{{$customer_data['alter_phonenumber']}}</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<div class="customer-details">
										<div class="d-flex align-items-center">
											<span class="customer-widget-icon d-inline-flex">
												<i class="fe fe-briefcase"></i>
											</span>
											<div class="customer-details-cont">
												<h6>Address</h6>
												<p>{{$customer_data['address']}}</p>
											</div>
										</div>
									</div>
								</div>	
								<div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<div class="customer-details">
										<div class="d-flex align-items-center">
											<span class="customer-widget-icon d-inline-flex">
												<i class="fe fe-briefcase"></i>
											</span>
											<div class="customer-details-cont">
												<h6>Source From</h6>
												<p>{{$customer_data['source_from']}}</p>
											</div>
										</div>
									</div>
								</div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<div class="customer-details">
										<div class="d-flex align-items-center">
											<span class="customer-widget-icon d-inline-flex">
												<i class="fe fe-briefcase"></i>
											</span>
											<div class="customer-details-cont">
												<h6>DOB</h6>
												<p>{{date('d-m-Y', strtotime($customer_data['birth_date']))}}</p>
											</div>
										</div>
									</div>
								</div>	<div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<div class="customer-details">
										<div class="d-flex align-items-center">
											<span class="customer-widget-icon d-inline-flex">
												<i class="fe fe-calendar"></i>
											</span>
											<div class="customer-details-cont">
												<h6>Wedding Date</h6>
												<p>{{date('d-m-Y', strtotime($customer_data['wedding_date']))}}</p>
											</div>
										</div>
									</div>
								</div>		
							</div>
						</div>
					</div>

               <div class="page-header">
						<div class="content-page-header">
							<h5>Family Details</h5>
						</div>
					</div>

                        <div class="invoice-item invoice-item-two card">
                           <div class="card-body">
                              <div class="row">

                                 <div class="col-md-4 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#28084B;font-weight: 700;line-height: 35px; ">Family Name</span>
                                 </div>
                                 <div class="col-md-2 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#28084B;font-weight: 700;line-height: 35px; ">Relationship</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#28084B;font-weight: 700;line-height: 35px; ">DOB</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#28084B;font-weight: 700;line-height: 35px; ">Wedding Date</span>
                                 </div>

                              </div>
                              <div class="row ">
                                 @foreach ($customer_data['families'] as $index => $families)
                                    @if ($families['customer_id'] == $customer_data['id'])
                                    <div class="col-md-4 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $families['family_name'] }}</span>
                                    </div>
                                    <div class="col-md-2 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $families['family_relationship'] }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ date('d-m-Y', strtotime($families['family_dob'])) }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; "> {{ date('d-m-Y', strtotime($families['family_weddingdate'])) }}</span>
                                    </div>
                                    @endif
                                 @endforeach
                              </div>
                           </div>
                        </div>



  

               </div>
            </div>
   </div>
</div>

           
   </div>
</div>
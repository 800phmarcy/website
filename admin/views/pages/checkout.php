
    
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="<?php echo site_url(getUrl(array("c" => "home", "m" => "index"))); ?>">Home</a> <span class="mx-2 mb-0">/</span> <a href="<?php echo site_url(getUrl(array("c" => "cart", "m" => "index"))); ?>">Cart</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
      
        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Shipping Address</h2>
            <div class="mb-3 map-border">
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28884.319245514427!2d55.25684228362724!3d25.185008819702485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f682def25f457%3A0x3dd4c4097970950e!2sBusiness%20Bay%20-%20Dubai!5e0!3m2!1sen!2sae!4v1660832572947!5m2!1sen!2sae" width="100%" height="250" style=" border-radius: 1rem;border:0
             "0o   allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="p-3 p-lg-5 border">


              <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_type" class="text-black">Address Type <span class="text-danger">*</span></label>
                  <select id="c_type" class="form-control">
                    <option value="1">Home</option>    
                    <option value="2">Office</option>      
                  </select>
              </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_state_country" class="text-black">Emirate <span class="text-danger">*</span></label>
                  <select id="c_country" class="form-control">
                    <option value="1">Select Emirate</option>    
                    <option value="2">Dubai</option>    
                    <option value="3">Abu Dhabi</option>    
                    <option value="4">Sharjah</option>    
                    <option value="5">Ajman</option>    
                    <option value="6">Umm al Quawein</option>    
                    <option value="7">Ras Al Khaimah</option>    
                    <option value="8">Fujairah</option>    
                    <option value="9">Al Ain</option>    
                  </select>
              </div>
              </div>

               <div class="form-group row">
                      <div class="col-md-6">
                  <label for="l_password" class="text-black">Apartment <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="l_password" name="l_password" placeholder="Apartment / Flat / Room">
                </div>
                <div class="col-md-6">
                    <label for="l_confirm_password" class="text-black">Building<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="l_confirm_password" name="l_confirm_password" placeholder="Building / Villa / Warehouse">
                </div>
    
              </div>

               <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_address" class="text-black">Street Address <span class="text-danger">*</span></label>
           
                  <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address">
                </div>
              </div>

           
              <div class="form-group">
                <label for="c_order_notes" class="text-black">Shipment Notes</label>
                <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
              </div>

            </div>
          </div>
          <div class="col-md-6">

            
            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Order Summary</h2>
                <div class="p-3 p-lg-5 border">
                  <table class="table site-block-order-table mb-5">
                    <tbody>
                      <tr>
                        <td class="text-black font-weight-bold"><strong>Subtotal</strong></td>
                        <td class="text-black">$350.00</td>
                      </tr>
                       <tr>
                        <td class="text-black font-weight-bold"><strong>VAT</strong></td>
                        <td class="text-black">$10.00</td>
                      </tr>
                       <tr>
                        <td class="text-black font-weight-bold"><strong>Discount</strong></td>
                        <td class="text-black">$20.00</td>
                      </tr>
                      <tr>
                        <td class="text-black font-weight-bold"><strong>Grand Total</strong></td>
                        <td class="text-black font-weight-bold"><strong>$320.00</strong></td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Online Payment</a></h3>

                    <div class="collapse" id="collapsebank">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div>

                  <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">Cash on Delivery</a></h3>

                    <div class="collapse" id="collapsecheque">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly to the driver. Please use your Order ID as the payment reference. Your order will be shipped and have to pay the amount once you receive the order.</p>
                      </div>
                    </div>
                  </div>


                  <div class="form-group">
                    <button class="btn btn-outline-primary btn-lg btn-block" id="place_order">Place Order</button>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>

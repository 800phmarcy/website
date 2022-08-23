
    
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="<?php echo site_url(getUrl(array("c" => "home", "m" => "index"))); ?>">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Create Account</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-6">

            <div class="p-3 p-lg-5">

              <div class="title-section mb-3">
                <h2 class="text-uppercase">Welcome Back,</h2>
              </div>

              <div class="sub-title-section mb-5">
                <h2>Enter your credentials to access your account!</h2>
              </div>


          
              <div class="form-group row">
                <div class="col-md-12">
                  <label for="l_email" class="text-black">Email <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="l_email" name="l_email">
                </div>          
              </div>

              <div class="form-group row mb-4">
                <div class="col-md-12">
                  <label for="l_password" class="text-black">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="l_password" name="l_password" placeholder="">
                </div>          
              </div>


                <div class="form-group">
                    <button class="btn btn-outline-primary btn-lg btn-block" id="place_order">Log In</button>
                </div>


                 <div class="row">
                  <div class="col-md-12 mb-0">Don't have an account? <strong class="text-black"><a href="<?php echo site_url(getUrl(array("c" => "account", "m" => "register"))); ?>">Register here</a> </strong></div>
                </div>



            </div>
          
          </div>

          <div class="col-md-6" >

            <img src="assets/images/model_6.png" class="img-fluid">
          
          </div>
        </div>


      </div>
    </div>

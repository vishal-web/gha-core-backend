<style>
.cart table td.middle-desc {
  max-width: 100px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.display-none {
  display: none;
}

.btn.selected {
  color: #fff;
  background-color: red;
}

#billing-address-list {
  padding-bottom: 20px;
}

.loader {
  border: 10px solid #f3f3f3; /* Light grey */
  border-top: 10px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 60px;
  height: 60px;
  animation: spin 2s linear infinite;
  left: 50%;
  top: 50%; 
  display: none;
  position: fixed;
  z-index: 99;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<div class='default-padding cart'>
  <div class='container'>
    <h2><?=$headline?></h2>
    <div id="overlay">
      <div class='loader'></div>
    </div>
    <div class='row'> 
      <div class='col-md-6'>

        <form id='checkout-form' action='<?=base_url('cart/submit')?>' method='post' class='form' enctype='multipart/form-data'>
          
          <?php if (empty($this->logged_in_user_data)) { ?>
            <div class='text-title title-base'>
              <hr>
              <h4 class='underline'>Create New Account</h4>
            </div>
          
            <div class='form-group'>
              <label class='control-label'>Name</label>
              <input type='text' class='form-control'  name='name'  id='name' placeholder='Enter your name' value=''>
            </div>
            <div class='form-group'>
              <label class='control-label'>Email</label>
              <input type='text' class='form-control'  name='email'  id='email' placeholder='Enter your email' value=''>
            </div>
            <div class='form-group'>
              <label class='control-label'>Password</label>
              <input type='password' class='form-control'  name='password'  id='password' placeholder='Enter your password' value=''>
            </div>
            <br/>
          <?php } ?>
          
          <?php $display_css = ''; if (!empty($saved_address)) { $display_css = 'display-none';?>
            <div id='billing-address-list'>
              <div class='text-title title-base'>
                <hr>
                <h4 class='underline'>Saved Billing Address</h4>
              </div>
              <div class="row">
                <?php  foreach($saved_address as $key => $saved_address) {  
                  $create_address = trim($saved_address['billing_street_address']).', '. $saved_address['city_name'] .', '.$saved_address['state_name']. ', '. $saved_address['billing_pincode'].' '.$saved_address['country_name']; 
                ?>  
                <div class="col-sm-6 m-b-20">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title"><?=ucfirst($saved_address['billing_name'])?></h4>
                      <p class="card-text"><?=$create_address?></p>
                      <a href="#" class="btn btn-default billing-address-use" data-id='<?=$saved_address['id']?>'>Use this</a>
                      <?php if (!isset($saved_address[$key + 1]))?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div> 
              <br>
              <a href="#" id='billing-address-add' class="btn btn-default">Add New</a> 
            </div>
          <?php } ?> 
          <div id='billing-address-form' class='<?=$display_css?> m-b-20'>
            <div class='text-title title-base'>
              <hr>
              <h4 class='underline'>Billing Details</h4>
            </div>
          
            <div class='form-group'>
              <label class='control-label'>Name</label>
              <input type='text' class='form-control'  name='billing_name'  id='billing_name' placeholder='Enter your name' value=''>
            </div>
            <div class='row'>
              <div class='col-md-6'>
                <div class='form-group'>
                  <label class='control-label'>Phone</label>
                  <input type='text' class='form-control' name='billing_phone' placeholder='Enter your phone number' value=''>
                </div>
              </div>
              <div class='col-md-6'>
                <div class='form-group'>
                  <label class='control-label'>Email</label>
                  <?php  
                    $email_value = !empty($logged_in_user_data) ? $logged_in_user_data[0]['email'] : null; 
                  ?>
                  <input type='email' class='form-control' name='billing_email' value='<?=$email_value?>'>
                </div>
              </div>
            </div>
            
            <div class='row'>
              <div class='col-md-6'> 
                <div class='form-group'>
                  <label class='control-label'>Street address</label>
                  <input type='text' class='form-control' name='billing_street_address' placeholder='House number and street name' value=''>
                </div>
              </div>
              <div class='col-md-6'>
                <div class='form-group'>
                  <label class='control-label'>Pincode/Zip</label>
                  <input type='text' class='form-control' name='billing_pincode' placeholder='Enter your pincode or zip' value=''>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class='control-label'>Country</label>
              <?php
                $billing_country_default = set_value('billing_country') == '' ? (isset($billing_country) ? $billing_country : '') : set_value('billing_country');
                $billing_country_options= ['class' => 'form-control', 'id' => 'country', 'style' => 'height:45px;'];
                echo form_dropdown('billing_country', $country_dropdown, $billing_country_default, $billing_country_options);
                echo form_error('billing_country');
              ?>
            </div>
              
            <div class="form-group">
              <label class='control-label'>State</label>
              <?php
                $billing_state_default = set_value('billing_state') == '' ? (isset($billing_state) ? $billing_state : '') : set_value('billing_state');
                $billing_state_options= ['class' => 'form-control', 'id' => 'state', 'style' => 'height:45px;',];
                echo form_dropdown('billing_state', $state_dropdown, $billing_state_default, $billing_state_options);
                echo form_error('billing_state');
              ?>
            </div>
            <div class="form-group">
              <label class='control-label'>City</label>
              <?php 
                $billing_city_default = set_value('billing_city') == '' ? (isset($billing_city) ? $billing_city : '') : set_value('billing_city');
                $billing_city_options= ['class' => 'form-control', 'id' => 'city', 'style' => 'height:45px;'];
                echo form_dropdown('billing_city', $city_dropdown, $billing_city_default, $billing_city_options);
                echo form_error('billing_city');
              ?>
            </div>

            <div class="form-group">
              
              <div class="checkbox">
                <input type="hidden" name='default_billing_address' value="0">

                <label>
                  <input type="checkbox" name='default_billing_address' value="1" style='min-height:auto; margin-top:6px;'>
                  Make this Default Billing Address
                </label>
              </div>
              
            </div>
            <input type='hidden' name='submit' value='Submit' />
            <button type='submit' class='btn btn-primary btn-lg' name='submit' value='Submit' >Submit</button>
          </div>
        </form>
      </div>

      <?php if (!empty($query)) { ?>
      <div class='col-md-6 checkout-order'>  
        <div class='text-title title-base'>
          <hr>
          <h4 class='underline'>Your order</h4>
        </div>
        <table border='0' class='table vertical-align-middle'>
          <?php 
            $total = 0;
            foreach ($query as $row) {  
              $course_title_desc = '<a href="'.base_url('course/').$row['url_title'].'"><b class="fs-16">'.$row['title'].'</b><br/><small>Duration: '.$row['duration'].'Months</small></a>';
              $total += $row['price'];
              $thumb_path = base_url('uploads/course/thumb/'.$row['featured_image']);
          ?>
          <tr>
            <td class='vcenter col-md-2'><img width='75' height='75' class='' src='<?=$thumb_path?>'/></td>
            <td class='vcenter middle-desc'><?=$course_title_desc?></td>
            <td class='vcenter text-right'><?=number_in_inr($row['price'])?></td>
          </tr>
          <?php } ?>
          
          <tr>
            <td colspan="2" class=''><b>Total</b></td>
            <td class='text-right'><?=number_in_inr($total)?></td>
          </tr>
        </table>
        <div class='col-md-12'>
          <div class='form-group text-center'>
            <button  class='btn btn-primary btn-lg'  value='Place Order' id='place-order'>Place Order</button>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
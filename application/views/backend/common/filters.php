<div class="col-xs-12"> 
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Filters</h3>
    </div> 
    <form action="<?=$form_location?>" method="get">
      <div class="box-body"> 
        <div class="row"> 
          <?php if(isset($filter_by['email'])) { ?>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">Search By Email / Phone</label>
              <input type="text" class="form-control" name="search" value="<?=isset($_GET['search']) ? $_GET['search'] : ''?>" placeholder="Enter Email / Phone">
            </div>
          </div>
          <?php } ?>
          <?php if(isset($filter_by['start_date'])) { ?>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">Start Date</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="start_date" value="<?=isset($_GET['start_date']) ? $_GET['start_date'] : ''?>" id="start-datepicker">
              </div>
            </div>
          </div>
          <?php } ?>
          <?php if(isset($filter_by['end_date'])) { ?>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">End Date</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="end_date" value="<?=isset($_GET['end_date']) ? $_GET['end_date'] : ''?>" id="end-datepicker">
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>  
      <div class="box-footer">
        <button type="submit" value='submit' class="btn btn-primary">Submit</button>
        <a href="<?=$filter_by['cancel_url']?>" class="btn btn-warning">Cancel</a>
      </div>
    </form>
  </div> 
</div>
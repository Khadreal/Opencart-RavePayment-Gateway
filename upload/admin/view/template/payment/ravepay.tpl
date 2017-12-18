<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-ravepay" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-ravepay" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="ravepay_total" value="<?php echo $ravepay_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="ravepay_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $ravepay_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-failed-status"><?php echo $entry_failed_status; ?></label>
            <div class="col-sm-10">
              <select name="ravepay_failed_status_id" id="input-failed-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $ravepay_failed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
         
         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-test-secret"><?php echo $entry_test_secret; ?></label>
            <div class="col-sm-10">
             <input class="form-control" placeholder="<?php echo $entry_test_secret; ?>" id="input-test-secret" type="text" value="<?php echo $ravepay_test_secret_key; ?>" name="ravepay_test_secret_key">
             <?php if ($error_test_secret_key) { ?>
                <div class="text-danger"><?php echo $error_test_secret_key; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-test-public"><?php echo $entry_test_public; ?></label>
            <div class="col-sm-10">
             <input class="form-control" placeholder="<?php echo $entry_test_public; ?>" id="input-test-public" type="text" value="<?php echo $ravepay_test_public_key; ?>" name="ravepay_test_public_key"> 
              <?php if ($error_test_public_key) { ?>
                <div class="text-danger"><?php echo $error_test_public_key; ?></div>
              <?php } ?>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-test-secret"><?php echo $entry_live_secret; ?></label>
            <div class="col-sm-10">
             <input class="form-control" placeholder="<?php echo $entry_live_secret; ?>" id="input-live-secret" type="text" value="<?php echo $ravepay_live_secret_key?>" name=" ravepay_live_secret_key">
              
              <?php if ($error_live_secret_key) { ?>
                <div class="text-danger"><?php echo $error_live_secret_key; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-test-live"><?php echo $entry_live_public; ?></label>
            <div class="col-sm-10">
             <input class="form-control" placeholder="<?php echo $entry_live_public; ?>" id="input-live-public" type="text" value="<?php echo $ravepay_live_public_key?>" name=" ravepay_live_public_key">
              <?php if ($error_live_public_key) { ?>
                <div class="text-danger"><?php echo $error_live_public_key; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_test_currency; ?></label>
            <div class="col-sm-10">
              <select name="ravepay_currency" id="input-order-status" class="form-control">
                <option value="NGN" <?php echo ($ravepay_currency == "NGN" ? 'selected="selected"': '') ?> >Naira</option>
                <option value="USD" <?php echo ($ravepay_currency == "USD" ? 'selected="selected"': '') ?> >US Dollar</option>
                <option value="EUR" <?php echo ($ravepay_currency == "EUR" ? 'selected="selected"': '') ?> >Euro</option>
                <option value="GBP" <?php echo ($ravepay_currency == "GBP" ? 'selected="selected"': '') ?> >Pounds</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_test_country; ?></label>
            <div class="col-sm-10">
              <select name="ravepay_country" id="input-order-status" class="form-control">
                <option value="NG">Nigeria</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-live-demo"><?php echo $entry_live; ?></label> 
            <div class="col-sm-10">
              <select name="ravepay_live" id="input-live-demo" class="form-control">
                <option value="1" <?php echo ($ravepay_live ? 'selected="selected"':''); ?>><?php echo $text_yes; ?>
                </option>
                <option value="0" <?php echo ($ravepay_live ? '':'selected="selected"'); ?>><?php echo $text_no; ?>
                </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="ravepay_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $ravepay_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="ravepay_status" id="input-status" class="form-control">
                <?php if ($ravepay_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="ravepay_sort_order" value="<?php echo $ravepay_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
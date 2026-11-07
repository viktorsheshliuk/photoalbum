<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> 
        <button type="submit" form="form-remarketing" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($max_input_vars_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $max_input_vars_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($jetcache_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $jetcache_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($seopro_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $seopro_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($theme_editor_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $theme_editor_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-remarketing" class="form-horizontal">
		  <div class="col-md-2">
		  <ul class="nav nav-pills nav-stacked">
		    <li class="active"><a href="#tab-diagnostics" data-toggle="tab" class="diag"><i class="fa fa-gears"></i> <?php echo $text_diagnostics; ?> <i class="fa fa-flash"></i></a></li>
            <li><a href="#tab-ecommerce-ga4" data-toggle="tab" <?php if ($remarketing_ecommerce_status || $remarketing_ecommerce_ga4_status || $remarketing_ecommerce_ga4_measurement_status) { ?>class="enabled"<?php } ?>><i class="fa fa-money"></i> <?php echo $text_ecommerce_ga4; ?></a></li>
			<li><a href="#tab-google" data-toggle="tab" <?php if ($remarketing_google_status) { ?>class="enabled"<?php } ?>><i class="fa fa-google"></i> <?php echo $text_google_remarketing; ?></a></li>
			<li><a href="#tab-google-reviews" data-toggle="tab" <?php if ($remarketing_reviews_status) { ?>class="enabled"<?php } ?>><i class="fa fa-google"></i> <?php echo $text_google_reviews; ?></a></li>
            <li><a href="#tab-facebook" data-toggle="tab" <?php if ($remarketing_facebook_status) { ?>class="enabled"<?php } ?>><i class="fa fa-facebook"></i> <?php echo $text_facebook_remarketing; ?></a></li>
			<li><a href="#tab-feed" data-toggle="tab" <?php if ($remarketing_feed_status) { ?> class="enabled"<?php } ?>><i class="fa fa-compress"></i> <?php echo $text_feed; ?></a></li>
			<li><a href="#tab-esputnik" data-toggle="tab" <?php if ($remarketing_esputnik_status) { ?> class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_esputnik; ?></a></li>
			<li><a href="#tab-tiktok" data-toggle="tab" <?php if ($remarketing_tiktok_status) { ?> class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_tiktok; ?></a></li>
			<li><a href="#tab-snapchat" data-toggle="tab" <?php if ($remarketing_snapchat_status) { ?> class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_snapchat; ?> Beta</a></li>
			<li><a href="#tab-uet" data-toggle="tab" <?php if ($remarketing_uet_status) { ?> class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_uet; ?> Beta</a></li>
			<li><a href="#tab-telegram" data-toggle="tab" <?php if ($remarketing_telegram_status) { ?> class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_telegram; ?></a></li>
            <li><a href="#tab-events" data-toggle="tab"><i class="fa fa-bullhorn"></i> <?php echo $text_events; ?></a></li>
            <li><a href="#tab-counters" data-toggle="tab"><i class="fa fa-tachometer"></i> <?php echo $text_counters; ?></a></li>
			<li><a href="<?php echo $remarketing_report_link; ?>" target="_blank"><i class="fa fa-rocket"></i> <?php echo $text_reports; ?></a></li>
            <li><a href="#tab-help" data-toggle="tab"><i class="fa fa-life-ring"></i> <?php echo $text_help; ?></a></li>
          </ul>
		  </div>
		  <div class="col-md-10">
		  <div class="tab-content">
		   <div class="tab-pane active" id="tab-diagnostics">
		   <legend><?php echo $text_version; ?>: <span class="version"><?php echo $version; ?></span><span class="version-update"></span></legend>
		   <legend><?php echo $text_check_install; ?></legend>
		   <div>
		   <div class="col-sm-12"><?php echo $check_install; ?></div>
		   </div>
		   <legend><?php echo $text_forum_documentation; ?></legend>
		   <div class="help-link"><a href="https://remarketing.freelancer.od.ua/" target="_blank"><?php echo $text_help_link; ?></a></div>
		   <div class="help-link"><a href="https://opencartforum.com/files/file/7492-sp-seo-remarketing-all-in-one-pro-23x-3x-google-analytics-4-dinamicheskiy-remarketing-google-ads-facebook-conversions-api-tiktok-marketing-api-fid-dlya-google-merchant-facebook-catalog-tiktok-google-otzyvy-esputnik/?tab=tutorials" target="_blank"><?php echo $text_help_link; ?> Opencartforum</a></div>
		    <?php if (!$remarketing_google_status && !$remarketing_ecommerce_ga4_status && !$remarketing_facebook_status) { ?> 
		  <legend>Quickstart</legend>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Google GA4 ID</label>
                <div class="col-sm-10">
                   <input type="text" name="ga4_id" value="" id="ga4_id" class="form-control"/>
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label">GTM ID</label>
                <div class="col-sm-10">
                   <input type="text" name="gtm_id" value="" id="gtm_id" class="form-control"/>
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Adwords ID</label>
                <div class="col-sm-10">
                   <input type="text" name="ads_id" value="" id="ads_id" class="form-control"/>
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Facebook Pixel ID</label>
                <div class="col-sm-10">
                   <input type="text" name="facebook_id" value="" id="facebook_id" class="form-control"/>
                </div>
		  </div>
		  <a class="btn btn-primary magic-button">Magic</a>
		  <script>
		  $('.magic-button').on('click', function() {
		      $('[name="remarketing_status"]').prop('checked', true);
			  fb_id = $('#facebook_id').val();
			  gtag_text = '';
		      if (fb_id != '') {
				  $('[name="remarketing_facebook_status"], [name="remarketing_facebook_script_status"], [name="remarketing_facebook_pixel_status"], [name="remarketing_facebook_lead"]').prop('checked', true);
				  $('[name="remarketing_facebook_currency"]').val('UAH').trigger('change');
				  $('[name="remarketing_facebook_identifier"]').val(fb_id);
			  }
			  ga4_id = $('#ga4_id').val();
		      if (ga4_id != '') {
				  $('[name="remarketing_ecommerce_ga4_status"]').prop('checked', true);
				  $('[name="remarketing_ecommerce_currency"]').val('UAH').trigger('change');
				  $('[name="remarketing_ecommerce_ga4_identifier"]').val(ga4_id);
			  }
			  ads_id = $('#ads_id').val();
		      if (ads_id != '') {
				  $('[name="remarketing_google_status"]').prop('checked', true);
				  $('[name="remarketing_google_currency"]').val('UAH').trigger('change');
				  $('[name="remarketing_google_identifier"]').val(ads_id);
			  }
			  gtm_id = $('#gtm_id').val();
		      if (gtm_id != '') {
				   var gtm_head_tag = "\n&lt;!-- Google Tag Manager --&gt;&lt;script&gt;(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm['start']':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" + gtm_id + "');&lt;/script&gt;&lt;!-- End Google Tag Manager --&gt;";
				   var gtm_body_tag = "\n&lt;!-- Google Tag Manager (noscript) --&gt;&lt;noscript&gt;&lt;iframe src='https://www.googletagmanager.com/ns.html?id=" + gtm_id + "' height='0' width='0' style='display:none;visibility:hidden'&gt;&lt;/iframe&gt;&lt;/noscript&gt;&lt;!-- End Google Tag Manager (noscript) --&gt;\n";
				   $('[name="remarketing_counter1"]').append(gtm_head_tag); 
				   $('[name="remarketing_counter2"]').append(gtm_body_tag); 
			  }
			  if (ga4_id != '' || ads_id != '') {
				  if (ga4_id != '') {
				      gtag_id = ga4_id;
				  }
				  if (ads_id != '' && ga4_id == '') {
				      gtag_id = ads_id;
				  }
				  gtag_text += "\n&lt;!-- Google tag (gtag.js) --&gt;&lt;script async src='https://www.googletagmanager.com/gtag/js?id=" + gtag_id + "'&gt;&lt;/script&gt;&lt;script&gt;window.dataLayer = window.dataLayer || [];function gtag(){dataLayer['push'](arguments);}gtag('js', new Date());gtag('config', '" + gtag_id + "');";
				  if (ga4_id != '' && ads_id != '') {
				     gtag_text += "gtag('config', '" + ads_id + "');";
				  }
				   gtag_text += "&lt;/script&gt;"; 
				   $('[name="remarketing_counter1"]').append(gtag_text);
			  }			  
			  $(this).text('Wait f|| $magic :)'); 
			  setTimeout(function() {
				  $('[form="form-remarketing"]').trigger('click');
			  }, 3000);
		  });
		  </script>
		  <br><br>
		  <?php } ?>

		   <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
				<label class="switch">
					<input type="checkbox" name="remarketing_status" <?php if ($remarketing_status) { ?>checked<?php } ?> > 
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_bot_status; ?></label>
            <div class="col-sm-10">
				<label class="switch">
					<input type="checkbox" name="remarketing_bot_status" <?php if ($remarketing_bot_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_admin_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_admin_status" <?php if ($remarketing_admin_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group"> 
            <label class="col-sm-2 control-label"><?php echo $entry_debug_mode; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_debug_mode" <?php if ($remarketing_debug_mode) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_autoclear_mode; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_autoclear_mode" <?php if ($remarketing_autoclear_mode) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_show_in_order; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_show_in_order" <?php if ($remarketing_show_in_order) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_no_shipping; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_no_shipping" <?php if ($remarketing_no_shipping) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		   <div>
		   </div>
		  </div>		  
		  <div class="tab-pane" id="tab-google">
          <legend><?php echo $text_google_remarketing; ?></legend>
		  <div class="help-link"><a href="https://support.google.com/google-ads/answer/7305793?hl=ru" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		  <div class="help-link"><a href="https://opencartforum.com/files/tutorials/532-instrukciya-po-nastroyke-remarketinga-google/" target="_blank"><?php echo $text_help_link; ?> Opencartforum</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_google_status" <?php if ($remarketing_google_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
		  <label class="col-sm-2 control-label"><?php echo $entry_currency; ?> - Google ADS</label>
				<div class="col-sm-10">
			<select name="remarketing_google_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code']  ==  $remarketing_google_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['code'] ?><?php echo $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo $currency['code'] ?><?php echo $currency['title']; ?></option>
				<?php } ?> 
				<?php } ?>
			</select>
		 </div>
		 </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_google_identifier; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_google_identifier" value="<?php echo $remarketing_google_identifier; ?>" class="form-control" />
                  </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_google_ads_identifier; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_google_ads_identifier" value="<?php echo $remarketing_google_ads_identifier; ?>" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_google_ads_identifier_cart; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_google_ads_identifier_cart" value="<?php echo $remarketing_google_ads_identifier_cart; ?>" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_google_ads_identifier_cart_page; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_google_ads_identifier_cart_page" value="<?php echo $remarketing_google_ads_identifier_cart_page; ?>" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_google_ads_ratio; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_google_ads_ratio" value="<?php echo $remarketing_google_ads_ratio; ?>" class="form-control" />
               </div>
			</div>
		    <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_google_id" class="form-control">
                <?php if ($remarketing_google_id  ==  'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_google_id  ==  'model' ) { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                 <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?> 
              </select>
            </div>
          </div> 
		  </div>
		  <div class="tab-pane" id="tab-facebook">
		  <div class="">
          </div> 
          <legend><?php echo $text_facebook_remarketing; ?></legend>
		  <div class="help-link"><a href="https://developers.facebook.com/docs/facebook-pixel/reference" target="_blank"><?php echo $text_help_link; ?> Facebook</a></div>
		  <div class="help-link"><a href="https://opencartforum.com/files/tutorials/534-instrukciya-po-nastroyke-remarketinga-facebook/ target="_blank"><?php echo $text_help_link; ?> Opencartforum</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_facebook_status" <?php if ($remarketing_facebook_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
		  <label class="col-sm-2 control-label"><?php echo $entry_currency; ?> - Facebook (Meta)</label>
				<div class="col-sm-10">
			<select name="remarketing_facebook_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code']  ==  $remarketing_facebook_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['code']; ?><?php echo $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?><?php echo $currency['title']; ?></option>
				<?php } ?> 
				<?php } ?>
			</select>
		 </div>
		 </div>		  
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_identifier; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_facebook_identifier" value="<?php echo $remarketing_facebook_identifier; ?>" class="form-control" />
                </div>
		  </div>
		   <div class="form-group">
           <label class="col-sm-2 control-label"><?php echo $entry_facebook_ratio; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_facebook_ratio" value="<?php echo $remarketing_facebook_ratio; ?>" class="form-control" />
               </div>
		   </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_facebook_id" class="form-control">
                <?php if ($remarketing_facebook_id  ==  'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_facebook_id  ==  'model' ) { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?> 
              </select>
            </div>
          </div>
		   <legend><?php echo $text_facebook_pixel; ?></legend>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_script_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_facebook_script_status" <?php if ($remarketing_facebook_script_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_pixel_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_facebook_pixel_status" <?php if ($remarketing_facebook_pixel_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_lead; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_facebook_lead" <?php if ($remarketing_facebook_lead) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		   <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_depth; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_facebook_depth" <?php if ($remarketing_facebook_depth) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_depth_params; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_facebook_depth_params" value="<?php echo $remarketing_facebook_depth_params; ?>" class="form-control" />
                </div>
			</div>
			<legend><?php echo $text_facebook_api; ?></legend>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_server_side; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_facebook_server_side" <?php if ($remarketing_facebook_server_side) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_token; ?></label>
            <div class="col-sm-10">
               <input type="text" name="remarketing_facebook_token" value="<?php echo $remarketing_facebook_token; ?>" class="form-control" />
            </div>
		  </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_api_ver; ?></label>
            <div class="col-sm-10">
               <input type="text" name="remarketing_facebook_api_ver" value="<?php echo $remarketing_facebook_api_ver; ?>" class="form-control" />
            </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_facebook_test_code; ?></label>
            <div class="col-sm-10">
               <input type="text" name="remarketing_facebook_test_code" value="<?php echo $remarketing_facebook_test_code; ?>" class="form-control" />
			   	<br><a class="btn btn-primary test-facebook"><?php echo $button_test_facebook; ?></a>
				<div class="facebook_result"></div>
				<script>
				$('.test-facebook').on('click', function(){
					$.ajax({ 
						type: 'post',
						url:  '<?php echo $test_facebook; ?>',
						data: {},
						dataType: 'json',
						success: function(json) { 
							if (typeof json.events_received !== "undefined" && json.events_received == 1) {
								$('.facebook_result').html('<br><div style="background: green;width: auto;display: inline-block;color: #fff;padding: 10px;font-weight: bold;">TEST OK!</div>');
							} else if (json.error !== "undefined") {
								$('.facebook_result').html('<br><div style="background: red;width: auto;display: inline-block;color: #fff;padding: 10px;font-weight: bold;">TEST FAILED! ' + json.error.message + '</div>');
							}
							console.log(json);
						}
					});
				})
				</script>
            </div>
		  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_facebook_send_status; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;"> 
				<?php foreach ($order_statuses as $order_status) { ?>
                    <div class="checkbox">
                      <label> <?php if (in_array($order_status['order_status_id'], $remarketing_facebook_send_status)) { ?>
                        <input type="checkbox" name="remarketing_facebook_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                        <?php echo $order_status['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="remarketing_facebook_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                        <?php echo $order_status['name']; ?>
                        <?php } ?> </label>
                    </div>
                    <?php } ?> </div>
                 </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_facebook_lead_send_status; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;"> 
				<?php foreach ($order_statuses as $order_status) { ?>
                    <div class="checkbox">
                      <label> <?php if (in_array($order_status['order_status_id'], $remarketing_facebook_lead_send_status)) { ?>
                        <input type="checkbox" name="remarketing_facebook_lead_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                        <?php echo $order_status['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="remarketing_facebook_lead_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                        <?php echo $order_status['name']; ?>
                        <?php } ?> </label>
                    </div>
                    <?php } ?> </div>
                 </div>
              </div>
			  <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_resend_status; ?></label>
                  <div class="col-sm-10">
                    <select name="remarketing_facebook_resend_status" class="form-control">
					  <option value="0"><?php echo $text_not_selected; ?></option>
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == remarketing_facebook_resend_status) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
			<div class="form-group form-facebook-transaction">
            <label class="col-sm-2 control-label"><?php echo $entry_manual_send; ?></label>
               <div class="col-sm-10">
               <label class="col-sm-2 control-label">Total</label>
               <div class="col-sm-10"><input type="text" name="manual_facebook_total" value="" class="form-control" /></div>
			   <label class="col-sm-2 control-label">Products</label><div class="select-product col-sm-10"><input type="text" name="manual_facebook_product" value="" placeholder="Select product" class="form-control" /></div>
			   <label class="col-sm-2 control-label"> </label><div class="facebook-products col-sm-10">
			   <div class="col-sm-12 manual-product"><span class="form-control">ID</span><span class="form-control">Name</span><span class="form-control">Price</span><span class="form-control">Quantity</span></div><br>
			   </div>
			   <br><br><a class="btn btn-primary send-facebook-transaction"><i class="fa fa-plus"></i> Send Transaction</a>
				<div class="send-facebook-result"></div>
			   </div>
            </div> 
<script>
	manual_facebook_product_id = 0;
	$('input[name=\'manual_facebook_product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						name: item['name'],
						label: item['name'],
						product_id: item['product_id'],
						value: item['product_id'],
						price: item['price']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'manual_facebook_product\']').val('');

		$('.facebook-products').append('<div class="col-sm-12 manual-facebook-product'+manual_facebook_product_id+'"><input type="text" name="manual_facebook_products[' + manual_facebook_product_id + '][product_id]" value="' + item['product_id'] + '" class="form-control col-sm-3" /><input type="text" name="manual_facebook_products[' + manual_facebook_product_id + '][name]" value="' + item['name'] + '" class="form-control col-sm-3" /><input type="text" name="manual_facebook_products[' + manual_facebook_product_id + '][price]" value="' + item['price'] + '" class="form-control col-sm-3" /><input type="text" name="manual_facebook_products[' + manual_facebook_product_id + '][quantity]" value="1" class="form-control col-sm-3" /> <i class="fa fa-trash-o" onclick="$(\'.manual-facebook-product' + manual_facebook_product_id + '\').remove();"></i></div>');
		manual_facebook_product_id++;
	}
});
	
	$('.send-facebook-transaction').on('click', function(){
	send_data = $('.form-facebook-transaction input[type=\'text\']');
	$.ajax({
		url: '/index.php?route=common/remarketing/sendFacebookManual',
		type: 'post',
		data: send_data,
		dataType: 'json',
		beforeSend: function() {
		},
		complete: function() {
		},
		success: function(json) {
			if (json['error']) {
				$('.send-facebook-result').html(json['error']);
			}
			if (json['success']) {
				$('.send-facebook-result').html(json['success']);
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
        }
	});
});
</script>
<style>
.facebook-products .form-control {
	width: 200px; display:inline-block;
}
</style>
		  </div>
		   <div class="tab-pane" id="tab-tiktok">
          <legend><?php echo $text_tiktok; ?></legend>
	   	  <div class="help-link"><a href="https://ads.tiktok.com/help/article?aid=10028" target="_blank"><?php echo $text_help_link; ?> TikTok</a></div>
	   	  <div class="help-link"><a href="https://ads.tiktok.com/marketing_api/docs?rid=959icq5stjr" target="_blank"><?php echo $text_help_link; ?> TikTok Marketing API</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_tiktok_status" <?php if ($remarketing_tiktok_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
		  <label class="col-sm-2 control-label"><?php echo $entry_currency; ?> - Tiktok</label>
		  <div class="col-sm-10">
			<select name="remarketing_tiktok_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code']  == $remarketing_tiktok_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['code']; ?><?php echo $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?><?php echo $currency['title']; ?></option>
				<?php } ?> 
				<?php } ?>
			</select>
		 </div>
		 </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_tiktok_identifier; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_tiktok_identifier" value="<?php echo $remarketing_tiktok_identifier; ?>" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_tiktok_ratio; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_tiktok_ratio" value="<?php echo $remarketing_tiktok_ratio; ?>" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_tiktok_id" class="form-control">
                <?php if ($remarketing_tiktok_id  ==  'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_tiktok_id  ==  'model' ) { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?> 
              </select>
            </div>
          </div> 
		  <legend><?php echo $text_tiktok_pixel; ?></legend>	
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_tiktok_script_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_tiktok_script_status" <?php if ($remarketing_tiktok_script_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_tiktok_pixel_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_tiktok_pixel_status" <?php if ($remarketing_tiktok_pixel_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <legend><?php echo $text_tiktok_api; ?></legend>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_tiktok_server_side; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_tiktok_server_side" <?php if ($remarketing_tiktok_server_side) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_tiktok_token; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_tiktok_token" value="<?php echo $remarketing_tiktok_token; ?>" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_tiktok_api_ver; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_tiktok_api_ver" value="<?php echo $remarketing_tiktok_api_ver; ?>" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_tiktok_test_code; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_tiktok_test_code" value="<?php echo $remarketing_tiktok_test_code; ?>" class="form-control" />
               </div>
		  </div> 
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $entry_tiktok_send_status; ?></label>
              <div class="col-sm-10">
                <div class="well well-sm" style="height: 150px; overflow: auto;"> 
				  <?php foreach ($order_statuses as $order_status) { ?>
                  <div class="checkbox">
                    <label> <?php if (in_array($order_status['order_status_id'], $remarketing_tiktok_send_status)) { ?>
                      <input type="checkbox" name="remarketing_tiktok_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                      <?php echo $order_status['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="remarketing_tiktok_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                      <?php echo $order_status['name']; ?>
                      <?php } ?> </label>
                  </div>
                  <?php } ?> </div>
               </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $entry_resend_status; ?></label>
              <div class="col-sm-10">
                <select name="remarketing_tiktok_resend_status" class="form-control">
				<option value="0"><?php echo $text_not_selected; ?></option>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == remarketing_tiktok_resend_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
		  </div>
		   <div class="tab-pane" id="tab-snapchat">
          <legend><?php echo $text_snapchat; ?></legend>
	   	  <div class="help-link"><a href="https://businesshelp.snapchat.com/s/topic/0TO0y000000YVdJGAW/snap-pixel?language=en_US" target="_blank"><?php echo $text_help_link; ?> Snapchat</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_snapchat_status" <?php if ($remarketing_snapchat_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
		  <label class="col-sm-2 control-label"><?php echo $entry_currency; ?></label>
				<div class="col-sm-10">
			<select name="remarketing_snapchat_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code']  ==  $remarketing_snapchat_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['code']; ?><?php echo $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?><?php echo $currency['title']; ?></option>
				<?php } ?> 
				<?php } ?>
			</select>
		 </div>
		 </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_snapchat_identifier; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_snapchat_identifier" value="<?php echo $remarketing_snapchat_identifier; ?>" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_snapchat_ratio; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_snapchat_ratio" value="<?php echo $remarketing_snapchat_ratio; ?>" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_snapchat_id" class="form-control">
                <?php if ($remarketing_snapchat_id  ==  'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_snapchat_id  ==  'model' ) { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?> 
              </select>
            </div>
          </div> 
		  <legend><?php echo $text_snapchat_pixel; ?></legend>	
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_snapchat_script_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_snapchat_script_status" <?php if ($remarketing_snapchat_script_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_snapchat_pixel_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_snapchat_pixel_status" <?php if ($remarketing_snapchat_pixel_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  </div>
		  <div class="tab-pane" id="tab-uet">
          <legend><?php echo $text_uet; ?></legend>
	   	  <div class="help-link"><a href="https://help.ads.microsoft.com/#apex/ads/en/60118/-1" target="_blank"><?php echo $text_help_link; ?> Microsoft</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_uet_status" <?php if ($remarketing_uet_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
          </div>
          <div class="tab-pane" id="tab-telegram">
          <legend><?php echo $text_telegram; ?></legend>
	   	  <div class="help-link"></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_telegram_status" <?php if ($remarketing_telegram_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_telegram_bot_id; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_telegram_bot_id" value="<?php echo $remarketing_telegram_bot_id; ?>" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_telegram_send_to_id; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_telegram_send_to_id" value="<?php echo $remarketing_telegram_send_to_id; ?>" class="form-control" />
               </div>
		  </div>
			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_telegram_send_status; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;"> 
				<?php foreach ($order_statuses as $order_status) { ?>
                    <div class="checkbox">
                      <label> <?php if (in_array($order_status['order_status_id'], $remarketing_telegram_send_status)) { ?>
                        <input type="checkbox" name="remarketing_telegram_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                        <?php echo $order_status['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="remarketing_telegram_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                        <?php echo $order_status['name']; ?>
                        <?php } ?> </label>
                    </div>
                    <?php } ?> </div>
                 </div>
              </div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_telegram_message; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_telegram_message" rows="5" class="form-control"><?php echo $remarketing_telegram_message; ?></textarea>
               </div>
		  </div>
		  </div>
		  <div class="tab-pane" id="tab-google-reviews">
          <legend><?php echo $text_google_reviews; ?></legend>
		  <div class="help-link"><a href="https://support.google.com/merchants/answer/7106244" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_reviews_status" <?php if ($remarketing_reviews_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_google_merchant_identifier; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_google_merchant_identifier" value="<?php echo $remarketing_google_merchant_identifier; ?>" class="form-control" />
                  </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_reviews_country; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_country" value="<?php echo $remarketing_reviews_country; ?>" class="form-control" />
                  </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_reviews_date; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_date" value="<?php echo $remarketing_reviews_date; ?>" class="form-control" />
                  </div>
			</div>
		  <div class="form-group"> 
            <label class="col-sm-2 control-label"><?php echo $entry_feed_gtin; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_feed_gtin" value="<?php echo $remarketing_reviews_feed_gtin; ?>" class="form-control" />
                  </div>
			</div>
		  <div class="form-group"> 
            <label class="col-sm-2 control-label"><?php echo $entry_feed_mpn; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_feed_mpn" value="<?php echo $remarketing_reviews_feed_mpn; ?>" class="form-control" />
                  </div>
			</div>
		  <div class="form-group"> 
            <label class="col-sm-2 control-label"><?php echo $entry_feed_sku; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_feed_sku" value="<?php echo $remarketing_reviews_feed_sku; ?>" class="form-control" />
                  </div>
			</div>
		  <div class="form-group"> 
            <label class="col-sm-2 control-label"><?php echo $entry_feed_asin; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_feed_asin" value="<?php echo $remarketing_reviews_feed_asin; ?>" class="form-control" />
                  </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_reviews_quick_order_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_reviews_quick_order_status" <?php if ($remarketing_reviews_quick_order_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_feed_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_reviews_feed_status" <?php if ($remarketing_reviews_feed_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
			  <br> 
			  <a href="/index.php?route=extension/feed/remarketing_feed/googleReviews" target="_blank"><?php echo $entry_feed_link; ?></a>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_feed_anonymous; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_reviews_feed_anonymous" <?php if ($remarketing_reviews_feed_anonymous) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  </div>
		  <div class="tab-pane" id="tab-events">
          <legend><?php echo $text_events; ?></legend>
			<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_events_cart; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_cart" rows="5" class="form-control"><?php echo $remarketing_events_cart; ?></textarea>
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_events_cart_add; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_cart_add" rows="5" class="form-control"><?php echo $remarketing_events_cart_add; ?></textarea>
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_events_purchase; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_purchase" rows="5" class="form-control"><?php echo $remarketing_events_purchase; ?></textarea>
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_events_quick_purchase; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_quick_purchase" rows="5" class="form-control"><?php echo $remarketing_events_quick_purchase; ?></textarea>
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_events_wishlist; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_wishlist" rows="5" class="form-control"><?php echo $remarketing_events_wishlist; ?></textarea>
               </div>
			</div>
		  </div>
		  <div class="tab-pane" id="tab-esputnik">
		  <legend><?php echo $text_esputnik; ?></legend>
		  <div class="help-link"><a href="https://esputnik.com/support/peredacha-dannyh-resursom-v1event" target="_blank"><?php echo $text_help_link; ?> eSputnik</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_esputnik_status" <?php if ($remarketing_esputnik_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <legend>WEB Tracking</legend>	
		  <div class="help-link"><a href="https://esputnik.com/support/poluchenie-i-ustanovka-skripta-veb-trekinga" target="_blank"><?php echo $text_help_link; ?> eSputnik</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_esputnik_webtracking_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_esputnik_webtracking_status" <?php if ($remarketing_esputnik_webtracking_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  	<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_esputnik_webtracking_identifier; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_esputnik_webtracking_identifier" value="<?php echo $remarketing_esputnik_webtracking_identifier; ?>" class="form-control" />
               </div>
			</div> 
		  <legend>API Tracking</legend>	
		  <div class="help-link"><a href="https://esputnik.com/support/peredacha-dannyh-resursom-v1event" target="_blank"><?php echo $text_help_link; ?> eSputnik</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_esputnik_api_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_esputnik_api_status" <?php if ($remarketing_esputnik_api_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_esputnik_login; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_esputnik_login" value="<?php echo $remarketing_esputnik_login; ?>" class="form-control" />
               </div>
			</div> 
		  <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo $entry_esputnik_password; ?></label>
             <div class="col-sm-10">
                <input type="text" name="remarketing_esputnik_password" value="<?php echo $remarketing_esputnik_password; ?>" class="form-control" />
             </div>
		  </div>
		  <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo $entry_esputnik_address_format; ?></label>
             <div class="col-sm-10">
                <input type="text" name="remarketing_esputnik_address_format" value="<?php echo $remarketing_esputnik_address_format; ?>" class="form-control" />
             </div>
		  </div>
		  <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo $entry_esputnik_ttn_field; ?></label>
             <div class="col-sm-10">
                <input type="text" name="remarketing_esputnik_ttn_field" value="<?php echo $remarketing_esputnik_ttn_field; ?>" class="form-control" />
             </div>
		  </div>
			 <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_esputnik_initialized_status; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;"> 
				<?php foreach ($order_statuses as $order_status) { ?>
                    <div class="checkbox">
                      <label> <?php if (in_array($order_status['order_status_id'], $remarketing_esputnik_initialized_status)) { ?>
                        <input type="checkbox" name="remarketing_esputnik_initialized_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                        <?php echo $order_status['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="remarketing_esputnik_initialized_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                        <?php echo $order_status['name']; ?>
                        <?php } ?> </label>
                    </div>
                    <?php } ?> </div>
                 </div>
             </div>
			 <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_esputnik_inprogress_status; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;"> 
				<?php foreach ($order_statuses as $order_status) { ?>
                    <div class="checkbox">
                      <label> <?php if (in_array($order_status['order_status_id'], $remarketing_esputnik_inprogress_status)) { ?>
                        <input type="checkbox" name="remarketing_esputnik_inprogress_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                        <?php echo $order_status['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="remarketing_esputnik_inprogress_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                        <?php echo $order_status['name']; ?>
                        <?php } ?> </label>
                    </div>
                    <?php } ?> </div>
                 </div>
             </div>
			 <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_esputnik_delivered_status; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;"> 
				<?php foreach ($order_statuses as $order_status) { ?>
                    <div class="checkbox">
                      <label> <?php if (in_array($order_status['order_status_id'], $remarketing_esputnik_delivered_status)) { ?>
                        <input type="checkbox" name="remarketing_esputnik_delivered_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                        <?php echo $order_status['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="remarketing_esputnik_delivered_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                        <?php echo $order_status['name']; ?>
                        <?php } ?> </label>
                    </div>
                    <?php } ?> </div>
                 </div>
             </div>
			 <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_esputnik_cancelled_status; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;"> 
				<?php foreach ($order_statuses as $order_status) { ?>
                    <div class="checkbox">
                      <label> <?php if (in_array($order_status['order_status_id'], $remarketing_esputnik_cancelled_status)) { ?>
                        <input type="checkbox" name="remarketing_esputnik_cancelled_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                        <?php echo $order_status['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="remarketing_esputnik_cancelled_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                        <?php echo $order_status['name']; ?>
                        <?php } ?> </label>
                    </div>
                    <?php } ?> </div>
                 </div>
             </div>
		  </div>
		   <div class="tab-pane" id="tab-ecommerce-ga4">
		   <legend><?php echo $text_ecommerce_ga4; ?> - (gtag.js)</legend>
			<div class="help-link"><a href="https://developers.google.com/analytics/devguides/collection/ga4/ecommerce" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
			<div class="help-link"><a href="https://opencartforum.com/files/tutorials/670-nastroyka-google-analytics-4-cherez-modul/" target="_blank"><?php echo $text_help_link; ?> Opencartforum</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_ecommerce_ga4_status" <?php if ($remarketing_ecommerce_ga4_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
		  <label class="col-sm-2 control-label"><?php echo $entry_currency; ?> - GA4</label>
		  <div class="col-sm-10">
			<select name="remarketing_ecommerce_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code']  ==  $remarketing_ecommerce_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['code']; ?><?php echo $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?><?php echo $currency['title']; ?></option>
				<?php } ?> 
				<?php } ?>
			</select>
		 </div>
		 </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_identifier; ?></label>
               <div class="col-sm-10">
              <select name="remarketing_ecommerce_ga4_id" class="form-control">
                <?php if ($remarketing_ecommerce_ga4_id  ==  'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_ecommerce_ga4_id  ==  'model' ) { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?> 
              </select>
            </div>
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_ecommerce_ga4_identifier; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_ecommerce_ga4_identifier" value="<?php echo $remarketing_ecommerce_ga4_identifier; ?>" class="form-control" />
                  </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_ecommerce_ga4_selector; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_ecommerce_ga4_selector" value="<?php echo $remarketing_ecommerce_ga4_selector; ?>" class="form-control" />
                  </div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label"><?php echo $entry_ecommerce_ratio; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_ecommerce_ratio" value="<?php echo $remarketing_ecommerce_ratio; ?>" class="form-control" />
               </div>
			</div>
			<legend><?php echo $text_ecommerce_ga4; ?> (dataLayer)</legend>
			<div class="help-link"><a href="https://developers.google.com/tag-manager/ecommerce-ga4?hl=ru" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
			<div class="help-link"><a href="https://opencartforum.com/files/tutorials/670-nastroyka-google-analytics-4-cherez-modul/" target="_blank"><?php echo $text_help_link; ?> Opencartforum</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_ecommerce_status" <?php if ($remarketing_ecommerce_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
           <legend><?php echo $text_ecommerce_ga4_measurement; ?></legend>
		   <div class="help-link"><a href="https://developers.google.com/analytics/devguides/collection/protocol/ga4?hl=ru" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		   <div class="help-link"><a href="https://opencartforum.com/files/tutorials/670-nastroyka-google-analytics-4-cherez-modul/" target="_blank"><?php echo $text_help_link; ?> Opencartforum</a></div>
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_ga4_only_purchase; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_ga4_only_purchase" <?php if ($remarketing_ga4_only_purchase) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_ecommerce_ga4_measurement_status" <?php if ($remarketing_ecommerce_ga4_measurement_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_identifier; ?></label>
               <div class="col-sm-10">
              <select name="remarketing_ecommerce_ga4_measurement_id" class="form-control">
                <?php if ($remarketing_ecommerce_ga4_measurement_id  ==  'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_ecommerce_ga4_measurement_id  ==  'model' ) { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?> 
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_ecommerce_ga4_api_secret; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_measurement_api_secret" value="<?php echo $remarketing_ecommerce_ga4_measurement_api_secret; ?>" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_ecommerce_ga4_analytics_id; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_analytics_id" value="<?php echo $remarketing_ecommerce_ga4_analytics_id; ?>" class="form-control" />
               </div>
			</div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_remarketing_ecommerce_ga4_send_status; ?></label>
                  <div class="col-sm-10">
                    <div class="well well-sm" style="height: 150px; overflow: auto;"> 
					<?php foreach ($order_statuses as $order_status) { ?>
                      <div class="checkbox">
                        <label> <?php if (in_array($order_status['order_status_id'], $remarketing_ecommerce_ga4_send_status)) { ?>
                          <input type="checkbox" name="remarketing_ecommerce_ga4_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                          <?php echo $order_status['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="remarketing_ecommerce_ga4_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                          <?php echo $order_status['name']; ?>
                          <?php } ?> </label>
                      </div>
                      <?php } ?> </div>
                   </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_remarketing_ecommerce_ga4_refund_status; ?></label>
                  <div class="col-sm-10">
                    <div class="well well-sm" style="height: 150px; overflow: auto;"> 
					<?php foreach ($order_statuses as $order_status) { ?>
                      <div class="checkbox">
                        <label> <?php if (in_array($order_status['order_status_id'], $remarketing_ecommerce_ga4_refund_status)) { ?>
                          <input type="checkbox" name="remarketing_ecommerce_ga4_refund_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                          <?php echo $order_status['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="remarketing_ecommerce_ga4_refund_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                          <?php echo $order_status['name']; ?>
                          <?php } ?> </label>
                      </div>
                      <?php } ?> </div>
                   </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_resend_status; ?></label> 
                  <div class="col-sm-10">
                    <select name="remarketing_ecommerce_ga4_resend_status" class="form-control">
					<option value="0"><?php echo $text_not_selected; ?></option>
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $remarketing_ecommerce_ga4_resend_status) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>

		   </div>
		   <div class="tab-pane" id="tab-counters">
		   <legend><?php echo $text_counters; ?></legend>
		   <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_counter1; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_counter1" rows="10" class="form-control"><?php echo $remarketing_counter1; ?></textarea>
               </div>
		   </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_counter_bot; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_counter_bot" rows="10" class="form-control"><?php echo $remarketing_counter_bot; ?></textarea>
               </div>
		   </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_counter2; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_counter2" rows="10" class="form-control"><?php echo $remarketing_counter2; ?></textarea>
               </div>
		   </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_counter3; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_counter3" rows="10" class="form-control"><?php echo $remarketing_counter3; ?></textarea>
               </div>
		   </div>
		  </div>
		   <div class="tab-pane" id="tab-feed">
		   <legend><?php echo $text_feed; ?></legend>
		   <div class="help-link"><a href="https://support.google.com/merchants/answer/7052112?hl=ru" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		   <div class="help-link"><a href="https://www.facebook.com/business/help/125074381480892?id=725943027795860" target="_blank"><?php echo $text_help_link; ?> Facebook (Meta)</a></div>
		   <div class="help-link"><a href="https://ads.tiktok.com/help/article?aid=10001006" target="_blank"><?php echo $text_help_link; ?> Tiktok</a></div>
		   <div class="help-link"><a href="https://opencartforum.com/files/tutorials/683-nastroyka-fida-dlya-google-merchant-facebook-tiktok-cherez-modul/" target="_blank"><?php echo $text_help_link; ?> Opencartforum</a></div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_status" <?php if ($remarketing_feed_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_currency; ?></label>
			  <div class="col-sm-10">
                 <select name="remarketing_feed_currency" class="form-control">
                    <?php foreach ($currencies as $currency) { ?>
                        <?php if ($currency['code'] == remarketing_feed_currency) { ?>
							<option value="<?php echo $currency['code']; ?>" selected="selected">(<?php echo $currency['code']; ?>) <?php echo $currency['title']; ?></option>
                        <?php } else { ?>
							<option value="<?php echo $currency['code']; ?>">(<?php echo $currency['code']; ?>) <?php echo $currency['title']; ?></option>
                        <?php } ?>
                    <?php } ?>
                 </select>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_currency_base; ?></label>
			  <div class="col-sm-10">
                 <select name="remarketing_feed_currency_base" class="form-control">
                    <?php foreach ($currencies as $currency) { ?>
                        <?php if ($currency['code'] == remarketing_feed_currency_base) { ?>
							<option value="<?php echo $currency['code']; ?>" selected="selected">(<?php echo $currency['code']; ?>) <?php echo $currency['title']; ?></option>
                        <?php } else { ?>
							<option value="<?php echo $currency['code']; ?>">(<?php echo $currency['code']; ?>) <?php echo $currency['title']; ?></option>
                        <?php } ?>
                    <?php } ?>
                 </select>
			</div>
		  </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_identifier" class="form-control">
                <?php if ($remarketing_feed_identifier  ==  'product_id') { ?>
                <option value="product_id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_feed_identifier  ==  'model') { ?>
                <option value="product_id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                 <?php } else { ?>
				<option value="product_id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?> 
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_key; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_key" value="<?php echo $remarketing_feed_key; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_links; ?></label>
               <div class="col-sm-10">
               		<b><?php echo $text_feed_merchant; ?></b> <a href="<?php echo $link_merchant; ?><?php if ($remarketing_feed_key) { ?>&key=<?php echo $remarketing_feed_key; ?><?php } ?>" target="_blank"><b><?php echo $link_merchant; ?><?php if ($remarketing_feed_key) { ?>&key=<?php echo $remarketing_feed_key; ?><?php } ?></b></a><br>
					<b><?php echo $text_feed_facebook; ?></b> <a href="<?php echo $link_facebook; ?><?php if ($remarketing_feed_key) { ?>&key=<?php echo $remarketing_feed_key; ?><?php } ?>" target="_blank"><b><?php echo $link_facebook; ?><?php if ($remarketing_feed_key) { ?>&key=<?php echo $remarketing_feed_key; ?><?php } ?></b></a><br>
					<b><?php echo $text_feed_tiktok; ?></b> <a href="<?php echo $link_tiktok; ?><?php if ($remarketing_feed_key) { ?>&key=<?php echo $remarketing_feed_key; ?><?php } ?>" target="_blank"><b><?php echo $link_tiktok; ?><?php if ($remarketing_feed_key) { ?>&key=<?php echo $remarketing_feed_key; ?><?php } ?></b></a><br>
					<br> 

					<b><?php echo $text_feed_help; ?></b>
               </div>
			</div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_adult; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_adult" <?php if ($remarketing_feed_adult) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_condition; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_condition" value="<?php echo $remarketing_feed_condition; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_gtin; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_gtin" value="<?php echo $remarketing_feed_gtin; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_mpn; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_mpn" value="<?php echo $remarketing_feed_mpn; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_highlight; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_highlight" value="<?php echo $remarketing_feed_highlight; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_replace_description; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_replace_description" value="<?php echo $remarketing_feed_replace_description; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_color; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_color" value="<?php echo $remarketing_feed_color; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_size; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_size" value="<?php echo $remarketing_feed_size; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_material; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_material" value="<?php echo $remarketing_feed_material; ?>" class="form-control" />
                </div> 
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_gender; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_gender" value="<?php echo $remarketing_feed_gender; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_age_group; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_age_group" value="<?php echo $remarketing_feed_age_group; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_store_code; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_store_code" value="<?php echo $remarketing_feed_store_code; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_all_attributes; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_all_attributes" <?php if ($remarketing_feed_all_attributes) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_tuning; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_tuning" <?php if ($remarketing_feed_tuning) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div>

			<div class="form-group <?php if (!$remarketing_feed_tuning) { ?>hidden<?php } ?>">
             <label class="col-sm-2 control-label"><?php echo $entry_category; ?>
			 <br>
			 <a href="http://www.google.com/basepages/producttype/taxonomy-with-ids.ru-RU.xls" target="_blank"><?php echo $text_category_google; ?></a><br><br>
			 <a href="https://support.google.com/merchants/answer/6324436?hl=ru" target="_blank">google_product_category HELP</a><br>
			 <a href="https://support.google.com/merchants/answer/6324406?hl=ru" target="_blank">product_type HELP</a><br>
			 <a href="https://support.google.com/merchants/answer/6324469?hl=ru" target="_blank">condition HELP</a><br>
			 <a href="https://support.google.com/google-ads/answer/6275295?hl=ru" target="_blank"> custom_label HELP</a>
			 </label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="max-height: 400px; overflow: auto;">
                    <table class="table table-striped">
                    <?php foreach ($categories as $category) { ?>
                    <tr class="feed-category">
                      <td class="checkbox">
                        <label>
						  <?php if (in_array($category['category_id'], $remarketing_feed_category)) { ?>
                          <input type="checkbox" name="remarketing_feed_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                          <b><?php echo $category['name']; ?></b>
                          <?php } else { ?>
                          <input type="checkbox" name="remarketing_feed_category[]" value="<?php echo $category['category_id']; ?>" />
                          <b><?php echo $category['name']; ?></b>
                          <?php } ?>
                        </label>
						<table class="table table-striped table-bordered">
							<tr>
								<td class="text-left gpc">google_product_category <input type="text" name="remarketing_feed_category_google_category[{{category['category_id']}}]" value="<?php echo $remarketing_feed_category_google_category[category['category_id']]; ?>" class="form-control"/></td>
								<td class="text-left gpt">product_type <input type="text" name="remarketing_feed_category_product_type[{{category['category_id']}}]" value="<?php echo $remarketing_feed_category_product_type[category['category_id']]; ?>" class="form-control"/></td>
								<td class="text-left">condition <input type="text" name="remarketing_feed_category_condition[{{category['category_id']}}]" value="<?php echo $remarketing_feed_category_condition[category['category_id']]; ?>" class="form-control"/></td>
								<td class="text-left">custom_label_0 <input type="text" name="remarketing_feed_category_custom_label_0[{{category['category_id']}}]" value="<?php echo $remarketing_feed_category_custom_label_0[category['category_id']]; ?>" class="form-control"/></td>
								<td class="text-left">custom_label_1 <input type="text" name="remarketing_feed_category_custom_label_1[{{category['category_id']}}]" value="<?php echo $remarketing_feed_category_custom_label_1[category['category_id']]; ?>" class="form-control"/></td>
								<td class="text-left">custom_label_2 <input type="text" name="remarketing_feed_category_custom_label_2[{{category['category_id']}}]" value="<?php echo $remarketing_feed_category_custom_label_2[category['category_id']]; ?>" class="form-control"/></td>
								<td class="text-left">custom_label_3 <input type="text" name="remarketing_feed_category_custom_label_3[{{category['category_id']}}]" value="<?php echo $remarketing_feed_category_custom_label_3[category['category_id']]; ?>" class="form-control"/></td>
								<td class="text-left">custom_label_4 <input type="text" name="remarketing_feed_category_custom_label_4[{{category['category_id']}}]" value="<?php echo $remarketing_feed_category_custom_label_4[category['category_id']]; ?>" class="form-control"/></td>
							</tr>
						</table>
                      </td>
                    </tr>
                    <?php } ?>
                    </table>
                  </div>
                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a><br><br>
				  <a onclick="copyToGpc();"><?php echo $text_copy_to_category; ?></a><br>
				  <a onclick="copyToGpt();"><?php echo $text_copy_to_product_type; ?></a><br><br>
				  <script>
				  function copyToGpc() {
					  $('.feed-category').each(function(){
						  $(this).find('.gpc input').val($(this).find('.checkbox b').text());
					  })
				  }
				  function copyToGpt() {
					  $('.feed-category').each(function(){
						  $(this).find('.gpt input').val($(this).find('.checkbox b').text());
					  })
				  }
				  </script>
          </div>
          </div>
		  <div class="form-group <?php if (!$remarketing_feed_tuning) { ?>hidden<?php } ?>">
             <label class="col-sm-2 control-label"><?php echo $entry_manufacturer; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="max-height: 400px; overflow: auto;">
                    <table class="table table-striped">
                    <?php foreach ($manufacturers as $manufacturer) { ?>
                    <tr>
                      <td class="checkbox">
                        <label>
						  <?php if (in_array($manufacturer['manufacturer_id'], $remarketing_feed_manufacturer)) { ?>
                          <input type="checkbox" name="remarketing_feed_manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                          <?php echo $manufacturer['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="remarketing_feed_manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                          <?php echo $manufacturer['name']; ?>
                          <?php } ?>
                        </label>
                      </td>
                    </tr>
                     <?php } ?>
                    </table>
                  </div>
                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
          </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_customer_group; ?></label>
                  <div class="col-sm-10">
                    <select name="remarketing_feed_customer_group" class="form-control">
                      <?php foreach ($customer_groups as $customer_group) { ?>
                      <?php if ($customer_group['customer_group_id'] == remarketing_feed_customer_group) { ?>
                      <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_custom_sql; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_custom_sql" value="<?php echo $remarketing_feed_custom_sql; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_special; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_special" <?php if ($remarketing_feed_special) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_min_price; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_min_price" value="<?php echo $remarketing_feed_min_price; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_max_price; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_max_price" value="<?php echo $remarketing_feed_max_price; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_zero_quantity; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_zero_quantity" <?php if ($remarketing_feed_zero_quantity) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_always_avail; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_always_avail" <?php if ($remarketing_feed_always_avail) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_in_stock; ?></label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;"> 
			    <?php foreach ($stock_statuses as $stock_status) { ?>
                <div class="checkbox">
                  <label> <?php if (in_array($stock_status['stock_status_id'], $remarketing_feed_in_stock)) { ?>
                    <input type="checkbox" name="remarketing_feed_in_stock[]" value="<?php echo $stock_status['stock_status_id']; ?>" checked="checked" />
                    <?php echo $stock_status['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="remarketing_feed_in_stock[]" value="<?php echo $stock_status['stock_status_id']; ?>" />
                    <?php echo $stock_status['name']; ?>
                    <?php } ?> </label>
                </div>
                <?php } ?> </div>
             </div>
          </div>
		  <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_out_of_stock; ?></label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;"> 
			    <?php foreach ($stock_statuses as $stock_status) { ?>
                <div class="checkbox">
                  <label> <?php if (in_array($stock_status['stock_status_id'], $remarketing_feed_out_of_stock)) { ?>
                    <input type="checkbox" name="remarketing_feed_out_of_stock[]" value="<?php echo $stock_status['stock_status_id']; ?>" checked="checked" />
                    <?php echo $stock_status['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="remarketing_feed_out_of_stock[]" value="<?php echo $stock_status['stock_status_id']; ?>" />
                    <?php echo $stock_status['name']; ?>
                    <?php } ?> </label>
                </div>
                <?php } ?> </div>
             </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_original_description; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_original_description" <?php if ($remarketing_feed_original_description) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group"> 
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_rich_text; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_rich_text" <?php if ($remarketing_feed_rich_text) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_ocstore_main; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_ocstore_main" <?php if ($remarketing_feed_ocstore_main) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_last_category; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_last_category" <?php if ($remarketing_feed_last_category) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_type_category; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_type_category" <?php if ($remarketing_feed_type_category) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_multiplier; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_multiplier" value="<?php echo $remarketing_feed_multiplier; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_original_image_status; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_original_image_status" <?php if ($remarketing_feed_original_image_status) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_additional_images; ?></label>
            <div class="col-sm-10">
			  <label class="switch">
					<input type="checkbox" name="remarketing_feed_additional_images" <?php if ($remarketing_feed_additional_images) { ?>checked<?php } ?> >
					<span class="slider round"></span>
				</label>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_utm; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_utm" value="<?php echo $remarketing_feed_utm; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_utm_facebook; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_utm_facebook" value="<?php echo $remarketing_feed_utm_facebook; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_utm_tiktok; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_utm_tiktok" value="<?php echo $remarketing_feed_utm_tiktok; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_empty_brand; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_empty_brand" value="<?php echo $remarketing_feed_empty_brand; ?>" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_description; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_feed_description" rows="5" class="form-control"><?php echo $remarketing_feed_description; ?></textarea>
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_short_desc; ?></label>
                <div class="col-sm-10">
					<input type="text" name="remarketing_feed_short_desc" value="<?php echo $remarketing_feed_short_desc; ?>" class="form-control" />
                </div>
		  </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_replace_from; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_feed_replace_from" rows="5" class="form-control"><?php echo $remarketing_feed_replace_from; ?></textarea>
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_replace_to; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_feed_replace_to" rows="5" class="form-control"><?php echo $remarketing_feed_replace_to; ?></textarea>
               </div>
		  </div>
	      </div>
		  <div class="tab-pane" id="tab-help">
		   <legend><?php echo $text_help; ?></legend>
		   <?php echo $text_credits; ?>
		  </div>
		  </div>
		  </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	$.ajax({ 
		type: 'post',
		url:  '<?php echo $check_version; ?>',
		data: {'version': '<?php echo $version; ?>'},
		dataType: 'text',
		success: function(response) { 
			if (response != '') {
				$('.version-update').html(response);
			}
		}
	});
})
</script>
<style>
.config-summary span {
	font-size:20px;
	color:#0043ff;
	font-weight:bold;
}
.version {
    color: green;
	font-weight:bold;
}
.summary-heading {
	font-size:20px;
	color:green;
	margin-bottom: 15px;
}
.enabled, .enabled:hover {
	background: #c7ffc7 !important;
    font-weight: bold;
}
.version-update {
	background: #c7ffc7 !important;
    font-weight: bold;
	margin-left:15px;
}
.diag, .diag:hover{
    background: #00b9ff !important;
    color: #fff !important;
}
legend {
	font-size:30px;
	margin-top:15px;
}
.help-link{
	font-size: 22px;
}
.help-link a{
	color: red;
}
.nav li a {
font-weight: bold;
}
.nav-pills > li.active > a.enabled, .nav-pills > li.active > a.enabled:hover, .nav-pills > li.active > a.enabled:focus {
color: red;
}
</style>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.form-group select.form-control {
text-align:left;
max-width:300px;
}
.selectric-wrapper{
text-align:left;
max-width:300px;
}
</style>
<?php echo $footer; ?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div id="modal-info" class="modal <?php if ($OC_V2) echo ' fade'; ?>" tabindex="-1" role="dialog" aria-hidden="true"></div>
  
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>

  <div class="<?php if($OC_V2) echo 'container-fluid'; ?>">
    <?php if (isset($success) && $success) { ?><div class="alert alert-success success"><i class="fa fa-check-circle"></i> <?php echo $success; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><script type="text/javascript">setTimeout("jQuery('.alert-success').slideUp();",5000);</script><?php } ?>
    <?php if (isset($info) && $info) { ?><div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $info; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
    <?php if (isset($error) && $error) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
    <?php if (isset($error_warning) && $error_warning) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
  
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="pull-right">
            <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
          </div>
          <h3 class="panel-title"><?php echo $heading_title; ?></h3>
        </div>
        <div class="content panel-body">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-0" data-toggle="tab"><i class="fa fa-sitemap"></i><?php echo $_language->get('text_tab_0'); ?></a></li>
            <!--<li><a href="#tab-1" data-toggle="tab"><i class="fa fa-sitemap"></i><?php echo $_language->get('text_tab_1'); ?></a></li>-->
            <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-cog"></i><?php echo $_language->get('text_tab_2'); ?></a></li>
            <?php if (!$seo_package_active) { ?>
            <li><a href="#tab-about" data-toggle="tab"><i class="fa fa-info"></i><?php echo $_language->get('text_tab_about'); ?></a></li>
            <?php } ?>
          </ul>
          
          
            <?php /*<input type="hidden" name="advanced_sitemap_fullcode" value="<?php echo $fullcode; ?>"/>*/ ?>
            <input type="hidden" name="advanced_sitemap_status" value="1"/>
            <div class="tab-content">
              <div class="tab-pane active clearfix" id="tab-0">
                <ul id="advanced_sitemap_feeds" class="nav nav-pills nav-stacked col-md-2">
                  <?php foreach ($stores as $store) { ?>
                  <li <?php if(!$store['store_id']) echo 'class="active"'; ?> id="feed-<?php echo $store['store_id']; ?>"><a href="#tab-feed-<?php echo $store['store_id']; ?>" data-toggle="pill"><?php echo $store['name']; ?></a></li>
                  <?php } ?>
                </ul>
                <div class="tab-content col-md-10">
                <?php foreach ($stores as $store) { ?>
                <div class="tab-pane <?php if(!$store['store_id']) echo ' active'; ?>" id="tab-feed-<?php echo $store['store_id']; ?>">
                  <table class="form">
                    <tr>
                      <td><?php echo $_language->get('entry_data_feed'); ?></td>
                      <td><i class="fa fa-sitemap"></i> <a style="text-decoration:none;" href="<?php echo $store['url'].$main_feed; ?>" target="_blank"><?php echo $store['url'].$main_feed; ?></a></td>
                    </tr>
                    <?php if (!empty($advanced_sitemap_lang_feeds)) { ?>
                    <tr>
                      <td><?php echo $_language->get('entry_lang_feed'); ?></td>
                      <td>
                        <?php foreach($lang_feeds as $feed) { ?>
                        <img src="<?php echo $feed['image']; ?>" alt=""/> <a style="text-decoration:none;" href="<?php echo $store['url'].$feed['feed']; ?>" target="_blank"><?php echo $store['url'].$feed['feed']; ?></a><br/><br/>
                        <?php } ?>
                      </td>
                    </tr>
                    <?php } ?>
                    <!--tr>
                      <td><?php echo $_language->get('entry_data_image_feed'); ?></td>
                      <td><i class="fa fa-sitemap"></i> <a style="text-decoration:none;" href="<?php echo $store['url'].$main_feed; ?>" target="_blank"><?php echo $store['url'].$main_feed; ?></a></td>
                    </tr-->
                    <tr>
                      <td><?php echo $_language->get('entry_grid_feed'); ?></td>
                      <td>
                        <?php foreach($grid_feeds as $feed) { ?>
                        <i class="fa fa-th"></i> <a style="text-decoration:none;" href="<?php echo $store['url'].$feed; ?>" target="_blank"><?php echo $store['url'].$feed; ?></a><br/><br/>
                        <?php } ?>
                      </td>
                    </tr>
                  </table>
                </div>
                <?php $store['store_id']++; ?>
                <?php } ?>
              </div>
              </div>
              <div class="tab-pane" id="tab-1">
              </div>
              <div class="tab-pane" id="tab-2">
                <ul class="nav nav-pills nav-stacked col-md-2">
                  <li class="active"><a href="#tab-opt-1" data-toggle="pill"><?php echo $_language->get('tab_opt_1'); ?></a></li>
                  <li><a href="#tab-opt-2" data-toggle="pill"><?php echo $_language->get('tab_opt_2'); ?></a></li>
                </ul>
                <div class="tab-content col-md-10">
                <div class="tab-pane active" id="tab-opt-1">
                  <table class="table table-hover">
                    <thead>
                    <tr>
                      <th style="width:200px"><?php echo $_language->get('text_link_type'); ?></th>
                      <th><?php echo $_language->get('entry_status'); ?></th>
                      <!--<th><?php echo $_language->get('entry_multilang'); ?></th>-->
                      <th><?php echo $_language->get('entry_priority'); ?></th>
                      <th><?php echo $_language->get('entry_freq'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php $feed_types = array('product', 'category', 'manufacturer', 'information'/*, 'image'*/);
                      if ($journal_active) $feed_types[] = 'journal';
                      foreach ($feed_types as $type) { ?>
                      <tr>
                        <td><?php echo $_language->get('text_type_'.$type); ?></td>
                        <td><input class="switch" type="checkbox" name="advanced_sitemap_cfg[<?php echo $type; ?>][status]" id="advanced_sitemap_cfg_<?php echo $type; ?>_status" value="1" <?php if(!empty($advanced_sitemap_cfg[$type]['status'])) echo 'checked="checked"'; ?>/></td>
                        <!--<td></td>-->
                        <td>
                          <select class="form-control" name="advanced_sitemap_cfg[<?php echo $type; ?>][priority]">
                            <?php foreach (array('10', '9', '8', '7', '6', '5', '4', '3', '2', '1', '0') as $priority) { ?>
                            <option value="<?php echo $priority/10; ?>" <?php if($priority/10 == $advanced_sitemap_cfg[$type]['priority']) echo 'selected=""'; ?>><?php echo $priority; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                          <select class="form-control" name="advanced_sitemap_cfg[<?php echo $type; ?>][freq]">
                            <?php foreach (array('always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never') as $changefreq) { ?>
                            <option value="<?php echo $changefreq; ?>" <?php if($changefreq == $advanced_sitemap_cfg[$type]['freq']) echo 'selected=""'; ?>><?php echo $_language->get('text_freq_'.$changefreq); ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><?php echo $_language->get('custom_links_include'); ?></td>
                        <td colspan="3"><textarea type="text" class="form-control" name="advanced_sitemap_cfg[custom_links_include]" id="advanced_sitemap_cfg_custom_links_include" cols="30" rows="10"><?php if(!empty($advanced_sitemap_cfg['custom_links_include'])) echo $advanced_sitemap_cfg['custom_links_include']; ?></textarea></td>
                      </tr>
                      <tr>
                        <td><?php echo $_language->get('custom_links_exclude'); ?></td>
                        <td colspan="3"><textarea type="text" class="form-control" name="advanced_sitemap_cfg[custom_links_exclude]" id="advanced_sitemap_cfg_custom_links_exclude" cols="30" rows="10"><?php if(!empty($advanced_sitemap_cfg['custom_links_exclude'])) echo $advanced_sitemap_cfg['custom_links_exclude']; ?></textarea></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="tab-opt-2">
                  <table class="form">
                    <tr>
                      <td><?php echo $_language->get('entry_item_no'); ?></td>
                      <td><input type="text" class="form-control" name="advanced_sitemap_limit" value="<?php echo !empty($advanced_sitemap_limit) ? $advanced_sitemap_limit : ''; ?>"/></td>
                    </tr>
                    <tr>
                      <td><?php echo $_language->get('entry_friendly_url'); ?></td>
                      <td><input class="switch" type="checkbox" name="advanced_sitemap_rewrite" id="advanced_sitemap_rewrite" value="1" <?php if(!empty($advanced_sitemap_rewrite)) echo 'checked="checked"'; ?>/></td>
                    </tr>
                    <tr>
                      <td><?php echo $_language->get('entry_lang_feeds'); ?></td>
                      <td><input class="switch" type="checkbox" name="advanced_sitemap_lang_feeds" id="advanced_sitemap_lang_feeds" value="1" <?php if(!empty($advanced_sitemap_lang_feeds)) echo 'checked="checked"'; ?>/></td>
                    </tr>
                    <tr>
                      <td><?php echo $_language->get('entry_in_stock'); ?></td>
                      <td><input class="switch" type="checkbox" name="advanced_sitemap_cfg[in_stock]" id="advanced_sitemap_cfg_in_stock" value="1" <?php if(!empty($advanced_sitemap_cfg['in_stock'])) echo 'checked="checked"'; ?>/></td>
                    </tr>
                    <tr>
                      <td><?php echo $_language->get('entry_include_img'); ?></td>
                      <td><input class="switch" type="checkbox" name="advanced_sitemap_cfg[img]" id="advanced_sitemap_cfg_img" value="1" <?php if(!empty($advanced_sitemap_cfg['img'])) echo 'checked="checked"'; ?>/></td>
                    </tr>
                    <tr>
                      <td><?php echo $_language->get('entry_additional_img'); ?></td>
                      <td><input class="switch" type="checkbox" name="advanced_sitemap_cfg[additional_img]" id="advanced_sitemap_cfg_additional_img" value="1" <?php if(!empty($advanced_sitemap_cfg['additional_img'])) echo 'checked="checked"'; ?>/></td>
                    </tr>
                    <tr>
                      <td><?php echo $_language->get('entry_fullsize_img'); ?></td>
                      <td><input class="switch" type="checkbox" name="advanced_sitemap_cfg[fullsize_img]" id="advanced_sitemap_cfg_fullsize_img" value="1" <?php if(!empty($advanced_sitemap_cfg['fullsize_img'])) echo 'checked="checked"'; ?>/></td>
                    </tr>
                    <tr>
                      <td><?php echo $_language->get('entry_display_img'); ?></td>
                      <td><input class="switch" type="checkbox" name="advanced_sitemap_cfg[display_img]" id="advanced_sitemap_cfg_display_img" value="1" <?php if(!empty($advanced_sitemap_cfg['display_img'])) echo 'checked="checked"'; ?>/></td>
                    </tr>
                  </table>
                </div>
              </div>
              </div>
              <div class="tab-pane" id="tab-about">
                <table class="form about">
                  <tr>
                    <td colspan="2" style="text-align:center;padding:30px 0 50px"><?php echo $heading_title; ?></td>
                  </tr>
                  <tr>
                    <td>Version</td>
                    <td>1.0</td>
                  </tr>
                  <tr>
                    <td>Free support</td>
                    <td>I take care of maintaining my modules at top quality and affordable price.<br/>In case of bug, incompatibility, or if you want a new feature, just contact me on my mail.</td>
                  </tr>
                  <tr>
                    <td>Contact</td>
                    <td><a href="mailto:support@geekodev.com">support@geekodev.com</a></td>
                  </tr>
                  <tr>
                    <td>Links</td>
                    <td>
                      If you like this module, please consider to make a star rating <span style="position:relative;top:3px;width:80px;height:17px;display:inline-block;background:url(data:data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAARCAYAAADUryzEAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNy8wNy8xMrG4sToAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzbovLKMAAACr0lEQVQ4jX1US0+TURA98/Xri0KBYqG8BDYItBoIBhFBBdRNTTQx0Q0gujBiAkEXxoXxD6iJbRcaY1iQEDXqTgwQWkWDIBU3VqWQoEgECzUU+n5910VbHhacZHLvzD05c+fMzaVhgxYJIwIYi+8B8FJ5bzjob9ucB4DmLttGMGyoAGMsyc1G7bEvA91roz2NL7Y7TziHHSxFmWsorbuUFgn79BaTLnMn3LYEZqPukCKruFAUGEd54w1ekqK69x8CSkoqMnJv72noTmN+O9Q5KlE44GqxmHTS7Qho5MH+X8SJUuMhAIbM/CrS1tSnCYsmkOoUnO7SiP3dHV8Mw5AoKkRCfTwR96ei+ZZGVVDDJQhIWAVbfhjDe8eQnd/Aq8+/VAIsAcGbR8ejQiR8jcwGbYZEkTFVd7I9B4IXcL+GEPwdK4SN0XJSDaCoAvHZsA4/93hWHNVNnbZpjoG5gl7XvpFnxggxAZRaA0rokliIAIkaxMnwdWLE7XW77jd12qYBgCMiNHfZlhgTCkZfPfUDBAYGItoiL0lK8N0+51txzD1u7Ji8njTGpk6bg/iUhSiU4GT5YOtPL940AOfiDyHod9/dMsYEzmLS5bBoKE/ES8ECCyACSF4IFledAdhd2SIFUdtmAp7i92QM+uKqVg6RJXDKakCcjyjSwcldMUDgG7I0h8WKdI0ewM2kFuTpmlb1bp2UMYBJyjBjm/FYh57MjA/1+1wuESNZOfjoLPwe516zUSdLIgi6l+sl3CIW5leD7/v7HPNTE+cOtr8tDXhWy+zWAcvnDx/XoiEPiirPBomgXxd32KAFEWp3FR0YdP60pop4sfHI5cmr+MfMRl2tXKnqzS5pyFuaHRusu2A5EyeoAEAQS2Q94VDg4pY/YUOf9ZgxnBaJJSeOdny6AgB/AYEpKtpaTusRAAAAAElFTkSuQmCC)"></span> on the module page :]<br/><br/>
                      <b>Module page :</b> <a target="_blank" href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id="><?php echo $heading_title; ?></a><br/>
                      <b>Other modules :</b> <a target="_blank" href="https://www.opencart.com/index.php?route=marketplace/extension&filter_member=GeekoDev">My modules on opencart</a><br/>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript"><!--
$('input.switch').iToggle({easing: 'swing',speed: 200});
//$('.select2').select2();
--></script>
<script type="text/javascript"><!--
$('body').on('click', '.info-btn', function() {
  $('#modal-info').html('<div style="text-align:center"><img src="view/advanced_sitemap/img/loader.gif" alt=""/></div>');
  $('#modal-info').load('index.php?route=module/advanced_sitemap/modal_info&<?php echo $token; ?>', {'info': $(this).attr('data-info')});
});
//--></script> 
<!-- /custom blocks -->
<?php echo $footer; ?>
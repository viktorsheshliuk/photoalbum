<?php echo $header; ?><?php echo $column_left; ?>
<?php if (!empty($upgrade)) { ?>
<div id="content">
  <div class="container-fluid">
    <div class="panel panel-default" style="margin-top:25px; min-height:700px">
      <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-upload" style="color:#86C440"></i> Complete SEO Package Upgrade Tool</h3></div>
      <div class="content panel-body">
        <?php if (!empty($upgrade_complete)) { ?>
          <h4>Upgrade process:</h4>
          <ul style="list-style-type:none; margin-bottom:50px">
            <?php foreach ($info as $msg) { ?>
            <li><i class="fa fa-check-circle" style="color:#60ba5b"></i> <?php echo $msg; ?></li> 
            <?php } ?>
          </ul>
          <div class="alert alert-success"><i class="fa fa-check-circle"></i> The upgrade has been successfully done, you can go back to module options to continue the configuration.</div>
          <div class="text-center" style="margin-top:50px;">
            <a href="<?php echo $cancel; ?>" class="btn btn-default btn-lg"><i class="fa fa-reply"></i> Back to module options</a>
          </div>
        <?php } else  { ?>
        <div class="alert alert-info">
          <p>Use this page to upgrade from your previous SEO extension, if you want to transfer your actual data (keywords, metas, titles, etc) to Complete SEO Package.</p>
        </div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <div class="form-group">
            <label class="control-label"><span data-toggle="tooltip" title="What was your previous extension?">Upgrade from:</span></label>
            <select class="form-control" name="module">
              <option value="seo_pack_pro">SEO Pack Pro</option>
              <option value="paladin">Paladin</option>
              <option value="all_in_one">All In One SEO</option>
              <option value="mega_kit">SEO Mega Kit Plus</option>
              <option value="backpack">iSense SEO BackPack</option>
              <option value="webkul_advanced_seo">Webkul Advanced SEO</option>
              <option value="broken_link_manager">Broken Link Manager</option>
            </select>
          </div>
          <div class="instructions" style="min-height:200px;">
            <div class="seo_pack_pro well">
              <h3>Upgrade from SEO Pack Pro</h3>
              <ol>
                <li><span style="color:#ec5d5d">Important: Make full backup of your database</span></li>
                <li>Disable or delete these modification files from /vqmod/xml/ folder:
                  <ul>
                    <li>autolinks.xml</li>
                    <li>canonicals.xml</li>
                    <li>custom_title.xml</li>
                    <li>friendly_urls.xml</li>
                    <li>info_meta.xml</li>
                    <li>instant_seo.xml</li>
                    <li>product_seo_plus.xml</li>
                    <li>product_seo_plus_link_to_store.xml</li>
                    <li>product_seo_plus_title_with_category.xml</li>
                    <li>SEOEDITOR.xml</li>
                    <li>seopack.xml</li>
                    <li>store_keyword.xml</li>
                  </ul>
                </li>
                <li>If you had an url extension defined in your previous module (like .html), put it in the field below, if not just let it empty</li>
                <li>Click on proceed button</li>
                <li>If using ocmod do refresh in Extensions > Modifications</li>
              </ol>
            </div>
            <div class="backpack well" style="display:none">
              <h3>Upgrade from iSense SEO BackPack</h3>
                <ol>
                <li><span style="color:#ec5d5d">Important: Make full backup of your database</span></li>
                <li><b>Do not</b> uninstall Backpack from Extensions</li>
                <li>Disable the modification: "SEO Backpack by iSenseLabs"</li>
                <li>Remove the file /admin/controller/extension/module/isenselabs_seo.php</li>
                <li>If you had an url extension defined in your previous module (like .html), put it in the field below, if not just let it empty</li>
                <li>Click on proceed button</li>
                <li>Refresh modifications in Extensions > Modifications</li>
              </ol>
            </div>
            <div class="webkul_advanced_seo well" style="display:none">
              <h3>Upgrade from Webkul Advanced SEO</h3>
                <ol>
                <li><span style="color:#ec5d5d">Important: Make full backup of your database</span></li>
                <li><b>Do not</b> uninstall Webkul Advanced SEO from Extensions</li>
                <li>Disable the modification: "Advanced SEO"</li>
                <li>Remove the file /admin/controller/extension/module/wkseo.php</li>
                <li>If you had an url extension defined in your previous module (like .html), don't forget to add it in module settings after upgrade (SEO Config > Keyword options)</li>
                <li>Click on proceed button</li>
                <li>Refresh modifications in Extensions > Modifications</li>
              </ol>
            </div>
            <div class="paladin well" style="display:none">
              <h3>Upgrade from Paladin</h3>
                <ol>
                <li><span style="color:#ec5d5d">Important: Make full backup of your database</span></li>
                <li><b>Do not</b> uninstall Paladin from Extensions</li>
                <li>Remove the file /admin/controller/module/superseobox.php</li>
                <li>Disable or delete these modification files:
                  <ul>
                    <li>/vqmod/xml/ssb-admin-generate.xml</li>
                    <li>/vqmod/xml/ssb-catalog-generate.xml</li>
                  </ul>
                </li>
                <li>If you had an url extension defined in your previous module (like .html), put it in the field below, if not just let it empty</li>
                <li>Click on proceed button</li>
                <li>If using ocmod do refresh in Extensions > Modifications</li>
              </ol>
            </div>
            <div class="all_in_one well" style="display:none">
              <h3>Upgrade from All in One SEO (Nerdherd)</h3>
              <ol>
                <li><span style="color:#ec5d5d">Important: Make full backup of your database</span></li>
                <li><b>Do not</b> uninstall All in One SEO from Extensions</li>
                <li>Remove the file /admin/controller/extension/module/aioseo.php</li>
                <li>Disable or delete these modification files:
                  <ul>
                    <li>/system/aios1.ocmod.xml and do refresh in Extensions > Modifications</li>
                  </ul>
                </li>
                <li>If you had an url extension defined in your previous module (like .html), put it in the field below, if not just let it empty</li>
                <li>Click on proceed button</li>
                <li>Do refresh in Extensions > Modifications</li>
              </ol>
            </div>
            <div class="mega_kit well" style="display:none">
              <h3>Upgrade from SEO Mega Kit</h3>
              <ol>
                <li><span style="color:#ec5d5d">Important: Make full backup of your database</span></li>
                <li><b>Do not</b> uninstall SEO Mega Kit from Extensions</li>
                <li>Disable or delete all modification files starting by _seo_mega_pack: /vqmod/xml/_seo_mega_pack***.xml</li>
                <li>If you had an url extension defined in your previous module (like .html), put it in the field below, if not just let it empty</li>
                <li>Click on proceed button</li>
                <li>Delete the file /admin/controller/module/seo_mega_pack.php</li>
                <li>Do refresh in Extensions > Modifications</li>
              </ol>
            </div>
            <div class="broken_link_manager well" style="display:none">
              <h3>Broken Link Manager</h3>
              <p>Click on proceed to save all actual urls to Complete SEO Package.</p>
              <p>Then you can disable the Broken Link Manager modification files.</p>
            </div>
          </div>
          <div class="form-group hideExtension">
            <label class="control-label"><span data-toggle="tooltip" title="If your urls have an extension like .html put it here, the dot must be included">Extension</span></label>
            <input class="form-control" type="text" name="ext" value="" placeholder="example: .html"/>
          </div>
        </form>
        <div class="text-center" style="margin-top:50px;">
          <button type="submit" form="form" class="btn btn-primary btn-lg"><i class="fa fa-cog"></i> Proceed</button>
          <a href="<?php echo $cancel; ?>" class="btn btn-default btn-lg"><i class="fa fa-reply"></i> Back to module options</a>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('select[name=module]').change(function(){
var mod = $(this).val();
    $('.instructions > div').hide(0);
    $('.instructions > .'+mod).fadeIn(700);
  
  if (mod == 'broken_link_manager') {
    $('.hideExtension').hide();
  } else {
    $('.hideExtension').show();
  }
});
</script>
<?php echo $footer; exit; ?>
<?php } ?>
<?php $gkhtab = $gkhdiv = 0; ?>
<div id="content">
<?php if (!empty($style_scoped)) { ?><style scoped><?php echo $style_scoped; ?></style><?php } ?>
<div id="modal-info" class="modal <?php if ($OC_V2) echo ' fade'; ?>" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
	
  <div class="<?php if ($OC_V2) echo 'container-fluid' ?>">
	<?php if (isset($success) && $success) { ?><div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><script type="text/javascript">setTimeout("$('.alert-success').slideUp();",5000);</script><?php } ?>
	<?php if (isset($info) && $info) { ?><div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $info; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
	<?php if (isset($error) && $error) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
  <?php if (isset($error_warning) && $error_warning) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="pull-right">
      <button type="submit" form="form" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
      <a href="<?php echo $cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
    </div>
    <h3 class="panel-title"><img style="vertical-align:top;padding-right:4px" src="view/seo_package/img/icon-big.png"/> <?php echo $heading_title; ?></h3>
  </div>
  <div class="content panel-body">
  <?php if (count($stores)) { ?>
    <div id="stores" class="form-inline">
      <?php echo $_language->get('text_store_select'); ?>
      <select name="store" class="form-control input-sm">
        <?php foreach ($stores as $store) { ?>
        <?php if ($store_id == $store['store_id']) { ?>
        <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  <?php } ?>
		<ul class="nav nav-tabs" id="mainNav">
      <?php if (!$store_id) { ?>
			<li <?php echo $currentTab == 'tab-dashboard' ? 'class="active"' : '' ?>><a href="#tab-dashboard" data-toggle="tab"><i class="fa fa-dashboard"></i><?php echo $_language->get('tab_seo_dashboard'); ?></a></li>
			<li <?php echo $currentTab == 'tab-editor' ? 'class="active"' : '' ?>><a href="#tab-editor" data-toggle="tab"><i class="fa fa-edit"></i><?php echo $_language->get('tab_seo_editor'); ?></a></li>
			<li <?php echo $currentTab == 'tab-update' ? 'class="active"' : '' ?>><a href="#tab-update" data-toggle="tab"><i class="fa fa-bolt"></i><?php echo $_language->get('tab_seo_update'); ?></a></li>
			<li <?php echo $currentTab == 'tab-general' ? 'class="active"' : '' ?>><a href="#tab-general" data-toggle="tab"><i class="fa fa-wrench"></i><?php echo $_language->get('tab_seo_options'); ?></a></li>
			<li <?php echo $currentTab == 'tab-store' ? 'class="active"' : '' ?>><a href="#tab-store" data-toggle="tab"><i class="fa fa-area-chart"></i><?php echo $_language->get('tab_seo_store'); ?></a></li>
			<li <?php echo $currentTab == 'tab-fpp' ? 'class="active"' : '' ?>><a href="#tab-fpp" data-toggle="tab"><i class="fa fa-location-arrow"></i><?php echo $_language->get('tab_seo_fpp'); ?></a></li>
			<li <?php echo $currentTab == 'tab-snippet' ? 'class="active"' : '' ?>><a href="#tab-snippet" data-toggle="tab"><i class="fa fa-thumbs-o-up"></i><?php echo $_language->get('tab_seo_snippets'); ?></a></li>
			<li <?php echo $currentTab == 'tab-analytics' ? 'class="active"' : '' ?>><a href="#tab-analytics" data-toggle="tab"><i class="fa fa-line-chart"></i><?php echo $_language->get('tab_seo_analytics'); ?></a></li>
			<li <?php echo $currentTab == 'tab-cron' ? 'class="active"' : '' ?>><a href="#tab-cron" data-toggle="tab"><i class="fa fa-terminal"></i><?php echo $_language->get('tab_seo_cron'); ?></a></li>
			<li <?php echo $currentTab == 'tab-about' ? 'class="active"' : '' ?>><a href="#tab-about" data-toggle="tab"><i class="fa fa-info"></i><?php echo $_language->get('tab_seo_about'); ?></a></li>
      <?php } else { ?>
        <li  <?php echo $currentTab == 'tab-multistore' ? 'class="active"' : '' ?>><a href="#tab-multistore" data-toggle="tab"><i class="fa fa-sitemap"></i><?php echo $_language->get('tab_seo_multistore'); ?></a></li>
        <?php if ($mlseo_multistore) { ?>
        <li <?php echo $currentTab == 'tab-editor' ? 'class="active"' : '' ?>><a href="#tab-editor" data-toggle="tab"><i class="fa fa-edit"></i><?php echo $_language->get('tab_seo_editor'); ?></a></li>
        <li <?php echo $currentTab == 'tab-update' ? 'class="active"' : '' ?>><a href="#tab-update" data-toggle="tab"><i class="fa fa-bolt"></i><?php echo $_language->get('tab_seo_update'); ?></a></li>
        <?php } ?>
        <li <?php echo $currentTab == 'tab-general' ? 'class="active"' : '' ?>><a href="#tab-general" data-toggle="tab"><i class="fa fa-wrench"></i><?php echo $_language->get('tab_seo_options'); ?></a></li>
        <li <?php echo $currentTab == 'tab-store' ? 'class="active"' : '' ?>><a href="#tab-store" data-toggle="tab"><i class="fa fa-area-chart"></i><?php echo $_language->get('tab_seo_store'); ?></a></li>
        <li <?php echo $currentTab == 'tab-snippet' ? 'class="active"' : '' ?>><a href="#tab-snippet" data-toggle="tab"><i class="fa fa-thumbs-o-up"></i><?php echo $_language->get('tab_seo_snippets'); ?></a></li>
        <li <?php echo $currentTab == 'tab-analytics' ? 'class="active"' : '' ?>><a href="#tab-analytics" data-toggle="tab"><i class="fa fa-line-chart"></i><?php echo $_language->get('tab_seo_analytics'); ?></a></li>
      <?php } ?>
		</ul>
    
		<div class="tab-content">
    <?php if (!$store_id) { ?>
		<div class="tab-pane <?php echo $currentTab == 'tab-dashboard' ? 'active' : '' ?>" id="tab-dashboard" style="position:relative;">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> <span><?php echo $_language->get('text_seo_score'); ?></span></h3>
          </div>
          <div class="panel-body">
            <div class="radial-progress" data-progress="0">
              <div class="circle">
                <div class="mask full">
                  <div class="fill"></div>
                </div>
                <div class="mask half">
                  <div class="fill"></div>
                  <div class="fill fix"></div>
                </div>
                <div class="shadow"></div>
              </div>
              <div class="inset">
                <div class="percentage">
                  <div class="numbers" style="color:transparent"><span>-</span><span>0%</span><span>1%</span><span>2%</span><span>3%</span><span>4%</span><span>5%</span><span>6%</span><span>7%</span><span>8%</span><span>9%</span><span>10%</span><span>11%</span><span>12%</span><span>13%</span><span>14%</span><span>15%</span><span>16%</span><span>17%</span><span>18%</span><span>19%</span><span>20%</span><span>21%</span><span>22%</span><span>23%</span><span>24%</span><span>25%</span><span>26%</span><span>27%</span><span>28%</span><span>29%</span><span>30%</span><span>31%</span><span>32%</span><span>33%</span><span>34%</span><span>35%</span><span>36%</span><span>37%</span><span>38%</span><span>39%</span><span>40%</span><span>41%</span><span>42%</span><span>43%</span><span>44%</span><span>45%</span><span>46%</span><span>47%</span><span>48%</span><span>49%</span><span>50%</span><span>51%</span><span>52%</span><span>53%</span><span>54%</span><span>55%</span><span>56%</span><span>57%</span><span>58%</span><span>59%</span><span>60%</span><span>61%</span><span>62%</span><span>63%</span><span>64%</span><span>65%</span><span>66%</span><span>67%</span><span>68%</span><span>69%</span><span>70%</span><span>71%</span><span>72%</span><span>73%</span><span>74%</span><span>75%</span><span>76%</span><span>77%</span><span>78%</span><span>79%</span><span>80%</span><span>81%</span><span>82%</span><span>83%</span><span>84%</span><span>85%</span><span>86%</span><span>87%</span><span>88%</span><span>89%</span><span>90%</span><span>91%</span><span>92%</span><span>93%</span><span>94%</span><span>95%</span><span>96%</span><span>97%</span><span>98%</span><span>99%</span><span>100%</span></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <style type="text/less"><?php echo $style_radial_meter; ?></style>
        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.6.1/less.min.js"></script>
      </div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cog"></i> <span><?php echo $_language->get('text_dashboard_config'); ?></span></h3>
          </div>
          <div class="panel-body form-horizontal">
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo $_language->get('text_seo_package_status'); ?></label>
              <div class="col-sm-9">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-power-off"></i></span>
                  <input type="text" name="mlseo_enabled" value="<?php echo $mlseo_enabled; ?>" class="toggler" data-mode="background" data-on-text="<?php echo strip_tags($_language->get('text_enabled')); ?>" data-off-text="<?php echo strip_tags($_language->get('text_disabled')); ?>" data-icons="" />
                </div>
              </div>
            </div>
          </div>
        </div>

        
      </div>
      <div class="clearfix">&nbsp;</div>
    </div>
    <?php } ?>
		<div class="tab-pane <?php echo $currentTab == 'tab-editor' ? 'active' : '' ?>" id="tab-editor" style="position:relative;">
			<ul id="tabs_editor_lang" class="nav nav-tabs" style="position:absolute; top:0; margin:0; <?php echo ($_language->get('direction')) == 'rtl' ? 'left:0;' : 'right:0;'; ?>">
				<?php if (count($languages) > 3) { ?>
				<li class="active pull-right dropdown">
         <?php foreach ($languages as $language) { ?>
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $language['image']; ?>" alt=""/> <span class="caret"></span><span class="hideLabel">&nbsp;&nbsp;Select language</span></a>
          <?php break; } ?>
          <ul class="dropdown-menu">
            <?php $f=0; foreach ($languages as $language) { ?>
            <li class="<?php if (!$f) echo 'active'; $f = 1; ?>"><a href="#editorlang-<?php echo $language['language_id']; ?>" editor-lang="<?php echo $language['language_id']; ?>" editor-lang-code="<?php echo $language['code']; ?>" data-toggle="tab"><img src="<?php echo $language['image']; ?>" alt=""/>&nbsp;&nbsp;<?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>
        </li>
				<?php } else { ?>
				<?php $f=0; foreach ($languages as $language) { ?>
				<li class="pull-right <?php if (!$f) echo 'active'; $f = 1; ?>"><a href="#editorlang-<?php echo $language['language_id']; ?>" editor-lang="<?php echo $language['language_id']; ?>" editor-lang-code="<?php echo $language['code']; ?>" data-toggle="tab"><img src="<?php echo $language['image']; ?>" alt=""/><span class="hideLabel">&nbsp;&nbsp;<?php echo $language['name']; ?></span></a></li>
				<?php } ?>
				<?php } ?>
			</ul>
			<ul id="tabs_editor" class="nav nav-tabs">
				<?php
          $editor_types = array('product', 'category', 'information', 'manufacturer', 'image', 'absolute', 'common', 'special', 'autolink', '404', 'redirect');
          if ($store_id) {
            $editor_types = array('product', 'category', 'information', 'manufacturer', 'image', 'common', 'special');
          }
        ?>
				<?php $f = 0; foreach ($editor_types as $type) { ?>
					<li <?php if (!$f) echo 'class="active"'; $f = 1; ?>><a class="<?php echo in_array($type, array('redirect__', '404')) ? 'ml-hide' : 'ml-show'; ?>" href="#tab-editor-<?php echo $type; ?>" editor-type="<?php echo $type; ?>" data-toggle="tab"><?php echo $_language->get('tab_seo_editor_'.$type); ?></a></li>
				<?php } ?>
			</ul>
			<div class="tab-content">
			  <?php $f=0; foreach ($editor_types as $type) { ?>
				<div id="tab-editor-<?php echo $type; ?>" class="tab-pane<?php if (!$f) {echo ' active'; $f=1;} ?>">
          <?php if (empty($mlseo_friendly) && in_array($type, array('common', 'special'))) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo $_language->get('error_friendly_disabled'); ?></div>
          <?php } else if (empty($mlseo_url_absolute) && $type == 'absolute') { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo $_language->get('error_absolute_disabled'); ?></div>
          <?php } else if (empty($mlseo_404) && $type == '404') { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo $_language->get('error_404_disabled'); ?></div>
          <?php } else if (empty($mlseo_redirect) && $type == 'redirect') { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo $_language->get('error_redirect_disabled'); ?></div>
          <?php } ?>
					<table id="seo_editor_<?php echo $type; ?>" class="seo_editor table table-condensed table-hover table-striped table-curved" width="100%" cellspacing="0">
						<thead>
							<tr>
                <?php if (in_array($type, array('redirect', 'absolute', 'autolink'))) { ?>
                  <th data-column="query"><i class="fa fa-link gkd-badge"></i> <?php echo $_language->get('text_editor_query_'.$type); ?></th>
									<th data-column="redirect"><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_editor_url_'.$type); ?></th>
									<th data-column="delete"></th>
								<?php } else if ($type == '404') { ?>
									<th data-column="query"><i class="fa fa-link gkd-badge"></i> <?php echo $_language->get('text_editor_query'); ?></th>
									<th data-column="count"><?php echo $_language->get('text_editor_count'); ?></th>
									<th data-column="delete"></th>
								<?php } else if ($type == 'image') { ?>
                  <th style="width:1px"></th>
									<th data-column="name"><i class="fa fa-italic gkd-badge"></i> <?php echo $_language->get('text_editor_item_name'); ?></th>
									<th data-column="image"><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_editor_image_name'); ?></th>
									<th data-column="image_alt"><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_editor_image_alt'); ?></th>
									<th data-column="image_title"><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_editor_image_title'); ?></th>
								<?php } else if (in_array($type, array('common', 'special'))) { ?>
									<th data-column="query"><i class="fa fa-link gkd-badge"></i> <?php echo $_language->get('text_editor_query_'.$type); ?></th>
									<th data-column="keyword"><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_editor_url'); ?></th>
									<th data-column="delete"></th>
								<?php } else { ?>
									<?php if (in_array($type, array('product', 'category', 'manufacturer'))) { ?>
										<th style="width:1px"></th>
										<th data-column="name"><i class="fa fa-italic gkd-badge"></i> <?php echo $_language->get('text_editor_name'); ?></th>
									<?php } ?>
									<?php if(in_array($type, array('information'))) { ?>
										<th data-column="title"><i class="fa fa-italic gkd-badge"></i> <?php echo $_language->get('text_editor_title'); ?></th>
									<?php } ?>
									<th data-column="seo_keyword" style="width:25%"><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_editor_url'); ?></th>
									<?php if (1) { ?>
										<th data-column="meta_title"><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_editor_meta_title'); ?></th>
										<th data-column="meta_keyword"><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_editor_meta_keyword'); ?></th>
										<th data-column="meta_description"><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_editor_meta_description'); ?></th>
									<?php } ?>
									<?php if (in_array($type, array('product')) && version_compare(VERSION, '1.5.3', '>=') && !$store_id) { ?>
										<th data-column="tag"><i class="fa fa-tags gkd-badge cyan"></i> <?php echo $_language->get('text_editor_tag'); ?></th>
									<?php } ?>
                  <?php if (in_array($type, array('product'))) { ?>
										<th data-column="related"><i class="fa fa-code-fork gkd-badge darkblue"></i> <?php echo $_language->get('text_editor_related'); ?></th>
									<?php } ?>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<tr><td style="height:200px"></td></tr>
						</tbody>
					</table>
          <?php if ($type == '404') { ?>
					<div class="btn-group more_actions">
					  <button type="button" class="btn btn-default deleteAliases redirOnly" data-toggle="modal" data-target="#close"><i class="fa fa-minus"></i> <?php echo $_language->get('text_seo_remove_redirected'); ?></button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					  <ul class="dropdown-menu" role="menu">
						<li><a class="deleteAliases redirOnly"><i class="fa fa-minus"></i> <?php echo $_language->get('text_seo_remove_redirected'); ?></a></li>
						<li><a class="deleteAliases"><i class="fa fa-close"></i> <?php echo $_language->get('text_seo_remove_urls'); ?></a></li>
					  </ul>
					</div>
          <div>&nbsp;
            <div class="gkdwidget gkdwidget-color-blueDark">
              <header role="heading">
                <i class="icon fa fa-info-circle fa-2x pull-left"></i>
                <ul class="nav nav-tabs pull-left in">
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('tab_seo_editor_404'); ?></span></a></li>
                </ul>
              </header>
              <div class="gkdwidget-container" style="display:none">
                <div class="tab-content">
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_404'); ?></div>
                </div>
              </div>
            </div>
          </div>
					<?php } else if ($type == 'redirect') { ?>
					<div class="btn-group more_actions">
					  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#newAliasModal" onclick="javascript:$('#newAliasModal input').val('')"><i class="fa fa-plus"></i> <?php echo $_language->get('text_seo_add_url'); ?></button>
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					  <ul class="dropdown-menu" role="menu">
						<li><a data-toggle="modal" data-target="#newAliasModal" onclick="javascript:$('#newAliasModal input[name=query]').val('')"><i class="fa fa-plus"></i> <?php echo $_language->get('text_seo_add_url'); ?></a></li>
						<li><a class="deleteAliases"><i class="fa fa-close"></i> <?php echo $_language->get('text_seo_remove_urls'); ?></a></li>
					  </ul>
					</div>
          <div>&nbsp;
            <div class="gkdwidget gkdwidget-color-blueDark">
              <header role="heading">
                <i class="icon fa fa-info-circle fa-2x pull-left"></i>
                <ul class="nav nav-tabs pull-left in">
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('tab_seo_editor_redirect'); ?></span></a></li>
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('tab_seo_editor_dynamic_redirect'); ?></span></a></li>
                </ul>
              </header>
              <div class="gkdwidget-container" style="display:none">
                <div class="tab-content">
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_redirections'); ?></div>
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_dynamic_redirections'); ?></div>
                </div>
              </div>
            </div>
          </div>
					<?php } else if (in_array($type, array('absolute', 'common', 'special', 'autolink'))) { ?>
					<div class="btn-group more_actions">
					  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#newAliasModal" onclick="javascript:$('#newAliasModal input[name=query]').val('')"><i class="fa fa-plus"></i> <?php echo $_language->get('text_seo_add_url'); ?></button>
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					  <ul class="dropdown-menu" role="menu">
						<li><a data-toggle="modal" data-target="#newAliasModal" onclick="javascript:$('#newAliasModal input[name=query]').val('')"><i class="fa fa-plus"></i> <?php echo $_language->get('text_seo_add_url'); ?></a></li>
					  <?php if ($type == 'common') { ?>
						<li data-toggle="tooltip" data-placement="right" title="<?php echo $_language->get('text_seo_reset_urls_tooltip'); ?>"><a class="restoreAliases"><i class="fa fa-magic"></i> <?php echo $_language->get('text_seo_reset_urls'); ?></a></li>
						<li data-toggle="tooltip" data-placement="right" title="<?php echo $_language->get('text_seo_export_urls_tooltip'); ?>"><a class="exportAliases"><i class="fa fa-save"></i> <?php echo $_language->get('text_seo_export_urls'); ?></a></li>
					  <?php } ?>
						<li><a class="deleteAliases"><i class="fa fa-close"></i> <?php echo $_language->get('text_seo_remove_urls'); ?></a></li>
					  </ul>
					</div>
          <div>&nbsp;
            <div class="gkdwidget gkdwidget-color-blueDark">
              <header role="heading">
                <i class="icon fa fa-info-circle fa-2x pull-left"></i>
                <ul class="nav nav-tabs pull-left in">
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('title_common_overview'); ?></span></a></li>
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('tab_seo_editor_absolute'); ?></span></a></li>
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('tab_seo_editor_common'); ?></span></a></li>
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('tab_seo_editor_special'); ?></span></a></li>
                </ul>
              </header>
              <div class="gkdwidget-container" style="display:none">
                <div class="tab-content">
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_common_overview'); ?></div>
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_absolute'); ?></div>
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_common'); ?></div>
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_special'); ?></div>
                </div>
              </div>
            </div>
          </div>
					<?php } ?>
          <?php if (in_array($type, array('product', 'category', 'information'))) { ?>
          <?php if (in_array($type, array('product'))) { ?>
          <div>&nbsp;
            <hr/>
            <span style="position:relative; bottom:10px;"><?php echo $_language->get('text_editor_show_columns'); ?></span>
            <?php foreach(array('image', 'name', 'url', 'meta_title', 'meta_keyword', 'meta_description', 'tag', 'related') as $colIndex => $colType) { ?>
            <input id="editorCol<?php echo $colType.$colType; ?>" class="checkable editorColumns" data-index="<?php echo $colIndex+1; ?>" data-column="<?php echo $colType; ?>" data-label="<?php echo $_language->get('text_editor_'.$colType); ?>" type="checkbox" name="mlseo_editor[product][<?php echo $colIndex+1; ?>]" value="1" <?php if (empty($mlseo_editor['product']) || !empty($mlseo_editor['product'][$colIndex+1])) echo 'checked="checked"'; ?> />&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>
          </div>
          <?php } ?>
          <div>&nbsp;
            <div class="gkdwidget gkdwidget-color-blueDark">
              <header role="heading">
                <i class="icon fa fa-info-circle fa-2x pull-left"></i>
                <ul class="nav nav-tabs pull-left in">
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('text_info_seo_titles_tab'); ?></span></a></li>
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('text_info_limits_tab'); ?></span></a></li>
                </ul>
              </header>
              <div class="gkdwidget-container" style="display:none">
                <div class="tab-content">
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_seo_titles'); ?></div>
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_limits'); ?></div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
    
		<div class="tab-pane <?php echo $currentTab == 'tab-general' ? 'active' : '' ?>" id="tab-general">
			<ul class="nav nav-pills nav-stacked col-md-2">
				<li class="active"><a href="#tab-general-1" data-toggle="pill"><i class="fa fa-cog"></i> <?php echo $_language->get('text_seo_tab_general_1'); ?></a></li>
				<li><a href="#tab-general-14" data-toggle="pill"><i class="fa fa-mail-forward"></i> <?php echo $_language->get('text_seo_tab_general_14'); ?></a></li>
				<li><a href="#tab-general-2" data-toggle="pill"><i class="fa fa-globe"></i> <?php echo $_language->get('text_seo_tab_general_2'); ?></a></li>
				<!--li><a href="#tab-general-9" data-toggle="pill"><i class="fa fa-cubes"></i> <?php echo $_language->get('text_seo_tab_general_9'); ?></a></li-->
				<li><a href="#tab-general-3" data-toggle="pill"><i class="fa fa-flag"></i> <?php echo $_language->get('text_seo_tab_general_3'); ?></a></li>
				<li><a href="#tab-general-6" data-toggle="pill"><i class="fa fa-file-o"></i> <?php echo $_language->get('text_seo_tab_general_6'); ?></a></li>
				<li><a href="#tab-general-4" data-toggle="pill"><i class="fa fa-edit"></i> <?php echo $_language->get('text_seo_tab_general_4'); ?></a></li>
				<li><a href="#tab-general-8" data-toggle="pill"><i class="fa fa-code-fork"></i> <?php echo $_language->get('text_seo_tab_general_8'); ?></a></li>
				<li><a href="#tab-general-10" data-toggle="pill"><i class="fa fa-comments-o"></i> <?php echo $_language->get('text_seo_tab_general_10'); ?></a></li>
				<li><a href="#tab-general-11" data-toggle="pill"><i class="fa fa-crosshairs"></i> <?php echo $_language->get('text_seo_tab_general_11'); ?></a></li>
				<li><a href="#tab-general-12" data-toggle="pill"><i class="fa fa-sitemap"></i> <?php echo $_language->get('text_seo_tab_general_12'); ?></a></li>
				<li><a href="#tab-general-18" data-toggle="pill"><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_tab_general_18'); ?></a></li>
				<li><a href="#tab-general-13" data-toggle="pill"><i class="fa fa-android"></i> <?php echo $_language->get('text_seo_tab_general_13'); ?></a></li>
				<li><a href="#tab-general-17" data-toggle="pill"><i class="fa fa-exclamation-triangle"></i> <?php echo $_language->get('text_seo_tab_general_17'); ?></a></li>
        <?php if (!$store_id) { ?>
				<li><a href="#tab-general-5" data-toggle="pill"><i class="fa fa-magic"></i> <?php echo $_language->get('text_seo_tab_general_5'); ?></a></li>
				<li><a href="#tab-general-15" data-toggle="pill"><i class="fa fa-bolt"></i> <?php echo $_language->get('tab_seo_update'); ?></a></li>
        <?php } ?>
				<li><a href="#tab-general-16" data-toggle="pill"><i class="fa fa-cubes"></i> <?php echo $_language->get('text_seo_tab_general_16'); ?></a></li>
				<!--li><a href="#tab-general-7" data-toggle="pill"><i class="fa fa-dashboard"></i> <?php echo $_language->get('text_seo_tab_general_7'); ?></a></li-->
			</ul>
			<div class="tab-content col-md-10">
				<div class="tab-pane active" id="tab-general-1">
          <table class="form">
          <?php /*
            <tr>
              <td><?php echo $_language->get('text_seo_package_status'); ?></td>
              <td colspan="2" style="padding-bottom:30px">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-power-off"></i></span>
                  <input type="text" name="mlseo_enabled" value="1" class="toggler" data-mode="background" data-on-text="<?php echo $_language->get('text_enabled'); ?>" data-off-text="<?php echo $_language->get('text_disabled'); ?>" data-icons="" />
                </div>
              </td>
            </tr>
            */ ?>
            <tr>
              <td><?php echo $_language->get('text_seo_components'); ?></td>
              <td colspan="2" style="padding-top:25px">
                <table class="table">
                  <thead>
                    <tr>
                      <th><?php echo $_language->get('text_enabled'); ?></th>
                      <th><?php echo $_language->get('text_description'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input class="checkable" data-label="<?php echo $_language->get('tab_seo_editor_absolute'); ?>" type="checkbox" name="mlseo_url_absolute" value="1" <?php if (!empty($mlseo_url_absolute)) echo 'checked="checked"'; ?> /></td>
                      <td><?php echo $_language->get('info_seo_absolute'); ?></td>
                    </tr>
                    <tr>
                      <td><input class="checkable" data-label="<?php echo $_language->get('tab_seo_editor_common'); ?>" type="checkbox" name="mlseo_friendly" value="1" <?php if (!empty($mlseo_friendly)) echo 'checked="checked"'; ?> /></td>
                      <td><?php echo $_language->get('info_seo_friendly'); ?></td>
                    </tr>
                    <tr>
                      <td><input class="checkable" data-label="<?php echo $_language->get('tab_seo_editor_404'); ?>" type="checkbox" name="mlseo_404" value="1" <?php if (!empty($mlseo_404)) echo 'checked="checked"'; ?> /></td>
                      <td><?php echo $_language->get('info_seo_404'); ?></td>
                    </tr>
                    <tr>
                      <td><input class="checkable" data-label="<?php echo $_language->get('tab_seo_editor_redirect'); ?>" type="checkbox" name="mlseo_redirect" value="1" <?php if (!empty($mlseo_redirect)) echo 'checked="checked"'; ?> /></td>
                      <td><?php echo $_language->get('info_seo_redirect'); ?></td>
                    </tr>
                    <tr>
                      <td><input class="checkable" data-label="<?php echo $_language->get('tab_seo_editor_autolink'); ?>" type="checkbox" name="mlseo_autolink" value="1" <?php if (!empty($mlseo_autolink)) echo 'checked="checked"'; ?> /></td>
                      <td><?php echo $_language->get('info_seo_autolink'); ?></td>
                    </tr>
                    <tr>
                      <td><input class="checkable" data-label="<?php echo $_language->get('entry_url_backup'); ?>" type="checkbox" name="mlseo_backup" value="1" <?php if (!empty($mlseo_backup)) echo 'checked="checked"'; ?> /></td>
                      <td><?php echo $_language->get('info_url_backup'); ?></td>
                    </tr>
                    <?php if (!$store_id && version_compare(VERSION, '2', '>=')) { ?>
                    <tr>
                      <td><input class="checkable" data-label="<?php echo $_language->get('text_multistore'); ?>" type="checkbox" name="mlseo_multistore" value="1" <?php if (!empty($mlseo_multistore)) echo 'checked="checked"'; ?> <?php if (count($stores) === 1) echo 'disabled="disabled"'; ?>/></td>
                      <td><?php echo $_language->get('info_multistore'); ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_shortcut'); ?></td>
              <td colspan="2">
                <select class="form-control" name="mlseo_shortcut">
                  <option value="" <?php if (empty($mlseo_shortcut)) echo 'selected="selected"'; ?>><?php echo $_language->get('text_shortcut_ext'); ?></option>
                  <option value="top" <?php if ($mlseo_shortcut == 'top') echo 'selected="selected"'; ?>><?php echo $_language->get('text_shortcut_top'); ?></option>
                  <option value="no" <?php if ($mlseo_shortcut == 'no') echo 'selected="selected"'; ?>><?php echo $_language->get('text_shortcut_no'); ?></option>
                </select>
              </td>
            </tr>
            <!--tr class="info">
              <td><i class='fa fa-info'></i></td>
              <td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general'); ?></td>
            </tr-->
          </table>
				</div>
        <div class="tab-pane" id="tab-general-16">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_banner'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_banners" name="mlseo_banners" value="1" <?php if ($mlseo_banners) echo 'checked="checked"'; ?> /></td>
              <td><span class="help"><?php echo $_language->get('text_seo_banner_help'); ?></span></td>
            </tr>
          </table>
				</div>
        <div class="tab-pane" id="tab-general-14">
          <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> If you're going to use redirect to HTTPS, make sure your urls defined in <b>config.php</b> are all defined to https (both <b>HTTP_SERVER</b> and <b>HTTPS_SERVER</b>).</div>
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_redirect_http'); ?></td>
              <td colspan="2">
                <select class="form-control" name="mlseo_redirect_http">
                  <option value=""><?php echo $_language->get('text_disabled'); ?></option>
                  <optgroup label="<?php echo $_language->get('text_seo_redirect_ssl'); ?>">
                    <option value="5" <?php if ($mlseo_redirect_http == '5') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_http_5'); ?></option>
                    <option value="6" <?php if ($mlseo_redirect_http == '6') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_http_6'); ?></option>
                  </optgroup>
                  <optgroup label="<?php echo $_language->get('text_seo_redirect_www'); ?>">
                    <option value="7" <?php if ($mlseo_redirect_http == '7') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_http_7'); ?></option>
                    <option value="8" <?php if ($mlseo_redirect_http == '8') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_http_8'); ?></option>
                  </optgroup>
                  <optgroup label="<?php echo $_language->get('text_seo_redirect_sslwww'); ?>">
                    <option value="4" <?php if ($mlseo_redirect_http == '4') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_http_4'); ?></option>
                    <option value="3" <?php if ($mlseo_redirect_http == '3') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_http_3'); ?></option>
                    <option value="2" <?php if ($mlseo_redirect_http == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_http_2'); ?></option>
                    <option value="1" <?php if ($mlseo_redirect_http == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_http_1'); ?></option>
                  </optgroup>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_redirect_canonical'); ?></td>
              <td colspan="2">
                <select class="form-control" name="mlseo_redirect_canonical">
                  <option value=""><?php echo $_language->get('text_disabled'); ?></option>
                  <option value="1" <?php if ($mlseo_redirect_canonical == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_canonical_1'); ?></option>
                  <option value="2" <?php if ($mlseo_redirect_canonical == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_redirect_canonical_2'); ?></option>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_redirect_dynamic'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_redirect_dynamic" name="mlseo_redirect_dynamic" value="1" <?php if ($mlseo_redirect_dynamic) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
          </table>
				</div>
        <?php if (!$store_id) { ?>
        <div class="tab-pane" id="tab-general-15">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_special_group'); ?></td>
              <td colspan="2">
                <select class="form-control" name="mlseo_special_group">
                  <option value=""><?php echo $_language->get('text_disabled'); ?></option>
                  <?php foreach ($customer_groups as $group) { ?>
                    <option value="<?php echo $group['customer_group_id']; ?>" <?php if ($mlseo_special_group == $group['customer_group_id']) echo 'selected="selected"'; ?>><?php echo $group['name']; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_format_tag'); ?></td>
              <td colspan="2">
                <input class="switch" type="checkbox" id="mlseo_format_tag" name="mlseo_format_tag" value="1" <?php if ($mlseo_format_tag) echo 'checked="checked"'; ?> />
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
				<div class="tab-pane" id="tab-general-2">
					<table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_flag'); ?></td>
              <td>
                <select class="form-control" name="mlseo_flag_mode">
                  <option value=""><?php echo $_language->get('text_disabled'); ?></option>
                  <option value="tag" <?php if ($mlseo_flag) echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_flag_tag'); ?> (example.com/en)</option>
                  <option value="store" <?php if ($mlseo_store_mode) echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_flag_store'); ?>  (en.example.com)</option>
                </select>
                <input type="hidden" name="mlseo_default_lang" value="<?php echo $_config->get('config_language'); ?>" />
                <input type="hidden" name="mlseo_flag" value="1" <?php if ($mlseo_flag) echo 'checked="checked"'; ?> />
                <input type="hidden" name="mlseo_store_mode" value="1" <?php if ($mlseo_store_mode) echo 'checked="checked"'; ?> />
              </td>
            </tr>
            <table class="flagmode-tag form">
              <tr>
                <td><?php echo $_language->get('text_seo_flag_short'); ?></td>
                <td><input class="switch" type="checkbox" id="mlseo_flag_short" name="mlseo_flag_short" value="1" <?php if ($mlseo_flag_short) echo 'checked="checked"'; ?> /></td>
              </tr>
              <tr>
                <td><?php echo $_language->get('text_seo_flag_default'); ?></td>
                <td><input class="switch" type="checkbox" id="mlseo_flag_default" name="mlseo_flag_default" value="1" <?php if ($mlseo_flag_default) echo 'checked="checked"'; ?> /></td>
              </tr>
              <tr>
                <td><?php echo $_language->get('text_seo_flag_upper'); ?></td>
                <td><input class="switch" type="checkbox" id="mlseo_flag_upper" name="mlseo_flag_upper" value="1" <?php if ($mlseo_flag_upper) echo 'checked="checked"'; ?> /></td>
              </tr>
              <tr>
                <td><?php echo $_language->get('text_seo_flag_detect'); ?></td>
                <td>
                  <select class="form-control" name="mlseo_flag_detect">
                    <option value=""><?php echo $_language->get('text_seo_flag_detect_auto'); ?></option>
                    <option value="1" <?php if ($mlseo_flag_detect) echo 'selected="selected"'; ?>><?php echo $_language->get('text_seo_flag_detect_force'); ?></option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><?php echo $_language->get('text_seo_flag_custom'); ?></td>
                <td>
                  <?php foreach ($languages as $language) {
                    $placeholder = $language['code'];
                    $placeholder = $mlseo_flag_short ? substr($placeholder, 0, 2) : $placeholder;
                    $placeholder = $mlseo_flag_upper ? strtoupper($placeholder) : strtolower($placeholder);
                  ?>
                    <div class="input-group">
                      <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                      <input class="form-control" type="text" name="mlseo_flag_custom[<?php echo $language['code']; ?>]" value="<?php echo isset($mlseo_flag_custom[$language['code']]) ? $mlseo_flag_custom[$language['code']] : ''; ?>" placeholder="<?php echo $placeholder; ?>"/>
                    </div>
                  <?php } ?>
                </td>
              </tr>
            </table>
            <table class="flagmode-store form">
              <?php if (!$journal3_active) { ?>
              <tr>
                <td><?php echo $_language->get('text_disable_other_store_links'); ?></td>
                <td><input class="switch" type="checkbox" id="mlseo_disable_other_store_links" name="mlseo_disable_other_store_links" value="1" <?php if ($mlseo_disable_other_store_links) echo 'checked="checked"'; ?> /></td>
              </tr>
              <?php } ?>
              <tr>
                <td><?php echo $_language->get('text_seo_substore_config'); ?></td>
                <td>
                  <?php foreach ($languages as $language) { ?>
                    <p><img style="margin-top:-2px" src="<?php echo $language['image']; ?>" alt="<?php echo $language['code']; ?>"/>  <?php echo !empty($lang_to_store[$language['code']]['config_url']) ? $lang_to_store[$language['code']]['config_url'] : '<span class="text-danger">'.$_language->get('text_no_language_defined').'</span>'; ?></p>
                  <?php } ?>
                </td>
              </tr>
            </table>
          <div class="gkdwidget gkdwidget-color-blueDark">
            <header role="heading">
              <i class="icon fa fa-info-circle fa-2x pull-left"></i>
              <ul class="nav nav-tabs pull-left in">
                <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_seo_flag_tag'); ?></a></li>
                <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_seo_flag_store'); ?></a></li>
              </ul>
            </header>
            <div class="gkdwidget-container" style="display:none">
              <div class="tab-content">
                <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_flag_mode'); ?></div>
                <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_store_mode'); ?></div>
              </div>
            </div>
          </div>
				</div>
				<div class="tab-pane" id="tab-general-3">
					<table class="form">
            <tr>
							<td><?php echo $_language->get('text_seo_hreflang'); ?></td>
							<td><input class="switch" type="checkbox" id="mlseo_hreflang" name="mlseo_hreflang" value="1" <?php if ($mlseo_hreflang) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr class="info">
            <td><i class='fa fa-info'></i></td>
							<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_3'); ?></td>
            </tr>
          </table>
        </div>
    <div class="tab-pane" id="tab-general-6">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-friendly-1" data-toggle="tab"><?php echo $_language->get('tab_friendly_pagination'); ?></a></li>
        <li><a href="#tab-friendly-4" data-toggle="tab"><?php echo $_language->get('tab_friendly_search'); ?></a></li>
        <li><a href="#tab-friendly-2" data-toggle="tab"><?php echo $_language->get('tab_friendly_sorting'); ?></a></li>
        <li><a href="#tab-friendly-3" data-toggle="tab"><?php echo $_language->get('tab_friendly_tag'); ?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab-friendly-1">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_pagination'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_pagination" name="mlseo_pagination" value="1" <?php if ($mlseo_pagination) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <!--tr>
              <td><?php echo $_language->get('text_seo_pagination_keyword'); ?></td>
              <td colspan="2">
                <?php foreach ($languages as $language) { ?>
                <div class="input-group">
                  <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                  <input type="text" class="form-control" placeholder="page" name="mlseo_pagination_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_pagination_'.$language['language_id']})) echo ${'mlseo_pagination_'.$language['language_id']}; ?>" />
                </div>
                <?php } ?>
              </td>
            </tr-->
            <?php if (version_compare(VERSION, '2.2', '>=')) { ?>
            <tr>
              <td><?php echo $_language->get('text_seo_pagination_fix'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_pagination_fix" name="mlseo_pagination_fix" value="1" <?php if ($mlseo_pagination_fix) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <?php } ?>
            <tr>
              <td><?php echo $_language->get('text_seo_pagination_name'); ?></td>
              <td colspan="2">
                <?php foreach ($languages as $language) { ?>
                <div class="input-group">
                  <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                  <input type="text" class="form-control" placeholder="page" name="mlseo_pagination_name_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_pagination_name_'.$language['language_id']})) echo ${'mlseo_pagination_name_'.$language['language_id']}; ?>" />
                </div>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_pagination_canonical'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_pagination_canonical" name="mlseo_pagination_canonical" value="1" <?php if ($mlseo_pagination_canonical) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr class="info">
              <td><i class='fa fa-info'></i></td>
              <td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_6'); ?></td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="tab-friendly-2">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_sort'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_sort" name="mlseo_sort" value="1" <?php if ($mlseo_sort) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_sorting_keyword'); ?></td>
              <td colspan="2">
                <?php foreach ($languages as $language) { ?>
                <div class="input-group">
                  <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                  <input type="text" class="form-control" placeholder="sort" name="mlseo_sort_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_sort_'.$language['language_id']})) echo ${'mlseo_sort_'.$language['language_id']}; ?>" />
                </div>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_order_keyword'); ?></td>
              <td colspan="2">
                <?php foreach ($languages as $language) { ?>
                <div class="input-group">
                  <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                  <input type="text" class="form-control" placeholder="asc|desc" name="mlseo_order_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_order_'.$language['language_id']})) echo ${'mlseo_order_'.$language['language_id']}; ?>" />
                </div>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_sortname_keyword'); ?></td>
              <td colspan="2">
                <?php foreach ($languages as $language) { ?>
                <div class="input-group">
                  <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                  <input type="text" class="form-control" placeholder="name|price|rating|model" name="mlseo_sortname_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_sortname_'.$language['language_id']})) echo ${'mlseo_sortname_'.$language['language_id']}; ?>" />
                </div>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_limit_keyword'); ?></td>
              <td colspan="2">
                <?php foreach ($languages as $language) { ?>
                <div class="input-group">
                  <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                  <input type="text" class="form-control" placeholder="limit" name="mlseo_limit_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_limit_'.$language['language_id']})) echo ${'mlseo_limit_'.$language['language_id']}; ?>" />
                </div>
                <?php } ?>
              </td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="tab-friendly-3">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_tag'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_tag" name="mlseo_tag" value="1" <?php if ($mlseo_tag) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_tag_keyword'); ?></td>
              <td colspan="2">
                <?php foreach ($languages as $language) { ?>
                <div class="input-group">
                  <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                  <input type="text" class="form-control" placeholder="tag" name="mlseo_fpp_tag_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_fpp_tag_'.$language['language_id']})) echo ${'mlseo_fpp_tag_'.$language['language_id']}; ?>" />
                </div>
                <?php } ?>
              </td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="tab-friendly-4">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_search'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_tag" name="mlseo_search" value="1" <?php if ($mlseo_search) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_search_keyword'); ?></td>
              <td colspan="2">
                <?php foreach ($languages as $language) { ?>
                <div class="input-group">
                  <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
                  <input type="text" class="form-control" placeholder="search" name="mlseo_fpp_search_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_fpp_search_'.$language['language_id']})) echo ${'mlseo_fpp_search_'.$language['language_id']}; ?>" />
                </div>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fix_search'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fix_search" id="mlseo_fix_search" value="1" <?php if (!empty($mlseo_fix_search)) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fix_search_help'); ?></td>
            </tr>
          </table>
        </div>
      </div>
		</div>
    
    <div class="tab-pane" id="tab-general-4">
      <table class="form">
        <?php if (!$store_id) { ?>
        <tr>
          <td style="width:250px;"><?php echo $_language->get('text_seo_whitespace'); ?></td>
          <td><input class="form-control" type="text" name="mlseo_whitespace" value="<?php echo $mlseo_whitespace; ?>" size="1" /></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $_language->get('text_seo_extension'); ?></td>
          <td><input class="form-control" type="text" name="mlseo_extension" value="<?php echo $mlseo_extension; ?>" size="7" placeholder=".html"/></td>
        </tr>
        <tr>
          <td><?php echo $_language->get('text_seo_extension_mode'); ?></td>
          <td>
            <select class="form-control" name="mlseo_extension_mode">
              <option value=""><?php echo $_language->get('text_ext_mode_all'); ?></option>
              <option value="nocat" <?php if ($mlseo_extension_mode == 'nocat') echo 'selected="selected"'; ?>><?php echo $_language->get('text_ext_mode_nocat'); ?></option>
            </select>
          </td>
        </tr>
        <tr>
          <td><?php echo $_language->get('text_safe_url_mode'); ?></td>
          <td>
            <select class="form-control" name="mlseo_safe_url">
              <option value=""><?php echo $_language->get('text_safe_url_min'); ?></option>
              <option value="ext" <?php if ($mlseo_safe_url == 'ext') echo 'selected="selected"'; ?>><?php echo $_language->get('text_safe_url_ext'); ?></option>
              <option value="max" <?php if ($mlseo_safe_url == 'max') echo 'selected="selected"'; ?>><?php echo $_language->get('text_safe_url_max'); ?></option>
            </select>
          </td>
        </tr>
        <?php if (!$store_id) { ?>
        <?php /* ?>
        <tr>
          <td><?php echo $_language->get('text_seo_delete'); ?></td>
          <td>
            <?php foreach ($languages as $language) { ?>
            <div class="input-group">
              <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
              <input type="text" class="form-control" name="mlseo_delete_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_delete_'.$language['language_id']})) echo ${'mlseo_delete_'.$language['language_id']}; ?>" placeholder="@|~|#|%"/>
            </div>
            <?php } ?>
          </td>
        </tr>
        <?php */ ?>
        <tr>
          <td><?php echo $_language->get('text_seo_remove'); ?></td>
          <td>
            <?php foreach ($languages as $language) { ?>
            <div class="input-group">
              <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
              <input type="text" class="form-control" name="mlseo_remove_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_remove_'.$language['language_id']})) echo ${'mlseo_remove_'.$language['language_id']}; ?>" placeholder="a,an,for,the,in,to"/>
            </div>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><?php echo $_language->get('text_seo_replace'); ?></td>
          <td>
            <?php foreach ($languages as $language) { ?>
            <div class="input-group">
              <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" alt=""/></span>
              <input type="text" class="form-control" name="mlseo_replace_<?php echo $language['language_id']; ?>" value="<?php if (!empty(${'mlseo_replace_'.$language['language_id']})) echo ${'mlseo_replace_'.$language['language_id']}; ?>" placeholder="&:and|%:percent|@:at|~|#"/>
            </div>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><?php echo $_language->get('text_seo_lowercase'); ?></td>
          <td><input class="switch" type="checkbox" id="mlseo_lowercase" name="mlseo_lowercase" value="1" <?php if ($mlseo_lowercase) echo 'checked="checked"'; ?> /></td>
        </tr>
        <tr>
          <td><?php echo $_language->get('text_seo_duplicate'); ?></td>
          <td><input class="switch" type="checkbox" id="mlseo_duplicate" name="mlseo_duplicate" value="1" <?php if ($mlseo_duplicate) echo 'checked="checked"'; ?> /></td>
        </tr>
        <tr>
          <td><?php echo $_language->get('text_seo_ascii'); ?></td>
            <td class="imgCheckbox">
              <?php foreach ($languages as $language) { ?>
              <img style="position:relative; bottom:12px; left:50px;" src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="checkbox" class="checkable" value="1" data-label="<?php echo $language['name']; ?>" id="mlseo_ascii_<?php echo $language['language_id']; ?>" name="mlseo_ascii_<?php echo $language['language_id']; ?>" <?php if ($_config->get('mlseo_ascii_'.$language['language_id'])) echo 'checked="checked"'; ?>/> <br />
              <?php } ?>
            </td>
        </tr>
        <tr class="info">
        <td><i class='fa fa-info'></i></td>
          <td style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_transform'); ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    
    <?php if (!$store_id) { ?>
    <div class="tab-pane" id="tab-general-5">
      <table class="form">
        <tr>
          <td><?php echo $_language->get('text_seo_autofill_desc'); ?></td>
          <td>
            <table class="table">
              <thead>
                <tr>
                  <th></th>
                  <th><?php echo $_language->get('text_insert'); ?></th>
                  <th><?php echo $_language->get('text_edit'); ?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_url'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautourl" value="1" <?php if (!empty($mlseo_insertautourl)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautourl" value="1" <?php if (!empty($mlseo_editautourl)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_title'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautoseotitle" value="1" <?php if (!empty($mlseo_insertautoseotitle)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautoseotitle" value="1" <?php if (!empty($mlseo_editautoseotitle)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_keyword'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautometakeyword" value="1" <?php if (!empty($mlseo_insertautometakeyword)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautometakeyword" value="1" <?php if (!empty($mlseo_editautometakeyword)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_description'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautometadesc" value="1" <?php if (!empty($mlseo_insertautometadesc)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautometadesc" value="1" <?php if (!empty($mlseo_editautometadesc)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-align-left gkd-badge cyan"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_full_desc'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautodesc" value="1" <?php if (!empty($mlseo_insertautodesc)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautodesc" value="1" <?php if (!empty($mlseo_editautodesc)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_h1'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautoh1" value="1" <?php if (!empty($mlseo_insertautoh1)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautoh1" value="1" <?php if (!empty($mlseo_editautoh1)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_h2'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautoh2" value="1" <?php if (!empty($mlseo_insertautoh2)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautoh2" value="1" <?php if (!empty($mlseo_editautoh2)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_h3'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautoh3" value="1" <?php if (!empty($mlseo_insertautoh3)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautoh3" value="1" <?php if (!empty($mlseo_editautoh3)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_image_title'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautoimgtitle" value="1" <?php if (!empty($mlseo_insertautoimgtitle)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautoimgtitle" value="1" <?php if (!empty($mlseo_editautoimgtitle)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_image_alt'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautoimgalt" value="1" <?php if (!empty($mlseo_insertautoimgalt)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautoimgalt" value="1" <?php if (!empty($mlseo_editautoimgalt)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_image_name'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautoimgname" value="1" <?php if (!empty($mlseo_insertautoimgname)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautoimgname" value="1" <?php if (!empty($mlseo_editautoimgname)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-tags gkd-badge cyan"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_tag'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautotags" value="1" <?php if (!empty($mlseo_insertautotags)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautotags" value="1" <?php if (!empty($mlseo_editautotags)) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><i class="fa fa-code-fork gkd-badge darkblue"></i> <?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_related'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_insert'); ?>" type="checkbox" name="mlseo_insertautorelated" value="1" <?php if (!empty($mlseo_insertautorelated)) echo 'checked="checked"'; ?> /></td>
                  <td><input class="checkable" data-label="<?php echo $_language->get('text_edit'); ?>" type="checkbox" name="mlseo_editautorelated" value="1" <?php if (!empty($mlseo_editautorelated)) echo 'checked="checked"'; ?> /></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td><?php echo $_language->get('text_seo_autotitle'); ?></td>
          <td class="multiple_switch">
            <div>
              <span> <?php echo $_language->get('text_insert'); ?></span>
              <input class="switch" type="checkbox" id="mlseo_insertautotitle" name="mlseo_insertautotitle" value="1" <?php if ($mlseo_insertautotitle) echo 'checked="checked"'; ?> />
            </div>
            <div>
              <span><?php echo $_language->get('text_edit'); ?></span>
              <input class="switch" type="checkbox" id="mlseo_editautotitle" name="mlseo_editautotitle" value="1" <?php if ($mlseo_editautotitle) echo 'checked="checked"'; ?> />
            </div>
          </td>
        </tr>
			</table>
    </div>
    <?php } ?>
    <div class="tab-pane" id="tab-general-7">
      <table class="form">
        <tr>
          <td><?php echo $_language->get('text_seo_urlcache'); ?></td>
          <td><!--input class="switch" type="checkbox" id="mlseo_cache" name="mlseo_cache" value="1" <?php if ($mlseo_cache) echo 'checked="checked"'; ?> /></td-->
          <td></td>
        </tr>
        <input type="hidden" id="mlseo_cache" name="mlseo_cache" value="" />
        <tr class="info">
          <td><i class='fa fa-info'></i></td>
          <td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_7'); ?></td>
        </tr>
      </table>
    </div>
    <div class="tab-pane" id="tab-general-8">
      <table class="form">
        <tr>
          <td><?php echo $_language->get('text_seo_canonical'); ?></td>
          <td><input class="switch" type="checkbox" id="mlseo_canonical" name="mlseo_canonical" value="1" <?php if ($mlseo_canonical) echo 'checked="checked"'; ?> /></td>
          <td></td>
        </tr>
        <tr class="info">
          <td><i class='fa fa-info'></i></td>
          <td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_8'); ?></td>
        </tr>
      </table>
    </div>
      <div class="tab-pane" id="tab-general-10">
        <table class="form">
          <tr>
            <td><?php echo $_language->get('text_seo_reviews'); ?></td>
            <td>
              <select class="form-control" name="mlseo_reviews">
                <option value=""><?php echo $_language->get('text_disabled'); ?></option>
                <option value="5" <?php if ($mlseo_reviews == '5') echo 'selected="selected"'; ?>>5</option>
                <option value="10" <?php if ($mlseo_reviews == '10') echo 'selected="selected"'; ?>>10</option>
                <option value="25" <?php if ($mlseo_reviews == '25') echo 'selected="selected"'; ?>>25</option>
                <option value="50" <?php if ($mlseo_reviews == '50') echo 'selected="selected"'; ?>>50</option>
                <option value="999" <?php if ($mlseo_reviews == '999') echo 'selected="selected"'; ?>><?php echo $_language->get('text_all'); ?></option>
              </select>
            <!--input class="switch" type="checkbox" id="mlseo_reviews" name="mlseo_reviews" value="1" <?php if ($mlseo_reviews) echo 'checked="checked"'; ?> /-->
            </td>
            <td></td>
          </tr>
          <tr>
            <td><?php echo $_language->get('text_seo_redir_reviews'); ?></td>
            <td><input class="switch" type="checkbox" id="mlseo_redir_reviews" name="mlseo_redir_reviews" value="1" <?php if ($mlseo_redir_reviews) echo 'checked="checked"'; ?> /></td>
            <td></td>
          </tr>
          <tr class="info">
            <td><i class='fa fa-info'></i></td>
            <td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_10'); ?></td>
          </tr>
        </table>
      </div>
      <div class="tab-pane" id="tab-general-11">
        <?php if ($journal3_active) { ?>
          <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> This function cannot be used with Journal 3</div>
        <?php } ?>
        <table class="form">
          <tr>
            <td><?php echo $_language->get('text_headers_lastmod'); ?></td>
            <td>
              <?php foreach (array('product', 'category') as $type) { ?>
              <input type="checkbox" class="checkable" value="1" data-label="<?php echo $_language->get('tab_seo_editor_'.$type); ?>" id="mlseo_header_lm_<?php echo $type; ?>" name="mlseo_header_lm_<?php echo $type; ?>" <?php if ($_config->get('mlseo_header_lm_'.$type)) echo 'checked="checked"'; ?> <?php if ($journal3_active) echo 'disabled'; ?>/> <br />
              <?php } ?>
            </td>
          </tr>
        </table>
        <div class="gkdwidget gkdwidget-color-blueDark">
          <header role="heading">
            <i class="icon fa fa-info-circle fa-2x pull-left"></i>
            <ul class="nav nav-tabs pull-left in">
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('tab_info_request'); ?></a></li>
            </ul>
          </header>
          <div class="gkdwidget-container" style="display:none">
            <div class="tab-content">
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_request'); ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="tab-general-12">
        <table class="form">
          <tr>
            <td><?php echo $_language->get('text_seopackage_sitemap'); ?></td>
            <td>
              <p><?php echo $_language->get('text_info_general_12'); ?></p>
              <p><a class="btn btn-primary" href="<?php echo $link_sitemap; ?>" target="_blank"><i class="fa fa-sitemap"></i> <?php echo $_language->get('text_seopackage_sitemap'); ?></a></p>
            </td>
          </tr>
        </table>
      </div>
      <div class="tab-pane" id="tab-general-13">
        <table class="form">
          <tr>
            <td><?php echo $_language->get('entry_robots'); ?>:</td>
            <td>
              <input type="checkbox" class="switch" value="1" id="mlseo_robots" name="mlseo_robots" <?php if ($mlseo_robots) echo 'checked="checked"'; ?>/> <br />
            </td>
          </tr>
          <?php foreach (array('product', 'category', 'information', 'account', 'checkout') as $type) { ?>
          <tr>
            <td><label class="control-label"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_robots_'.$type.'_i'); ?>" style="font-weight:normal;"><?php echo $_language->get('entry_robots_'.$type); ?></span></label></td>
            <td>
              <select class="form-control" name="mlseo_meta_robots[<?php echo $type; ?>]">
                <option value="" <?php if (isset($mlseo_meta_robots[$type]) && $mlseo_meta_robots[$type] == 'all') echo 'selected="selected"'; ?>>all</option>
                <option value="noindex" <?php if (isset($mlseo_meta_robots[$type]) && $mlseo_meta_robots[$type] == 'noindex') echo 'selected="selected"'; ?>>noindex, follow</option>
                <option value="nofollow" <?php if (isset($mlseo_meta_robots[$type]) && $mlseo_meta_robots[$type] == 'nofollow') echo 'selected="selected"'; ?>>index, nofollow</option>
                <option value="none" <?php if (isset($mlseo_meta_robots[$type]) && $mlseo_meta_robots[$type] == 'none') echo 'selected="selected"'; ?>>none</option>
                <option value="noimageindex" <?php if (isset($mlseo_meta_robots[$type]) && $mlseo_meta_robots[$type] == 'noimageindex') echo 'selected="selected"'; ?>>noimageindex</option>
              </select>
            </td>
          </tr>
          <?php } ?>
        </table>
        <div class="gkdwidget gkdwidget-color-blueDark">
          <header role="heading">
            <i class="icon fa fa-info-circle fa-2x pull-left"></i>
            <ul class="nav nav-tabs pull-left in">
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_seo_tab_general_13'); ?></a></li>
            </ul>
          </header>
          <div class="gkdwidget-container" style="display:none">
            <div class="tab-content">
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_robots'); ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="tab-general-18">
        <table class="table">
              <thead>
                <tr>
                  <th></th>
                  <th><?php echo $_language->get('text_heading_position'); ?><br /><span style="font-weight:normal"><?php echo $_language->get('text_heading_position_i'); ?></span></th>
                  <th><?php echo $_language->get('text_heading_css'); ?><br /><span style="font-weight:normal"><?php echo $_language->get('text_heading_css_i'); ?></span></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (array('product', 'category', 'information') as $type) { ?>
                <tr>
                  <td><label class="control-label"><?php echo $_language->get('tab_seo_editor_'.$type); ?></label></td>
                  <td>
                    <?php foreach (array('h1', 'h2', 'h3') as $headingType) { ?>
                      <div class="input-group">
                        <div class="input-group-addon"><?php echo strtoupper($headingType); ?></div>
                        <select class="form-control" name="mlseo_headings[<?php echo $type; ?>][<?php echo $headingType; ?>][pos]">
                          <option value="" <?php if (isset($mlseo_headings[$type][$headingType]['pos']) && $mlseo_headings[$type][$headingType]['pos'] == '') echo 'selected="selected"'; ?>><?php echo $_language->get('text_disabled'); ?></option>
                          <option value="man" <?php if (isset($mlseo_headings[$type][$headingType]['pos']) && $mlseo_headings[$type][$headingType]['pos'] == 'man') echo 'selected="selected"'; ?>><?php echo $_language->get('text_headings_manual'); ?></option>
                          <option value="topdesc" <?php if (isset($mlseo_headings[$type][$headingType]['pos']) && $mlseo_headings[$type][$headingType]['pos'] == 'topdesc') echo 'selected="selected"'; ?>><?php echo $_language->get('text_headings_topdesc'); ?></option>
                          <option value="botdesc" <?php if (isset($mlseo_headings[$type][$headingType]['pos']) && $mlseo_headings[$type][$headingType]['pos'] == 'botdesc') echo 'selected="selected"'; ?>><?php echo $_language->get('text_headings_botdesc'); ?></option>
                        </select>
                      </div>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach (array('h1', 'h2', 'h3') as $headingType) { ?>
                      <div class="input-group">
                        <div class="input-group-addon">CSS</div>
                        <input type="text" class="form-control" name="mlseo_headings[<?php echo $type; ?>][<?php echo $headingType; ?>][css]" value="<?php if (!empty($mlseo_headings[$type][$headingType]['css'])) echo $mlseo_headings[$type][$headingType]['css']; ?>" placeholder="color:#000; font-size:14px;"/>
                      </div>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
                
        <div class="gkdwidget gkdwidget-color-blueDark">
          <header role="heading">
            <i class="icon fa fa-info-circle fa-2x pull-left"></i>
            <ul class="nav nav-tabs pull-left in">
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_info_seo_titles_tab'); ?></a></li>
            </ul>
          </header>
          <div class="gkdwidget-container" style="display:none">
            <div class="tab-content">
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_seo_titles'); ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="tab-general-17">
        <table class="form">
          <tr>
            <td><?php echo $_language->get('entry_404_log'); ?></td>
            <td><input type="checkbox" class="switch" value="1" id="mlseo_404_log" name="mlseo_404_log" <?php if ($mlseo_404_log) echo 'checked="checked"'; ?>/></td>
          </tr>
          <tr>
            <td><?php echo $_language->get('entry_404_redir'); ?></td>
            <td><input type="checkbox" class="switch" value="1" id="mlseo_404_redir" name="mlseo_404_redir" <?php if ($mlseo_404_redir) echo 'checked="checked"'; ?>/></td>
          </tr>
          <tr>
            <td><?php echo $_language->get('entry_404_filter'); ?></td>
            <td><input type="text" class="form-control" value="<?php echo $mlseo_404_filter; ?>" id="mlseo_404_filter" name="mlseo_404_filter" /></td>
          </tr>
          <tr>
            <td><?php echo $_language->get('entry_404_filter_ext'); ?></td>
            <td><input type="text" class="form-control" value="<?php echo $mlseo_404_filter_ext; ?>" id="mlseo_404_filter_ext" name="mlseo_404_filter_ext" placeholder="jpg|png|txt|js" /></td>
          </tr>
        </table>
        <div class="gkdwidget gkdwidget-color-blueDark">
          <header role="heading">
            <i class="icon fa fa-info-circle fa-2x pull-left"></i>
            <ul class="nav nav-tabs pull-left in">
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_seo_tab_general_17'); ?></a></li>
            </ul>
          </header>
          <div class="gkdwidget-container" style="display:none">
            <div class="tab-content">
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_404_options'); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="clear:both"></div>
  </div>
    
		<div class="tab-pane <?php echo $currentTab == 'tab-store' ? 'active' : '' ?>" id="tab-store">
			  <ul id="language-<?php echo $store_id; ?>" class="nav nav-tabs">
				<?php $first=0; foreach ($languages as $language) { ?>
				<li<?php if (!$first) { echo ' class="active"'; $first=1;} ?>><a href="#tab-language-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['image']; ?>" alt=""/> <?php echo $language['name']; ?></a></li>
				<?php } ?>
			  </ul>
				<div class="tab-content">
			  <?php $first=0; foreach ($languages as $language) { ?>
			  <div id="tab-language-<?php echo $store_id; ?>-<?php echo $language['language_id']; ?>" class="tab-pane<?php if (!$first) { echo ' active'; $first=1;} ?>">
        <fieldset>
          <legend><?php echo $_language->get('store_seo_global'); ?></legend>
          <table class="form">
            <tr>
              <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('entry_store_seo_title_extra'); ?></td>
              <td>
                <input type="text" class="form-control store_seo_title" name="mlseo_title_prefix[<?php echo $store_id . $language['language_id']; ?>]" value="<?php echo isset($mlseo_title_prefix[$store_id.$language['language_id']]) ? $mlseo_title_prefix[$store_id.$language['language_id']] : ''; ?>" placeholder="<?php echo $_language->get('seo_title_prefix'); ?>"/></td>
                <td class="text-center"><?php echo $_language->get('text_seo_mode_title'); ?></td>
                <td><input type="text" class="form-control store_seo_title" name="mlseo_title_suffix[<?php echo $store_id . $language['language_id']; ?>]" value="<?php echo isset($mlseo_title_suffix[$store_id.$language['language_id']]) ? $mlseo_title_suffix[$store_id.$language['language_id']] : ''; ?>" placeholder="<?php echo $_language->get('seo_title_suffix'); ?>"/>
              </td>
            </tr>
          </table>
        </fieldset>
        <fieldset style="margin-top:35px">
          <legend><?php echo $_language->get('store_seo_home'); ?></legend>
          <table class="form">
            <tr>
              <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('entry_store_seo_title'); ?></td>
              <td><input type="text" class="form-control store_seo_title" name="mlseo_store[<?php echo $store_id . $language['language_id']; ?>][seo_title]" value="<?php echo isset($mlseo_store[$store_id.$language['language_id']]['seo_title']) ? $mlseo_store[$store_id.$language['language_id']]['seo_title'] : ''; ?>"/></td>
            </tr>
            <tr>
              <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('entry_store_desc'); ?></td>
              <td><textarea class="form-control store_seo_desc" name="mlseo_store[<?php echo $store_id . $language['language_id']; ?>][description]" cols="60" rows="6"><?php echo isset($mlseo_store[$store_id.$language['language_id']]['description']) ? $mlseo_store[$store_id.$language['language_id']]['description'] : ''; ?></textarea></td>
            </tr>
            <tr>
              <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('entry_store_keywords'); ?></td>
              <td><textarea class="form-control" name="mlseo_store[<?php echo $store_id . $language['language_id']; ?>][keywords]" cols="60" rows="6"><?php echo isset($mlseo_store[$store_id.$language['language_id']]['keywords']) ? $mlseo_store[$store_id.$language['language_id']]['keywords'] : ''; ?></textarea></td>
            </tr>
            <tr>
              <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('entry_store_title'); ?></td>
              <td><input type="text" class="form-control" name="mlseo_store[<?php echo $store_id . $language['language_id']; ?>][title]" value="<?php echo isset($mlseo_store[$store_id.$language['language_id']]['title']) ? $mlseo_store[$store_id.$language['language_id']]['title'] : ''; ?>" size="63" placeholder="<?php echo $_language->get('info_store_heading'); ?>"/></td>
            </tr>
            <tr>
              <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('entry_store_h2'); ?></td>
              <td><input type="text" class="form-control" name="mlseo_store[<?php echo $store_id . $language['language_id']; ?>][h2]" value="<?php echo isset($mlseo_store[$store_id.$language['language_id']]['h2']) ? $mlseo_store[$store_id.$language['language_id']]['h2'] : ''; ?>" size="63" placeholder="<?php echo $_language->get('info_store_heading'); ?>"/></td>
            </tr>
            <tr>
              <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('entry_store_h3'); ?></td>
              <td><input type="text" class="form-control" name="mlseo_store[<?php echo $store_id . $language['language_id']; ?>][h3]" value="<?php echo isset($mlseo_store[$store_id.$language['language_id']]['h3']) ? $mlseo_store[$store_id.$language['language_id']]['h3'] : ''; ?>" size="63" placeholder="<?php echo $_language->get('info_store_heading'); ?>"/></td>
            </tr>
          </table>
        </fieldset>
			  </div>
			  <?php } ?>
			</div>
      <div>&nbsp;
        <div class="gkdwidget gkdwidget-color-blueDark">
          <header role="heading">
            <i class="icon fa fa-info-circle fa-2x pull-left"></i>
            <ul class="nav nav-tabs pull-left in">
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('tab_seo_store'); ?></a></li>
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_info_seo_titles_tab'); ?></a></li>
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('entry_robots'); ?></a></li>
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_info_limits_tab'); ?></a></li>
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_info_analytics_tab'); ?></a></li>
            </ul>
          </header>
          <div class="gkdwidget-container" style="display:none">
            <div class="tab-content">
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_store'); ?></div>
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_seo_titles'); ?></div>
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_robots'); ?></div>
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_limits'); ?></div>
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_analytics'); ?></div>
            </div>
          </div>
        </div>
      </div>
		</div>
    
    <div class="tab-pane <?php echo $currentTab == 'tab-analytics' ? 'active' : '' ?>" id="tab-analytics">
      <table class="form">
        <tr>
          <td><i class="fa fa-google gkd-badge purple"></i> <?php echo $_language->get('entry_gg_components'); ?></td>
          <td>
            <?php foreach (array('gg_analytics', 'gg_enhanced', 'gg_adwords') as $type) { ?>
            <input type="checkbox" class="checkable" value="1" data-label="<?php echo $_language->get('text_'.$type); ?>" name="mlseo_store[<?php echo $store_id; ?>][<?php echo $type; ?>]" id="mlseo_store_<?php echo $type; ?>" <?php if (!empty($mlseo_store[$store_id][$type])) echo 'checked="checked"'; ?>/> <br />
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><i class="fa fa-google gkd-badge purple"></i> <?php echo $_language->get('entry_analytics_code'); ?></td>
          <td><input type="text" class="form-control" name="mlseo_store[<?php echo $store_id; ?>][analytics]" value="<?php echo isset($mlseo_store[$store_id]['analytics']) ? $mlseo_store[$store_id]['analytics'] : ''; ?>" placeholder="G-123456789"/></td>
        </tr>
        <tr>
          <td><i class="fa fa-google gkd-badge purple"></i> <?php echo $_language->get('entry_adwords_code'); ?></td>
          <td><input type="text" class="form-control" name="mlseo_store[<?php echo $store_id; ?>][adwords]" value="<?php echo isset($mlseo_store[$store_id]['adwords']) ? $mlseo_store[$store_id]['adwords'] : ''; ?>" placeholder="AW-12345678"/></td>
        </tr>
      </table>
      <div>&nbsp;
        <div class="gkdwidget gkdwidget-color-blueDark">
          <header role="heading">
            <i class="icon fa fa-info-circle fa-2x pull-left"></i>
            <ul class="nav nav-tabs pull-left in">
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_info_analytics4_tab'); ?></a></li>
              <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_info_analytics_tab'); ?></a></li>
            </ul>
          </header>
          <div class="gkdwidget-container" style="display:none">
            <div class="tab-content">
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_analytics4'); ?></div>
              <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('text_info_analytics'); ?></div>
            </div>
          </div>
        </div>
      </div>
		</div>
    
    <div class="tab-pane <?php echo $currentTab == 'tab-snippet' ? 'active' : '' ?>" id="tab-snippet">
      <ul class="nav nav-pills nav-stacked col-md-2">
				<li class="active"><a href="#tab-snippet-1" data-toggle="pill"><i class="fa fa-google"></i> <?php echo $_language->get('text_seo_tab_snippet_1'); ?></a></li>
				<?php /*<li><a href="#tab-snippet-4" data-toggle="pill"><i class="fa fa-google"></i> <?php echo $_language->get('text_seo_tab_snippet_4'); ?></a></li>*/ ?>
				<li><a href="#tab-snippet-2" data-toggle="pill"><i class="fa fa-facebook-square"></i> <?php echo $_language->get('text_seo_tab_snippet_2'); ?></a></li>
				<li><a href="#tab-snippet-5" data-toggle="pill"><i class="fa fa-facebook-square"></i> <?php echo $_language->get('text_seo_tab_snippet_5'); ?></a></li>
				<li><a href="#tab-snippet-3" data-toggle="pill"><i class="fa fa-twitter"></i> <?php echo $_language->get('text_seo_tab_snippet_3'); ?></a></li>
			</ul>
			<div class="tab-content col-md-10">
				<div class="tab-pane active" id="tab-snippet-1">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('entry_enable_microdata'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_microdata" name="mlseo_microdata" value="1" <?php if ($mlseo_microdata) echo 'checked="checked"'; ?> /></td>
            </tr>
          </table>
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-microdata-1" data-toggle="tab"><?php echo $_language->get('tab_microdata_1'); ?></a></li>
            <li><a href="#tab-microdata-7" data-toggle="tab"><?php echo $_language->get('tab_microdata_7'); ?></a></li>
            <li><a href="#tab-microdata-2" data-toggle="tab"><?php echo $_language->get('tab_microdata_2'); ?></a></li>
            <li><a href="#tab-microdata-3" data-toggle="tab"><?php echo $_language->get('tab_microdata_3'); ?></a></li>
            <li><a href="#tab-microdata-4" data-toggle="tab"><?php echo $_language->get('tab_microdata_4'); ?></a></li>
            <li><a href="#tab-microdata-5" data-toggle="tab"><?php echo $_language->get('tab_microdata_5'); ?></a></li>
            <li><a href="#tab-microdata-6" data-toggle="tab"><?php echo $_language->get('tab_microdata_6'); ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-microdata-1">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_product" name="mlseo_microdata_data[product]" value="1" <?php if (!empty($mlseo_microdata_data['product'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td class="checkboxinline">
                    <?php foreach (array('model','brand','reviews','sku','upc','mpn','ean','isbn') as $rstype) { ?>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_'.$rstype); ?>" type="checkbox" name="mlseo_microdata_data[<?php echo $rstype; ?>]" value="1" <?php if (!empty($mlseo_microdata_data[$rstype])) echo 'checked="checked"'; ?> />
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_order_status'); ?></td>
                  <td colspan="2" class="form-horizontal">
                    <?php foreach ($stock_statuses as $stock_status) { ?>
                    <div class="form-group" style="border:0; padding: 5px 0;">
                      <label class="col-sm-2 control-label"><?php echo $stock_status['name']; ?></label>
                      <div class="col-sm-10">
                        <select class="form-control" name="mlseo_microdata_data[order_status][<?php echo $stock_status['stock_status_id']; ?>]">
                          <option value=""><?php echo $_language->get('text_disabled'); ?></option>
                          <?php foreach (array('InStock','InStoreOnly','LimitedAvailability','OnlineOnly','OutOfStock','Discontinued','PreOrder','PreSale','SoldOut') as $mdStock) { ?>
                            <option value="<?php echo $mdStock; ?>" <?php if (isset($mlseo_microdata_data['order_status'][$stock_status['stock_status_id']]) && $mlseo_microdata_data['order_status'][$stock_status['stock_status_id']] == $mdStock) echo 'selected="selected"'; ?>><?php echo $mdStock; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <?php } ?>
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-2">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_organization" name="mlseo_microdata_data[organization]" value="1" <?php if (!empty($mlseo_microdata_data['organization'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_microdata_search'); ?>" type="checkbox" id="mlseo_microdata_data_org_search" name="mlseo_microdata_data[organization_search]" value="1" <?php if (!empty($mlseo_microdata_data['organization_search'])) echo 'checked="checked"'; ?> /><br />
                  </td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_contact'); ?></td>
                  <td>
                    <div class="input-group" style="width:100%">
                      <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                      <input style="width:60%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_phone'); ?>" name="mlseo_microdata_data[contact][0][phone]" value="<?php if (!empty($mlseo_microdata_data['contact'][0]['phone'])) echo $mlseo_microdata_data['contact'][0]['phone']; ?>" />
                      <select class="form-control" name="mlseo_microdata_data[contact][0][type]" style="width:40%">
                        <?php foreach (array('customer support', 'technical support', 'billing support', 'bill payment', 'sales', 'reservations', 'credit card support', 'emergency', 'baggage tracking', 'roadside assistance', 'package tracking') as $mdc_type) { ?>
                        <option value="<?php echo $mdc_type; ?>" <?php if (!empty($mlseo_microdata_data['contact'][0]['type']) && $mlseo_microdata_data['contact'][0]['type'] == $mdc_type) echo 'selected="selected"'; ?>><?php echo ucfirst($mdc_type); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="input-group" style="width:100%; margin-top:10px;">
                      <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                      <input style="width:60%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_phone'); ?>" name="mlseo_microdata_data[contact][1][phone]" value="<?php if (!empty($mlseo_microdata_data['contact'][1]['phone'])) echo $mlseo_microdata_data['contact'][1]['phone']; ?>" />
                      <select class="form-control" name="mlseo_microdata_data[contact][1][type]" style="width:40%">
                        <?php foreach (array('customer support', 'technical support', 'billing support', 'bill payment', 'sales', 'reservations', 'credit card support', 'emergency', 'baggage tracking', 'roadside assistance', 'package tracking') as $mdc_type) { ?>
                        <option value="<?php echo $mdc_type; ?>" <?php if (!empty($mlseo_microdata_data['contact'][1]['type']) && $mlseo_microdata_data['contact'][1]['type'] == $mdc_type) echo 'selected="selected"'; ?>><?php echo ucfirst($mdc_type); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="input-group" style="width:100%; margin-top:10px;">
                      <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                      <input style="width:60%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_phone'); ?>" name="mlseo_microdata_data[contact][2][phone]" value="<?php if (!empty($mlseo_microdata_data['contact'][2]['phone'])) echo $mlseo_microdata_data['contact'][2]['phone']; ?>" />
                      <select class="form-control" name="mlseo_microdata_data[contact][2][type]" style="width:40%">
                        <?php foreach (array('customer support', 'technical support', 'billing support', 'bill payment', 'sales', 'reservations', 'credit card support', 'emergency', 'baggage tracking', 'roadside assistance', 'package tracking') as $mdc_type) { ?>
                        <option value="<?php echo $mdc_type; ?>" <?php if (!empty($mlseo_microdata_data['contact'][2]['type']) && $mlseo_microdata_data['contact'][2]['type'] == $mdc_type) echo 'selected="selected"'; ?>><?php echo ucfirst($mdc_type); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-3">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_store" name="mlseo_microdata_data[store]" value="1" <?php if (!empty($mlseo_microdata_data['store'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_microdata_logo'); ?>" type="checkbox" id="mlseo_microdata_data_store_logo" name="mlseo_microdata_data[store_logo]" value="1" <?php if (!empty($mlseo_microdata_data['store_logo'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_email'); ?>" type="checkbox" id="mlseo_microdata_data_store_mail" name="mlseo_microdata_data[store_mail]" value="1" <?php if (!empty($mlseo_microdata_data['store_mail'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_phone'); ?>" type="checkbox" id="mlseo_microdata_data_store_phone" name="mlseo_microdata_data[store_phone]" value="1" <?php if (!empty($mlseo_microdata_data['store_phone'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_microdata_address'); ?>" type="checkbox" id="mlseo_microdata_data_address" name="mlseo_microdata_data[address]" value="1" <?php if (!empty($mlseo_microdata_data['address'])) echo 'checked="checked"'; ?> /><br />
                  </td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_microdata_address'); ?></td>
                  <td>
                    <input type="text" class="form-control" placeholder="<?php echo $_language->get('entry_address_street'); ?>" name="mlseo_microdata_data[address_street]" value="<?php if (!empty($mlseo_microdata_data['address_street'])) echo $mlseo_microdata_data['address_street']; ?>" />
                    <input type="text" style="margin-top:10px;" class="form-control" placeholder="<?php echo $_language->get('entry_address_city'); ?>" name="mlseo_microdata_data[address_city]" value="<?php if (!empty($mlseo_microdata_data['address_city'])) echo $mlseo_microdata_data['address_city']; ?>" />
                    <input type="text" style="margin-top:10px;" class="form-control" placeholder="<?php echo $_language->get('entry_address_region'); ?>" name="mlseo_microdata_data[address_region]" value="<?php if (!empty($mlseo_microdata_data['address_region'])) echo $mlseo_microdata_data['address_region']; ?>" />
                    <input type="text" style="margin-top:10px;" class="form-control" placeholder="<?php echo $_language->get('entry_address_code'); ?>" name="mlseo_microdata_data[address_code]" value="<?php if (!empty($mlseo_microdata_data['address_code'])) echo $mlseo_microdata_data['address_code']; ?>" />
                    <input type="text" style="margin-top:10px;" class="form-control" placeholder="<?php echo $_language->get('entry_address_country'); ?>" name="mlseo_microdata_data[address_country]" value="<?php if (!empty($mlseo_microdata_data['address_country'])) echo $mlseo_microdata_data['address_country']; ?>" />
                  </td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_same_as'); ?></td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://twitter.com/MyStore" name="mlseo_microdata_data[same_as][0]" value="<?php if (!empty($mlseo_microdata_data['same_as'][0])) echo $mlseo_microdata_data['same_as'][0]; ?>" />
                    </div>
                    <div class="input-group" style="margin-top:10px">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://www.pinterest.com/MyStore" name="mlseo_microdata_data[same_as][1]" value="<?php if (!empty($mlseo_microdata_data['same_as'][1])) echo $mlseo_microdata_data['same_as'][1]; ?>" />
                    </div>
                    <div class="input-group" style="margin-top:10px">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://www.facebook.com/MyStore" name="mlseo_microdata_data[same_as][2]" value="<?php if (!empty($mlseo_microdata_data['same_as'][2])) echo $mlseo_microdata_data['same_as'][2]; ?>" />
                    </div>
                    <div class="input-group" style="margin-top:10px">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://www.linkedin.com/MyStore" name="mlseo_microdata_data[same_as][3]" value="<?php if (!empty($mlseo_microdata_data['same_as'][3])) echo $mlseo_microdata_data['same_as'][3]; ?>" />
                    </div>
                    <div class="input-group" style="margin-top:10px">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://www.foursquare.com/MyStore" name="mlseo_microdata_data[same_as][5]" value="<?php if (!empty($mlseo_microdata_data['same_as'][5])) echo $mlseo_microdata_data['same_as'][5]; ?>" />
                    </div>
                    <div class="input-group" style="margin-top:10px">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://www.yelp.com/MyStore" name="mlseo_microdata_data[same_as][6]" value="<?php if (!empty($mlseo_microdata_data['same_as'][6])) echo $mlseo_microdata_data['same_as'][6]; ?>" />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_pricerange'); ?></td>
                  <td>
                    <select class="form-control" name="mlseo_microdata_data[pricerange]">
                      <?php foreach (array('','$','$$','$$$','$$$$','$$$$$') as $pricerange) { ?>
                      <option value="<?php echo $pricerange; ?>" <?php if (isset($mlseo_microdata_data['pricerange']) && $mlseo_microdata_data['pricerange'] == $pricerange) echo 'selected="selected"'; ?>><?php echo $pricerange ? $pricerange : $_language->get('text_disabled'); ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-4">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_website" name="mlseo_microdata_data[website]" value="1" <?php if (!empty($mlseo_microdata_data['website'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_microdata_search'); ?>" type="checkbox" id="mlseo_microdata_data_websearch" name="mlseo_microdata_data[website_search]" value="1" <?php if (!empty($mlseo_microdata_data['website_search'])) echo 'checked="checked"'; ?> /><br />
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-5">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_place" name="mlseo_microdata_data[place]" value="1" <?php if (!empty($mlseo_microdata_data['place'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_microdata_gps'); ?></td>
                  <td>
                    <div class="input-group" style="width:100%;">
                      <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                      <input style="width:50%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_gps_lat'); ?>" name="mlseo_microdata_data[gps_lat]" value="<?php if (!empty($mlseo_microdata_data['gps_lat'])) echo $mlseo_microdata_data['gps_lat']; ?>" />
                      <input style="width:50%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_gps_long'); ?>" name="mlseo_microdata_data[gps_long]" value="<?php if (!empty($mlseo_microdata_data['gps_long'])) echo $mlseo_microdata_data['gps_long']; ?>" />
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-6">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_breadcrumbs" name="mlseo_microdata_data[breadcrumbs]" value="1" <?php if (!empty($mlseo_microdata_data['breadcrumbs'])) echo 'checked="checked"'; ?> /></td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-7">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_category" name="mlseo_microdata_data[category]" value="1" <?php if (!empty($mlseo_microdata_data['category'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td class="checkboxinline">
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> <?php echo $_language->get('entry_cat_reviews_i'); ?></div>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_cat_reviews'); ?>" type="checkbox" name="mlseo_microdata_data[cat_reviews]" value="1" <?php if (!empty($mlseo_microdata_data['cat_reviews'])) echo 'checked="checked"'; ?> />
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div>
            <div class="gkdwidget gkdwidget-color-blueDark" data-widget-fullscreenbutton="true">
              <header role="heading">
                <i class="icon fa fa-info-circle fa-2x pull-left"></i>
                <ul class="nav nav-tabs pull-left in">
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('text_seo_tab_snippet_1'); ?></a></li>
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('tab_faq'); ?></a></li>
                </ul>
              </header>
              <div class="gkdwidget-container" style="display:none">
                <div class="tab-content">
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_microdata'); ?></div>
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_microdata_faq'); ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
				<div class="tab-pane" id="tab-snippet-2">
					<table class="form">
						<tr>
              <td><?php echo $_language->get('entry_enable_opengraph'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_opengraph" name="mlseo_opengraph" value="1" <?php if ($mlseo_opengraph) echo 'checked="checked"'; ?> /></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_opengraph_id'); ?></td>
              <td>
                <input type="text" class="form-control" placeholder="111122223333444" name="mlseo_opengraph_data[page_id]" value="<?php if (!empty($mlseo_opengraph_data['page_id'])) echo $mlseo_opengraph_data['page_id']; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_product_data'); ?></td>
              <td>
                <input class="checkable" data-label="<?php echo $_language->get('entry_description'); ?>" type="checkbox" id="mlseo_opengraph_data_desc" name="mlseo_opengraph_data[desc]" value="1" <?php if (!empty($mlseo_opengraph_data['desc'])) echo 'checked="checked"'; ?> />
              </td>
            </tr>
          </table>
          <div>
            <div class="gkdwidget gkdwidget-color-blueDark" data-widget-fullscreenbutton="true">
              <header role="heading">
                <!--div class="gkdwidget-ctrls"><a href="javascript:void(0);" class="button-icon gkdwidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand"></i></a></div-->
                <i class="icon fa fa-info-circle fa-2x pull-left"></i>
                <ul class="nav nav-tabs pull-left in">
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('help_fb_appid_tab'); ?></a></li>
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('help_fb_setup_tab'); ?></a></li>
                </ul>
              </header>
              <div class="gkdwidget-container" style="display:none">
                <div class="tab-content">
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_fb_appid'); ?></div>
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_fb_setup'); ?></div>
                </div>
              </div>
            </div>
          </div>
				</div>
        <div class="tab-pane" id="tab-snippet-5">
					<table class="form">
            <tr>
              <td><?php echo $_language->get('entry_facebook_pixel'); ?></td>
              <td>
                <textarea class="form-control" placeholder="Paste facebook pixel code here" name="mlseo_fb_pixel" style="height:280px"><?php if (!empty($mlseo_fb_pixel)) echo $mlseo_fb_pixel; ?></textarea>
              </td>
            </tr>
          </table>
          <div>
            <div class="gkdwidget gkdwidget-color-blueDark" data-widget-fullscreenbutton="true">
              <header role="heading">
                <!--div class="gkdwidget-ctrls"><a href="javascript:void(0);" class="button-icon gkdwidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand"></i></a></div-->
                <i class="icon fa fa-info-circle fa-2x pull-left"></i>
                <ul class="nav nav-tabs pull-left in">
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('help_fb_pixel_tab'); ?></a></li>
                  <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><?php echo $_language->get('help_fb_pixel2_tab'); ?></a></li>
                </ul>
              </header>
              <div class="gkdwidget-container" style="display:none">
                <div class="tab-content">
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_fb_pixel'); ?></div>
                  <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_fb_pixel2'); ?></div>
                </div>
              </div>
            </div>
          </div>
				</div>
        <div class="tab-pane" id="tab-snippet-3">
					<table class="form">
						<tr>
              <td><?php echo $_language->get('entry_enable_tcard'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_tcard" name="mlseo_tcard" value="1" <?php if ($mlseo_tcard) echo 'checked="checked"'; ?> /></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_twitter_nick'); ?></td>
              <td>
                <input type="text" class="form-control" placeholder="@nickname" name="mlseo_tcard_data[nick]" value="<?php if (!empty($mlseo_tcard_data['nick'])) echo $mlseo_tcard_data['nick']; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_twitter_home_type'); ?></td>
              <td>
                <select class="form-control" name="mlseo_tcard_data[home_type]">
                  <option value="summary" <?php if (!empty($mlseo_tcard_data['home_type']) && $mlseo_tcard_data['home_type'] == 'summary') echo 'selected="selected"'; ?>><?php echo $_language->get('entry_twitter_summary'); ?></option>
                  <option value="summary_large_image" <?php if (!empty($mlseo_tcard_data['home_type']) && $mlseo_tcard_data['home_type'] == 'summary_large_image') echo 'selected="selected"'; ?>><?php echo $_language->get('entry_twitter_summary_large'); ?></option>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_product_data'); ?></td>
              <td>
                <input class="checkable" data-label="<?php echo $_language->get('entry_description'); ?>" type="checkbox" id="mlseo_tcard_data_desc" name="mlseo_tcard_data[desc]" value="1" <?php if (!empty($mlseo_tcard_data['desc'])) echo 'checked="checked"'; ?> />
              </td>
            </tr>
          </table>
				</div>
        <?php /*
         <div class="tab-pane" id="tab-snippet-4">
					<table class="form">
						<tr>
              <td><?php echo $_language->get('entry_enable_gpublisher'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_gpublisher" name="mlseo_gpublisher" value="1" <?php if ($mlseo_gpublisher) echo 'checked="checked"'; ?> /></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_gpublisher_url'); ?></td>
              <td>
                <input type="text" class="form-control" placeholder="https://plus.google.com/my_google_plus/" name="mlseo_gpublisher_data[url]" value="<?php if (!empty($mlseo_gpublisher_data['url'])) echo $mlseo_gpublisher_data['url']; ?>" />
              </td>
            </tr>
          </table>
				</div>
        */ ?>
      </div>
      <div style="clear:both"></div>
		</div>
		
    <?php if (!$store_id) { ?>
    <div class="tab-pane <?php echo $currentTab == 'tab-fpp' ? 'active' : '' ?>" id="tab-fpp">
      <!-- start fpp -->
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-fpp-1" data-toggle="tab"><?php echo $_language->get('tab_fpp_product'); ?></a></li>
        <li><a href="#tab-fpp-2" data-toggle="tab"><?php echo $_language->get('tab_fpp_category'); ?></a></li>
        <li><a href="#tab-fpp-3" data-toggle="tab"><?php echo $_language->get('tab_fpp_manufacturer'); ?></a></li>
        <li><a href="#tab-fpp-4" data-toggle="tab"><?php echo $_language->get('tab_fpp_search'); ?></a></li>
        <li><a href="#tab-fpp-5" data-toggle="tab"><?php echo $_language->get('tab_fpp_common'); ?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab-fpp-1">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_mode'); ?></td>
              <td>
                <select name="mlseo_fpp_mode" class="form-control">
                  <option value="0" <?php if ($mlseo_fpp_mode == '0') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_0'); ?></option>
                  <option value="1" <?php if ($mlseo_fpp_mode == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_1'); ?></option>
                  <option value="2" <?php if ($mlseo_fpp_mode == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_2'); ?></option>
                  <option value="4" <?php if ($mlseo_fpp_mode == '4') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_4'); ?></option>
                  <option value="3" <?php if ($mlseo_fpp_mode == '3') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_3'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_mode_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_depth'); ?></td>
              <td>
                <select name="mlseo_fpp_depth" class="form-control">
                  <option value="0" <?php if ($mlseo_fpp_depth == '0') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_unlimited'); ?></option>
                  <option value="1" <?php if ($mlseo_fpp_depth == '1') echo 'selected="selected"'; ?>>1</option>
                  <option value="2" <?php if ($mlseo_fpp_depth == '2') echo 'selected="selected"'; ?>>2</option>
                  <option value="3" <?php if ($mlseo_fpp_depth == '3') echo 'selected="selected"'; ?>>3</option>
                  <option value="4" <?php if ($mlseo_fpp_depth == '4') echo 'selected="selected"'; ?>>4</option>
                  <option value="5" <?php if ($mlseo_fpp_depth == '5') echo 'selected="selected"'; ?>>5</option>
                  <option value="6" <?php if ($mlseo_fpp_depth == '6') echo 'selected="selected"'; ?>>6</option>
                  <option value="7" <?php if ($mlseo_fpp_depth == '7') echo 'selected="selected"'; ?>>7</option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_depth_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_breadcrumbs_fix'); ?></td>
              <td>
                <select name="mlseo_fpp_breadcrumbs" class="form-control">
                  <option value="0" <?php if ($mlseo_fpp_breadcrumbs == '0') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_breadcrumbs_0'); ?></option>
                  <option value="1" <?php if ($mlseo_fpp_breadcrumbs == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_breadcrumbs_1'); ?></option>
                  <option value="2" <?php if ($mlseo_fpp_breadcrumbs == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_breadcrumbs_2'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_breadcrumbs_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_bc_mode'); ?></td>
              <td>
                <select name="mlseo_fpp_bc_mode" class="form-control">
                  <option value="0" <?php if ($mlseo_fpp_bc_mode == '0') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_0'); ?></option>
                  <option value="1" <?php if ($mlseo_fpp_bc_mode == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_1'); ?></option>
                  <option value="2" <?php if ($mlseo_fpp_bc_mode == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_2'); ?></option>
                  <option value="4" <?php if ($mlseo_fpp_bc_mode == '4') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_4'); ?></option>
                  <option value="3" <?php if ($mlseo_fpp_bc_mode == '3') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_3'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_mode_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_noprodbreadcrumb'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fpp_noprodbreadcrumb" id="mlseo_fpp_noprodbreadcrumb" value="1" <?php if ($mlseo_fpp_noprodbreadcrumb) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_noprodbreadcrumb_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_bypasscat'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fpp_bypasscat" id="mlseo_fpp_bypasscat" value="1" <?php if ($mlseo_fpp_bypasscat) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_bypasscat_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_category'); ?></td>
              <td colspan="2">
                <input type="text" name="category" value="" placeholder="<?php echo $_language->get('placeholder_category'); ?>" id="input-category" class="form-control" />
                <div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
                  <?php foreach ($categories as $product_category) { ?>
                    <?php if (in_array($product_category['category_id'],(array) $mlseo_fpp_categories)) { ?>
                    <div id="mlseo_fpp_categories<?php echo $product_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
                      <input type="hidden" name="mlseo_fpp_categories[]" value="<?php echo $product_category['category_id']; ?>" />
                    </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              </td>
            </tr>
            <?php /* changed to autocomplete for performance
            <tr>
              <td><?php echo $_language->get('entry_category'); ?></td>
              <td colspan="2"><div class="scrollbox" style="width:90%;height:350px">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($category['category_id'],(array) $mlseo_fpp_categories)) { ?>
                    <input type="checkbox" name="mlseo_fpp_categories[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="mlseo_fpp_categories[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $_language->get('text_select_all'); ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $_language->get('text_unselect_all'); ?></a></td>
            </tr>
            */ ?>
          </table>
        </div>
        <div class="tab-pane" id="tab-fpp-2">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_directcat'); ?></td>
              <td style="width:220px">
                <select name="mlseo_fpp_directcat" class="form-control">
                  <option value="1" <?php if ($mlseo_fpp_directcat == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_cat_mode_0'); ?></option>
                  <option value="" <?php if (!$mlseo_fpp_directcat) echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_cat_mode_1'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_directcat_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_cat_canonical'); ?></td>
              <td>
                <select name="mlseo_fpp_cat_canonical" class="form-control">
                  <option value="" <?php if (!$mlseo_fpp_cat_canonical) echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_cat_mode_0'); ?></option>
                  <option value="1" <?php if ($mlseo_fpp_cat_canonical == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_cat_mode_1'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_cat_canonical_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_absolute'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_absolute" name="mlseo_absolute" value="1" <?php if ($mlseo_absolute) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_seo_absolute_help'); ?></td>
            </tr>
          </table>
          <script type="text/javascript">
            $('select[name=mlseo_fpp_directcat]').change(function(){
              $('select[name=mlseo_fpp_cat_canonical]').prop('disabled', $(this).val());
              if ($(this).val()) {
                $('select[name=mlseo_fpp_cat_canonical]').val('');
              }
            });
            $('select[name=mlseo_fpp_directcat]').change();
            
            $('select[name=mlseo_fpp_mode]').change(function(){
              if ($(this).val() == 1 || $(this).val() == 2) {
                $('select[name=mlseo_fpp_depth]').prop('disabled', false);
              } else {
                $('select[name=mlseo_fpp_depth]').prop('disabled', true);
              }
            });
            $('select[name=mlseo_fpp_mode]').change();
          </script>
        </div>
        <div class="tab-pane" id="tab-fpp-3">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_brand_parent'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fpp_brand_parent" id="mlseo_fpp_brand_parent" value="1" <?php if ($mlseo_fpp_brand_parent) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_brand_parent_help'); ?></td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="tab-fpp-4">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_remove_search'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fpp_remove_search" id="mlseo_fpp_remove_search" value="1" <?php if ($mlseo_fpp_remove_search) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_remove_search_help'); ?></td>
            </tr>
            <?php /*
            <tr>
              <td><?php echo $_language->get('text_fix_search'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fix_search" id="mlseo_fix_search" value="1" <?php if (!empty($mlseo_fix_search)) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fix_search_help'); ?></td>
            </tr>
            */ ?>
          </table>
        </div>
        <div class="tab-pane" id="tab-fpp-5">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_slash'); ?></td>
              <td style="width:220px">
                <select name="mlseo_fpp_slash" class="form-control">
                  <option value="" <?php if (!$mlseo_fpp_slash) echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_slash_mode_0'); ?></option>
                  <option value="1" <?php if ($mlseo_fpp_slash == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_slash_mode_1'); ?></option>
                  <option value="2" <?php if ($mlseo_fpp_slash == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_slash_mode_2'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_slash_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fix_cart'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fix_cart" id="mlseo_fix_cart" value="1" <?php if (!empty($mlseo_fix_cart)) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fix_cart_help'); ?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- end fpp -->
		</div>
    <?php } ?>
    
    <?php if ($store_id) { ?>
		<div class="tab-pane<?php if ($store_id) echo ' active'; ?>" id="tab-multistore">
      <div class="well">
        <h4><?php echo $_language->get('tab_seo_multistore'); ?></h4>
        <p><?php echo $_language->get('info_multistore_dashboard'); ?></p>
      </div>
    </div>
    <?php } ?>
    
    <?php if (!$store_id  || ($store_id && $mlseo_multistore)) { ?>
		<div class="tab-pane <?php echo $currentTab == 'tab-update' ? 'active' : '' ?>" id="tab-update">
			 <table class="form">
       <tr>
        <td colspan="2">
          <div class="row-fluid clearfix jumbo">
            <label class="col-sm-2"><?php echo $_language->get('text_seo_simulate'); ?></label>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-floppy-o"></i></span>
                <input type="text" name="simulate" value="1" class="toggler" data-mode="background" data-on-text="<?php echo $_language->get('text_simulation'); ?>" data-off-text="<?php echo $_language->get('text_write'); ?>" data-icons="" data-on-color="#f0a357" data-off-color="#5ca455"/>
              </div>
            </div>
            <div class="col-sm-1"></div>
            <label class="col-sm-2"><?php echo $_language->get('text_seo_empty_only'); ?></label>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-magic"></i></span>
                <input type="text" name="empty_only" value="1" class="toggler" data-mode="background" data-on-text="<?php echo $_language->get('text_empty_only'); ?>" data-off-text="<?php echo $_language->get('text_all_values'); ?>" data-icons="" data-on-color="#f0a357" data-off-color="#5ca455"/>
              </div>
            </div>
            <!--
            <label class="col-sm-2"><?php echo $_language->get('text_seo_redirect_mode'); ?></label>
            <div class="col-sm-2">
              <input class="switch" type="checkbox" id="redirect_mode"  name="redirect_mode" value="1" checked="checked"/>
            </div>
            -->
          </div>
         </td>
        </tr>
				<tr>
					<td><?php echo $_language->get('text_seo_languages'); ?>:</td>
					<td class="imgCheckbox">
            <?php foreach ($languages as $language) { ?>
            <img style="position:relative; bottom:12px; left:50px;" src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="checkbox" class="checkable" value="<?php echo $language['language_id']; ?>" data-label="<?php echo $language['name']; ?>" id="langs_selector_<?php echo $language['language_id']; ?>" name="langs[]" checked="checked"/> 
            <?php } ?>
          </td>
				</tr>
      </table>
      
      <ul id="tabs_editor" class="nav nav-tabs">
				<?php
          $massupdate_types = array('product', 'category', 'information', 'manufacturer', 'other');
        ?>
					<li class="active"><a href="#tab-generator-product" editor-type="product" data-toggle="tab"><?php echo $_language->get('text_seo_generator_product'); ?></a></li>
					<li><a href="#tab-generator-category" editor-type="category" data-toggle="tab"><?php echo $_language->get('text_seo_generator_category'); ?></a></li>
					<li><a href="#tab-generator-information" editor-type="information" data-toggle="tab"><?php echo $_language->get('text_seo_generator_information'); ?></a></li>
					<li><a href="#tab-generator-manufacturer" editor-type="manufacturer" data-toggle="tab"><?php echo $_language->get('text_seo_generator_manufacturer'); ?></a></li>
          <?php if (!$store_id) { ?>
					<li><a href="#tab-generator-other" editor-type="other" data-toggle="tab"><?php echo $_language->get('text_seo_generator_other'); ?></a></li>
          <?php } ?>
			</ul>
			<div class="tab-content">
				<div id="tab-generator-product" class="tab-pane active">
          <div class="form-horizontal" style="margin-bottom:20px">
            <div class="form-group">
              <label class="col-sm-1 control-label"><?php echo $_language->get('text_seo_category'); ?></label>
              <div class="col-sm-11">
                <select name="filter_category" class="form-control">
                  <option value=""><?php echo $_language->get('text_all'); ?></option>
                  <?php foreach ($categories as $product_category) { ?>
                    <option value="<?php echo $product_category['category_id']; ?>"><?php echo $product_category['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          
          <table class="generator table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo $_language->get('text_type'); ?></th>
                <th style="width:40%"><?php echo $_language->get('text_patterns'); ?></th>
                <th><?php echo $_language->get('text_generate'); ?></th>
                <th><?php echo $_language->get('text_available_tags'); ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_seo_mode_url'); ?></td>
                <td><input type="text" name="mlseo_product_url_pattern" value="<?php echo $mlseo_product_url_pattern; ?>" class="form-control" placeholder="[name]"/></td>
                <td><a onclick="seo_update('product', 'url');" class="btn btn-block btn-success"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></span></a></td>
                <td class="patterns" rowspan="<?php echo ($store_id ? 12 : 14); ?>"><?php echo $_language->get('text_seo_generator_product_desc'); ?><br/><br/><br/><?php echo $_language->get('text_seo_generator_drag_info'); ?></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h1'); ?></td>
                <td><input type="text" name="mlseo_product_h1_pattern" value="<?php echo $mlseo_product_h1_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('product', 'h1');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h1'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h2'); ?></td>
                <td><input type="text" name="mlseo_product_h2_pattern" value="<?php echo $mlseo_product_h2_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('product', 'h2');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h2'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h3'); ?></td>
                <td><input type="text" name="mlseo_product_h3_pattern" value="<?php echo $mlseo_product_h3_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('product', 'h3');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h3'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_title'); ?></td>
                <td><input type="text" name="mlseo_product_title_pattern" value="<?php echo $mlseo_product_title_pattern; ?>" class="form-control"  placeholder="[name] - [model]"/></td>
                <td><a onclick="seo_update('product', 'title');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_title'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_keyword'); ?></td>
                <td><input type="text" name="mlseo_product_keyword_pattern" value="<?php echo $mlseo_product_keyword_pattern; ?>" class="form-control"  placeholder="[name], [model], [category]"/></td>
                <td><a onclick="seo_update('product', 'keyword');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_keywords'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_description'); ?></td>
                <td><input type="text" name="mlseo_product_description_pattern" value="<?php echo $mlseo_product_description_pattern; ?>" class="form-control"  placeholder="[name] - [model] - [category] - [desc]"/></td>
                <td><a onclick="seo_update('product', 'description');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_desc'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_seo_mode_image_alt'); ?></td>
                <td><input type="text" name="mlseo_product_image_alt_pattern" value="<?php echo $mlseo_product_image_alt_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('product', 'image_alt');" class="btn btn-block btn-success"><span><i class="fa fa-picture-o"></i> <?php echo $_language->get('text_seo_generator_imgalt'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_seo_mode_image_title'); ?></td>
                <td><input type="text" name="mlseo_product_image_title_pattern" value="<?php echo $mlseo_product_image_title_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('product', 'image_title');" class="btn btn-block btn-success"><span><i class="fa fa-picture-o"></i> <?php echo $_language->get('text_seo_generator_imgtitle'); ?></span></a></td>
              </tr>
              <?php if (!$store_id) { ?>
              <tr>
                <td><i class="fa fa-picture-o gkd-badge orange"></i> <?php echo $_language->get('text_seo_mode_image_name'); ?></td>
                <td><input type="text" name="mlseo_product_image_name_pattern" value="<?php echo $mlseo_product_image_name_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('product', 'image_name');" class="btn btn-block btn-success"><span><i class="fa fa-picture-o"></i> <?php echo $_language->get('text_seo_generator_imgname'); ?></span></a></td>
              </tr>
              <?php if (version_compare(VERSION, '1.5.3', '>=')) { ?>
              <tr>
                <td><i class="fa fa-tags gkd-badge cyan"></i> <?php echo $_language->get('text_seo_mode_tag'); ?></td>
                <td><input type="text" name="mlseo_product_tag_pattern" value="<?php echo $mlseo_product_tag_pattern; ?>" class="form-control"  placeholder="[name], [model], [category]"/></td>
                <td><a onclick="seo_update('product', 'tag');" class="btn btn-block btn-success"><span><i class="fa fa-tags"></i> <?php echo $_language->get('text_seo_generator_tag'); ?></span></a></td>
              </tr>
              <?php } ?>
              <?php } ?>
              <tr>
                <td><i class="fa fa-align-left gkd-badge cyan"></i> <?php echo $_language->get('text_seo_mode_full_desc'); ?></td>
                <td><textarea class="form-control" name="mlseo_product_full_desc_pattern" style="height:100px" placeholder="[name] - [model] - [category]"><?php echo $mlseo_product_full_desc_pattern; ?></textarea></td>
                <td style="vertical-align:top"><a onclick="seo_update('product', 'full_desc');" class="btn btn-block btn-success"><span><i class="fa fa-align-left"></i> <?php echo $_language->get('text_seo_generator_full_desc'); ?></span></a></td>
              </tr>
              <?php if (!$store_id) { ?>
              <tr>
                <td><i class="fa fa-code-fork gkd-badge darkblue"></i> <?php echo $_language->get('text_seo_mode_related'); ?></td>
                <td class="form-inline">
                  <input type="hidden" name="mlseo_product_related_samecat"/>
                  <?php echo $_language->get('text_seo_generator_related_no'); ?> <input style="margin-right:15px" type="text" name="mlseo_product_related_no" value="<?php echo $mlseo_product_related_no; ?>" size="2" class="form-control" />
                  <?php echo $_language->get('text_seo_generator_related_relevance'); ?> <input style="margin-right:15px" type="text" name="mlseo_product_related_relevance" value="<?php echo $mlseo_product_related_relevance; ?>" size="2" class="form-control"/>
                   <span style="position:relative; top:10px;"><input type="checkbox" class="checkable" value="1" data-label="<?php echo $_language->get('text_seo_generator_related_samecat'); ?>" id="mlseo_product_related_samecat" name="mlseo_product_related_samecat" <?php echo $mlseo_product_related_samecat ? 'checked="checked"' : ''; ?>/></span>
                </td>
                <td><a onclick="seo_update('product', 'related');" class="btn btn-block btn-success"><span><i class="fa fa-sitemap"></i> <?php echo $_language->get('text_seo_generator_related'); ?></span></a></td>
              </tr>
              <?php } ?>
              <tr>
                <td><i class="fa fa-mail-forward gkd-badge red"></i> <?php echo $_language->get('text_seo_mode_redirection'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_redirect_i'); ?></td>
                <td><a onclick="seo_update('redirect', 'product');" class="btn btn-block btn-success"><span><i class="fa fa-share"></i> <?php echo $_language->get('text_seo_generator_redirect'); ?></span></a></td>
              </tr>
              <?php if ($store_id) { ?>
              <tr>
                <td><i class="fa fa-copy gkd-badge red"></i> <?php echo $_language->get('text_seo_mode_store_copy'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_store_copy_i'); ?></td>
                <td><a onclick="seo_update('product', 'store_copy');" class="btn btn-block btn-success"><span><i class="fa fa-copy"></i> <?php echo $_language->get('text_seo_generator_store_copy'); ?></span></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div id="tab-generator-category" class="tab-pane">
          <div class="form-horizontal" style="margin-bottom:20px">
            <div class="form-group">
              <label class="col-sm-1 control-label"><?php echo $_language->get('text_seo_category'); ?></label>
              <div class="col-sm-11">
                <select name="filter_cat_category" class="form-control">
                  <option value=""><?php echo $_language->get('text_all'); ?></option>
                  <?php foreach ($categories as $product_category) { ?>
                    <option value="<?php echo $product_category['category_id']; ?>"><?php echo $product_category['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          
          <table class="generator table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo $_language->get('text_type'); ?></th>
                <th style="width:40%"><?php echo $_language->get('text_patterns'); ?></th>
                <th><?php echo $_language->get('text_generate'); ?></th>
                <th><?php echo $_language->get('text_available_tags'); ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_seo_mode_url'); ?></td>
                <td><input type="text" name="mlseo_category_url_pattern" value="<?php echo $mlseo_category_url_pattern; ?>" class="form-control" placeholder="[name]"/></td>
                <td><a onclick="seo_update('category', 'url');" class="btn btn-block btn-success"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></span></a></td>
                <td class="patterns" rowspan="<?php echo ($store_id ? 10 : 9); ?>"><?php echo $_language->get('text_seo_generator_category_desc'); ?><br/><br/><br/><?php echo $_language->get('text_seo_generator_drag_info'); ?></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h1'); ?></td>
                <td><input type="text" name="mlseo_category_h1_pattern" value="<?php echo $mlseo_category_h1_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('category', 'h1');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h1'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h2'); ?></td>
                <td><input type="text" name="mlseo_category_h2_pattern" value="<?php echo $mlseo_category_h2_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('category', 'h2');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h2'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h3'); ?></td>
                <td><input type="text" name="mlseo_category_h3_pattern" value="<?php echo $mlseo_category_h3_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('category', 'h3');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h3'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_title'); ?></td>
                <td><input type="text" name="mlseo_category_title_pattern" value="<?php echo $mlseo_category_title_pattern; ?>" class="form-control"  placeholder="[name] - [model]"/></td>
                <td><a onclick="seo_update('category', 'title');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_title'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_keyword'); ?></td>
                <td><input type="text" name="mlseo_category_keyword_pattern" value="<?php echo $mlseo_category_keyword_pattern; ?>" class="form-control"  placeholder="[name], [model], [category]"/></td>
                <td><a onclick="seo_update('category', 'keyword');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_keywords'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_description'); ?></td>
                <td><input type="text" name="mlseo_category_description_pattern" value="<?php echo $mlseo_category_description_pattern; ?>" class="form-control"  placeholder="[name] - [model] - [category] - [desc]"/></td>
                <td><a onclick="seo_update('category', 'description');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_desc'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-align-left gkd-badge cyan"></i> <?php echo $_language->get('text_seo_mode_full_desc'); ?></td>
                <td><textarea class="form-control" name="mlseo_category_full_desc_pattern" style="height:100px" placeholder="[name] - [model] - [category]"><?php echo $mlseo_category_full_desc_pattern; ?></textarea></td>
                <td style="vertical-align:top"><a onclick="seo_update('category', 'full_desc');" class="btn btn-block btn-success"><span><i class="fa fa-align-left"></i> <?php echo $_language->get('text_seo_generator_full_desc'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-mail-forward gkd-badge red"></i> <?php echo $_language->get('text_seo_mode_redirection'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_redirect_i'); ?></td>
                <td><a onclick="seo_update('redirect', 'category');" class="btn btn-block btn-success"><span><i class="fa fa-share"></i> <?php echo $_language->get('text_seo_generator_redirect'); ?></span></a></td>
              </tr>
              <?php if ($store_id) { ?>
              <tr>
                <td><i class="fa fa-copy gkd-badge red"></i> <?php echo $_language->get('text_seo_mode_store_copy'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_store_copy_i'); ?></td>
                <td><a onclick="seo_update('category', 'store_copy');" class="btn btn-block btn-success"><span><i class="fa fa-copy"></i> <?php echo $_language->get('text_seo_generator_store_copy'); ?></span></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div id="tab-generator-information" class="tab-pane">
          <table class="generator table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo $_language->get('text_type'); ?></th>
                <th style="width:40%"><?php echo $_language->get('text_patterns'); ?></th>
                <th><?php echo $_language->get('text_generate'); ?></th>
                <th><?php echo $_language->get('text_available_tags'); ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_seo_mode_url'); ?></td>
                <td><input type="text" name="mlseo_information_url_pattern" value="<?php echo $mlseo_information_url_pattern; ?>" class="form-control" placeholder="[name]"/></td>
                <td><a onclick="seo_update('information', 'url');" class="btn btn-block btn-success"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></span></a></td>
                <td class="patterns" rowspan="<?php echo ($store_id ? 10 : 9); ?>"><?php echo $_language->get('text_seo_generator_information_desc'); ?><br/><br/><br/><?php echo $_language->get('text_seo_generator_drag_info'); ?></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h1'); ?></td>
                <td><input type="text" name="mlseo_information_h1_pattern" value="<?php echo $mlseo_information_h1_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('information', 'h1');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h1'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h2'); ?></td>
                <td><input type="text" name="mlseo_information_h2_pattern" value="<?php echo $mlseo_information_h2_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('information', 'h2');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h2'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h3'); ?></td>
                <td><input type="text" name="mlseo_information_h3_pattern" value="<?php echo $mlseo_information_h3_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('information', 'h3');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h3'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_title'); ?></td>
                <td><input type="text" name="mlseo_information_title_pattern" value="<?php echo $mlseo_information_title_pattern; ?>" class="form-control"  placeholder="[name] - [model]"/></td>
                <td><a onclick="seo_update('information', 'title');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_title'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_keyword'); ?></td>
                <td><input type="text" name="mlseo_information_keyword_pattern" value="<?php echo $mlseo_information_keyword_pattern; ?>" class="form-control"  placeholder="[name], [model], [information]"/></td>
                <td><a onclick="seo_update('information', 'keyword');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_keywords'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_description'); ?></td>
                <td><input type="text" name="mlseo_information_description_pattern" value="<?php echo $mlseo_information_description_pattern; ?>" class="form-control"  placeholder="[name] - [model] - [information] - [desc]"/></td>
                <td><a onclick="seo_update('information', 'description');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_desc'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-align-left gkd-badge cyan"></i> <?php echo $_language->get('text_seo_mode_full_desc'); ?></td>
                <td><textarea class="form-control" name="mlseo_information_full_desc_pattern" style="height:100px" placeholder="[name] - [model] - [information]"><?php echo $mlseo_information_full_desc_pattern; ?></textarea></td>
                <td style="vertical-align:top"><a onclick="seo_update('information', 'full_desc');" class="btn btn-block btn-success"><span><i class="fa fa-align-left"></i> <?php echo $_language->get('text_seo_generator_full_desc'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-mail-forward gkd-badge red"></i> <?php echo $_language->get('text_seo_mode_redirection'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_redirect_i'); ?></td>
                <td><a onclick="seo_update('redirect', 'information');" class="btn btn-block btn-success"><span><i class="fa fa-share"></i> <?php echo $_language->get('text_seo_generator_redirect'); ?></span></a></td>
              </tr>
              <?php if ($store_id) { ?>
              <tr>
                <td><i class="fa fa-copy gkd-badge red"></i> <?php echo $_language->get('text_seo_mode_store_copy'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_store_copy_i'); ?></td>
                <td><a onclick="seo_update('information', 'store_copy');" class="btn btn-block btn-success"><span><i class="fa fa-copy"></i> <?php echo $_language->get('text_seo_generator_store_copy'); ?></span></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div id="tab-generator-manufacturer" class="tab-pane">
          <table class="generator table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo $_language->get('text_type'); ?></th>
                <th style="width:40%"><?php echo $_language->get('text_patterns'); ?></th>
                <th><?php echo $_language->get('text_generate'); ?></th>
                <th><?php echo $_language->get('text_available_tags'); ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_seo_mode_url'); ?></td>
                <td><input type="text" name="mlseo_manufacturer_url_pattern" value="<?php echo $mlseo_manufacturer_url_pattern; ?>" class="form-control" placeholder="[name]"/></td>
                <td><a onclick="seo_update('manufacturer', 'url');" class="btn btn-block btn-success"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></span></a></td>
                <td class="patterns" rowspan="<?php echo ($store_id ? 10 : 9); ?>"><?php echo $_language->get('text_seo_generator_manufacturer_desc'); ?><br/><br/><br/><?php echo $_language->get('text_seo_generator_drag_info'); ?></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h1'); ?></td>
                <td><input type="text" name="mlseo_manufacturer_h1_pattern" value="<?php echo $mlseo_manufacturer_h1_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('manufacturer', 'h1');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h1'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h2'); ?></td>
                <td><input type="text" name="mlseo_manufacturer_h2_pattern" value="<?php echo $mlseo_manufacturer_h2_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('manufacturer', 'h2');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h2'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-header gkd-badge blue"></i> <?php echo $_language->get('text_seo_mode_h3'); ?></td>
                <td><input type="text" name="mlseo_manufacturer_h3_pattern" value="<?php echo $mlseo_manufacturer_h3_pattern; ?>" class="form-control"  placeholder="[name]"/></td>
                <td><a onclick="seo_update('manufacturer', 'h3');" class="btn btn-block btn-success"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h3'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_title'); ?></td>
                <td><input type="text" name="mlseo_manufacturer_title_pattern" value="<?php echo $mlseo_manufacturer_title_pattern; ?>" class="form-control"  placeholder="[name] - [model]"/></td>
                <td><a onclick="seo_update('manufacturer', 'title');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_title'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_keyword'); ?></td>
                <td><input type="text" name="mlseo_manufacturer_keyword_pattern" value="<?php echo $mlseo_manufacturer_keyword_pattern; ?>" class="form-control"  placeholder="[name], [model], [manufacturer]"/></td>
                <td><a onclick="seo_update('manufacturer', 'keyword');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_keywords'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-code gkd-badge green"></i> <?php echo $_language->get('text_seo_mode_description'); ?></td>
                <td><input type="text" name="mlseo_manufacturer_description_pattern" value="<?php echo $mlseo_manufacturer_description_pattern; ?>" class="form-control"  placeholder="[name] - [model] - [manufacturer] - [desc]"/></td>
                <td><a onclick="seo_update('manufacturer', 'description');" class="btn btn-block btn-success"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_desc'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-align-left gkd-badge cyan"></i> <?php echo $_language->get('text_seo_mode_full_desc'); ?></td>
                <td><textarea class="form-control" name="mlseo_manufacturer_full_desc_pattern" style="height:100px" placeholder="[name] - [model] - [manufacturer]"><?php echo $mlseo_manufacturer_full_desc_pattern; ?></textarea></td>
                <td style="vertical-align:top"><a onclick="seo_update('manufacturer', 'full_desc');" class="btn btn-block btn-success"><span><i class="fa fa-align-left"></i> <?php echo $_language->get('text_seo_generator_full_desc'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-mail-forward gkd-badge red"></i> <?php echo $_language->get('text_seo_mode_redirection'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_redirect_i'); ?></td>
                <td><a onclick="seo_update('redirect', 'manufacturer');" class="btn btn-block btn-success"><span><i class="fa fa-share"></i> <?php echo $_language->get('text_seo_generator_redirect'); ?></span></a></td>
              </tr>
              <?php if ($store_id) { ?>
              <tr>
                <td><i class="fa fa-copy gkd-badge red"></i> <?php echo $_language->get('text_seo_mode_store_copy'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_store_copy_i'); ?></td>
                <td><a onclick="seo_update('manufacturer', 'store_copy');" class="btn btn-block btn-success"><span><i class="fa fa-copy"></i> <?php echo $_language->get('text_seo_generator_store_copy'); ?></span></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div id="tab-generator-other" class="tab-pane">
          <table class="generator table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo $_language->get('text_type'); ?></th>
                <th style="width:40%"><?php echo $_language->get('text_info'); ?></th>
                <th><?php echo $_language->get('text_generate'); ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><i class="fa fa-android gkd-badge "></i> <?php echo $_language->get('text_seo_mode_robots'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_robots_i'); ?></td>
                <td><a onclick="seo_update('robots', 'all');" class="btn btn-block btn-success"><span><i class="fa fa-android"></i> <?php echo $_language->get('text_seo_generator_robots'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-link gkd-badge purple"></i> <?php echo $_language->get('text_seo_mode_internal_links'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_internal_links_i'); ?></td>
                <td><a onclick="seo_update('links', 'all');" class="btn btn-block btn-success"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_internal_links'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-file-text-o gkd-badge blue"></i> <?php echo $_language->get('text_seo_generator_report'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_report_i'); ?></td>
                <td><a onclick="seo_update('report', 'url_alias');" class="btn btn-block btn-success"><span><i class="fa fa-file-text-o"></i> <?php echo $_language->get('text_url_alias_report_btn'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-copy gkd-badge cyan"></i> <?php echo $_language->get('text_seo_generator_deduplicate'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_deduplicate_i'); ?></td>
                <td><a onclick="seo_update('cleanup', 'duplicate');" class="btn btn-block btn-success"><span><i class="fa fa-copy"></i> <?php echo $_language->get('text_cleanup_duplicate_btn'); ?></span></a></td>
              </tr>
              <tr>
                <td><i class="fa fa-repeat gkd-badge cyan"></i> <?php echo $_language->get('text_seo_generator_cleanup'); ?></td>
                <td><?php echo $_language->get('text_seo_generator_cleanup_i'); ?></td>
                <td><a onclick="seo_update('cleanup', 'url');" class="btn btn-block btn-success"><span><i class="fa fa-repeat"></i> <?php echo $_language->get('text_cleanup_btn'); ?></span></a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="update_result">
        <div>
          <div class="fullscreen" onclick="javascript:fullscreen();"><?php echo $_language->get('text_seo_fullscreen'); ?></div>
          <div class="simulation simu"><?php echo $_language->get('text_seo_simulation_mode'); ?></div>
          <div class="simulation write" style="display:none"><?php echo $_language->get('text_seo_write_mode'); ?></div>
          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th style="width:1%"></th>
                <th><?php echo $_language->get('text_seo_item'); ?></th>
                <th><?php echo $_language->get('text_seo_old_value'); ?></th>
                <th><?php echo $_language->get('text_seo_new_value'); ?></th>
              </tr>
            </thead>
            <tbody>
              <tr data-lang="0" style="display:none"><td colspan="4"></td></tr>
              <?php $f=0; foreach ($languages as $language) { ?>
              <tr data-lang="<?php echo $language['language_id']; ?>" style="display:none"><td colspan="4"><?php echo $language['name']; ?></td></tr>
              <?php } ?>
              <tr><td colspan="4" class="text-center"><?php echo $_language->get('text_seo_update_info'); ?></td></tr>
              <tr data-lang="loading" id="loading" style="display:none"><td colspan="4" class="text-center" style="padding:30px 0"><img src="view/seo_package/img/loading.gif" alt=""/></td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div id="generateProgress" class="progress" style="margin-top:15px;display:none">
        <div class="progress-bar progress-bar-striped progress-bar-success active"></div>
      </div>
		</div>
    <?php } ?>
		
    <?php if (!$store_id) { ?>
    <div class="tab-pane <?php echo $currentTab == 'tab-cron' ? 'active' : '' ?>" id="tab-cron">
      <ul class="nav nav-pills nav-stacked col-md-2">
				<li class="active"><a href="#tab-cron-1" data-toggle="pill"><i class="fa fa-cogs"></i> <?php echo $_language->get('text_tab_cron_1'); ?></a></li>
				<li><a href="#tab-cron-2" data-toggle="pill"><i class="fa fa-file-text-o"></i> <?php echo $_language->get('text_tab_cron_2'); ?></a></li>
			</ul>
			<div class="tab-content col-md-10">
				<div class="tab-pane active" id="tab-cron-1">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_simulate'); ?></td>
              <td>
                <input class="switch" type="checkbox" id="cron_simulate"  name="mlseo_cron[simulation]" value="1" <?php if (!empty($mlseo_cron['simulation'])) echo 'checked="checked"'; ?>/>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_empty_only'); ?></td>
              <td>
                <input class="switch" type="checkbox" id="cron_empty_only"  name="mlseo_cron[empty_only]" value="1" <?php if (!empty($mlseo_cron['empty_only'])) echo 'checked="checked"'; ?>/>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_cron_log'); ?></td>
              <td>
                <select name="mlseo_cron_log" class="form-control">
                  <?php foreach (array('all', 'report', 'off') as $log_type) { ?>
                  <option value="<?php echo $log_type; ?>"<?php echo (!empty($mlseo_cron_log) && $mlseo_cron_log == $log_type) ? ' selected="selected"' : ''; ?>><?php echo $_language->get('text_log_'.$log_type); ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_cron_update'); ?></td>
              <td>
              <table class="cron">
                <tr>
                  <td>
                    <b><?php echo $_language->get('text_seo_generator_product'); ?></b><br />
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_url'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="url" <?php if (isset($mlseo_cron['update']['product']) && in_array('url', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_title'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="title" <?php if (isset($mlseo_cron['update']['product']) && in_array('title', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_keyword'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="keyword" <?php if (isset($mlseo_cron['update']['product']) && in_array('keyword', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_description'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="description" <?php if (isset($mlseo_cron['update']['product']) && in_array('description', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_full_desc'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="full_desc" <?php if (isset($mlseo_cron['update']['product']) && in_array('full_desc', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h1'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="h1" <?php if (isset($mlseo_cron['update']['product']) && in_array('h1', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h2'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="h2" <?php if (isset($mlseo_cron['update']['product']) && in_array('h2', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h3'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="h3" <?php if (isset($mlseo_cron['update']['product']) && in_array('h3', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_image_title'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="image_title" <?php if (isset($mlseo_cron['update']['product']) && in_array('image_title', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_image_alt'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="image_alt" <?php if (isset($mlseo_cron['update']['product']) && in_array('image_alt', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_tag'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="tag" <?php if (isset($mlseo_cron['update']['product']) && in_array('tag', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_related'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="related" <?php if (isset($mlseo_cron['update']['product']) && in_array('related', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/> 
                  </td>
                  <td>
                    <b><?php echo $_language->get('text_seo_generator_category'); ?></b><br />
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_url'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="url" <?php if (isset($mlseo_cron['update']['category']) && in_array('url', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_title'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="title" <?php if (isset($mlseo_cron['update']['category']) && in_array('title', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_keyword'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="keyword" <?php if (isset($mlseo_cron['update']['category']) && in_array('keyword', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_description'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="description" <?php if (isset($mlseo_cron['update']['category']) && in_array('description', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_full_desc'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="full_desc" <?php if (isset($mlseo_cron['update']['category']) && in_array('full_desc', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h1'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="h1" <?php if (isset($mlseo_cron['update']['category']) && in_array('h1', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h2'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="h2" <?php if (isset($mlseo_cron['update']['category']) && in_array('h2', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h3'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="h3" <?php if (isset($mlseo_cron['update']['category']) && in_array('h3', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                  </td>
                  <td>
                    <b><?php echo $_language->get('text_seo_generator_information'); ?></b><br />
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_url'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="url" <?php if (isset($mlseo_cron['update']['information']) && in_array('url', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_title'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="title" <?php if (isset($mlseo_cron['update']['information']) && in_array('title', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_keyword'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="keyword" <?php if (isset($mlseo_cron['update']['information']) && in_array('keyword', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_description'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="description" <?php if (isset($mlseo_cron['update']['information']) && in_array('description', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_full_desc'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="full_desc" <?php if (isset($mlseo_cron['update']['information']) && in_array('full_desc', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h1'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="h1" <?php if (isset($mlseo_cron['update']['information']) && in_array('h1', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h2'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="h2" <?php if (isset($mlseo_cron['update']['information']) && in_array('h2', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h3'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="h3" <?php if (isset($mlseo_cron['update']['information']) && in_array('h3', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                  </td>
                  <td>
                    <b><?php echo $_language->get('text_seo_generator_manufacturer'); ?></b><br />
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_url'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="url" <?php if (isset($mlseo_cron['update']['manufacturer']) && in_array('url', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_title'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="title" <?php if (isset($mlseo_cron['update']['manufacturer']) && in_array('title', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_keyword'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="keyword" <?php if (isset($mlseo_cron['update']['manufacturer']) && in_array('keyword', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_description'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="description" <?php if (isset($mlseo_cron['update']['manufacturer']) && in_array('description', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_full_desc'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="full_desc" <?php if (isset($mlseo_cron['update']['manufacturer']) && in_array('full_desc', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h1'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="h1" <?php if (isset($mlseo_cron['update']['manufacturer']) && in_array('h1', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h2'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="h2" <?php if (isset($mlseo_cron['update']['manufacturer']) && in_array('h2', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_h3'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="h3" <?php if (isset($mlseo_cron['update']['manufacturer']) && in_array('h3', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                  </td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          <div class="gkdwidget gkdwidget-color-blueDark">
            <header role="heading">
              <i class="icon fa fa-info-circle fa-2x pull-left"></i>
              <ul class="nav nav-tabs pull-left in">
                <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('help_cron_title'); ?></span></a></li>
                <li><a data-toggle="tab" href="#gkhelp<?php echo $gkhtab++; ?>"><span class="hidden-mobile hidden-tablet"><?php echo $_language->get('help_cron_setup_title'); ?></span></a></li>
              </ul>
            </header>
            <div class="gkdwidget-container" style="display:none">
              <div class="tab-content">
                <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_cron'); ?></div>
                <div class="tab-pane" id="gkhelp<?php echo $gkhdiv++; ?>"><?php echo $_language->get('help_cron_setup'); ?></div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab-cron-2">
          <textarea wrap="off" rows="30" readonly class="form-control"><?php echo $cli_log; ?></textarea>
          <div class="text-center" style="margin-top:20px">
            <a class="btn btn-success" <?php if (!$cli_log_link || !$cli_log) { echo 'disabled'; } else { echo 'href="'.$cli_log_link.'"';} ?>><i class="fa fa-download"></i> <?php echo $_language->get('text_cli_log_save'); ?></a>
            <a <?php if (!$cli_log_link || !$cli_log) { echo 'disabled not'; } ?>onclick="confirm('<?php echo $_language->get('text_confirm'); ?>') ? location.href='<?php echo $action.'&clear_cli_logs=1'; ?>' : false;" class="btn btn-danger"><i class="fa fa-eraser"></i> <?php echo $_language->get('text_clear_logs'); ?></a>
          </div>
        </div>
      </div>
		</div>
		<?php } ?>
    <?php if (!$store_id) { ?>
    <div class="tab-pane <?php echo $currentTab == 'tab-about' ? 'active' : '' ?>" id="tab-about">
      <div class="row">
        <div class="col-md-4">
          <h3><i class="fa fa-info-circle"></i> Extension details</h3>
          <div class="table-responsive">
            <table class="table"><tbody>
              <tr>
                <td>Module</td>
                <td><?php echo strip_tags($heading_title); ?></td>
              </tr>
              <tr>
                <td>Version</td>
                <td><?php echo $module_version; ?> - <?php echo $module_type; ?></td>
              </tr>
              <tr>
                <td>Upgrade Tool</td>
                <td>Easy upgrade from older seo module: <a href="<?php echo $upgrade_url; ?>"><i class="fa fa-upload"></i> Upgrade Tool</a></td>
              </tr>
              <tr>
                <td>Backup settings</td>
                <td>Backup your current module settings: <a href="index.php?route=module/complete_seo/backup&<?php echo $token; ?>"><i class="fa fa-save"></i> Backup</a><br/><br/>To restore: upload the backup file into<br/>System > Maintenance > Backup/Restore</td>
              </tr>
            <?php if (!empty($license_info)) { ?>
              <tr>
                <td colspan="2" style="padding:0;">
                  <h3 style="padding-top:40px;margin-bottom:10px;"><i class="fa fa-check-square"></i> Your License</h3>
                </td>
              </tr>
              <tr>
                <td>License holder</td>
                <td><?php echo $license_info['email']; ?></td>
              </tr>
              <tr>
                <td>Registered domain</td>
                <td><?php echo $license_info['website']; ?></td>
              </tr>
              <tr>
                <td>License expires on</td>
                <td><?php echo date('F d, Y', strtotime($license_info['support_date'])); ?></td>
              </tr>
              <tr>
                <td>License status</td>
                <td style="vertical-align:middle">
                  <?php if (time() > strtotime($license_info['support_date'])) { ?>
                    <span class="label label-danger" style="font-size:12px">Expired</span>
                  <?php } else { ?>
                    <span class="label label-success" style="font-size:12px"><i class="fa fa-check"></i> Valid</span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="padding:20px 0;">
                <?php if (time() > strtotime($license_info['support_date'])) { ?>
                  <a target="_blank" href="http://geekodev.com/renewal?module=<?php echo $module; ?>&license=<?php echo $license_info['license']; ?>" class="btn btn-success btn-block" style="font-size:14px;"><i class="fa fa-refresh"></i> Renew my license</a>
                  <?php } else { ?>
                  <a target="_blank" href="http://geekodev.com/login" class="btn btn-grey btn-block" style="font-size:14px;"><i class="fa fa-cog"></i> Manage my license</a>
                <?php } ?>
                </td>
              </tr>
            <?php } else { ?>
              <tr><td colspan="2"></td></tr>
            <?php } ?>
            </tbody></table>
          </div>
        </div>
        <div class="col-md-8">
          <h3><i class="fa fa-external-link"></i> Connect with us</h3>
          <div class="row">
            <div class="col-md-12">
              <div class="well text-center">
                <div style="height:80px"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAACXBIWXMAAAsTAAALEwEAmpwYAAA5z2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS41LWMwMTQgNzkuMTUxNDgxLCAyMDEzLzAzLzEzLTEyOjA5OjE1ICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgICAgICAgICB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIgogICAgICAgICAgICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iCiAgICAgICAgICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgICAgICAgICAgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmV4aWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vZXhpZi8xLjAvIj4KICAgICAgICAgPHhtcDpDcmVhdG9yVG9vbD5BZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpPC94bXA6Q3JlYXRvclRvb2w+CiAgICAgICAgIDx4bXA6Q3JlYXRlRGF0ZT4yMDE2LTA2LTEzVDE4OjMyOjA2KzAyOjAwPC94bXA6Q3JlYXRlRGF0ZT4KICAgICAgICAgPHhtcDpNZXRhZGF0YURhdGU+MjAxNi0wNi0xM1QxODozMjowNiswMjowMDwveG1wOk1ldGFkYXRhRGF0ZT4KICAgICAgICAgPHhtcDpNb2RpZnlEYXRlPjIwMTYtMDYtMTNUMTg6MzI6MDYrMDI6MDA8L3htcDpNb2RpZnlEYXRlPgogICAgICAgICA8eG1wTU06SW5zdGFuY2VJRD54bXAuaWlkOjRlN2U2MGY0LTdiYzYtMDY0Ni04ZTJhLThhNWRhNWRlMjEyYjwveG1wTU06SW5zdGFuY2VJRD4KICAgICAgICAgPHhtcE1NOkRvY3VtZW50SUQ+eG1wLmRpZDowMjgzNzFmNC00MzJlLTY5NDctYjk4ZS1hZGJmNTBiZWViMDk8L3htcE1NOkRvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+eG1wLmRpZDowMjgzNzFmNC00MzJlLTY5NDctYjk4ZS1hZGJmNTBiZWViMDk8L3htcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD4KICAgICAgICAgPHhtcE1NOkhpc3Rvcnk+CiAgICAgICAgICAgIDxyZGY6U2VxPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5jcmVhdGVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6MDI4MzcxZjQtNDMyZS02OTQ3LWI5OGUtYWRiZjUwYmVlYjA5PC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE2LTA2LTEzVDE4OjMyOjA2KzAyOjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpPC9zdEV2dDpzb2Z0d2FyZUFnZW50PgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo0ZTdlNjBmNC03YmM2LTA2NDYtOGUyYS04YTVkYTVkZTIxMmI8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTYtMDYtMTNUMTg6MzI6MDYrMDI6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICA8L3JkZjpTZXE+CiAgICAgICAgIDwveG1wTU06SGlzdG9yeT4KICAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9wbmc8L2RjOmZvcm1hdD4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHRpZmY6T3JpZW50YXRpb24+MTwvdGlmZjpPcmllbnRhdGlvbj4KICAgICAgICAgPHRpZmY6WFJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj43MjAwMDAvMTAwMDA8L3RpZmY6WVJlc29sdXRpb24+CiAgICAgICAgIDx0aWZmOlJlc29sdXRpb25Vbml0PjI8L3RpZmY6UmVzb2x1dGlvblVuaXQ+CiAgICAgICAgIDxleGlmOkNvbG9yU3BhY2U+NjU1MzU8L2V4aWY6Q29sb3JTcGFjZT4KICAgICAgICAgPGV4aWY6UGl4ZWxYRGltZW5zaW9uPjYwPC9leGlmOlBpeGVsWERpbWVuc2lvbj4KICAgICAgICAgPGV4aWY6UGl4ZWxZRGltZW5zaW9uPjYwPC9leGlmOlBpeGVsWURpbWVuc2lvbj4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgCjw/eHBhY2tldCBlbmQ9InciPz75HNQxAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAeeSURBVHja5Jt7cBXVHcc/NyEIhA1gJO2oPAQhsUAplFbrM8cOKBWoLzoWaEdbbXOmlbZOp04ftrVlSuuMWgZ1o44tVTRTUSOotRlHFrFIW0FrgEKFxIRHjGBQcqCBhJj+sb9LN8t97I13N+v4/Yfd88r97u9xfr/fOSR6enpIIpFI0F+wHasA+DKwADgPOANIAAeAfwF/BdZoZXblunYvjnEgbDvWSGA18IUAwzcADwI1WpnOjyrhx4H5OU7bA9wJ2NmIx4qw7VjFwLvAoD4usRO4RSvzbBDCBfQ/5n8IsgATgGdsx3rYdqzh2Qb3q4RtxxoEbAHOztOSTcA8rcyW2EnYdqxC4P48kgUYC7xiO9aloUtYpHUuMA2oECIjgE6gWb5+I7AfKAVulO0nDHQAc7Qya/PutGzHOgu4GfgmUEJ8cBiYrpXZmRfCtmNNAX4FzIuJ80uFN4AZVZXtx5MNA/qourcBP+rL/HwikShk9KkzGVFcQUfnAXa31dHR9a53yFTgK8BjfSJsO9YEYJUs1K8oGXwWsyf/mRHFFSfaurqPsP7Nxex8Z5V36FVewgU5kJ0FbIoD2YJEEbOnPN6LbENDA3fdcQ8du66kzJruHT7J+zIgINmFwB+BojgY5pjSyxkxpLxX2/du/j7NTc0ALL33eki8luz6RK+PFZDsw3EhCzBsyPiT2rq6uk48Dx04yttVHFjCtmPNBFbEzQsfObbvpLZly3/PYytrmPLpyYwpH8SOrSe6TgkUeNiONRZ4TYKHWKGosJgF59YzeODIlP3Pb5lPc1vdifeqyvZERpW2HSsB/CmOZJPeuG7bQo4df9+fF7GpaWkvshJ1ZVXpG4CLiTFaD/2dmn9Mo+KTixheXM7RrjYa9j/FAfO6f+gLGVXadqyBQANwJh99bAbmVVW2t2RS6UUxILtd9vvvAu/0Yf4G4KvA57UyLdlU+lsxkMxWrUw9UG871grgSuAaycZOP8lwYR/wKrAet9DXGCg9rF5XcrpMjgMeBX6sldmToiRUKtr5AdCarGnZjlUGzAQUcCEwDLigqrK9MR3hhcDKGNngceA5oBbYCDR5yA0Bxkv+PUMIfga3tOvFOVWV7TvSEb4TuCUCIqtEgqNkN7gsh1y6XaK+wQHGrtXKfNHL0W/DkyKSXHWyGgHcYzvWKcCXgK8Bc7KEsUE/zGbgOn+jn/CYiAh/A0gSRitzTNS21nas03BPH64Xdc0Vr+MW6h9KVa/2q/TBPEVXLwI/B8aJ5OYCQ31jbtPKLPFFd5cAnVqZV6RtMu7xyxVin141PgQcBFqAbbjHMX/RyjT7f0zaEk/1upLuPCUK47Qyb3nIlAAa+IlPJVcA9wGtwE+Bb0v7L7Uyt+dLnTIR7snD+ge1MqVpYvQy4BFgVja11MpMD4NwGGmfSdehldkvTmmrr2sNsNzzvjos5xFpEU72zkeBcgka5kpWNhv3yOQprw2HUh7yvR/Ow5qZTvKukzCxSP722yLZItyTwI1hkk1F+L1cTEM849+A/3rat2SY462hdouXvVHerxGnRhwJPwuM1spM08pcJEF9Eq9msOE1wGKgRiTdApR5howKm7DfS6+TvTAbpko247XPNuBU4GfAUuB24Cbgn8ACrczhNHZdBdwB7AWu0sr8J98kM4WWrQHXSPXjHVHLJcAvPOHhXNxzp2VppF4NVEflOP0q3RJw3rAUbTWe5ybJdFLZbr+ir4RThZ+1wPPy/BvcI44ngFt9H8O7RUUOv0oHTf7PTKGaH9iOtRjYgXtKsRtYpJV52UNyDvAd4CKg2HasDqBePtb9Wpn3o5Zw0DtQ49PY4y4pAAKMBn6dlKbtWLXAM8Dl/P80YLB4+N8CjbZjXRs14e0B503M0Lfb87xX/l0p21A2M1llO5aOjLBsHU0B5n02Q9/XgbuB3wGLbceaJ/YM8CTuNYezZVyqYtt9clIZ/j4sdemHJEHPhtH+AluafXY17i2BRmCiVqbb0zdSEoky37QmoDzoTbsPmy09F3CdmwKOS1ZRWr1kRaMO4N4m8GMs7sl9JBK2JKgvzjK3DRivlTmURcJ1kv92i7M7KNFXAW61sUfa/HWsWq3M1aFLWCtjCFaqLZUwMhuSuW0h8DRwF+61polAhfiNt1LM+1wUXjqJ5QHn/8B2rGw3YP8gNSekLpXMjpo9mVWqQOa0yAhrZbbhuQiSAYVAjTifdBnSUdl76yQb24t7A+88rcxR27FmAKnmd0diwx7bOwN4EwgSAr4BXJLNnlPY90BJOs5P0V2vlZkaug17JLMPt5IYBFOBDbZjjcuB7DCx6fPTDFkbpQ0nsUzCwSCYBGy2HUvbjjUgA9GhkgNvl1pWOjwYqUp7fmAJ8JI4nKBoEE+/CTgiNjoB94p/ZYAtb4VW5oYwCgCB7lqKU1oLTI4gg9sKXKCVaQ+DcKC6tEREF4uDCRP/Bmblk2yuNuwl/R7uYfMSXzUjX3gAmKGVeTuyIl7Q68O2Y03CPRPKx02fl4FbtTIbwyKZtwvitmNdCPwQ93Qvl1OMTgk579XKvBS2U8j7f+ORPXU2cCnwKYmTh0tC0CWloz2SNKwD1odpp4EJfxzwvwEAYkXXmaPo4PsAAAAASUVORK5CYII=" alt="" style="position:relative;top:6px;"/></div>
                <h3>Made by GeekoDev</h3>
                <p>Developed with love and skill.<br/>Check our other great extensions on our website.</p>
                <a href="https://geekodev.com" target="_blank" class="btn btn-lg btn-grey">Visit our website</a>
              </div>
            </div>
          
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="well text-center">
                <div style="height:80px"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD8AAABGCAYAAAB7ckzWAAAACXBIWXMAAAsTAAALEwEAmpwYAABCt2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS41LWMwMTQgNzkuMTUxNDgxLCAyMDEzLzAzLzEzLTEyOjA5OjE1ICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgICAgICAgICAgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iCiAgICAgICAgICAgIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiCiAgICAgICAgICAgIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIgogICAgICAgICAgICB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICAgICAgICAgICB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyI+CiAgICAgICAgIDx4bXA6Q3JlYXRvclRvb2w+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwveG1wOkNyZWF0b3JUb29sPgogICAgICAgICA8eG1wOkNyZWF0ZURhdGU+MjAxOC0xMi0xNFQxNDoyNjowMyswMTowMDwveG1wOkNyZWF0ZURhdGU+CiAgICAgICAgIDx4bXA6TWV0YWRhdGFEYXRlPjIwMTktMDUtMjFUMTE6NTA6MTMrMDI6MDA8L3htcDpNZXRhZGF0YURhdGU+CiAgICAgICAgIDx4bXA6TW9kaWZ5RGF0ZT4yMDE5LTA1LTIxVDExOjUwOjEzKzAyOjAwPC94bXA6TW9kaWZ5RGF0ZT4KICAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9wbmc8L2RjOmZvcm1hdD4KICAgICAgICAgPHhtcE1NOkluc3RhbmNlSUQ+eG1wLmlpZDphMmU2OTE0Yy01MGNkLTU5NDItYWE5OS1lNDhlYWM5YmU4MDU8L3htcE1NOkluc3RhbmNlSUQ+CiAgICAgICAgIDx4bXBNTTpEb2N1bWVudElEPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDpmY2E3ZDJkYy0wNzNkLTRiNDgtOTc3Zi0zNzJiZWJiMzRmYjk8L3htcE1NOkRvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+eG1wLmRpZDpmZGE2ZjBiMC0xZWM4LTM5NDYtYjZiMy1lZjViNzgwNjNlZjk8L3htcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD4KICAgICAgICAgPHhtcE1NOkhpc3Rvcnk+CiAgICAgICAgICAgIDxyZGY6U2VxPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5jcmVhdGVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6ZmRhNmYwYjAtMWVjOC0zOTQ2LWI2YjMtZWY1Yjc4MDYzZWY5PC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE4LTEyLTE0VDE0OjI2OjAzKzAxOjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5zYXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOjhmNDYyYTFiLTljZWYtNDI0Zi1iMGQ2LTE1OTZhYTJiMGZjYjwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxOC0xMi0xNFQxNToxOTozOSswMTowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpPC9zdEV2dDpzb2Z0d2FyZUFnZW50PgogICAgICAgICAgICAgICAgICA8c3RFdnQ6Y2hhbmdlZD4vPC9zdEV2dDpjaGFuZ2VkPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo4NDY1OTc0ZS1iODJmLWZjNGEtODMyNy01Y2Q1YjQ3ODM1MjY8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTgtMTItMTRUMTU6MjE6NDYrMDE6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE5IChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+ZGVyaXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5jb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZzwvc3RFdnQ6cGFyYW1ldGVycz4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPnNhdmVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6ZjU3NWU5YTYtOGM3YS1iYjQwLWE5ZGUtYThjMjIzODQ4NTU3PC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE4LTEyLTE0VDE1OjIxOjQ2KzAxOjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5zYXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOmEyZTY5MTRjLTUwY2QtNTk0Mi1hYTk5LWU0OGVhYzliZTgwNTwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxOS0wNS0yMVQxMTo1MDoxMyswMjowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOlNlcT4KICAgICAgICAgPC94bXBNTTpIaXN0b3J5PgogICAgICAgICA8eG1wTU06RGVyaXZlZEZyb20gcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICA8c3RSZWY6aW5zdGFuY2VJRD54bXAuaWlkOjg0NjU5NzRlLWI4MmYtZmM0YS04MzI3LTVjZDViNDc4MzUyNjwvc3RSZWY6aW5zdGFuY2VJRD4KICAgICAgICAgICAgPHN0UmVmOmRvY3VtZW50SUQ+eG1wLmRpZDpmZGE2ZjBiMC0xZWM4LTM5NDYtYjZiMy1lZjViNzgwNjNlZjk8L3N0UmVmOmRvY3VtZW50SUQ+CiAgICAgICAgICAgIDxzdFJlZjpvcmlnaW5hbERvY3VtZW50SUQ+eG1wLmRpZDpmZGE2ZjBiMC0xZWM4LTM5NDYtYjZiMy1lZjViNzgwNjNlZjk8L3N0UmVmOm9yaWdpbmFsRG9jdW1lbnRJRD4KICAgICAgICAgPC94bXBNTTpEZXJpdmVkRnJvbT4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHRpZmY6T3JpZW50YXRpb24+MTwvdGlmZjpPcmllbnRhdGlvbj4KICAgICAgICAgPHRpZmY6WFJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj43MjAwMDAvMTAwMDA8L3RpZmY6WVJlc29sdXRpb24+CiAgICAgICAgIDx0aWZmOlJlc29sdXRpb25Vbml0PjI8L3RpZmY6UmVzb2x1dGlvblVuaXQ+CiAgICAgICAgIDxleGlmOkNvbG9yU3BhY2U+NjU1MzU8L2V4aWY6Q29sb3JTcGFjZT4KICAgICAgICAgPGV4aWY6UGl4ZWxYRGltZW5zaW9uPjYzPC9leGlmOlBpeGVsWERpbWVuc2lvbj4KICAgICAgICAgPGV4aWY6UGl4ZWxZRGltZW5zaW9uPjcwPC9leGlmOlBpeGVsWURpbWVuc2lvbj4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgCjw/eHBhY2tldCBlbmQ9InciPz50/a+4AAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAABINSURBVHjazJtprF1Xdcd/ezjDHd9kPw+xiZ3ECTFJSAIhSkhIQkXCIDFWhVDKh1IEFIKAoraqCqIRbSlQVFBUaCkUoZKiigZalRYCLZSWqWlCQigZHJzBjuM3+A13vufsvVc/nPuen5+HvGs/m2xp+8Pzvefu/xr/a6191Dte8QpO44qA5wC7gQuAHcBOYAtQHfw/QA7MAHuAe4FvAz9c+aAQhCQyVFNLEFmXw9nTAHg3cBNwA3AdUF/j9zYDFwOvBW4FpoFPAH92ujSzXuAvB14NvBE4d52eOQl8BHj74Nn3rTt4pU7tAQpAqT8WkZeukzWuXjuAewXeCvzNuoL3Xk4ZvfPhtVqpuyOrLjxNAgD4LDCm4Daguy7ge3k4pQcEEUT4YjW1F57OyGm0InP+o5nXH42s/kkIctMgSJ700krByW6twAX5TBrrX7VGcRq1PhA09HIPcBnwCHDeKYEXEU5mKwQX5P0Ib7NGr1v6ObGmwAchBEEp6sC/rkiXwz9Poxh2G6UQ4fl9Fz5mrcLq06/1pQAjwsrf2gV8+OSFqRUns/PAXyAQG82ZWoKglGJVhnoPsP3kzB4YZqMg9/JOH8ILjT6TWi80HmmFOfI3Y+DdJwU+DHxozdsLPoS3LvmgUgrh8EmKQKiW96nyiJXAFZBEmmPI+qQ4uhVkCI+DIFwpwnMVqviDAoVC68IyQhB8CMjg80or9EAgK1LjUMu5gChFvWSJrMaHox5w4WA/MCS9VcPEG4LIjbJCG2YAqpt58sIqCEs+og5bglGKyCoiozFaLX9fOFoYIkLuhF7m6fUdkVZUSpZSnJxIcJcNDX4Yq1QFqBcumTcUeTdzgcyFZeKglaKXexZaGc6FIkiqw9YTW0McaaxWaK2Wxe+DgEAcaWoVy6bRiEt3b+Oq523j3//7Me6+f4rx0dLxXOkS4Pbh6G0YygYjEblk5W+3+w4ogpDRimYnZ3axz+bxEtddNsmWjSVqpYjIapwPtLqOxVZOt+/oZ4EgQmQ15cRQK0eMVCwT9YgtGyts3VxnfOs4lCPO2zXOpz93N3fdd5Atm6qEo899/tA+PyQ5SQd1+BEUUQ38/smZLiPViDe/7ByuvXSSc86qEkd62cSXfMEHwTmP80JRWwhaFxYRxRZtLV5bHIbmYp98ts34hgpveM1uHtvfoNXOKJeO4jZbfyklrUKxf7rDReeO8r43PpudO0bI2jnzjWwQ4AQJgaUgqdTA3LVCaw1ao1UBVgeLDga8EHxe8HqjWZjrMLa1zrVXbuMrX3+YSjla7f9jZxy80Yr9Mx2evaPOx265jDQ1HHiyWYhEgYQiFsTlEiaKWEoSKIVSekCaNGrgyBICwfljR9t2xnN3T/If33+CfuaJI7PyA6VBSFmzKQ9PclatVtcxUol4783PJi1Z9h/sLLMwGagmrdcojdSJ0oQoiTFJjIkitDUFTwiB4D3B++XvHAVdQbOVsX1LjV07x2i2stUfKQHJcNx+BSFZw+4CrZUPmG9kvOpF2zn/vDEOTHUw5nA4lBBIqmXicgmf5wOAAfEBCYM9RMzxXiC17No5xjH6EPuB3lDgY6NY606sctaoDyyd13uhWrbs3jmC9NxRlExpjY4iQvDrU9YowAUmJ8qUUrs64v/2aeX2QUAr9TmtuE8Ech+olSOqZUs380flX3W4Ilm/5QOl1BLHZpnpaQmf1hJ+qCUwzLa4bEjpK0wItwUfPuv7njRJKMUGd4x2mBzOcevX0AgFCSobj3OeyNg8U/GfnBS3749sHdr2jNbzOgj0IR5RWKuWo/ppX8FjrWG+tJlmTyglxndVUnHOD21itrp911Ba997T7XR+DwSVK/IyuKBRcmbAKwmIMSzE4yy6QEWTasInSvWRVxgbIUOcw45UKkOBBz453W1d0e91wRvINUIKSq+zc5+wq0EUcmLxKBcolSsv37hhwwdF5NZhsod1Lh8G/Fal1DvVUi27guH9spYa/OO9e4/3/uNAZ83RflhCJ6DPmIaHsARhlUZOA3jhGYf8cBIEwukE/0xeQ/uePokfUM9Q8NGwhZrVeu34lVL7lNYPoPTuM9ayXWM721r7oNeqOYxTWu/Xzru11risf5Vz+QNK661aIPdF++lMRnwpDoPSgtaC925vp926NgxJtOyhmalhSU4DkTusNe9a6AYXGwlprOJwhgwhCMRWiVGBEIKySUSe539/aHqqPzS9HUbzy9ze6Hf3Mrm12ZOZt19Xevnmuv76TPP0MzwRMInFNx1PPvmUanfdw+m2zZcmaanrsoxhhwRD+fxSxPMB2T/vZ26+MuWVz0umZubyYqig1iUIHxe4NQomUu785j71+FSbzaP2bxfn57sbNyeYOB66vrBTs01ACDrBqwj1NBEjCMy3A2++uswtL63SaPinMofXCnMCDz3FSk6oVSPspjLfuXMfn7xjLxtGkl8kif14nvWZOXgQu0ZeLxJweU7e72Pf9CtnEZSl3JsmzhfIojq5rR63HeZCoYZXXV4i7yu6Th/QmsckyLlqpeqVWu7YFCOtEwu0kmjiWBG8kPuiN2iNhkRDycJixhe/9DAf+LuHyfLAdqt/o5v1nQiERnMAXB1D9AqjAjZvkbVb6MhSHR2nNrER9dP5Ht7EVDv72TJ3F5XmI9B+ArSBaPzYBYuCRjPQzQLWaFzuPuNz9zal1arq05NUyiTVCuE4sUUE0ljR6QvTi45KqhivGnIHzUGP//7HW3zhW/u48+4Zbnr+Rt5w3dbbfvJI45a5ZkZk9XHsTaEJlPI5XICF0tlM7rqIXZddxsjGTYxu2oz62n5BCWQRiIK0D5ML93LWzPcYaT6C9T168RjOVo5txkoVFxV6/Z8GHy5eKQAJgjKa8mi90P4xuEEaKTIn/NFXZvi/fX22jKf4/iJPTc0x3w7sn+2x2M65ZGeNt9y0nZuvP+v71cnSNd25HsEFjrA2FKIg9h2ifIGgUxZLZ/PI2IuZGb2A0QmwFvodyLqg/uXxbAUojTOWfgyRgw0Le9mwcC/jjQeodx7H6ZR+aePAI+SIDCDeT/gs/xGE81bGneA8ab1KXCkTnDsKfCXRtPuBt/7VAe5/vM/miRTpz0O/weYNFXZvr3LlBWNc9Zxx6ptK9/pmdk2rmbeT2KDVUrGh0XjifB5Cn166jZnKBUxVL2a6+iy8gSQHl7kiKA4EtgL8qoiuDP1Y4zXUO13GGg+z+dCPmZj+Mf3yJN6WUbLClKXoyuaZuzOK9EuKGxSDYYUxVMZGijiwKiILUEs1P3+yz8+e6DFZt5y7yVJLDfWyJZoogYCbbX+1E/RrZZVni7Ik2RxR3uTgyKUcqD+f2cp5LKYljEDqAib4Y8acY4JfLQpnLb0EbIBtD93J5p99AbQmJCMgASVC0AZvU/o9/94o0p8YG0uXO7zeeZJKidJIDe/cUZ4jAap1g001OIEcggesodHqMz+1QGx5S5xEn499Cy0eGYyAbXeebjrJw+f/FgfGLiDTUMoh9o6nG7+voRAQrMup5YKzEY9fdCO9ZJRND/wDIh6xMUFZ4rxJ0psnN6O62crwXhgbS7GDgJR1umhriMtHm7/S0G55aPmCyBhFFEc05zocemqONFZExhjbmuZQup3MlNHiML6HVM/mF7tez6GJrdS6gZJ3iFJrSrBrroJEKYzLqTQ0i+e+gLmNF9OaW0AZgzcJKnguf+gvGZ25T/J4G1nmmJ5uU68nVGsxYhT9RgsEkloF8R5ZxYmVVkSRRSRwYN8sjZkGGzZWSFJDpfVkeHDjS7hr6xuxIUOLQ7xQHS+TpobRVo6o4pxr7weuU3X21T3di03wW3fe9ac3VmZ+/r5WfQfiPSEIpTSiXImwVqGBqJwSlUtorZczgAK893TaGbMHF3C9jMlNNeLEUG/sZc+GGz7ywI43fzuWsOdVF5SfWJ9m6DqBv+O+ZiM3tZp3jt33fkBqC3tUp7atCFauGGhEkUFrRfAebQzamOVJjAC9bk6v06dajdkwWUMrodLaz5P1y+R/tr1XIVBRjf2vvqS+/RkD/p9/tviNdhbfpAmQVPAedv30w2yY+V9atWcVTi3FhSZZcadFJCDC8mWnJLGMjJaoVBPE5dQ7+9g7dg33bH0HCohcG4+mkvT/+pXPGX3bqZ57XdpY3dzcABDQ0O9gDOy55A+ZnbyCcusAymUE9OG5/FI/SGmMNaSlmPGJMps2VylXE+i3qXafYu/4tfxkSwHcDoADdDP7pl+q5r/zaOt8o/SvgXndwQW5NHcBPWB3GsHbMsbA5N4vsXPvHXSSCXJTRiForTBGEceGODZEkcYYjQuKOG+Qugb3bHk9j42+DCUQ+XYhWMD5QBpbNo1wt+D/USR8+fqd1UdPK/jvPto6F9HvEsyNgjlHxKYAqYGFvjDX6BSFyLJJCRKVCQq2zHyDyw/cTs/WyaI6RgnGFFZQmH3AYyjn89jQ54fbf5Op6tUoL0ShS1hBa3wQJuolKrEi90sM03UV/hcK/w1UuO36ndXHTwn8d/e2XySom8FcOwBbOs7oDoDZRp/M+eVrZksCcDpFWc1k+0dcvf/zOBXTtmMQDuf6oAzVbBZB84PttzBbuRDrcrTkBZlZUdqmsWWiFuPDiRourqvwe8D/l0Juv/6cyg9OCP67e5ujYG4VzA2COV/ExmtumxpY7AYWWt0jtD8oNQgqwtuIifaDXL3vUyg87XhDMXdTmlp/ir6p8f3t76dROgub91DH4GfOB8brZWrJYa2vrfvk+gr/kMJ/C/yHrj+n1loG/5+PdT7kfemDcpKXRa0u6vzZRg/nD/v+ylpBUORRynj7Ia7Z/0m0eJrxRur9gwPgv8NiaRtR3j1mJ8EHIbaaTSMpXk5l8i1iTfd3r9tR/rj6+s8bd4iuvqaWKHwoGgsn1TQ30OgJ883OUdpnRWvE2xJJtsALpz7F1uxB9qaX86NN7yLYFOs6R5j5UVqvlaileiitH5HaFBgNjV7A0P6i+vI9zTzLseP1MiOpJgsnJ9Wn0/6SAILAxGgJnbXQe75J2P06+gKNRgd9HE6+HlpXCmINCz1hrtGmnNCxoI0xirlmlyAlRkoakUG7aojlQqH9UhKx2O6hj6FBHwKjtQpzhxb49j/dzsP3P8glVyxywyt/nfFamUONNsdqqIoI5TQeXG07OcUoBYc6nka7jzWGIJKqL9/TDkGUEhGcF+qVhImyJTC8AKyGvofZxe4RmWApUo/Vyxw8sJ+v/fnv05yZojw6TmdhjtEt27jx7X/A2Tt3sdDsHvU9YwqtC8Nr3eqCyc22Ha1OD2MKsmU1old2YyJraLR7zLZz1MA/htV+aqGcRvgVTYslN9gxCr49TWN6ivrms4jKFUa2bGP60UfozDzGjtGihPYr8lgQoZLGGD08cDMAPtPKaXb6WGuPaHvp1bV7ZA2tbsbUYlZMR/SwsRRqqcVoRe4Czgcqaczm0RJBYNP2XWy94EKMgjRNwTt2XXEVF73gxeQeNo2WSWKL84HcBSJrqCR6aCuMTHGWg42Mdm+p0SlPz+2t0fSynJnFHtnAl4f1/ZFKijWakUrKhlqEUuB8weYiG5EkKXGckCQpxloQIQ+FsDfWk+Xv18sJkRpO65EpZojTiz16WX7M7HPCwsYaTeY804tdem44C8g9VBPNlrES9ZLBB/ADofTaTXrtFihNCAG0ptdq0Wk3iTRkg3RbLxm2jBU0NhtC67GGzMHUQofc+eMCf9qqzprijvxCq09guFHYkpmu5A5agXd5cbF4qYOqND7Pyfo9llrwIizT12HM3WrIBQ41e/hBoDylktYaTT93NHoBO6T/ryZMurg4RAh+OfAoXYDP+11WU4NhCZdS0OoVb37YNUTrNcHRStHLHC6APpW5oyp8vuidr5j55xm9Xht9Ct2F4m1L6GVuzRZq1yZRNXiN9NSHrkUjQx1FYpzkR2jCaHi6OOs57B5aFRwjiCy/ybVu3dvTPXgP3h0hoG4uBDm+rGUAOLWKIOCLO3JopQhrnAzbpcmKUmfwnlGQYqvikOJ9McwY8O9mVjRHijngCQbfIkWJGytyGUbWQkCCrab+e82eva6wxmNn00LKxZvTpyKiUGgmKKM7ymiU1sv38gcDr5qoooWtFNinsXvnwXmPKIMaWIlWUpxVHQ948RpILfX/9v8DANZcUq3+irKzAAAAAElFTkSuQmCC" alt=""/></div>
                <h3>Get support</h3>
                <p>You have an issue or need help about module usage?<br/>You have some idea or feature request?</p>
                <a href="https://support.geekodev.com" target="_blank" class="btn btn-lg btn-grey">Open a ticket</a>
              </div>
            </div>
            <div class="col-md-6">
              <div class="well text-center">
                <div style="height:80px"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABLCAYAAADNsPFaAAAACXBIWXMAAAsTAAALEwEAmpwYAABERGlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS41LWMwMTQgNzkuMTUxNDgxLCAyMDEzLzAzLzEzLTEyOjA5OjE1ICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgICAgICAgICAgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIgogICAgICAgICAgICB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIKICAgICAgICAgICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgICAgICAgICAgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiCiAgICAgICAgICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICAgICAgICAgICB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyI+CiAgICAgICAgIDx4bXA6Q3JlYXRvclRvb2w+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwveG1wOkNyZWF0b3JUb29sPgogICAgICAgICA8eG1wOkNyZWF0ZURhdGU+MjAxNi0xMi0yMVQyMTowNSswMTowMDwveG1wOkNyZWF0ZURhdGU+CiAgICAgICAgIDx4bXA6TW9kaWZ5RGF0ZT4yMDE5LTA1LTE4VDIxOjA2OjA4KzAyOjAwPC94bXA6TW9kaWZ5RGF0ZT4KICAgICAgICAgPHhtcDpNZXRhZGF0YURhdGU+MjAxOS0wNS0xOFQyMTowNjowOCswMjowMDwveG1wOk1ldGFkYXRhRGF0ZT4KICAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9wbmc8L2RjOmZvcm1hdD4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHBob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4KICAgICAgICAgICAgPHJkZjpCYWc+CiAgICAgICAgICAgICAgIDxyZGY6bGk+eG1wLmRpZDo2NDI2N2M4Mi0wN2JmLWYwNDMtOTQyMS0yMzk3NzliODZjNTU8L3JkZjpsaT4KICAgICAgICAgICAgPC9yZGY6QmFnPgogICAgICAgICA8L3Bob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4KICAgICAgICAgPHhtcE1NOkluc3RhbmNlSUQ+eG1wLmlpZDpiNmNjZWQzYS1hZDQxLTY4NDMtODhhOC0xNjQyZWY2ZTljMTE8L3htcE1NOkluc3RhbmNlSUQ+CiAgICAgICAgIDx4bXBNTTpEb2N1bWVudElEPnhtcC5kaWQ6NjQyNjdjODItMDdiZi1mMDQzLTk0MjEtMjM5Nzc5Yjg2YzU1PC94bXBNTTpEb2N1bWVudElEPgogICAgICAgICA8eG1wTU06T3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6NjQyNjdjODItMDdiZi1mMDQzLTk0MjEtMjM5Nzc5Yjg2YzU1PC94bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpIaXN0b3J5PgogICAgICAgICAgICA8cmRmOlNlcT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+Y3JlYXRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOjY0MjY3YzgyLTA3YmYtZjA0My05NDIxLTIzOTc3OWI4NmM1NTwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxNi0xMi0yMVQyMTowNSswMTowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGltYWdlL3BuZyB0byBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo3YzgwNzlhZi04Zjc5LTkzNGQtYjkwZi05ZWI1NjYwZTk5YjA8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTYtMTItMjJUMDk6NDg6NTgrMDE6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5zYXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOmQ4YTVkOGQ2LTc4ODctNDk0OC1hZTkzLWU5ZTc4YjI0Yzk2ODwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxOS0wNC0yM1QxNTo0NDo0MiswMjowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+ZGVyaXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5jb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZzwvc3RFdnQ6cGFyYW1ldGVycz4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPnNhdmVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6ZjFhMTdkOTUtODQ1NC1lNTQwLThmMTItMDY4ZDBkNTE5NWRiPC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE5LTA0LTIzVDE1OjQ0OjQyKzAyOjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpPC9zdEV2dDpzb2Z0d2FyZUFnZW50PgogICAgICAgICAgICAgICAgICA8c3RFdnQ6Y2hhbmdlZD4vPC9zdEV2dDpjaGFuZ2VkPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDpiNmNjZWQzYS1hZDQxLTY4NDMtODhhOC0xNjQyZWY2ZTljMTE8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTktMDUtMThUMjE6MDY6MDgrMDI6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICA8L3JkZjpTZXE+CiAgICAgICAgIDwveG1wTU06SGlzdG9yeT4KICAgICAgICAgPHhtcE1NOkRlcml2ZWRGcm9tIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgPHN0UmVmOmluc3RhbmNlSUQ+eG1wLmlpZDpkOGE1ZDhkNi03ODg3LTQ5NDgtYWU5My1lOWU3OGIyNGM5Njg8L3N0UmVmOmluc3RhbmNlSUQ+CiAgICAgICAgICAgIDxzdFJlZjpkb2N1bWVudElEPnhtcC5kaWQ6NjQyNjdjODItMDdiZi1mMDQzLTk0MjEtMjM5Nzc5Yjg2YzU1PC9zdFJlZjpkb2N1bWVudElEPgogICAgICAgICAgICA8c3RSZWY6b3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6NjQyNjdjODItMDdiZi1mMDQzLTk0MjEtMjM5Nzc5Yjg2YzU1PC9zdFJlZjpvcmlnaW5hbERvY3VtZW50SUQ+CiAgICAgICAgIDwveG1wTU06RGVyaXZlZEZyb20+CiAgICAgICAgIDx0aWZmOk9yaWVudGF0aW9uPjE8L3RpZmY6T3JpZW50YXRpb24+CiAgICAgICAgIDx0aWZmOlhSZXNvbHV0aW9uPjcyMDAwMC8xMDAwMDwvdGlmZjpYUmVzb2x1dGlvbj4KICAgICAgICAgPHRpZmY6WVJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOllSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpSZXNvbHV0aW9uVW5pdD4yPC90aWZmOlJlc29sdXRpb25Vbml0PgogICAgICAgICA8ZXhpZjpDb2xvclNwYWNlPjY1NTM1PC9leGlmOkNvbG9yU3BhY2U+CiAgICAgICAgIDxleGlmOlBpeGVsWERpbWVuc2lvbj43MDwvZXhpZjpQaXhlbFhEaW1lbnNpb24+CiAgICAgICAgIDxleGlmOlBpeGVsWURpbWVuc2lvbj43NTwvZXhpZjpQaXhlbFlEaW1lbnNpb24+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8P3hwYWNrZXQgZW5kPSJ3Ij8+F5l64gAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAAF5ElEQVR42uyba4hUVRzAf/fOax/q7K6PXR8rhj0RMbUtUyos7YMEmkUiERTRh0KLIgqiKCEhEIkkI0wi6ENE0AvrQ7uiBj7SzKSXEkGpWGrqXDVdZ2fu6cP5j3ud5525O87seP5wmLlnzj337O/+z/9xzllLKYWRXLENAgPGgDFgDBgDxoAxYAyYxpLw7B3OWOCEQZGrMeuBGw2KXDAK+A242eC4HMzDwDlgH/CSQTIIJgXMEs1ZDRwEVgLtxivB70APcB64HlgngNYDdwPW1QbGmrU94b2+CdgMjM9qdxjoA7YD3wKHgItXExiATmAjcF+R+44C3wF/imb9Ii7/BHCqUcFk5FngRQHlV04KnGMyLR3gtHyeAdJ5pqWSKd0BhAHX57NCwAXp3xuoWtLHKflMe17WWRnLSak7VwkYgFHAU8CTwOQGmin9npd2QDzyfmCTgCwJxvt2lgDLgLuAcQ1qWg4Ba4C3/YLxykhgHjBfPNm0BgS1wpq5PRHUF7cD14qbnw50A1OkjBO7MdzkYDhkQdrVVsrKsogWYJemdhrYI8UrUaBNAHWLvWoWjWuRz3QZg1UCud2TyijPy4lIfZdcj5TnV7KCkAiHbAjbELUHn5Jh0Z+CpAuWVVGElwSOS9ldg7ceB8aKNs8AHgRu8XnvBqtnV4KoDSNCg2AycBRwZgAupHxrT73LcuBd0d5C8j3QEwZQCtIqFwxAaxgiFpxP6TbDHM5H4qY3FUhz/gYWUWr+KcBVEA1BPAaxEKSUrhvGsq1A/TFgrgSouR6jb3a8YI8L9jpEbG17BkR7hqECrcijLfuBxcBf2dl1SSiZ35tCMDIKLWKT0sNLe+YBb2TVbQHmeKEAWD27Euy+LV72ExbudUi6gT3XlZRpwF4g5qn7FHgg73pMJVDI2B4b4lFojQzapDqVbmBrFpT3C0EBsIKcj5m728FCa0syDSm3LrWmDfgBuMZTtwZ4oeiyQ9CDQ7N3Olr1hIhSutSJRCUume6pex5YW+rGwHlMdlxjWbrUCaDeLCiPAR/4ubFqCZ7l0aAayefAnZ7rJcAXfm8ODCbtXh4Q5oNTA7uzUeISJNJdBOwop4PAYNwsILYXRG20ZTXwuHw/AixEr9KVp/FBjO/MHc6lv92mLjzSSvTWD8DPwL2S/5RvO4OMIiVUQvUBZbkHyhbg1kqhBNKYqdscwrJcYdU+uJsD7JTvnwAPBfa2QbSl2YaQVXMoY9CbgADvDAWUiozv5K0OKRdawhCzB6dTjcRGrw5GgFeA14eq47LBDLg6NmkN1UVuZANvicbsG9I4rLMvwT/3lE4kOzc7WBZcTEM8Al0xvSbTqGKnFIzpc4pP4j4HV0F/GsIWdET976MOVwlnXvpoD5yTC+K09TqWpd2wssTYphSMb9G25aLb2GdD8tqYjl4HF1TI44HSCiY1Q1tEFqYGmz8CLBXv0A98BbwH/BdwbLdL0neDBNh7ZA3lwJUAY3X0JnIqldI7YbaE9SkFE5v1FEq6l4zuGPQK2B15+v0DuB/4qcJxrQWeK/DbM55ArqpWvagkXehqgtExPX089ravABSAqRJwdVUwpleLQEG80NKagbGApNIeqCOmV+i4fPrMKNF3K/BymeMZD7zmo906qnx4u2DnaaU9UGeThpS1ybzMZ/+LJJXyK4t9tpsouVD1wXh3yJVMoc4YNIdzjC1lTJGx6A18vzKpjLbdVfdKrhjczBmtlEBpj+gplMctH/PZ/7/oI2d+5UgZbQ9XVWPSCkZHYUqL9jyTmmFKq55CbuGs+WOf/X9NeUc9vvTZ7ihVPkFhK3TANiKs859MUcX3qD8EfizR91lgVZnjOerT+K6gysG3DRpAKquUSIMU+mB0oXXUQ+iF6OMVjGkV8GaR5z4NfFb1AG/UNwkmNGm3PFDZO3gCfSZ4gtiULegzKGcCjm0+8ChwHTAg2fMG4NcrEvma/9SvMPI1YIwYMAaMAWPAGDAGjAFjwBgwBowBY8SAMWAMmCGV/wcAW96kU8ix6wIAAAAASUVORK5CYII=" alt=""/></div>
                <h3>Feedback</h3>
                <p>If you like this module, please consider to leave a comment on module page, or <a href="https://www.opencart.com/index.php?route=account/rating" target="_blank">a rating</a> from your account.</p>
                <a href="https://www.opencart.com/index.php?route=extension/extension/info&extension_id=<?php echo $OCID; ?>" target="_blank" class="btn btn-lg btn-grey">OC module page</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <style type="text/css">
        #tab-about .well p{font-size:13px; min-height:55px}
        #tab-about table td{font-size:13px; padding: 13px 5px;}
        #tab-about table tr td:first-child{font-weight:bold;}
        #tab-about .btn-grey{background: #818181; color: white; border-color: #6b6b6b;}
        #tab-about .btn-grey:hover{background: #646464; color: white; border-color: #727272;}
      </style>
		</div>
    <?php } ?>
  	</div>
  </div>
</div>
	</form>
</div>
<div class="modal" id="newAliasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $_language->get('text_seo_new_alias_title'); ?></h4>
      </div>
      <div class="modal-body">
	<form class="form-stacked" role="form">
		   <div class="container-fluid">
			<div class="row clearfix modalinfo common"><div class="col-md-12 column"><?php echo $_language->get('text_seo_new_alias_info'); ?></div></div>
			<div class="row clearfix modalinfo special"><div class="col-md-12 column"><?php echo $_language->get('text_seo_new_spec_alias_info'); ?></div></div>
			<div class="row clearfix modalinfo absolute"><div class="col-md-12 column"><?php echo $_language->get('text_seo_new_absolute_alias_info'); ?></div></div>
			<div class="row clearfix modalinfo autolink"><div class="col-md-12 column"><?php echo $_language->get('text_seo_new_autolink_info'); ?></div></div>
			<div class="row clearfix modalinfo redirect 404"><div class="col-md-12 column"><?php echo $_language->get('text_seo_new_redirect'); ?></div></div>
			<hr />
			<div class="row clearfix">
				<div class="form-group">
          <label><?php echo $_language->get('text_editor_query'); ?></label>
					<input class="form-control" name="query" type="text" placeholder="<?php echo $_language->get('text_editor_query'); ?>"/>
				</div>
				<div class="form-group">
        <label class="modalinfo common special"><?php echo $_language->get('text_editor_url'); ?></label>
        <label class="modalinfo absolute"><?php echo $_language->get('text_editor_url'); ?></label>
        <label class="modalinfo redirect 404"><?php echo $_language->get('text_editor_url_redirect'); ?></label>
        <label class="modalinfo autolink"><?php echo $_language->get('text_editor_url_autolink'); ?></label>
					<input class="form-control" name="keyword" type="text" placeholder="<?php echo $_language->get('text_editor_url'); ?>"/>
				</div>
			</div>
		</div>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary addAlias">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" media="screen" />
<script type="text/javascript"><!--
$('#form').on('submit', function(e) {
  $(this).attr('action', $(this).attr('action') + '&tab=' + $('ul#mainNav li.active > a').attr('href').replace('#', ''));
});

$(function(){
  window.setGaugeMeter = function() {
    $('.radial-progress').attr('data-progress', <?php echo $seo_score; ?>);
  }
  setTimeout(window.setGaugeMeter, 400);
});

// Drag and drop tags
$(document).ready( function() {
  $('.generator .patterns b').draggable({
    helper: 'clone',
    cursor: 'grabbing'
  });
  $('.generator input, .generator textarea').droppable({
    accept: '.generator .patterns b',
    drop: function(ev, ui) {
      $(this).insertAtCaret(ui.draggable.text());
    }
  });
});

$.fn.insertAtCaret = function (myValue) {
  return this.each(function(){
  //IE support
  if (document.selection) {
    this.focus();
    sel = document.selection.createRange();
    sel.text = myValue;
    this.focus();
  }
  //MOZILLA / NETSCAPE support
  else if (this.selectionStart || this.selectionStart == '0') {
    var startPos = this.selectionStart;
    var endPos = this.selectionEnd;
    var scrollTop = this.scrollTop;
    this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
    this.focus();
    this.selectionStart = startPos + myValue.length;
    this.selectionEnd = startPos + myValue.length;
    this.scrollTop = scrollTop;
  } else {
    this.value += myValue;
    this.focus();
  }
  });
};


// Category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
    if (request.term != 'undefined') {
      request = request.term;
    }
    
		$.ajax({
			url: 'index.php?route=module/complete_seo/category_autocomplete&<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item, item2) {
    if (item2.item.value != 'undefined') {
      item = item2.item;
    }
    
		$('input[name=\'category\']').val('');

		$('#product-category' + item['value']).remove();

		$('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="mlseo_fpp_categories[]" value="' + item['value'] + '" /></div>');
	}
});

$('body').delegate('.editorColumns', 'change', function() {
  if ($(this).prop('checked')) {
    $('#seo_editor_product th:nth-child('+$(this).attr('data-index')+'), #seo_editor_product td:nth-child('+$(this).attr('data-index')+')').show();
  } else {
    $('#seo_editor_product th:nth-child('+$(this).attr('data-index')+'), #seo_editor_product td:nth-child('+$(this).attr('data-index')+')').hide();
  }
  
  $('#seo_editor_product th:nth-child(1)').css('width', '1%');
});

$('#product-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

$('input[name=mlseo_enabled]').change(function(){
if ($(this).val() == 1) {
  $('.radial-progress').attr('data-progress', <?php echo $seo_score; ?>);
} else {
  $('.radial-progress').attr('data-progress', 0);
}
});
$('select[name=store]').change(function(){
	document.location = 'index.php?route=module/complete_seo&<?php echo $token; ?>&store_id='+jQuery(this).val();
});
$('body').on('click', '.gkdwidget .icon', function(){
  $(this).closest('.gkdwidget').find('.gkdwidget-container').slideUp(function(){
    $(this).closest('.gkdwidget').find('.active').removeClass('active');
  });
});
$('body').on('click', '.gkdwidget a[data-toggle="tab"]', function(){
  $(this).closest('.gkdwidget').find('.gkdwidget-container').fadeIn();
});
$('.toggler').toggler();
$('input.switch').iToggle({easing: 'swing',speed: 200});
jQuery.each( jQuery('input.checkable'), function(){ jQuery(this).prettyCheckable(); });

$('select[name="mlseo_flag_mode"]').on('change', function() {
  var flagmode = $(this).val();
  
  $('input[name="mlseo_flag"]').val(flagmode == 'tag' ? 1 : '');
  $('input[name="mlseo_store_mode"]').val(flagmode == 'store' ? 1 : '');
  
  $('[class^="flagmode-"]').fadeOut('fast', function(){
    $('.flagmode-'+flagmode).fadeIn();
  });
});

$('select[name="mlseo_flag_mode"]').trigger('change');

<?php if (false && !$OC_V2) { ?>
$('#tabs a').tabs();
$('#tabs_editor a').tabs();
$('#language-friendly a').tabs();
$('#tabs_editor_lang a').tabs();

$('#stores a').tabs();
<?php foreach ($stores as $store) { ?>
$('#language-<?php echo $store['store_id']; ?> a').tabs();
<?php } ?>
<?php }/*!OC_V2*/ ?>

<?php if (count($languages) > 3) { ?>
$('#tabs_editor_lang ul > li > a').on('click', function(){
$('#tabs_editor_lang > li > a > img').attr('src', $(this).find('img').attr('src'));
});
<?php } ?>

function reset_urls(type, lang){
	location = '<?php echo str_replace('&amp;', '&', $_url->link('module/complete_seo/reset_urls', $token, 'SSL')); ?>&type='+type+'&lang='+lang;
}
function seo_update(type, mode){
  $('html,body').animate({scrollTop:$('#update_result').offset().top}, 500);
	$('#loading').show();
  
  $('#generateProgress').show();
  $('#generateProgress .progress-bar').addClass('active');
  
  $('#generateProgress .progress-bar').css('width','0%').css('min-width', '2em').html('0 %');

  $('#update_result tbody tr:not([data-lang])').remove();
  
  processQueue(type, mode, 0);
  return '';
  
	//$('#update_result *').fadeOut();
	/*$('#update_result').html('<img style="padding-left:40%" src="view/seo_package/img/bigloader.gif"/>');
	$.ajax({
		url: 'index.php?route=module/complete_seo/generator&type='+type+'&mode='+mode+'&<?php echo $token; ?>',
		data: $('#tab-update :input').serialize(),
		dataType: 'text',
		success: function(data){
			$('#update_result').html(data);
			$('#loading').hide();
		}
	});
  */
}
function display_old(){
	$('.toggle').toggleClass('active');
	$('.res_table td:nth-child(3)').toggle();
}
function fullscreen(){
	if ($('#update_result').hasClass('full')){
		$('.fullscreen').removeClass('active');
		$('#update_result').removeClass('full');
		$('html, body').css({'overflow': 'auto','height': 'auto'});
	} else {
		$('.fullscreen').addClass('active');
		$('#update_result').addClass('full');
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	}
}

function processQueue(type, mode, start) {
  $.ajax({
    url: 'index.php?route=module/complete_seo/generator&type='+type+'&mode='+mode+'&start='+start+'&store=<?php echo $store_id; ?>&<?php echo $token; ?>',
    type: 'POST',
		data: $('#tab-update :input').serialize(),
		dataType: 'json',
		success: function(data){
      if (data.success) {
        $('#generateProgress .progress-bar').css('width',data.progress + '%').html(data.progress + ' %');
        
        if (data.log.langs) {
          $.each(data.log.langs, function(lang_id, lang) {
            $.each(lang.rows, function(i, item) {
              var img = name = changed = '';
              if (lang.lang_img) {
                img = '<img src="'+lang.lang_img+'" alt=""/>';
              }
              
              if (item.link) {
                name = '<a href="'+item.link+'" target="_blank">'+item.name+'</a>';
              } else {
                name = item.name;
              }
              
              if (item.changed) {
                changed = ' class="c"';
              }
              
              $('#update_result tr[data-lang="'+lang_id+'"]').before('<tr><td>'+img+'</td><td>'+name+'</td><td>'+item.old_value+'</td><td'+changed+'>'+item.value+'</td></tr>');
            });
            
            if (lang.no_main) {
              $('#update_result table td:nth-child(2), #update_result table th:nth-child(2)').hide();
            } else {
              $('#update_result table td:nth-child(2), #update_result table th:nth-child(2)').show();
            }
            
            if (lang.no_old) {
              $('#update_result table td:nth-child(3), #update_result table th:nth-child(3)').hide();
            } else {
              $('#update_result table td:nth-child(3), #update_result table th:nth-child(3)').show();
            }
          });
          
        }
        
        if (!data.finished) {
          processQueue(type, mode, data.processed);
        } else {
          $('#generateProgress .progress-bar').removeClass('active');
          $('#loading').hide();
          if ($('#update_result tbody tr:not([data-lang])').length == 0) {
             $('#update_result table tbody').append('<tr><td colspan="4" style="padding:30px 0" class="text-center"><?php echo $_language->get('text_nothing_changed'); ?></td></tr>');
          }
        }
      }
		},
    error: function(xhr) {
      $('#generateProgress .progress-bar').removeClass('active');
      $('#loading').hide();
      if (xhr.responseText.length > 1000) {
        alert('Your session has terminated, please log-in again');
      } else {
        alert(xhr.responseText);
      }
    }
	});
}
$(document).ready(function () { 
  $('input[name="simulate"]').on('change', function() {
    if ($(this).val() == 1) {
      $('#update_result .write').hide();
      $('#update_result .simu').show();
    } else {
      $('#update_result .simu').hide();
      $('#update_result .write').show();
    }
  });
});
--></script>
<script type="text/javascript"><!--
var editor_type, editor_lang;

var columnsArray = function(type){
	if (type == 'product') {
		return [
			{'width': '1%', 'orderable': false, 'searchable': false},
			{'width': '21%'},
			{'width': '13%'},
			{'width': '13%'},
			{'width': '13%'},
			<?php if (version_compare(VERSION, '1.5.3', '>=') && !$store_id) { ?>
			{'width': '13%'},
			<?php } ?>
			{'width': '13%'},
			{'width': '13%', 'orderable': false, 'searchable': false}
		];
	}
	else if (type == 'category') {
		return [
			{'width': '1%', 'orderable': false, 'searchable': false},
			null,
			{'width': '25%'},
			{'width': '15%'},
			{'width': '15%'},
			{'width': '15%'}
		];
	}
	else if (type == 'information') {
		return [
			null,
			{'width': '22%'},
			{'width': '19%'},
			{'width': '19%'},
			{'width': '19%'}
		];
	}
	else if (type == 'manufacturer') {
		return [
			{'width': '1%', 'orderable': false, 'searchable': false},
			null,
			{'width': '22%'},
			{'width': '19%'},
			{'width': '19%'},
			{'width': '19%'}
		];
	}
  else if (type == 'image') {
		return [
			{'width': '1%', 'orderable': false, 'searchable': false},
			null,
			{'width': '25%'},
			{'width': '25%'},
			{'width': '25%'},
		];
	}
	else if (type == 'common' || type == 'special' || type == 'redirect' || type == 'absolute' || type == 'autolink') {
		return [
			{'width': '47%'},
			null,
			{'width': '50px', 'orderable': false, 'class': 'center'}
		];
	}
  else if (type == '404') {
		return [
			null,
			{'width': '5%'},
			{'width': '50px', 'orderable': false, 'class': 'center'}
		];
	}
}
// save number of rows to display between each table
var lastPageLength = 10;
$('#tab-editor').on('change', '.dataTables_length select', function(e) {
	lastPageLength = this.value;
});

function reloadCurrentTable() {
	editor_type = $('#tabs_editor li.active > a').attr('editor-type');
	lang = $('#tabs_editor_lang li.active > a[editor-lang]').attr('editor-lang');
	
	$('#seo_editor_'+editor_type).dataTable().api().page.len(lastPageLength);
	$('#seo_editor_'+editor_type).dataTable().api().ajax.url('index.php?route=module/complete_seo/editor_data&type=' + editor_type + '&lang=' + lang + '&store=<?php echo $store_id; ?>&<?php echo $token; ?>').load();
}
	
$(document).ready(function() {

	<?php if (!$store_id  || ($store_id && $mlseo_multistore)) { ?>
	$('#tabs_editor a, #tabs_editor_lang a[editor-lang]').on('shown.bs.tab', function() {
    if ($(this).hasClass('ml-hide')) {
      $('#tabs_editor_lang').hide();
    } else {
      $('#tabs_editor_lang').show();
    }
    
		editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
		lang = $('#tabs_editor_lang li.active > a[editor-lang]').attr('editor-lang');
		is_instancied = $($('#tabs_editor > li.active > a').attr('href') + ' .dataTable').length;
		if (!is_instancied) {
			$('#seo_editor_'+editor_type).dataTable({
				"processing": true,
				"serverSide": true,
				"ajax": 'index.php?route=module/complete_seo/editor_data&type=' + editor_type + '&lang=' + lang + '&store=<?php echo $store_id; ?>&<?php echo $token; ?>',
				"order": [1, 'asc'],
				"lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
				"pageLength": lastPageLength,
				"language": {
					paginate: {
						first: '<<',
						previous: '<',
						next: '>',
						last: '>>'
					},
					"processing": '<img style="z-index:10;position:absolute;left:43%" src="view/seo_package/img/bigloader.gif"/>',
					"info": '_START_ - _END_ / _TOTAL_',
					"infoFiltered": ''
				},
				"columns": columnsArray(editor_type)
			});
      
      $('#seo_editor_product').on('column-sizing.dt', function () {
        if (editor_type == 'product') {
          //$('.editorColumns').trigger('change');
          $('#seo_editor_product th:nth-child(1)').css('width', '1%');
        }
      });
      
      $('#seo_editor_'+editor_type).on( 'draw.dt', function () {
        var titleIdx = $('#seo_editor_'+editor_type+' th[data-column="meta_title"]').index();
        
        if (titleIdx > 0) {
          $.each($('#seo_editor_'+editor_type+' tbody tr'), function(){
            setLimitColor($(this).find('td:eq('+titleIdx+') a'));
          });
        }
        
        var descIdx = $('#seo_editor_'+editor_type+' th[data-column="meta_description"]').index();
        
        if (descIdx > 0) {
          $.each($('#seo_editor_'+editor_type+' tbody tr'), function(){
            setLimitColor($(this).find('td:eq('+descIdx+') a'));
          });
        }
        
        if (editor_type == 'product') {
          $('.editorColumns').trigger('change');
        }
      
        //$('#seo_editor_'+editor_type+' .ttip').tooltip();
      });
		}
		else {
			reloadCurrentTable();
		}
	});
	
	$('#tabs_editor a:first').trigger('shown.bs.tab');
  <?php } ?>
  
  function setLimitColor(el, len, type) {
    len = typeof len !== 'undefined' ? len : false;
    type = typeof type !== 'undefined' ? type : false;
    
    if (!type) {
      var type = $(el).closest('.seo_editor').find('th').eq($(el).closest('td').index()).attr('data-column');
    }
    
    if (type == 'meta_title') {
      var limit_low = 67;
      var limit_hi = 85;
    } else if (type == 'meta_description') {
      var limit_low = 300;
      var limit_hi = 320;
    } else {
      return;
    }
    
    if (len !== false) {
    } else if (el.tagName == 'TEXTAREA' || el.tagName == 'INPUT') {
      len = $(el).val().trim().length;
    } else {
      len = $(el).html().length;
    }
    
    if (len > limit_hi) {
      $(el).css('color', '#f23333');
    } else if (len > limit_low) {
      $(el).css('color', '#fc7402');
    } else {
      $(el).css('color', '#333');
    }
  }
  
  // title and desc length
  $('.seo_editor').on('focus keydown keyup', '.editable-input textarea, .editable-input input', function(e) {
    setLimitColor(e.target);
	});
  
  $('.store_seo_title').on('focus keydown keyup', function(e) {
    setLimitColor(e.target, false, 'meta_title');
	});
  $('.store_seo_desc').on('focus keydown keyup', function(e) {
    setLimitColor(e.target, false, 'meta_description');
	});
  $('.store_seo_title,.store_seo_desc').trigger('keyup');
  
	// editor
	$.fn.editable.defaults.mode = 'inline';
	$.fn.editable.defaults.emptytext = '';
	
  <?php /*
  var products = [<?php foreach ($products as $p) { ?>{id:'<?php echo $p['product_id']?>', text:'<?php echo $p['name']?>'},<?php } ?>];
  */ ?>

  var select2Active = false;
  
  $('.seo_editor').on('click', 'a.select2', function(e) {
    var select =  $(this).parent().find('select');
    if (!select.is(':visible')) {
      $('.select2-input').hide();
      $('a.select2').show();
      $(this).hide();
      $(this).prev().show();
      select.attr('data-pk');
      select.select2({
        minimumInputLength:1,
        width: '100%',
        placeholder: 'Choose product',
        ajax: {
          url: 'index.php?route=module/complete_seo/product_search&<?php echo $token; ?>',
          dataType: 'json',
          delay: 250,
        }
      });
    }
    select2Active = true;
  });

  $('.seo_editor').on('click', 'button.select2-submit', function(e) {
    e.preventDefault();
    
    $.ajax({
      url: 'index.php?route=module/complete_seo/editor_update&<?php echo $token; ?>',
      data: {
        'pk': $(this).parent().parent().find('select').attr('data-pk'),
        'col': $(this).parent().parent().find('select').attr('data-col'),
        'value': $(this).parent().parent().find('select').val(),
        'store': '<?php echo $store_id; ?>',
      },
      dataType: 'json',
      method: 'post',
      success: function(data){
        $('a.select2[pk='+data.pk+']').html(data.msg);
        $('.select2-input').hide();
        $('a.select2').show();
        
        var $e = $('a.select2[pk='+data.pk+']').closest('td');
                    
        $e.css('background-color', '#9EC499');
        setTimeout(function(){
          $e.css('background-color', '');
          $e.addClass('editable-bg-transition');
          setTimeout(function(){
             $e.removeClass('editable-bg-transition');  
          }, 1700);
        }, 10);
      },
      error: function(xhr){
        if (xhr.responseText.length > 1000) {
          alert('Your session has terminated, please log-in again');
        } else {
          alert(xhr.responseText);
        }
      }
    });
  });
  
  // close selector on click elsewhere
  $('html').on('click', function(e) {
    if (!select2Active && !$('.select2-container').is('.select2-container--open')) {
      $('.select2-input').hide();
      $('a.select2').show();
    }
    select2Active = false;
  });
  
  // prevent closing selector
	$('.seo_editor').on('select2:unselect select2:close', '.select2-input', function(e) {
     select2Active = true;
	});
	$('.seo_editor').on('click', '.select2-container--open', function(e) {
      select2Active = true;
	});
  
	$('.seo_editor').editable({
		selector: 'a[data-pk]',
		highlight: false,
		ajaxOptions: {dataType: 'json'},
		success: function(response, newValue) {
			
			var $e = $(this).closest('td');
                    
			$e.css('background-color', '#9EC499');
			setTimeout(function(){
				$e.css('background-color', '');
				$e.addClass('editable-bg-transition');
				setTimeout(function(){
				   $e.removeClass('editable-bg-transition');  
				}, 1700);
			}, 10);
			
			if (!response) {
				return "Unknown error";
			} else if (response.status == 'error') {
				return response.msg;
			} else if (response.status == 'success') {
        setLimitColor($e.find('.editable'), response.msg.length);
				return {newValue: response.msg};
			}else if (response.status == 'success-related') {
        $e.html(response.msg);
        //$('a.related[data-pk="'+response.pk+'"]').text(response.msg);
				//return {newValue: response.val};
			}
			
		},
	    error: function(response, newValue) {
			return 'Request error (session terminated ?)';
		},
		url: 'index.php?route=module/complete_seo/editor_update&<?php echo $token; ?>&store=<?php echo $store_id; ?>'
	});
  
	$('.seo_editor').on('click', 'td', function(e) {
    $('.editable').editable('option', 'params', {
      'type': $('#tabs_editor > li.active > a').attr('editor-type'),
      'col': $(e.target).closest('.seo_editor').find('th').eq($(this).index()).attr('data-column'),
      'lang': $('#tabs_editor_lang li.active > a[editor-lang]').attr('editor-lang')
    });
    
    if ($(this).find('.select2-input').is(':visible')) {
      select2Active = true;
    }
    
		if ($(e.target).is('td') && $(this).find('> a').length) {
			$(this).find('> a').trigger('click');
			return false;
		} else if ($(e.target).is('td') && $(this).find('> a.modal-related').length) {
			$(this).find('> a.modal-related').trigger('click');
			return false;
		}
	});
  
  $('body').on('click', '.info-btn', function() {
    $('#modal-info').html('<div style="text-align:center"><img src="view/complete_seo/img/loader.gif" alt=""/></div>');
    $('#modal-info').load('index.php?route=module/complete_seo/modal_info&<?php echo $token; ?>', {'info': $(this).attr('data-info')});
  });
  
  $('body').on('click', '.modal-related', function() {
    $('#modal-info').html('<div style="text-align:center"><img src="view/complete_seo/img/loader.gif" alt=""/></div>');
    $('#modal-info').load('index.php?route=module/complete_seo/modal_related&<?php echo $token; ?>', {'id': $(this).attr('data-pk')});
  });
	
	$('.seo_editor').on('click', '.deleteAlias', function(e) {
		if (confirm('<?php echo $_language->get('text_seo_confirm'); ?>')) {
      editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
			$.ajax({
				url: 'index.php?route=module/complete_seo/editor_delete_alias&type='+ editor_type +'&pk='+$(this).attr('data-pk')+'&<?php echo $token; ?>',
				success: function(){ reloadCurrentTable(); }
			});
		}
	});
	$('#newAliasModal').on('show.bs.modal', function (e) {
	  editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
		$('#newAliasModal .modalinfo').hide();
    $('#newAliasModal .' + editor_type).show();
	})
	$('.modal').on('click', '.addAlias', function(e) {
		editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
		lang = $('#tabs_editor_lang li.active > a[editor-lang]').attr('editor-lang');
		$.ajax({
			url: 'index.php?route=module/complete_seo/editor_add_alias&type='+ editor_type +'&lang='+ lang +'&store=<?php echo $store_id; ?>&<?php echo $token; ?>',
			data: $('#newAliasModal form').serialize(),
			success: function(){ $('#newAliasModal').modal('hide'); reloadCurrentTable(); }
		});
	});
	$('.more_actions').on('click', '.restoreAliases', function(e) {
		if (confirm('<?php echo $_language->get('text_seo_confirm'); ?>')) {
			editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
			lang = $('#tabs_editor_lang li.active > a[editor-lang]').attr('editor-lang');
			lang_code = $('#tabs_editor_lang li.active > a[editor-lang-code]').attr('editor-lang-code');
			$.ajax({
				url: 'index.php?route=module/complete_seo/editor_restore_aliases&type='+ editor_type +'&lang='+ lang +'&lang_code='+ lang_code +'&store=<?php echo $store_id; ?>&<?php echo $token; ?>',
				success: function(){ reloadCurrentTable(); }
			});
		}
	});
	$('.more_actions').on('click', '.exportAliases', function(e) {
		editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
		lang = $('#tabs_editor_lang li.active > a[editor-lang]').attr('editor-lang');
		lang_code = $('#tabs_editor_lang li.active > a[editor-lang-code]').attr('editor-lang-code');
		url = 'index.php?route=module/complete_seo/editor_export_aliases&type='+ editor_type +'&lang='+ lang +'&lang_code='+ lang_code +'&<?php echo $token; ?>';
		window.open(url, '_blank');
	});
	$('.more_actions').on('click', '.deleteAliases', function(e) {
		if (confirm('<?php echo $_language->get('text_seo_confirm'); ?>')) {
      var redirOnly = '';
      if ($(this).hasClass('redirOnly')) {
        redirOnly = '&redir_only=1';
      }
			editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
			lang = $('#tabs_editor_lang li.active > a[editor-lang]').attr('editor-lang');
			$.ajax({
				url: 'index.php?route=module/complete_seo/editor_delete_aliases&type='+ editor_type +'&lang='+ lang + redirOnly + '&store=<?php echo $store_id; ?>&<?php echo $token; ?>',
				success: function(){ reloadCurrentTable(); }
			});
		}
	});
});
//--></script>
<?php if ($OC_V2) { ?>
<style>
#update_result{margin-top:40px;}
</style>
<?php } ?>
<?php echo $footer; ?>
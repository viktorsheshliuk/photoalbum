<?php if ($gkd_snippet == 'seo_tab') { if ($_config->get('mlseo_enabled') && ($_config->get('mlseo_multistore') || $item_type == 'manufacturer')) { ?>
<ul class="nav nav-pills nav-stacked col-md-2" id="stores"<?php if (!$_config->get('mlseo_multistore')) echo ' style="display:none"' ?>>
  <?php $first=0; foreach ($stores as $store) {
    if (!$store['store_id'] && $item_type != 'manufacturer') continue;
    if ($store['store_id'] && !$_config->get('mlseo_multistore')) continue;
  ?>
    <li<?php if(!$first) { echo ' class="active"'; $first=1;} ?>><a href="#gkd-tab-store-<?php echo $store['store_id']; ?>" data-toggle="pill"><?php echo $store['name']; ?></a></li>
  <?php } ?>
</ul>
<div class="tab-content col-md-<?php echo (!$_config->get('mlseo_multistore') ? 12 : 10); ?> clearfix">
  <?php $first=0; foreach ($stores as $store) {
    if (!$store['store_id'] && $item_type != 'manufacturer') continue;
    if ($store['store_id'] && !$_config->get('mlseo_multistore')) continue;
  ?>
  <div id="gkd-tab-store-<?php echo $store['store_id']; ?>" class="tab-pane<?php if(!$first) { echo ' active'; $first=1;} ?>">
    <ul id="gkd-tab-store-language-<?php echo $store['store_id']; ?>" class="nav nav-tabs">
    <?php $first=0; foreach ($languages as $language) { ?>
    <li<?php if(!$first) { echo ' class="active"'; $first=1;} ?>><a href="#gkd-store-tab-language-<?php echo $store['store_id']; ?>-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
    <?php } ?>
    </ul>
    
    <div class="tab-content">
      <?php $first=0; foreach ($languages as $language) { ?>
      <div id="gkd-store-tab-language-<?php echo $store['store_id']; ?>-<?php echo $language['language_id']; ?>" class="tab-pane<?php if(!$first) {echo ' active'; $first=1;} ?>">
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-nameinput-seo-name<?php echo $store['store_id'].$language['language_id']; ?>"><?php echo ($_language->get('entry_name') == 'entry_name') ? $_language->get('entry_title') : $_language->get('entry_name'); ?></label>
          <div class="col-sm-10">
            <input type="text" name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['name']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo ($_language->get('entry_name') == 'entry_name') ? $_language->get('entry_title') : $_language->get('entry_name'); ?>" id="input-seo-name<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-fulldesc<?php echo $store['store_id'].$language['language_id']; ?>"><?php echo $_language->get('entry_description'); ?></label>
          <div class="col-sm-10">
            <?php if (version_compare(VERSION, '3', '>=')) { ?>
            <textarea name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $_language->get('entry_description'); ?>" data-toggle="summernote" data-lang="" id="input-seo-fulldesc<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control"><?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['description']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['description'] : ''; ?></textarea>
            <?php } else { ?>
            <textarea name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $_language->get('entry_description'); ?>" id="input-seo-fulldesc<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control summernote"><?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['description']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['description'] : ''; ?></textarea>
            <?php } ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <btn class="btn btn-block btn-default btnSeoGen" onClick="seoPackageGen('all', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i> Generate all SEO values</btn>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-keyword<?php echo $store['store_id'].$language['language_id']; ?>"><?php echo $_language->get('entry_keyword'); ?></label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][seo_keyword]" value="<?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['seo_keyword']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['seo_keyword'] : ''; ?>" placeholder="<?php echo $_language->get('entry_keyword'); ?>" id="input-seo-keyword<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_keyword', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-h1<?php echo $store['store_id'].$language['language_id']; ?>">SEO H1</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][seo_h1]" value="<?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['seo_h1']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['seo_h1'] : ''; ?>" placeholder="SEO H1" id="input-seo-h1<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h1', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-h2<?php echo $store['store_id'].$language['language_id']; ?>">SEO H2</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][seo_h2]" value="<?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['seo_h2']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['seo_h2'] : ''; ?>" placeholder="SEO H2" id="input-seo-h2<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h2', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-h3<?php echo $store['store_id'].$language['language_id']; ?>">SEO H3</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][seo_h3]" value="<?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['seo_h3']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['seo_h3'] : ''; ?>" placeholder="SEO H3" id="input-seo-h3<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h3', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <?php if ($item_type == 'product') { ?>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-image-alt<?php echo $store['store_id'].$language['language_id']; ?>">Image alt</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][image_alt]" value="<?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['image_alt']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['image_alt'] : ''; ?>" placeholder="Image alt" id="input-image-alt<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('image_alt', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-image-title<?php echo $store['store_id'].$language['language_id']; ?>">Image title</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][image_title]" value="<?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['image_title']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['image_title'] : ''; ?>" placeholder="Image title" id="input-image-title<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('image_title', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <?php } ?>
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-meta-title<?php echo $store['store_id'].$language['language_id']; ?>"><?php echo $_language->get('entry_meta_title'); ?></label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['meta_title']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $_language->get('entry_meta_title'); ?>" id="input-meta-title<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('meta_title', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
            <?php if (isset($error_meta_title[$language['language_id']])) { ?>
            <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-meta-description<?php echo $store['store_id'].$language['language_id']; ?>"><?php echo $_language->get('entry_meta_description'); ?></label>
          <div class="col-sm-10">
            <div class="input-group">
              <textarea name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $_language->get('entry_meta_description'); ?>" id="input-meta-description<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control"><?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['meta_description']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['meta_description'] : ''; ?></textarea>
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('meta_description', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $store['store_id'].$language['language_id']; ?>"><?php echo $_language->get('entry_meta_keyword'); ?></label>
          <div class="col-sm-10">
            <div class="input-group">
              <textarea name="seo_<?php echo $item_type; ?>_description[<?php echo $store['store_id']; ?>][<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $_language->get('entry_meta_keyword'); ?>" id="input-meta-keyword<?php echo $store['store_id'].$language['language_id']; ?>" class="form-control"><?php echo isset(${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['meta_keyword']) ? ${'seo_'.$item_type.'_description'}[$store['store_id']][$language['language_id']]['meta_keyword'] : ''; ?></textarea>
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('meta_keyword', '<?php echo $language['language_id']; ?>', '<?php echo $store['store_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if ($item_type == 'manufacturer') { ?>
      <?php if (version_compare(VERSION, '2', '>=')) { ?>
      <link href="view/javascript/codemirror/lib/codemirror.css" rel="stylesheet" />
      <link href="view/javascript/codemirror/theme/monokai.css" rel="stylesheet" />
      <script type="text/javascript" src="view/javascript/codemirror/lib/codemirror.js"></script> 
      <script type="text/javascript" src="view/javascript/codemirror/lib/xml.js"></script> 
      <script type="text/javascript" src="view/javascript/codemirror/lib/formatting.js"></script> 
      <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
      <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
      <script type="text/javascript" src="view/javascript/summernote/summernote-image-attributes.js"></script> 
      <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 
      <?php } ?>
      <script type="text/javascript"><!--
      $('.btnSeoGen').hover( function(){
        $(this).addClass('btn-primary');
      }, function(){
        $(this).removeClass('btn-primary');
      });
      
      function seoPackageGen(field, lang, store) {
        $.ajax({
          url: 'index.php?route=module/complete_seo/get_value&type=<?php echo $item_type; ?>&id=<?php echo isset($_GET[$item_type.'_id']) ? $_GET[$item_type.'_id'] : 0; ?>&field='+field+'&store='+store+'&lang='+lang+'&<?php echo $token_type; ?>=<?php echo $token; ?>',
          method: 'POST',
          data: $('form#form-<?php echo $item_type; ?>').serialize(),
          dataType: 'json',
          success: function(values) {
            jQuery.each( values, function( i, val ) {
              if (field == 'description') {
                if (CKEDITOR.status == 'loaded'){
                  var el = $('[name="'+i+'"]').next();
                  var id = $(el).attr('id').replace('cke_','');
                  CKEDITOR.instances[id].setData(val);
                } else if (typeof $('#input-description'+lang).summernote('code') === 'string') {
                  $('[name="'+i+'"]').summernote('code', val);
                } else {
                  $('[name="'+i+'"]').code(val);
                }
              } else {
                $('[name="'+i+'"]').val(val);
              }
              $('[name="'+i+'"]').css('transition', '');
              $('[name="'+i+'"]').css('background-color', '#FCFFC6');
              setTimeout(function(){
                $('[name="'+i+'"]').css('transition', 'all 0.5s ease');
                $('[name="'+i+'"]').css('background-color', '');
              }, 10);
            });
          }
        });
      }
      --></script>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
</div>
<?php }} else if ($gkd_snippet == 'snippet_robots') { ?>
<?php if (version_compare(VERSION, '2', '>=')) { ?>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="input-sort-order">Meta Robots</label>
    <div class="col-sm-10">
      <select class="form-control" name="meta_robots">
        <option value="" <?php if($meta_robots == '') echo 'selected="selected"'; ?>>all</option>
        <option value="noindex" <?php if($meta_robots == 'noindex') echo 'selected="selected"'; ?>>noindex, follow</option>
        <option value="nofollow" <?php if($meta_robots == 'nofollow') echo 'selected="selected"'; ?>>index, nofollow</option>
        <option value="none" <?php if($meta_robots == 'none') echo 'selected="selected"'; ?>>none</option>
        <option value="noimageindex" <?php if($meta_robots == 'noimageindex') echo 'selected="selected"'; ?>>noimageindex</option>
      </select>
    </div>
  </div>
<?php } else { ?>
<tr>
  <td>Meta Robots</td>
  <td>
    <select class="form-control" name="meta_robots">
      <option value="" <?php if($meta_robots == '') echo 'selected="selected"'; ?>>all</option>
      <option value="noindex" <?php if($meta_robots == 'noindex') echo 'selected="selected"'; ?>>noindex, follow</option>
      <option value="nofollow" <?php if($meta_robots == 'nofollow') echo 'selected="selected"'; ?>>index, nofollow</option>
      <option value="none" <?php if($meta_robots == 'none') echo 'selected="selected"'; ?>>none</option>
      <option value="noimageindex" <?php if($meta_robots == 'noimageindex') echo 'selected="selected"'; ?>>noimageindex</option>
    </select>
  </td>
</tr>
<?php }} else if ($gkd_snippet == 'seo_canonical') { ?>
<div class="form-group">
  <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="Choose the path you want as canonical for this product - if you just added a new category you need to save product before being able to choose it">Canonical path</span></label>
  <div class="col-sm-10">
    <select name="seo_canonical" id="input-canonical" class="form-control">
      <option value="">- Auto -</option>
      <?php foreach ($product_categories as $product_category) { ?>
        <option value="<?php echo $product_category['category_id']; ?>" <?php echo (isset($seo_canonical) && $seo_canonical == $product_category['category_id']) ? 'selected' : ''; ?>><?php echo $product_category['name']; ?></option>
      <?php } ?>
    </select>
  </div>
</div>
<?php } else if ($gkd_snippet == 'snippet_metas') { ?>
  <?php if (version_compare(VERSION, '2.2', '>=') || $_config->get('mlseo_enabled')) { ?>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <btn class="btn btn-block btn-default btnSeoGen" onClick="seoPackageGen('all', '<?php echo $_language_id; ?>', '')"><i class="fa fa-bolt"></i> Generate all SEO values</btn>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-seo-keyword<?php echo $_language_id; ?>"><!--span data-toggle="tooltip" title="<?php echo $_language->get('help_keyword'); ?>"--><?php echo $_language->get('entry_keyword'); ?></label>
      <div class="col-sm-10">
        <div class="input-group">
          <input type="text" name="<?php echo $item_type; ?>_description[<?php echo $_language_id; ?>][seo_keyword]" value="<?php echo isset(${$item_type.'_description'}[$_language_id]) ? ${$item_type.'_description'}[$_language_id]['seo_keyword'] : ''; ?>" placeholder="<?php echo $_language->get('entry_keyword'); ?>" id="input-seo-keyword<?php echo $_language_id; ?>" class="form-control" />
          <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_keyword', '<?php echo $_language_id; ?>', '')"><i class="fa fa-bolt"></i></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-seo-h1<?php echo $_language_id; ?>">SEO H1</label>
      <div class="col-sm-10">
        <div class="input-group">
          <input type="text" name="<?php echo $item_type; ?>_description[<?php echo $_language_id; ?>][seo_h1]" value="<?php echo isset(${$item_type.'_description'}[$_language_id]) ? ${$item_type.'_description'}[$_language_id]['seo_h1'] : ''; ?>" placeholder="SEO H1" id="input-seo-h1<?php echo $_language_id; ?>" class="form-control" />
          <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h1', '<?php echo $_language_id; ?>', '')"><i class="fa fa-bolt"></i></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-seo-h2<?php echo $_language_id; ?>">SEO H2</label>
      <div class="col-sm-10">
        <div class="input-group">
          <input type="text" name="<?php echo $item_type; ?>_description[<?php echo $_language_id; ?>][seo_h2]" value="<?php echo isset(${$item_type.'_description'}[$_language_id]) ? ${$item_type.'_description'}[$_language_id]['seo_h2'] : ''; ?>" placeholder="SEO H2" id="input-seo-h2<?php echo $_language_id; ?>" class="form-control" />
          <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h2', '<?php echo $_language_id; ?>', '')"><i class="fa fa-bolt"></i></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-seo-h3<?php echo $_language_id; ?>">SEO H3</label>
      <div class="col-sm-10">
        <div class="input-group">
          <input type="text" name="<?php echo $item_type; ?>_description[<?php echo $_language_id; ?>][seo_h3]" value="<?php echo isset(${$item_type.'_description'}[$_language_id]) ? ${$item_type.'_description'}[$_language_id]['seo_h3'] : ''; ?>" placeholder="SEO H3" id="input-seo-h3<?php echo $_language_id; ?>" class="form-control" />
          <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h3', '<?php echo $_language_id; ?>', '')"><i class="fa fa-bolt"></i></span>
        </div>
      </div>
      <script type="text/javascript"><!--
      $('.btnSeoGen').hover( function(){
        $(this).addClass('btn-primary');
      }, function(){
        $(this).removeClass('btn-primary');
      });
      
      function seoPackageGen(field, lang, store) {
        $.ajax({
          url: 'index.php?route=module/complete_seo/get_value&type=<?php echo $item_type; ?>&id=<?php echo isset($_GET[$item_type.'_id']) ? $_GET[$item_type.'_id'] : 0; ?>&field='+field+'&store='+store+'&lang='+lang+'&<?php echo $token_type; ?>=<?php echo $token; ?>',
          method: 'POST',
          data: $('form#form-<?php echo $item_type; ?>').serialize(),
          dataType: 'json',
          success: function(values) {
            jQuery.each( values, function( i, val ) {
              if (field == 'description') {
                if (CKEDITOR.status == 'loaded'){
                  var el = $('[name="'+i+'"]').next();
                  var id = $(el).attr('id').replace('cke_','');
                  CKEDITOR.instances[id].setData(val);
                } else if (typeof $('#input-description'+lang).summernote('code') === 'string') {
                  $('[name="'+i+'"]').summernote('code', val);
                } else {
                  $('[name="'+i+'"]').code(val);
                }
              } else {
                $('[name="'+i+'"]').val(val);
              }
              $('[name="'+i+'"]').css('transition', '');
              $('[name="'+i+'"]').css('background-color', '#FCFFC6');
              setTimeout(function(){
                $('[name="'+i+'"]').css('transition', 'all 0.5s ease');
                $('[name="'+i+'"]').css('background-color', '');
              }, 10);
            });
          }
        });
      }
      --></script>
    </div>
    <?php if ($item_type == 'product') { ?>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-image-alt<?php echo $_language_id; ?>">Image alt</label>
      <div class="col-sm-10">
        <div class="input-group">
          <input type="text" name="<?php echo $item_type; ?>_description[<?php echo $_language_id; ?>][image_alt]" value="<?php echo isset(${$item_type.'_description'}[$_language_id]) ? ${$item_type.'_description'}[$_language_id]['image_alt'] : ''; ?>" placeholder="Image alt" id="input-image-alt<?php echo $_language_id; ?>" class="form-control" />
          <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('image_alt', '<?php echo $_language_id; ?>', '')"><i class="fa fa-bolt"></i></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-image-title<?php echo $_language_id; ?>">Image title</label>
      <div class="col-sm-10">
        <div class="input-group">
          <input type="text" name="<?php echo $item_type; ?>_description[<?php echo $_language_id; ?>][image_title]" value="<?php echo isset(${$item_type.'_description'}[$_language_id]) ? ${$item_type.'_description'}[$_language_id]['image_title'] : ''; ?>" placeholder="Image title" id="input-image-title<?php echo $_language_id; ?>" class="form-control" />
          <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('image_title', '<?php echo $_language_id; ?>', '')"><i class="fa fa-bolt"></i></span>
        </div>
      </div>
    </div>
    <?php } ?>
  <?php } ?>
<?php } ?>
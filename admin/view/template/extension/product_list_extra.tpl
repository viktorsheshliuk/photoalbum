<div id="product-extra-wrapper">

<?php if(!isset($ajaxed)){?>

  <?php echo $header;?><?php echo $column_left; ?>

<div id="content">

  <style type="text/css">

    #discount-special-window .modal-content input{width: 100%;}

    table#product-extra-table{font-size: 12px;}

    .table > thead > tr > td.editable{background-color: #fff;}

    .action-button a{line-height: 16px; min-width: 23px; display: inline-block; margin: 4px 2px; text-align: center;}

    .heading{margin-bottom: 20px;}

    .hidden{display: none;}

    tbody a.included{color: #007700;}

    tbody a.excluded{color: #770000;}

    .red{color: #770000;}

    .yellow{color: #FFA500;}

    .green{color: #007700;}

    /*td.product-model input, td.quantity input, td.sku input, td.seo input, td.price input, td.sort_order input, td.product-name input, td.weight input, td.dimensions input {border: none; text-align: right; width:95%; background: transparent;}*/

    td.inputs input {outline: 0; box-shadow: none; border: 1px solid rgba(0,0,0,0); text-align: right; width:95%; background: rgba(0,0,0,0);}

    td.inputs input:hover{box-shadow: none;border: 1px solid rgba(0,0,0,0);}

    td.inputs input:focus{box-shadow: none;border: 1px solid rgba(0,0,0,0);}

    td.product-name input, td.product-model input, td.product-meta-title input{text-align: left;}

    .updated{background: #FFEFAF !important;}

    .extra-warning{margin-bottom: 10px; color: #c00;}

    .list tbody td a.pe_action{line-height: 30px;}

    td.actions{/*width: 116px;*/}

    td.sort_order{width: 6%;}

    span.nobr{white-space: nowrap;}

    .filter{width: 90%;}

    select.filter{width: 100%;}

    tr ul{margin: 0px; padding: 0px; padding-left: 15px;}

    .list tbody td a.remove-category{float: right; background: #900; color: #fff; padding: 0px 3px 0px 3px; text-decoration: none;}

    .cat-list{margin-bottom: 3px; overflow: auto;}

    .list tbody td.categories{vertical-align: top;}

    .category-cell{position: relative;}

    .list tbody td a.add-category{background: #497700; color: #fff; padding: 0px 3px 1px 3px; float: right; text-decoration: none; position: absolute; top: -7px; left: -4px;}

    .pe_action{background-color: #ccc; padding: 3px 7px; color: #fff; font-weight: bold; text-shadow: 0.5px 0px .5px #333; border-radius: 2px; box-shadow: 0px 0px 2px #333; margin-left: 4px;}

    .list tbody td a.pe_action{text-decoration: none;}

    .pe_action:hover{background-color: #333; color: #ccc; box-shadow: none;}

    .edit_link{background-color: #FFA100;}

    .edit_link:hover{background-color: #AD6A00;}

    

    .edit_desc_link{background-color: #FF4C00;}

    .edit_desc_link:hover{background-color: #70270A;}

    

    .has_special{background-color: #0094FF;}

    .has_special:hover{background-color: #005796;}

    

    .view_link{background-color: #A556FF;}

    .view_link:hover{background-color: #552191;}

    

    .has_discount{background-color: #67C918;}

    .has_discount:hover{background-color: #3D7C09;}

    #content{padding: 10px 10px 128px;}

    a.pe_action:visited{color: #fff;}

    .column-switcher div.checkbox{float: left; margin-right: 10px;}

    .column-switcher{margin-bottom: 20px;}

    .hide-column{display: none;}

    a.lightblue-button{background-color: #4EABFC;}

    a.lightblue-other-button{background-color: #257FB6;}

    

    .frontend-price{color: #676767;}

    .image-wrapper{position: relative;}

    .image-wrapper img{width: 100px; height: 100px;}

    tbody td a.remove{display:none; background: #900; color: #fff; padding: 0px 3px 1px 3px; float: right; text-decoration: none; position: absolute; top: -7px; right: -4px;}

    tbody td:hover a.remove{display: block;}

    .gross{color: #683C3C;}

    .net{color: #777777;}

    .checkbox-explanation{font-style: italic; color: #555; margin-left: 25px; font-size: 90%; margin-bottom: 10px;}

    .clear-fix{clear:both;}

    .settings-box-wrapper{min-width: 250px;}

    label.checkbox-inline{

      min-width: 130px;

    }

    label.checkbox-inline + label.checkbox-inline{

      margin-left: 0px;

      margin-bottom: 5px;

    }

    .popover{

      max-width: 500px;

      width: 500px;

    }

    /*view-hook-stylesheet*/

    .is_favourite{background-color: #CB0007;}

    .is_favourite:hover{background-color: #CB0007;}

    #form-product-extra{

      overflow: auto;

    }

  </style>

  <div class="status-text" style="display:none">

    <span class="enabled"><?php echo $text_enabled;?></span>

    <span class="disabled"><?php echo $text_disabled;?></span>

  </div>

  <div class="subtract-text" style="display:none">

    <span class="yes"><?php echo $text_yes;?></span>

    <span class="no"><?php echo $text_no;?></span>

  </div>

  <?php if ($error_warning) { ?>

    <div class="alert alert-warning alert-dismissible"><?php echo $error_warning; ?></div>

  <?php } ?>

  <?php if ($success) { ?>

    <div class="alert alert-success alert-dismissible"><?php echo $success; ?></div>

  <?php } ?>

  <div class="box">

    <div class="heading">

      <div class="row">

        <div class="col-md-4">

          <h1><?php echo $heading_title; ?></h1>

        </div>

        <div class="col-md-8 text-right">

          <div class="btn-group language-selector">

            <?php 

            if(isset($languages)){

              foreach($languages as $lang=>$language){

                if($language['language_id'] == $selected_language){

                  $selected_lang = $language['name'];

                }

                $options[] = '<li><a href="#" data-code="'.$language['name'].'" data-id="'.$language['language_id'].'">'.$language['name'].'</a></li>';

              }

            }

            ?>

            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">

              Язык: <span id="selected-language"><?php echo (isset($selected_lang) ? $selected_lang : ''); ?></span> <span class="caret"></span>

            </button>

            <ul class="dropdown-menu language-selection" role="menu">

              <?php echo implode("\n", $options);?>

            </ul>

          </div>

          <a href="<?php echo $insert; ?>" class="btn btn-primary insert-product" data-toggle="tooltip" title="<?php echo $button_insert; ?>"><i class="fa fa-plus"></i></a>

          

          <a href="#" class="btn btn-primary disable-button" data-toggle="tooltip" title="<?php echo $button_disable; ?>"><i class="fa fa-power-off"></i></a>

          <a href="#" class="btn btn-primary enable-button" data-toggle="tooltip" title="<?php echo $button_enable; ?>"><i class="fa fa-play"></i></a>

        

          <a onclick="$('#form-product-extra').attr('action', '<?php echo $copy; ?>'); $('#form-product-extra').submit();" class="btn btn-primary button" data-toggle="tooltip" title="<?php echo $button_copy; ?>"><i class="fa fa-copy"></i></a>

          <a onclick="#" class="btn btn-danger delete-button" data-toggle="tooltip" title="<?php echo $button_delete; ?>"><i class="fa fa-trash-o"></i></a>

          <!--<a class="btn btn-info copy-default-product" href="<?php echo $copy; ?>" data-toggle="tooltip" title="<?php echo $copy_default_product;?>"><i class="fa fa-file-o"></i></a>

          <a onclick="editDefaultProduct()" class="btn btn-info default-product" href="index.php?route=catalog/product/edit&user_token=<?php echo $user_token; ?>&product_id=-1" data-toggle="tooltip" title="<?php echo $edit_default_product;?>"><i class="fa fa-pencil-square-o"></i></a>-->

          <a class="btn btn-warning columns-button" title="<?php echo $column_switch; ?>" data-toggle="tooltip"><i class="fa fa-check-square-o"></i></a>

          <a class="btn btn-default settings-button" title="<?php echo $settings_switch; ?>" data-toggle="tooltip"><i class="fa fa-cogs"></i> </a>

          <!--view-hook-buttons-top-->  

        </div>

      </div>

    </div>

    <div class="content clear-fix">

      <div class="column-switcher <?php echo (((isset($_COOKIE['show-column-checkboxes']) && $_COOKIE['show-column-checkboxes'] == 1))?'':'hide-column');?>">

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="id-column"> <?php echo $id_text; ?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="image-column"> <?php echo $image_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="product-column"> <?php echo $product_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="model-column"> <?php echo $model_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="category-column"> <?php echo $category_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="manufacturer-column"> <?php echo $manufacturer_column_switch;?>

        </label>

        <?php if(count($stores) > 0){?>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="stores-column"> <?php echo $stores_column_switch;?>

        </label>

        <?php };?>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="price-column"> <?php echo $price_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="frontend-price-column"> <?php echo $frontend_price_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="qty-column"> <?php echo $qty_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="status-column"> <?php echo $status_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="subtract-column"> <?php echo $subtract_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="order-column"> <?php echo $order_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="sku-column"> <?php echo $sku_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="upc-column"> <?php echo $upc_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="location-column"> <?php echo $location_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="date-available-column"> <?php echo $date_available_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="seo-column"> <?php echo $seo_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="weight-column"> <?php echo $weight_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="weight-class-column"> <?php echo $weight_class_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="tax-class-column"> <?php echo $tax_class_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="stock-status-column"> <?php echo $out_of_stock_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="dimensions-column"> <?php echo $dimensions_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="length-class-column"> <?php echo $length_class_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="product-meta-title-column"> <?php echo $product_meta_title_switch;?>

        </label>

        <!--view-hook-switcher-buttons-->

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="featured-column"> Рекомендуемый

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="ean-column"> <?php echo $ean_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="jan-column"> <?php echo $jan_column_switch;?>

        </label>

        <label class="checkbox-inline">

            <input type="checkbox" class="switcher" checked="checked" name="mpn-column"> <?php echo $mpn_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="isbn-column"> <?php echo $isbn_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="discount-price-column"> <?php echo $discount_price_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="special-price-column"> <?php echo $special_price_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="discounts-column"> <?php echo $discounts_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="specials-column"> <?php echo $specials_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="edit-column"> <?php echo $edit_column_switch;?>

        </label>

        <label class="checkbox-inline">

          <input type="checkbox" class="switcher" checked="checked" name="view-column"> <?php echo $view_column_switch;?>

        </label>

        <div style="clear:both"></div>

      </div>

      <div class="settings-box hidden">

        <div class="settings-box-wrapper">

          <div class="cb">

            <input type="checkbox" class="switcher" checked="checked" name="popup-edit" /> <?php echo $edit_column_popup_switch;?>

          </div>

          <div class="cb">

            <input type="checkbox" class="switcher" checked="checked" name="remove-auto-redirect" /> <?php echo $remove_auto_redirect;?>

          </div>

          <div class="db">

            <input type="checkbox" class="switcher" checked="checked" name="remove-delete-confirmation" /> <?php echo $remove_delete_confirm;?>

          </div>

          <!--view-hook-settings-->

        </div>

      </div>

      <!--<div class="extra-warning"><?php echo $extra_warning;?></div>-->
      
      <div>
      <button id="bulk_remove">Перенести</button> выделенные товары в категорию 
      <select name="filter_category_for_bulk_remove" class="">
                  <option value="*"></option>
                  <?php foreach($categories as $key=>$category){?>
                      <option value="<?php echo $key;?>" title="<?php echo $category;?>"><?php echo $category;?></option>         
                  <?php }?>
      </select>
      </div>

      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product-extra" current="index.php?route=extension/product_extra&user_token=<?php echo $user_token; ?>">

<?php } /*End ajaxed */?>

        <table class="table table-bordered table-hover" id="product-extra-table">

          <thead>

            <tr>

              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>

              <td class="left id-column <?php echo ((isset($_COOKIE['id-column']) && $_COOKIE['id-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.id') { ?>

                <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $id_text ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $id_text ?></a>

                <?php } ?></td>

              <td class="center image-column <?php echo ((isset($_COOKIE['image-column']) && $_COOKIE['image-column'] == 1)?'':'hide-column');?>"><?php echo $column_image; ?></td>

              <td class="left product-column <?php echo ((isset($_COOKIE['product-column']) && $_COOKIE['product-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'pd.name') { ?>

                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>

                <?php } ?></td>

              <td class="left model-column <?php echo ((isset($_COOKIE['model-column']) && $_COOKIE['model-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.model') { ?>

                <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>

                <?php } ?></td>

              <td class="left product-meta-title-column <?php echo ((isset($_COOKIE['product-meta-title-column']) && $_COOKIE['product-meta-title-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'pd.meta_title') { ?>

                <a href="<?php echo $sort_meta_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_meta_title; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_meta_title; ?>"><?php echo $column_meta_title; ?></a>

                <?php } ?></td>

              <td class="category-column <?php echo ((isset($_COOKIE['category-column']) && $_COOKIE['category-column'] == 1)?'':'hide-column');?>">

                <?php echo $column_category; ?>

              </td>

              <td class="left manufacturer-column <?php echo ((isset($_COOKIE['manufacturer-column']) && $_COOKIE['manufacturer-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'm.name') { ?>

                <a href="<?php echo $sort_manufacturer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_manufacturer; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_manufacturer; ?>"><?php echo $column_manufacturer; ?></a>

                <?php } ?></td>

              <?php if(count($stores) > 0){?>

              <td class="stores-column <?php echo ((isset($_COOKIE['stores-column']) && $_COOKIE['stores-column'] == 1)?'':'hide-column');?>">

                <?php echo $column_store; ?>

              </td>

              <td class="stores-column <?php echo ((isset($_COOKIE['stores-column']) && $_COOKIE['stores-column'] == 1)?'':'hide-column');?>">

                <?php echo $store_frontend_text; ?>

              </td>

              <?php };?>

              <td class="right price-column <?php echo ((isset($_COOKIE['price-column']) && $_COOKIE['price-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.price') { ?>

                <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>

                <?php } ?></td>

              <td class="right frontend-price-column <?php echo ((isset($_COOKIE['frontend-price-column']) && $_COOKIE['frontend-price-column'] == 1)?'':'hide-column');?>">

                <?php echo $frontend_price; ?>

              </td>

              <td class="right qty-column <?php echo ((isset($_COOKIE['qty-column']) && $_COOKIE['qty-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.quantity') { ?>

                <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>

                <?php } ?></td>

              <td class="left status-column <?php echo ((isset($_COOKIE['status-column']) && $_COOKIE['status-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.status') { ?>

                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>

                <?php } ?></td>

              <td class="left subtract-column <?php echo ((isset($_COOKIE['subtract-column']) && $_COOKIE['subtract-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.subtract') { ?>

                <a href="<?php echo $sort_subtract; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subtract; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_subtract; ?>"><?php echo $column_subtract; ?></a>

                <?php } ?></td>

              <td class="right sku-column <?php echo ((isset($_COOKIE['sku-column']) && $_COOKIE['sku-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.sku') { ?>

                <a href="<?php echo $sort_sku; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sku; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_sku; ?>"><?php echo $column_sku; ?></a>

                <?php } ?></td>



              <td class="right upc-column <?php echo ((isset($_COOKIE['upc-column']) && $_COOKIE['upc-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.upc') { ?>

                <a href="<?php echo $sort_upc; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_upc; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_upc; ?>"><?php echo $column_upc; ?></a>

                <?php } ?></td>

              

              <td class="right location-column <?php echo ((isset($_COOKIE['location-column']) && $_COOKIE['location-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.location') { ?>

                <a href="<?php echo $sort_location; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_location; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_location; ?>"><?php echo $column_location; ?></a>

                <?php } ?></td>

              <td class="right date-available-column <?php echo ((isset($_COOKIE['date-available-column']) && $_COOKIE['date-available-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.date_available') { ?>

                <a href="<?php echo $sort_date_available; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_available; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_date_available; ?>"><?php echo $column_date_available; ?></a>

                <?php } ?></td>

<!-- Seo Keyword -->

              <td class="right seo-column <?php echo ((isset($_COOKIE['seo-column']) && $_COOKIE['seo-column'] == 1)?'':'hide-column');?>"><?php echo $seo_column; ?></td>

<!-- Weight-->

              <td class="right weight-column <?php echo ((isset($_COOKIE['weight-column']) && $_COOKIE['weight-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.weight') { ?>

                <a href="<?php echo $sort_weight; ?>" class="<?php echo strtolower($order); ?>"><?php echo $weight_column_switch ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_weight; ?>"><?php echo $weight_column_switch ?></a>

                <?php } ?></td>

                

<!-- Weight class -->              

              <td class="left weight-class-column <?php echo ((isset($_COOKIE['weight-class-column']) && $_COOKIE['weight-class-column'] == 1)?'':'hide-column');?>">                <?php echo $weight_class_column_switch ?>

              </td>

              

<!-- Tax class -->

              <td class="left tax-class-column <?php echo ((isset($_COOKIE['tax-class-column']) && $_COOKIE['tax-class-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'tc.title') { ?>

                <a href="<?php echo $sort_tax_class; ?>" class="<?php echo strtolower($order); ?>"><?php echo $tax_class_column_switch ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_tax_class; ?>"><?php echo $tax_class_column_switch ?></a>

                <?php } ?></td>

                

<!--Out of stock -->

              <td class="stock-status-column <?php echo ((isset($_COOKIE['stock-status-column']) && $_COOKIE['stock-status-column'] == 1)?'':'hide-column');?>">

                <?php echo $out_of_stock_column ?>

              </td>

              

<!-- Dimensions -->

              <td colspan="3" class="center dimensions-column <?php echo ((isset($_COOKIE['dimensions-column']) && $_COOKIE['dimensions-column'] == 1)?'':'hide-column');?>"><?php echo $dimensions_column_switch ?></td>



<!-- Length class-->

              <td class="length-class-column <?php echo ((isset($_COOKIE['length-class-column']) && $_COOKIE['length-class-column'] == 1)?'':'hide-column');?>"><?php echo $length_class_column_switch ?></td>

              <td class="left sort_order order-column <?php echo ((isset($_COOKIE['order-column']) && $_COOKIE['order-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.sort_order') { ?>

                <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>

                <?php } ?></td>

              <!--view-hook-table-head-->

              <td class="right ean-column <?php echo ((isset($_COOKIE['ean-column']) && $_COOKIE['ean-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.ean') { ?>

                <a href="<?php echo $sort_ean; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ean; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_ean; ?>"><?php echo $column_ean; ?></a>

                <?php } ?></td>

              <td class="right jan-column <?php echo ((isset($_COOKIE['jan-column']) && $_COOKIE['jan-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.jan') { ?>

                <a href="<?php echo $sort_jan; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_jan; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_jan; ?>"><?php echo $column_jan; ?></a>

                <?php } ?></td>

              <td class="right mpn-column <?php echo ((isset($_COOKIE['mpn-column']) && $_COOKIE['mpn-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.mpn') { ?>

                <a href="<?php echo $sort_mpn; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_mpn; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_mpn; ?>"><?php echo $column_mpn; ?></a>

                <?php } ?></td>

              <td class="right isbn-column <?php echo ((isset($_COOKIE['isbn-column']) && $_COOKIE['isbn-column'] == 1)?'':'hide-column');?>"><?php if ($sort == 'p.isbn') { ?>

                <a href="<?php echo $sort_isbn; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_isbn; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_isbn; ?>"><?php echo $column_isbn; ?></a>

                <?php } ?></td>

              <td class="center discount-price-column <?php echo ((isset($_COOKIE['discount-price-column']) && $_COOKIE['discount-price-column'] == 1)?'':'hide-column');?>"><?php echo $discount_price_column_switch ?></td>

              <td class="center special-price-column <?php echo ((isset($_COOKIE['special-price-column']) && $_COOKIE['special-price-column'] == 1)?'':'hide-column');?>"><?php echo $special_price_column_switch ?></td>

              <td class="right actions"><?php echo $column_action; ?></td>

            </tr>

          </thead>

          <tbody>

            <tr class="filter">

              <td></td>

              <td class="id-column <?php echo ((isset($_COOKIE['id-column']) && $_COOKIE['id-column'] == 1)?'':'hide-column');?>"><input type="text" name="filter_id" class="filter" size="4" value="<?php echo $filter_id; ?>" /></td>

              <td class="image-column <?php echo ((isset($_COOKIE['image-column']) && $_COOKIE['image-column'] == 1)?'':'hide-column');?>"></td>

              <td class="product-column <?php echo ((isset($_COOKIE['product-column']) && $_COOKIE['product-column'] == 1)?'':'hide-column');?>"><input type="text" name="filter_name" class="filter" size="10" value="<?php echo $filter_name; ?>" /></td>

              <td class="model-column <?php echo ((isset($_COOKIE['model-column']) && $_COOKIE['model-column'] == 1)?'':'hide-column');?>"><input type="text" name="filter_model" class="filter" size="10" value="<?php echo $filter_model; ?>" /></td>

              <td class="product-meta-title-column <?php echo ((isset($_COOKIE['product-meta-title-column']) && $_COOKIE['product-meta-title-column'] == 1)?'':'hide-column');?>"><input type="text" name="filter_meta_title" class="filter" size="10" value="<?php echo $filter_meta_title; ?>" /></td>

              <td class="category-column <?php echo ((isset($_COOKIE['category-column']) && $_COOKIE['category-column'] == 1)?'':'hide-column');?>">

                <select name="filter_category" class="filter" >

                  <option value="*"></option>

                  <?php foreach($categories as $key=>$category){?>

                    <?php if ($filter_category == $key) { ?>

                      <option selected="selected" value="<?php echo $key;?>" title="<?php echo $category;?>"><?php echo $category;?></option>

                    <?php } else {?>

                      <option value="<?php echo $key;?>" title="<?php echo $category;?>"><?php echo $category;?></option>

                    <?php }?>

                  <?php }?>

                </select>

              </td>

              <td class="manufacturer-column <?php echo ((isset($_COOKIE['manufacturer-column']) && $_COOKIE['manufacturer-column'] == 1)?'':'hide-column');?>">

                <select name="filter_manufacturer" class="filter">

                  <option value="*"></option>

                  <?php foreach($manufacturers as $key=>$manufacturer){?>

                    <?php if ($filter_manufacturer == $key) { ?>

                      <option selected="selected" value="<?php echo $key;?>"><?php echo $manufacturer;?></option>

                    <?php } else {?>

                      <option value="<?php echo $key;?>"><?php echo $manufacturer;?></option>

                    <?php }?>

                  <?php }?>

                </select>

              </td>

              <?php if(count($stores) > 0){?>

              <td class="stores-column <?php echo ((isset($_COOKIE['stores-column']) && $_COOKIE['stores-column'] == 1)?'':'hide-column');?>"><select name="filter_store" class="filter">

                  <option value="*"></option>

                  <?php if (is_numeric($filter_store) && $filter_store == 0) { ?>

                    <option value="0" selected="selected"><?php echo $text_default;?></option>

                  <?php } else { ?>

                    <option value="0"><?php echo $text_default;?></option>

                  <?php } ?>

                  

                  <?php foreach($stores as $store){?>

                    <?php if ($filter_store == $store['store_id']) { ?>

                      <option selected="selected" value="<?php echo $store['store_id'];?>"><?php echo $store['name'];?></option>

                    <?php } else { ?>

                      <option value="<?php echo $store['store_id'];?>"><?php echo $store['name'];?></option>

                    <?php } ?>

                    

                  <?php };?>

                </select></td>

                <td class="stores-column <?php echo ((isset($_COOKIE['stores-column']) && $_COOKIE['stores-column'] == 1)?'':'hide-column');?>">

                  &nbsp;

                  </td>

              <?php };?>

              <td align="right" class="price-column <?php echo ((isset($_COOKIE['price-column']) && $_COOKIE['price-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_price" size="6" value="<?php echo $filter_price; ?>" style="text-align: right;" /></td>

              <td align="right" class="frontend-price-column <?php echo ((isset($_COOKIE['frontend-price-column']) && $_COOKIE['frontend-price-column'] == 1)?'':'hide-column');?>"><span class="gross"><?php echo $frontend_price_gross;?></span><br/><span class="net"><?php echo $frontend_price_net;?></span></td>

              <td align="right" class="qty-column <?php echo ((isset($_COOKIE['qty-column']) && $_COOKIE['qty-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_quantity" size="4" value="<?php echo $filter_quantity; ?>" style="text-align: right;" /></td>

              <td class="status-column <?php echo ((isset($_COOKIE['status-column']) && $_COOKIE['status-column'] == 1)?'':'hide-column');?>"><select name="filter_status" class="filter">

                  <option value="*"></option>

                  <?php if ($filter_status) { ?>

                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>

                  <?php } else { ?>

                  <option value="1"><?php echo $text_enabled; ?></option>

                  <?php } ?>

                  <?php if (!is_null($filter_status) && !$filter_status) { ?>

                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>

                  <?php } else { ?>

                  <option value="0"><?php echo $text_disabled; ?></option>

                  <?php } ?>

                </select></td>

              <td class="subtract-column <?php echo ((isset($_COOKIE['subtract-column']) && $_COOKIE['subtract-column'] == 1)?'':'hide-column');?>"><select name="filter_subtract" class="filter">

                  <option value="*"></option>

                  <?php if ($filter_subtract) { ?>

                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>

                  <?php } else { ?>

                  <option value="1"><?php echo $text_enabled; ?></option>

                  <?php } ?>

                  <?php if (!is_null($filter_subtract) && !$filter_subtract) { ?>

                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>

                  <?php } else { ?>

                  <option value="0"><?php echo $text_disabled; ?></option>

                  <?php } ?>

                </select></td>

              <td align="right" class="sku-column <?php echo ((isset($_COOKIE['sku-column']) && $_COOKIE['sku-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_sku" size="4" value="<?php echo $filter_sku; ?>" style="text-align: right;" /></td>



              <td align="right" class="upc-column <?php echo ((isset($_COOKIE['upc-column']) && $_COOKIE['upc-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_upc" size="4" value="<?php echo $filter_upc; ?>" style="text-align: right;" /></td>

              

              <td align="right" class="location-column <?php echo ((isset($_COOKIE['location-column']) && $_COOKIE['location-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_location" size="4" value="<?php echo $filter_location; ?>" style="text-align: right;" /></td>

              <td align="right" class="date-available-column <?php echo ((isset($_COOKIE['date-available-column']) && $_COOKIE['date-available-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_date_available" size="4" value="<?php echo $filter_date_available; ?>" style="text-align: right;" /></td>



              <td align="right" class="seo-column <?php echo ((isset($_COOKIE['seo-column']) && $_COOKIE['seo-column'] == 1)?'':'hide-column');?>">&nbsp;</td>

<!-- Weight -->

              <td class="weight-column <?php echo ((isset($_COOKIE['weight-column']) && $_COOKIE['weight-column'] == 1)?'':'hide-column');?>"><input type="text" name="filter_weight" class="filter" size="10" value="<?php echo $filter_weight; ?>" /></td>

<!--Weight class-->

              <td class="weight-class-column <?php echo ((isset($_COOKIE['weight-class-column']) && $_COOKIE['weight-class-column'] == 1)?'':'hide-column');?>">

                  <select name="filter_weight_class" class="filter">

                    <option value="*"></option>

                    <?php foreach($weight_classes as $key=>$weight_class){?>

                      <?php if ($filter_weight_class == $key) { ?>

                        <option selected="selected" value="<?php echo $key;?>"><?php echo $weight_class;?></option>

                      <?php } else {?>

                        <option value="<?php echo $key;?>"><?php echo $weight_class;?></option>

                      <?php }?>

                    <?php }?>

                  </select>

              </td>

<!--Tax class-->

              <td class="tax-class-column <?php echo ((isset($_COOKIE['tax-class-column']) && $_COOKIE['tax-class-column'] == 1)?'':'hide-column');?>">

                <select name="filter_tax_class" class="filter">

                  <option value="*"></option>

                  <?php foreach($tax_classes as $key=>$tax_class){?>

                    <?php if ($filter_tax_class == $key) { ?>

                      <option selected="selected" value="<?php echo $key;?>"><?php echo $tax_class;?></option>

                    <?php } else {?>

                      <option value="<?php echo $key;?>"><?php echo $tax_class;?></option>

                    <?php }?>

                  <?php }?>

                </select>

              </td>

<!-- out of stock status -->

              <td class="stock-status-column <?php echo ((isset($_COOKIE['stock-status-column']) && $_COOKIE['stock-status-column'] == 1)?'':'hide-column');?>">

                <select name="filter_stock_status" class="filter">

                  <option value="*"></option>

                  <?php foreach($stock_statuses as $key=>$stock_status){?>

                    <?php if ($filter_stock_status == $key) { ?>

                      <option selected="selected" value="<?php echo $key;?>"><?php echo $stock_status;?></option>

                    <?php } else {?>

                      <option value="<?php echo $key;?>"><?php echo $stock_status;?></option>

                    <?php }?>

                  <?php }?>

                </select>

              </td>

<!--Dimensions -->

              <td class="dimensions-column <?php echo ((isset($_COOKIE['dimensions-column']) && $_COOKIE['dimensions-column'] == 1)?'':'hide-column');?>"><?php echo $length_text; ?></td>

              <td class="dimensions-column <?php echo ((isset($_COOKIE['dimensions-column']) && $_COOKIE['dimensions-column'] == 1)?'':'hide-column');?>"><?php echo $width_text ?></td>

              <td class="dimensions-column <?php echo ((isset($_COOKIE['dimensions-column']) && $_COOKIE['dimensions-column'] == 1)?'':'hide-column');?>"><?php echo $height_text ?></td>

<!--Length class-->

              <td class="length-class-column <?php echo ((isset($_COOKIE['length-class-column']) && $_COOKIE['length-class-column'] == 1)?'':'hide-column');?>">

                  <select name="filter_length_class" class="filter">

                    <option value="*"></option>

                    <?php foreach($length_classes as $key=>$length_class){?>

                      <?php if ($filter_length_class == $key) { ?>

                        <option selected="selected" value="<?php echo $key;?>"><?php echo $length_class;?></option>

                      <?php } else {?>

                        <option value="<?php echo $key;?>"><?php echo $length_class;?></option>

                      <?php }?>

                    <?php }?>

                  </select>

              </td>

              

              <td align="right" class="order-column <?php echo ((isset($_COOKIE['order-column']) && $_COOKIE['order-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_sort_order" size="4" value="<?php echo $filter_sort_order; ?>" style="text-align: right;" /></td>

              <!--view-hook-table-filter-->

              <td align="right" class="ean-column <?php echo ((isset($_COOKIE['ean-column']) && $_COOKIE['ean-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_ean" size="4" value="<?php echo $filter_ean; ?>" style="text-align: right;" /></td>

              <td align="right" class="jan-column <?php echo ((isset($_COOKIE['jan-column']) && $_COOKIE['jan-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_jan" size="4" value="<?php echo $filter_jan; ?>" style="text-align: right;" /></td>

              <td align="right" class="mpn-column <?php echo ((isset($_COOKIE['mpn-column']) && $_COOKIE['mpn-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_mpn" size="4" value="<?php echo $filter_mpn; ?>" style="text-align: right;" /></td>

              <td align="right" class="isbn-column <?php echo ((isset($_COOKIE['isbn-column']) && $_COOKIE['isbn-column'] == 1)?'':'hide-column');?>"><input class="filter" type="text" name="filter_isbn" size="4" value="<?php echo $filter_isbn; ?>" style="text-align: right;" /></td>

              <td class="center discount-price-column <?php echo ((isset($_COOKIE['discount-price-column']) && $_COOKIE['discount-price-column'] == 1)?'':'hide-column');?>"><?php echo $max_priority; ?></td>

              <td class="center special-price-column <?php echo ((isset($_COOKIE['special-price-column']) && $_COOKIE['special-price-column'] == 1)?'':'hide-column');?>"><?php echo $max_priority; ?></td>

              <td class="text-center" class="white-space: nowrap;">

                <a onclick="filter();" class="btn btn-default button"><i class="fa fa-search" aria-hidden="true"></i></a>

                <a onclick="resetFilter();" class="btn btn-default button"><i class="fa fa-times" aria-hidden="true"></i></a>

              </td>

            </tr>









            <?php if ($products) { ?>

            <?php foreach ($products as $product) { ?>

            <tr class="product-row" data-id="<?php echo $product['product_id']; ?>">

              <td style="text-align: center;"><?php if ($product['selected']) { ?>

                <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />

                <?php } else { ?>

                <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />

                <?php } ?></td>

              <td class="left id-column <?php echo ((isset($_COOKIE['id-column']) && $_COOKIE['id-column'] == 1)?'':'hide-column');?>"><?php echo $product['product_id']; ?>

<!-- product_descriptions-->

              <div class="hidden">

                <?php foreach($product['descriptions'] as $description){?>

                  <textarea class="descriptions" rel="<?php echo $description['language_id'];?>"><?php echo $description['description'];?></textarea>

                <?php };?>

              </div>

              </td>

              <td class="center product-image image-column <?php echo ((isset($_COOKIE['image-column']) && $_COOKIE['image-column'] == 1)?'':'hide-column');?>" rel="<?php echo $link;?>&type=change_image&product_id=<?php echo $product['product_id'];?>">

                  <div class="image-wrapper">

                  <a href="" id="thumb-image-<?php echo $product['product_id'];?>" data-toggle="main-image" class="img-thumbnail">

                    <img src="<?php echo $product['image']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>

                    <input type="hidden" name="image" value="<?php echo $product['image']; ?>" data-id="<?php echo $product['product_id'];?>" id="image-<?php echo $product['product_id'];?>" rel="index.php?route=extension/product_extra&type=change_image&user_token=<?php echo $user_token; ?>"/>

                    <a class="remove" href="#">&times</a>

                  </div>

              </td>

              <td class="left inputs product-name product-column <?php echo ((isset($_COOKIE['product-column']) && $_COOKIE['product-column'] == 1)?'':'hide-column');?>">

                <span class="product-name-wrapper"><?php echo $product['name']; ?></span>

                <input style="display: none;" type="text" orig="<?php echo $product['name']; ?>" rel="<?php echo $link;?>&type=change_name&product_id=<?php echo $product['product_id'];?>&language=<?php echo $selected_language;?>" name="model" value="<?php echo $product['name']; ?>"/>

              </td>

              <td class="left inputs product-model model-column <?php echo ((isset($_COOKIE['model-column']) && $_COOKIE['model-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['model']; ?>" rel="<?php echo $link;?>&type=change_model&product_id=<?php echo $product['product_id'];?>" name="model" value="<?php echo $product['model']; ?>"/>

              </td>

              <td class="left inputs product-meta-title product-meta-title-column <?php echo ((isset($_COOKIE['product-meta-title-column']) && $_COOKIE['product-meta-title-column'] == 1)?'':'hide-column');?>">

                <span class="product-meta-title-wrapper"><?php echo $product['meta_title']; ?></span>

                <input style="display: none;" type="text" orig="<?php echo $product['meta_title']; ?>" rel="<?php echo $link;?>&type=change_meta_title&product_id=<?php echo $product['product_id'];?>&language=<?php echo $selected_language;?>" name="model" value="<?php echo $product['meta_title']; ?>"/>

              </td>

              <td class="left categories category-column <?php echo ((isset($_COOKIE['category-column']) && $_COOKIE['category-column'] == 1)?'':'hide-column');?>" id="categories-for-<?php echo $product['product_id'];?>">

                <div class="category-cell">

                  <ul>

                  <?php if($product['categories']){?>

                    <?php foreach($product['categories'] as $k=>$category){?>

                      <?php if(isset($categories[$category])){;?>

                        <li class="cat-list" data-id="<?php echo $category;?>">

                          <?php echo $categories[$category];?>

                        </li>

                      <?php };?>

                    <?php };?>

                  <?php };?>

                  </ul>

                </div>

              </td>

              <td class="left product-manufacturer manufacturer-column <?php echo ((isset($_COOKIE['manufacturer-column']) && $_COOKIE['manufacturer-column'] == 1)?'':'hide-column');?>" rel="<?php echo $product['manufacturer_id'];?>" loc="<?php echo $link;?>&type=change_manufacturer&product_id=<?php echo $product['product_id'];?>"><?php echo (isset($manufacturers[$product['manufacturer_id']]))?$manufacturers[$product['manufacturer_id']]:''; ?></td>

              <?php if(count($stores) > 0){?>

              <td class="left stores stores-column <?php echo ((isset($_COOKIE['stores-column']) && $_COOKIE['stores-column'] == 1)?'':'hide-column');?>">

                <div>

                  <a href="<?php echo $link;?>&type=change_store&product_id=<?php echo $product['product_id'];?>&store_id=0" class="<?php echo (in_array(0, $product['stores']))?"included":"excluded";?>">

                    <?php echo $text_default;?>

                  </a>

                </div>

                <?php foreach($stores as $store){?>

                  <div>

                    <a href="<?php echo $link;?>&type=change_store&product_id=<?php echo $product['product_id'];?>&store_id=<?php echo $store['store_id'];?>" class="<?php echo (in_array($store['store_id'], $product['stores']))?"included":"excluded";?>">

                      <?php echo $store['name'];?>

                    </a>

                  </div>

                <?php };?>

              </td>

              <!-- store preview-->

              <td class="left stores-column <?php echo ((isset($_COOKIE['stores-column']) && $_COOKIE['stores-column'] == 1)?'':'hide-column');?>">

                <div>

                  <a href="<?php echo HTTP_CATALOG;?>?route=product/product&product_id=<?php echo $product['product_id'];?>" target="frontend">

                    <?php echo $text_default;?>

                  </a>

                </div>

                <?php foreach($stores as $store){?>

                  <div>

                    <a href="<?php echo $store['url'];?>?route=product/product&product_id=<?php echo $product['product_id'];?>" target="frontend">

                      <?php echo $store['name'];?>

                    </a>

                  </div>

                <?php };?>

              </td>

              <?php };?>

              <td class="right inputs price price-column <?php echo ((isset($_COOKIE['price-column']) && $_COOKIE['price-column'] == 1)?'':'hide-column');?>">

                <input class="gross-price-field product-price-field" type="text" orig="<?php echo $product['price'];?>" rel="<?php echo $link;?>&type=change_price&product_id=<?php echo $product['product_id'];?>" name="quantity" value="<?php echo $product['price'];?>"/>

              </td>

              <td class="right frontend-price frontend-price-column <?php echo ((isset($_COOKIE['frontend-price-column']) && $_COOKIE['frontend-price-column'] == 1)?'':'hide-column');?>">

                <span class="gross"><?php echo number_format($product['frontend_price'][1], 4);?></span><br/>

                <span class="net"><?php echo number_format($product['frontend_price'][0], 4);?></span>

              </td>

              <td class="right inputs quantity qty-column <?php echo ((isset($_COOKIE['qty-column']) && $_COOKIE['qty-column'] == 1)?'':'hide-column');?>">

                <?php if ($product['quantity'] <= 0) {

                  $class = "red";

                } elseif ($product['quantity'] <= 5) {

                  $class = "yellow";

                } else {

                  $class = "green";

                }?>

                <input type="text" orig="<?php echo $product['quantity'];?>" rel="<?php echo $link;?>&type=change_quantity&product_id=<?php echo $product['product_id'];?>" name="quantity" class="<?php echo $class;?>" value="<?php echo $product['quantity'];?>"/>

              </td>

              <td class="status left status-column <?php echo ((isset($_COOKIE['status-column']) && $_COOKIE['status-column'] == 1)?'':'hide-column');?>"><a href="<?php echo $link;?>&type=change_status&product_id=<?php echo $product['product_id'];?>&store_id=0" class="<?php echo ($product['status_int'] == 1 )?"included":"excluded";?>"><?php echo $product['status']; ?></a></td>

              <td class="subtract left subtract-column <?php echo ((isset($_COOKIE['subtract-column']) && $_COOKIE['subtract-column'] == 1)?'':'hide-column');?>"><a href="<?php echo $link;?>&type=change_subtract&product_id=<?php echo $product['product_id'];?>&store_id=0" class="<?php echo ($product['subtract_int'] == 1 )?"included":"excluded";?>"><?php echo $product['subtract']; ?></a></td>

              <td class="right inputs sku sku-column <?php echo ((isset($_COOKIE['sku-column']) && $_COOKIE['sku-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['sku'];?>" rel="<?php echo $link;?>&type=change_sku&product_id=<?php echo $product['product_id'];?>" name="sku" value="<?php echo $product['sku'];?>"/>

              </td>



              <td class="right inputs upc upc-column <?php echo ((isset($_COOKIE['upc-column']) && $_COOKIE['upc-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['upc'];?>" rel="<?php echo $link;?>&type=change_upc&product_id=<?php echo $product['product_id'];?>" name="upc" value="<?php echo $product['upc'];?>"/>

              </td>

              

              <td class="right inputs location location-column <?php echo ((isset($_COOKIE['location-column']) && $_COOKIE['location-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['location'];?>" rel="<?php echo $link;?>&type=change_location&product_id=<?php echo $product['product_id'];?>" name="location" value="<?php echo $product['location'];?>"/>

              </td>

              <td class="right inputs date datefield date_available date-available-column <?php echo ((isset($_COOKIE['date-available-column']) && $_COOKIE['date-available-column'] == 1)?'':'hide-column');?>">

                <input type="text" class="datepicker" data-format="YYYY-MM-DD" data-date-format="YYYY-MM-DD" orig="<?php echo $product['date_available'];?>" rel="<?php echo $link;?>&type=change_date_available&product_id=<?php echo $product['product_id'];?>" name="date_available" value="<?php echo $product['date_available'];?>"/>

              </td>



              <td class="left inputs seo seo-column <?php echo ((isset($_COOKIE['seo-column']) && $_COOKIE['seo-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['keyword']; ?>" rel="<?php echo $link;?>&type=change_seo&product_id=<?php echo $product['product_id'];?>" name="keyword" value="<?php echo $product['keyword']; ?>"/>

              </td>

              

<!-- Weight -->

              <td class="left inputs weight weight-column <?php echo ((isset($_COOKIE['weight-column']) && $_COOKIE['weight-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['weight']; ?>" rel="<?php echo $link;?>&type=change_weight&product_id=<?php echo $product['product_id'];?>" name="weight" value="<?php echo $product['weight']; ?>"/>

              </td>

              

<!-- Weight class -->

              <td class="left weight-class weight-class-column <?php echo ((isset($_COOKIE['weight-class-column']) && $_COOKIE['weight-class-column'] == 1)?'':'hide-column');?>" rel="<?php echo $product['weight_class_id'];?>" loc="<?php echo $link;?>&type=change_weight_class&product_id=<?php echo $product['product_id'];?>"><?php echo (isset($weight_classes[$product['weight_class_id']]))?$weight_classes[$product['weight_class_id']]:''; ?></td>

              

<!-- Tax Class -->

              <td class="left tax-class tax-class-column <?php echo ((isset($_COOKIE['tax-class-column']) && $_COOKIE['tax-class-column'] == 1)?'':'hide-column');?>" rel="<?php echo $product['tax_class_id'];?>" loc="<?php echo $link;?>&type=change_tax_class&product_id=<?php echo $product['product_id'];?>"><?php echo (isset($tax_classes[$product['tax_class_id']]))?$tax_classes[$product['tax_class_id']]:''; ?></td>

              

<!-- Out of stock status -->

              <td class="left stock-status stock-status-column <?php echo ((isset($_COOKIE['stock-status-column']) && $_COOKIE['stock-status-column'] == 1)?'':'hide-column');?>" rel="<?php echo $product['stock_status_id'];?>" loc="<?php echo $link;?>&type=change_stock_status&product_id=<?php echo $product['product_id'];?>"><?php echo (isset($stock_statuses[$product['stock_status_id']]))?$stock_statuses[$product['stock_status_id']]:''; ?></td>

              

<!--Dimensions -->

              <td class="left inputs length dimensions dimensions-column <?php echo ((isset($_COOKIE['dimensions-column']) && $_COOKIE['dimensions-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['length']; ?>" rel="<?php echo $link;?>&type=change_length&product_id=<?php echo $product['product_id'];?>" name="length" value="<?php echo $product['length']; ?>"/>

              </td>

              <td class="left inputs width dimensions dimensions-column <?php echo ((isset($_COOKIE['dimensions-column']) && $_COOKIE['dimensions-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['width']; ?>" rel="<?php echo $link;?>&type=change_width&product_id=<?php echo $product['product_id'];?>" name="width" value="<?php echo $product['width']; ?>"/>

              </td>

              <td class="left inputs height dimensions dimensions-column <?php echo ((isset($_COOKIE['dimensions-column']) && $_COOKIE['dimensions-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['height']; ?>" rel="<?php echo $link;?>&type=change_height&product_id=<?php echo $product['product_id'];?>" name="height" value="<?php echo $product['height']; ?>"/>

              </td>

<!-- Length class -->

              <td class="left length-class length-class-column <?php echo ((isset($_COOKIE['length-class-column']) && $_COOKIE['length-class-column'] == 1)?'':'hide-column');?>" rel="<?php echo $product['length_class_id'];?>" loc="<?php echo $link;?>&type=change_length_class&product_id=<?php echo $product['product_id'];?>"><?php echo (isset($length_classes[$product['length_class_id']]))?$length_classes[$product['length_class_id']]:''; ?></td>

              

              <td class="right inputs sort_order order-column <?php echo ((isset($_COOKIE['order-column']) && $_COOKIE['order-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['sort_order'];?>" rel="<?php echo $link;?>&type=change_sort_order&product_id=<?php echo $product['product_id'];?>" name="sort_order" value="<?php echo $product['sort_order'];?>"/>

              <!--view-hook-table-row-->

              <td class="right inputs ean ean-column <?php echo ((isset($_COOKIE['ean-column']) && $_COOKIE['ean-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['ean'];?>" rel="<?php echo $link;?>&type=change_ean&product_id=<?php echo $product['product_id'];?>" name="ean" value="<?php echo $product['ean'];?>"/>

              </td>

              <td class="right inputs jan jan-column <?php echo ((isset($_COOKIE['jan-column']) && $_COOKIE['jan-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['jan'];?>" rel="<?php echo $link;?>&type=change_jan&product_id=<?php echo $product['product_id'];?>" name="jan" value="<?php echo $product['jan'];?>"/>

              </td>

              <td class="right inputs mpn mpn-column <?php echo ((isset($_COOKIE['mpn-column']) && $_COOKIE['mpn-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['mpn'];?>" rel="<?php echo $link;?>&type=change_mpn&product_id=<?php echo $product['product_id'];?>" name="mpn" value="<?php echo $product['mpn'];?>"/>

              </td>

              <td class="right inputs isbn isbn-column <?php echo ((isset($_COOKIE['isbn-column']) && $_COOKIE['isbn-column'] == 1)?'':'hide-column');?>">

                <input type="text" orig="<?php echo $product['isbn'];?>" rel="<?php echo $link;?>&type=change_isbn&product_id=<?php echo $product['product_id'];?>" name="isbn" value="<?php echo $product['isbn'];?>"/>

              </td>

              <td class="right inputs discount-price-column discount-column <?php echo ((isset($_COOKIE['discount-price-column']) && $_COOKIE['discount-price-column'] == 1)?'':'hide-column');?>">

                <input class="gross-price-field discount-price-field" type="text" orig="<?php echo $product['discount_price'];?>" rel="<?php echo $link;?>&type=change_discount&product_id=<?php echo $product['product_id'];?>" name="discount_price" value="<?php echo $product['discount_price'];?>"/>

              </td>

              <td class="right inputs special-price-column special-column <?php echo ((isset($_COOKIE['special-price-column']) && $_COOKIE['special-price-column'] == 1)?'':'hide-column');?>">

                <input class="gross-price-field special-price-field" type="text" orig="<?php echo $product['special_price'];?>" rel="<?php echo $link;?>&type=change_special&product_id=<?php echo $product['product_id'];?>" name="special_price" value="<?php echo $product['special_price'];?>"/>

              </td>



              <td class="nobr acions">

                  <span class="action-button edit-column <?php echo ((isset($_COOKIE['edit-column']) && $_COOKIE['edit-column'] == 1)?'':'hide-column');?>"><a class="edit_link pe_action" href="<?php echo $product['action']; ?>" title="<?php echo $edit_link;?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>

                  <?php //if(count($stores) == 0){?>

                    <span class="action-button view-column <?php echo ((isset($_COOKIE['view-column']) && $_COOKIE['view-column'] == 1)?'':'hide-column');?>"><a class="view_link pe_action" href="<?php echo HTTP_CATALOG;?>?route=product/product&product_id=<?php echo $product['product_id'];?>" target="frontend" title="<?php echo $view_column_switch;?>"><i class="fa fa-eye" aria-hidden="true"></i></a></span>

                  <?php //};?>

                  <span class="action-button discounts-column <?php echo ((isset($_COOKIE['discounts-column']) && $_COOKIE['discounts-column'] == 1)?'':'hide-column');?>"><a class="<?php echo ($product['hasDiscount'] == true)?'has_discount ':'';?>discount_link pe_action" href="<?php echo $link;?>&type=special_prices&product_id=<?php echo $product['product_id'];?>&t=discount" title="<?php echo $discount_link; ?>">C</a></span>

                  <span class="action-button specials-column <?php echo ((isset($_COOKIE['specials-column']) && $_COOKIE['specials-column'] == 1)?'':'hide-column');?>"><a class="<?php echo ($product['hasSpecial'] == true)?'has_special ':'';?>special_link pe_action" href="<?php echo $link;?>&type=special_prices&product_id=<?php echo $product['product_id'];?>&t=special" title="<?php echo $special_link; ?>">A</a></span>

                  <span class="action-button featured-column <?php echo ((isset($_COOKIE['featured-column']) && $_COOKIE['featured-column'] == 1)?'':'hide-column');?>"><a class="<?php echo (in_array($product['product_id'], $featured)?'is_favourite ':'');?> featured_link pe_action" href="<?php echo $link;?>&type=featured_product&product_id=<?php echo $product['product_id'];?>" title="Сделать Рекомендуемым"><i class="fa fa-star" aria-hidden="true"></i></a></span>

                  <!--view-hook-actions-row-->

              </td>

              

            </tr>

            <?php } ?>

            <?php } else { ?>

            <tr>

              <td class="center" colspan="1000"><?php echo $text_no_results; ?></td>

            </tr>

            <?php } ?>

          </tbody>

        </table>

        <div class="row">

          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>

          <div class="col-sm-6 text-right">

            <div style="float:right; line-height: 25px; margin-left: 10px;">

              <?php echo $results; ?> · 

              <?php $page_rows = array(3,20,50,100);?>

              <?php echo $rows_in_table;?>

              <select name="rows-per-page" id="rows-per-page">

                <?php foreach($page_rows as $row){;?>

                  <option <?php echo (isset($current_rows) && $current_rows == $row)?'selected="selected"':'';?> value="<?php echo $row;?>"><?php echo $row;?></option>

                <?php };?>

              </select>

            </div>

          </div>

        </div>

<?php if(!isset($ajaxed)){?>

      </form>

    </div>

  </div>

  

  

  <script type="text/javascript"><!--

  function resetFilter(){

    $('#product-extra-wrapper tr.filter input').val('');

    $('#product-extra-wrapper tr.filter select').each(function(){

      $(this).val($(this).find('option:first').val());

    });

    filter();

  }

  function filter() {

          url = 'index.php?route=extension/product_extra&user_token=<?php echo $user_token; ?>';

          

          var filter_id = $('#product-extra-wrapper input[name=\'filter_id\']').prop('value');

          if (filter_id) {

                  url += '&filter_id=' + encodeURIComponent(filter_id);

          }

          

          var filter_name = $('#product-extra-wrapper input[name=\'filter_name\']').prop('value');

          

          if (filter_name) {

                  url += '&filter_name=' + encodeURIComponent(filter_name);

          }

          

          var filter_model = $('#product-extra-wrapper input[name=\'filter_model\']').prop('value');

          

          if (filter_model) {

                  url += '&filter_model=' + encodeURIComponent(filter_model);

          }



          var filter_meta_title = $('#product-extra-wrapper input[name=\'filter_meta_title\']').prop('value');

          

          if (filter_meta_title) {

                  url += '&filter_meta_title=' + encodeURIComponent(filter_meta_title);

          }

          

          var filter_quantity = $('#product-extra-wrapper input[name=\'filter_quantity\']').prop('value');

          

          if (filter_quantity) {

                  url += '&filter_quantity=' + encodeURIComponent(filter_quantity);

          }

          

          var filter_weight = $('#product-extra-wrapper input[name=\'filter_weight\']').prop('value');

          

          if (filter_weight) {

                  url += '&filter_weight=' + encodeURIComponent(filter_weight);

          }

          

          var filter_sku = $('#product-extra-wrapper input[name=\'filter_sku\']').prop('value');

          

          if (filter_sku) {

                  url += '&filter_sku=' + encodeURIComponent(filter_sku);

          }



          var filter_upc = $('#product-extra-wrapper input[name=\'filter_upc\']').prop('value');

          

          if (filter_upc) {

                  url += '&filter_upc=' + encodeURIComponent(filter_upc);

          }

          var filter_ean = $('#product-extra-wrapper input[name=\'filter_ean\']').prop('value');

          

          

          var filter_location = $('#product-extra-wrapper input[name=\'filter_location\']').prop('value');

          

          if (filter_location) {

                  url += '&filter_location=' + encodeURIComponent(filter_location);

          }

          var filter_date_available = $('#product-extra-wrapper input[name=\'filter_date_available\']').prop('value');

          

          if (filter_date_available) {

                  url += '&filter_date_available=' + encodeURIComponent(filter_date_available);

          }

          

          var filter_status = $('#product-extra-wrapper select[name=\'filter_status\']').prop('value');

          

          if (filter_status != '*') {

                  url += '&filter_status=' + encodeURIComponent(filter_status);

          }



          var filter_subtract = $('#product-extra-wrapper select[name=\'filter_subtract\']').prop('value');

          

          if (filter_subtract != '*') {

                  url += '&filter_subtract=' + encodeURIComponent(filter_subtract);

          }

          

          var filter_store = $('#product-extra-wrapper select[name=\'filter_store\']').val();

          

          if (typeof(filter_store) != 'undefined' &&filter_store != '*') {

                  url += '&filter_store=' + encodeURIComponent(filter_store);

          }

          

          var filter_category = $('#product-extra-wrapper select[name=\'filter_category\']').val();

          

          if (typeof(filter_category) != 'undefined' &&filter_category != '*') {

                  url += '&filter_category=' + encodeURIComponent(filter_category);

          }

          

          var filter_manufacturer = $('#product-extra-wrapper select[name=\'filter_manufacturer\']').val();

          

          if (typeof(filter_manufacturer) != 'undefined' &&filter_manufacturer != '*') {

                  url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);

          }

          

          var filter_tax_class = $('#product-extra-wrapper select[name=\'filter_tax_class\']').val();

          

          if (typeof(filter_tax_class) != 'undefined' &&filter_tax_class != '*') {

                  url += '&filter_tax_class=' + encodeURIComponent(filter_tax_class);

          }

          

          var filter_length_class = $('#product-extra-wrapper select[name=\'filter_length_class\']').val();

          

          if (typeof(filter_length_class) != 'undefined' &&filter_length_class != '*') {

                  url += '&filter_length_class=' + encodeURIComponent(filter_length_class);

          }

          

          var filter_weight_class = $('#product-extra-wrapper select[name=\'filter_weight_class\']').val();

          

          if (typeof(filter_weight_class) != 'undefined' &&filter_weight_class != '*') {

                  url += '&filter_weight_class=' + encodeURIComponent(filter_weight_class);

          }

          

          var filter_stock_status = $('#product-extra-wrapper select[name=\'filter_stock_status\']').val();

          

          if (typeof(filter_stock_status) != 'undefined' &&filter_stock_status != '*') {

                  url += '&filter_stock_status=' + encodeURIComponent(filter_stock_status);

          }

          

          var filter_price = $('#product-extra-wrapper input[name=\'filter_price\']').prop('value');

          

          if (filter_price) {

                  url += '&filter_price=' + encodeURIComponent(filter_price);

          }

          

          var filter_sort_order = $('#product-extra-wrapper input[name=\'filter_sort_order\']').prop('value');

          

          if (filter_sort_order) {

                  url += '&filter_sort_order=' + encodeURIComponent(filter_sort_order);

          }

          /*view-hook-javascript-1*/

          if (filter_ean) {

                  url += '&filter_ean=' + encodeURIComponent(filter_ean);

          }

          var filter_jan = jQuery('input[name=\'filter_jan\']').attr('value');



          if (filter_jan) {

                  url += '&filter_jan=' + encodeURIComponent(filter_jan);

          }

          var filter_mpn = jQuery('input[name=\'filter_mpn\']').attr('value');



          if (filter_mpn) {

                  url += '&filter_mpn=' + encodeURIComponent(filter_mpn);

          }

          var filter_isbn = jQuery('input[name=\'filter_isbn\']').attr('value');



          if (filter_isbn) {

                  url += '&filter_isbn=' + encodeURIComponent(filter_isbn);

          }

          //Handling ajaxed filter

          ajaxified(url);

          console.log(url);

          $('#form').attr('current', url);

          //location = url;

          

          /*view-hook-javascript-2*/

  }

  $(document).on('click', 'a.featured_link', function(e){

    e.preventDefault();

    var a = $(this);

    

    $.get($(this).attr('href'), function(){

      a.toggleClass('is_favourite');

    });

  });

  /*view-hook-javascript-3*/

  $(document).on('focusout', 'td.ean input', function(){

      var input = $(this);

      if(input.prop('value') != input.attr('orig')){

          $.get(input.attr('rel')+'&ean='+input.val(), function(result){

                  input.val(result);

                  input.attr('orig', result);

                  input.parents('td').addClass('updated');

                  setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);

          });

      }

  });

  $(document).on('focusout', 'td.jan input', function(){

      var input = $(this);

      if(input.prop('value') != input.attr('orig')){

          $.get(input.attr('rel')+'&jan='+input.val(), function(result){

                  input.val(result);

                  input.attr('orig', result);

                  input.parents('td').addClass('updated');

                  setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);

          });

      }

  });

  $(document).on('focusout', 'td.mpn input', function(){

      var input = $(this);

      if(input.prop('value') != input.attr('orig')){

          $.get(input.attr('rel')+'&mpn='+input.val(), function(result){

                  input.val(result);

                  input.attr('orig', result);

                  input.parents('td').addClass('updated');

                  setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);

          });

      }

  });

  $(document).on('focusout', 'td.isbn input', function(){

      var input = $(this);

      if(input.prop('value') != input.attr('orig')){

          $.get(input.attr('rel')+'&isbn='+input.val(), function(result){

                  input.val(result);

                  input.attr('orig', result);

                  input.parents('td').addClass('updated');

                  setTimeout(function(){input.parents('td').removeClass('updated');}, 1500);

          });

      }

  });

  $(document).on('change', '#product-extra-wrapper td.discount-column input.discount-price-field', function(e){

    var td = $(this).parents('td');

    var tds = $(this).parents('tr').children('td');

    var product_id = $(tds[0]).find('input').val();

    var trigger = $(this);

    $.get($(this).attr('rel'), {price: $(this).val()}, function(response){

      td.addClass('updated');

      trigger.val(response);

      td.parents('tr').find('td.acions .discount_link').addClass('has_discount');

      setTimeout(function(){td.removeClass('updated');}, 1500);

    });

  });

  $(document).on('change', '#product-extra-wrapper td.special-column input.special-price-field', function(e){

    var td = $(this).parents('td');

    var tds = $(this).parents('tr').children('td');

    var product_id = $(tds[0]).find('input').val();

    var trigger = $(this);

    $.get($(this).attr('rel'), {price: $(this).val()}, function(response){

      td.addClass('updated');

      trigger.val(response);

      td.parents('tr').find('td.acions .special_link').addClass('has_special');

      setTimeout(function(){td.removeClass('updated');}, 1500);

    });

  });

  //--></script>

  

  <script type="text/javascript"><!--

  var token = '<?php echo $user_token; ?>';

  var link = 'index.php?route=extension/product_extra&user_token=<?php echo $user_token; ?>';

  var no_image = '<?php echo $no_image; ?>';

  var text_product_manager = '<?php echo $text_product_manager; ?>';

  $(document).ready(function($) {

    $(document).on('keydown', '#product-extra-wrapper tr.filter input', function(e) {

          if (e.keyCode == 13) {

                  filter();

          }

    });

    $(document).on('focusout', '#product-extra-wrapper tr.filter input', function(e) {

          filter();

    });

    

    $(document).on('keydown', '#product-extra-wrapper .product-row :input', function(e) {

            if (e.keyCode == 13) {

              $(this).trigger('blur');

              $(this).focus();

              return false;

            }

    });

    $(document).on('click', '#discount-special-window button.discount-save', function(e){

        var trigger = $(this);

        e.preventDefault();

        trigger.removeClass('btn-primary').addClass('btn-warning').prepend('<i class="fa fa-floppy-o"></i> ');

        $.post($(this).attr('data-url'), $('#discount-special-window form').serialize(), function(response){

          ajaxified($('#form-product-extra').attr('current'));

          setTimeout(function(){

            trigger.removeClass('btn-warning').addClass('btn-primary');

            trigger.find('i').remove();

          }, 1500);

        });

      });

    $(document).on('click', '#product-extra-wrapper a.special_link, a.discount_link', function(e){

      e.preventDefault();

      var trigger = $(this);

      var title = $(this).parents('tr').find('.product-name').text();

      var model = $(this).parents('tr').find('.product-model').text();

      var popupLink = $(this).attr('href')+'&popup=true&rand='+Math.floor(Math.random()*1100000);

      $('#popup-window').remove();

      var popup = $('<div id="popup-window" class="hidden"></div>');

      popup.appendTo('body')

      popup.append('<div id="discount-special-window" class="modal" tabindex="-1" role="dialog"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-body" style="height: 600px;"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button><button type="button" data-url="'+popupLink+'" class="btn btn-primary discount-save">Сохранить</button></div></div>');

      popup.find('.modal-body').load(popupLink,null, function(){

            $('#popup-window').removeClass('hidden');

            $('#discount-special-window').modal({}).modal('show');

          });

    });

    



    $(document).on('click', '#product-extra-wrapper .copy-default-product', function(e){

      e.preventDefault();

      jQuery.get('index.php?route=extension/product_extra/default_product&user_token='+token, function(result){

        jQuery.post('index.php?route=catalog/product/copy&user_token='+token, {selected: [-1]}, function(result){

          ajaxified(jQuery('#form-product-extra').attr('current'));

        })

      });

    })



    $(document).on('click', '#product-extra-wrapper .disable-button', function(e){

      e.preventDefault();

      $('#form-product-extra').attr('action', 'index.php?route=extension/product_extra/disable&user_token=<?php echo $user_token; ?>');

      $('#form-product-extra').submit();

    })

   $(document).on('click', '#product-extra-wrapper .enable-button', function(e){

      e.preventDefault();

      $('#form-product-extra').attr('action', 'index.php?route=extension/product_extra/enable&user_token=<?php echo $user_token; ?>');

      $('#form-product-extra').submit();

    })





    $(document).on('click', '#product-extra-wrapper .delete-button', function(e){

      e.preventDefault();

      if(getCookie('remove-delete-confirmation') != 1){

        if(!confirm('Вы уверены?')){

          return false;

        }

      }

      $('#form-product-extra').attr('action', 'index.php?route=extension/product_extra/delete&user_token=<?php echo $user_token; ?>');

      $('#form-product-extra').submit();

    })


  });

  //--></script>

  <ul style="display: none;" id="cat-node-template">

    <li class="cat-list" id="product---p---category---c--">

      <a href="<?php echo $link;?>&type=remove_category&product_id=--p--&category_id=--c--" class="remove-category" style="display: none;">x</a>

      --cc--

    </li>

  </ul>

  </div>

  <?php echo $footer; ?>

<?php }?>

</div>
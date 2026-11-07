<?php if (isset($product) && $product) { ?>
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
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" id="thumb-<?php echo $product['product_id'];?>"/>
                    <input type="hidden" name="image" value="<?php echo $product['image']; ?>" data-id="<?php echo $product['product_id'];?>" id="image-<?php echo $product['product_id'];?>" rel="index.php?route=extension/product_extra&type=change_image&token=<?php echo $token; ?>"/>
                    <a class="remove" href="#">&times</a>
                  </a>
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
                  <a href="<?php echo $link;?>&type=add_category&product_id=<?php echo $product['product_id'];?>" class="add-category" style="display:none">+</a>
                  <ul>
                  <?php if($product['categories']){?>
                    <?php foreach($product['categories'] as $k=>$category){?>
                      <?php if(isset($categories[$category])){;?>
                        <li class="cat-list" id="product-<?php echo $product['product_id'];?>-category-<?php $category;?>">
                          <a href="<?php echo $link;?>&type=remove_category&product_id=<?php echo $product['product_id'];?>&category_id=<?php echo $category;?>" class="remove-category" style="display: none;">x</a>
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
                <input class="product-price-field gross-price-field" type="text" orig="<?php echo $product['price'];?>" rel="<?php echo $link;?>&type=change_price&product_id=<?php echo $product['product_id'];?>" name="quantity" value="<?php echo $product['price'];?>"/>
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
              <td class="right inputs date_available date-available-column <?php echo ((isset($_COOKIE['date-available-column']) && $_COOKIE['date-available-column'] == 1)?'':'hide-column');?>">
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
              <td class="right inputs discount-price-column discount-column <?php echo ((isset($_COOKIE['discount-price-column']) && $_COOKIE['discount-price-column'] == 1)?'':'hide-column');?>">
                <input class="gross-price-field discount-price-field" type="text" orig="<?php echo $product['discount_price'];?>" rel="<?php echo $link;?>&type=change_discount&product_id=<?php echo $product['product_id'];?>" name="discount_price" value="<?php echo $product['discount_price'];?>"/>
              </td>
              <td class="right inputs special-price-column special-column <?php echo ((isset($_COOKIE['special-price-column']) && $_COOKIE['special-price-column'] == 1)?'':'hide-column');?>">
                <input class="gross-price-field special-price-field" type="text" orig="<?php echo $product['special_price'];?>" rel="<?php echo $link;?>&type=change_special&product_id=<?php echo $product['product_id'];?>" name="special_price" value="<?php echo $product['special_price'];?>"/>
              </td>
              <td class="nobr acions">
                  <span class="edit-column <?php echo ((isset($_COOKIE['edit-column']) && $_COOKIE['edit-column'] == 1)?'':'hide-column');?>"><a class="edit_link pe_action" href="<?php echo $product['action']; ?>" title="<?php echo $edit_link;?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                  <?php //if(count($stores) == 0){?>
                    <span class="view-column <?php echo ((isset($_COOKIE['view-column']) && $_COOKIE['view-column'] == 1)?'':'hide-column');?>"><a class="view_link pe_action" href="<?php echo HTTP_CATALOG;?>?route=product/product&product_id=<?php echo $product['product_id'];?>" target="frontend" title="<?php echo $view_column_switch;?>"><i class="fa fa-eye" aria-hidden="true"></i></a></span>
                  <?php //};?>
                  <span class="discounts-column <?php echo ((isset($_COOKIE['discounts-column']) && $_COOKIE['discounts-column'] == 1)?'':'hide-column');?>"><a class="<?php echo ($product['hasDiscount'] == true)?'has_discount ':'';?>discount_link pe_action" href="<?php echo $link;?>&type=special_prices&product_id=<?php echo $product['product_id'];?>&t=discount" title="<?php echo $discount_link; ?>">C</a></span>
                  <span class="specials-column <?php echo ((isset($_COOKIE['specials-column']) && $_COOKIE['specials-column'] == 1)?'':'hide-column');?>"><a class="<?php echo ($product['hasSpecial'] == true)?'has_special ':'';?>special_link pe_action" href="<?php echo $link;?>&type=special_prices&product_id=<?php echo $product['product_id'];?>&t=special" title="<?php echo $special_link; ?>">A</a></span>
                  <span class="action-button featured-column <?php echo ((isset($_COOKIE['featured-column']) && $_COOKIE['featured-column'] == 1)?'':'hide-column');?>"><a class="<?php echo (in_array($product['product_id'], $featured)?'is_favourite ':'');?> featured_link pe_action" href="<?php echo $link;?>&type=featured_product&product_id=<?php echo $product['product_id'];?>" title="Сделать Рекомендуемым"><i class="fa fa-star" aria-hidden="true"></i></a></span>
                  <!--view-hook-actions-row-->
              </td>
<?php } ?>
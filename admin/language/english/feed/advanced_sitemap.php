<?php
// Heading
if (file_exists(DIR_APPLICATION . 'model/tool/seo_package.php')) {
  $_['heading_title']	= '<img src="view/seo_package/img/icon.png" style="vertical-align:top;padding-right:4px"/> <b style="color:#11b209">SEO Package</b> <b style="color:#555">Sitemap</b>';
} else {
  $_['heading_title'] = '<i class="fa fa-sitemap" style="color:#11b209"></i> <b>Advanced</b> <b style="color:#11b209">Sitemap Generator</b>';
}

// Text 
$_['text_feed'] = 'Product Feeds';
$_['text_add_feed'] = 'New sitemap';
$_['text_success'] = 'Success: options have been saved';
$_['text_info'] = 'This sitemap does not contains duplicates and integrates the hreflang tag if enabled in seo package options.';
$_['text_minute'] = 'Minute(s)';
$_['text_hour'] = 'Hour(s)';
$_['text_day'] = 'Day(s)';
$_['entry_data_feed']	= 'Full sitemap:<span class="help">Feed containing all languages using hreflang tag (hreflang will be displayed in case of more than one language)</span>';
$_['entry_lang_feed']	= 'Lang based sitemap:<span class="help">Use these if you prefer separate language version</span>';
$_['entry_grid_feed']	= 'Grid product sitemap:<span class="help">A grid of product thumbnails (this is for consult only, do not give this sitemap link to google)</span>';

// Tabs
$_['text_tab_0'] = 'Sitemaps';
$_['tab_opt_1'] = 'Sitemap configuration';
$_['tab_opt_2'] = 'Advanced options';
$_['entry_feed_title'] = 'Name:';
$_['entry_cache_delay'] = 'Cache Delay';
$_['entry_cache_delay_help'] = 'How many time to display generated file until re-generation ?';
$_['entry_language'] = 'Language:<span class="help"></span>';
$_['entry_feed_url'] = 'Sitemap Url:<span class="help">Give this url to google or bing</span>';

$_['text_tab_1'] = 'Custom links';

// Configuration
$_['text_tab_2'] = 'Configuration';

$_['text_link_type'] = 'Link type';
$_['text_type_product'] = 'Product';
$_['text_type_category'] = 'Category';
$_['text_type_manufacturer'] = 'Brand';
$_['text_type_information'] = 'Information';
$_['text_type_custom'] = 'Custom link';
$_['text_type_journal'] = 'Journal blog';

$_['entry_status'] = 'Status';
$_['entry_lang_feeds'] = 'Language Based Sitemap<span class="help">Enable or disable per language based sitemap</span>';
$_['entry_priority'] = 'Priority';
$_['entry_freq'] = 'Change frenquency';
$_['entry_in_stock'] = 'Include only in stock products:<span class="help">If disabled all products are included, if enabled only product with quantity >= 1</span>';
$_['entry_item_no'] = 'Number of items per xml:<span class="help">How many urls do you want to display in each xml file, default is 500';
$_['entry_friendly_url'] = 'Friendly URL:<span class="help">Display this sitemap in http://example.com/sitemap.xml instead of the default opencart sitemap</span>';
$_['entry_display_img'] = 'Display image thumb in feed:<span class="help">This is for viewing only, the image is still included for search engines.<br/>Warning: if you enable this, the images could be indexed by google and lead to sitemap, it is recommended to enable this setting only for testing purpose.</span>';
$_['entry_include_img'] = 'Include main image in feed:<span class="help">Include main product image into your feed? This is better if you want to be found via google image search</span>';
$_['entry_additional_img'] = 'Include additional images:<span class="help">Include additional product images into your feed? This is better if you want to be found via google image search</span>';
$_['entry_fullsize_img'] = 'Fullsize images:<span class="help">Link to the fullsize image if enabled, or the resized image if disabled (like the one in product page)</span>';
$_['custom_links_include'] = 'Include Custom Links:<span class="help">Set up your own links into the sitemap.<br/><br/>Must be formatted like this: <b>type@url</b><br/><br/>For example with static url: <b>MyBlog@http://website/my-blog</b><br/><br/>Or using dynamic urls (they will be automatically rewritten), just put all that is after index.php?route=, like this:<br/><b>MyBlog@blog/blog_id=123</b></span>';
$_['custom_links_exclude'] = 'Exclude Links:<span class="help">Set up the links you do not want to include in sitemap, it can be any link of your website.<br/><br/>For example:<br/><b>http://website/some_product</b></span>';

$_['text_freq_always'] = 'Always';
$_['text_freq_hourly'] = 'Hourly';
$_['text_freq_daily'] = 'Daily';
$_['text_freq_weekly'] = 'Weekly';
$_['text_freq_monthly'] = 'Monthly';
$_['text_freq_yearly'] = 'Yearly';
$_['text_freq_never'] = 'Never';

$_['text_tab_about'] = 'About';

// Entry

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify SEO Package Sitemap feed!';
?>
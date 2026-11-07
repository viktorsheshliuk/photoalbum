<?php
// English   Multilingual SEO      Author: Sirius Dev
// Heading
$_['heading_title']		  = '<img src="view/seo_package/img/icon.png" style="vertical-align:top;padding-right:4px"/><b style="color:#555">Complete</b> <b style="color:#11b209">SEO Package</b>';
$_['module_title']		  = 'Complete SEO <span>Package</span>';
  
$_['text_store_select'] = 'Store';

// Dashboard
$_['tab_seo_dashboard'] = 'Dashboard';
$_['text_seo_score'] = 'SEO Power';
$_['text_dashboard_config'] = 'SEO Overview';

// Tab multistore
$_['tab_seo_multistore'] = 'Multistore';
$_['info_multistore_dashboard']	= 'Here you can define specific parameters each store.<br/><br/>If Multistore SEO component is enabled you can also set specific urls for each store products/categories/informations and the mass update tab will be available here.<br/><br/>Enabling Multistore component will insert new tables in your database to handle the multistore urls and seo data (titles, metas, etc.).';

// Tab seo editor
$_['tab_seo_editor']      					= 'SEO Editor';
$_['tab_seo_editor_product']			= 'Product';
$_['tab_seo_editor_category']			= 'Category';
$_['tab_seo_editor_information']		= 'Information';
$_['tab_seo_editor_manufacturer']	= 'Manufacturer';
$_['tab_seo_editor_image']	= 'Image';
$_['tab_seo_editor_absolute']			= 'Absolute Url';
$_['tab_seo_editor_common']			= 'Common Page Url';
$_['tab_seo_editor_special']			= 'Param Url';
$_['tab_seo_editor_redirect']			= 'Url Redirection';
$_['tab_seo_editor_404']			= '404 Manager';
$_['text_multistore']			= 'Multistore SEO';
$_['info_multistore']			= 'Give different SEO information (keyword, metas, etc) on products and categories for each store';
$_['text_editor_count']					= 'Count';
$_['text_editor_query']					= 'Query';
$_['text_editor_query_redirect'] = 'Query';
$_['text_editor_query_absolute']		= 'Full Query (value after route=)';
$_['text_editor_query_common']		= 'Query (value after route=)';
$_['text_editor_query_special']		= 'Query (ex: custom_id=1)';
$_['text_editor_image']					= 'Image';
$_['text_editor_name']					= 'Name';
$_['text_editor_title']						= 'Title';
$_['text_editor_meta_title']				= 'Meta title';
$_['text_editor_meta_keyword']		= 'Meta keyword';
$_['text_editor_meta_description']	= 'Meta description';
$_['text_editor_url']						= 'SEO url';
$_['text_editor_url_absolute']	= 'Full seo url';
$_['text_editor_url_redirect']	= 'Redirect to';
$_['text_editor_tag']						= 'Tags';
$_['text_editor_h1']						= 'Seo H1';
$_['text_editor_item_name']	= 'Product name';
$_['text_editor_image_name']	= 'Name';
$_['text_editor_image_alt']	= 'Alt';
$_['text_editor_image_title']	= 'Title';
$_['text_editor_related']			= 'Related';
$_['text_seo_new_alias_title']			= 'Insert new url alias';
$_['text_seo_new_absolute_alias_info'] = 'Rewrite an url in absolute way, for example index.php?route=<b>blog/blog&post_id=123</b><br/>In query field put <b>blog/blog&post_id=123</b> (insert only the value after index.php?route=)<br/>In SEO url field put the url you want: <b>blog/this-is-a-blog-post</b>';
$_['text_seo_new_alias_info']			= 'Rewrite an url that use the route parameter, for example index.php?route=<b>account/account</b><br/>In query field put <b>account/account</b> (it is not necessary to insert route=)<br/>In SEO url field put the url you want: <b>my-account</b>';
$_['text_seo_new_spec_alias_info']	= 'Rewrite urls that belongs to any custom module even if it is not made to handle friendly urls.<br/>For example index.php?<b>blog_news_id=123</b><br/>In query field put <b>blog_news_id=123</b><br/>In SEO url field put the url you want: <b>a-great-url-for-my-great-news</b>';
$_['text_seo_new_redirect']	= 'This generates a 301 redirection to indicate to search engines that the current url has been moved permanently to a new one. Use this feature to fix crawling errors from google webmaster.<br/><br/>In query type the full url <b>http://example.com/broken-url</b><br/>In redirect field put new url <b>http://example.com/fixed-url</b><br/><br/>Or without the domain name (don\'t forget the initial /)<br/>In query: <b>/broken-url</b><br/>In redirect field: <b>/fixed-url</b><br/><br/>Dynamic redirection<br/>If you want to make it work even with further url updates fill the redirect field that way:<br/><b>product/product&product_id=42</b> (where 42 is your actual product id)';
$_['text_info_limits_tab'] = 'Meta fields limits';
$_['text_info_limits_title'] = 'Meta title and description limits';
$_['text_info_robots'] = '<h4>Meta Robots</h4>
<p>The robots meta tag lets you utilize a granular, page-specific approach to controlling how an individual page should be indexed and served to users in search results.<br/>The setting defined here will be the default one for all pages of your store, then you can edit a specific product to change the robots value (in data tab) for this product only.<br/>The meta robots parameter will be set in your page as meta tag in head section: &lt;meta name="robots" /&gt;</p>
<table class="table table-bordered">
  <tbody><tr><th>Directive</th><th>Meaning</th></tr>
  <tr><td><code><span>all</span></code></td>
    <td>There are no restrictions for indexing or serving. Note: this
      directive is the default value and has no effect if explicitly
      listed, so when you choose this value the meta robots tag won\'t be displayed</td></tr>
  <tr><td><code><span>noindex</span></code></td>
    <td>Do not show this page in search results</td></tr>
  <tr><td><code><span>nofollow</span></code></td>
    <td>Do not follow the links on this page</td></tr>
  <tr><td><code><span>none</span></code></td>
    <td>Equivalent to <code><span>noindex,<wbr> nofollow</span></code></td></tr>
  <tr><td><code><span>noimageindex</span></code></td>
    <td>Do not index images on this page.</td></tr>
</tbody></table>
<h4>Automatic settings</h4>
<p>Once enabled you will be able to define the default value for meta robots, and the module will automatically apply the best parameter for some specific pages, please see the following list to know which parameters are automatically set on your website:</p>
<table class="table table-bordered">
<tr><th style="width:220px">Type</th><th>Meta robots value</th></tr>
<tr><td>Pagination pages</td><td><code>noindex, follow</code></td></tr>
<tr><td>Page with limit parameter</td><td><code>noindex, follow</code></td></tr>
<tr><td>Search pages</td><td><code>none</code> (noindex, nofollow)</td></tr>
</table>
';
$_['text_info_limits'] = '<h4>Meta title and description limits</h4>
<p>Meta title and description are very important since they are what the user will see when making a request on search engines, title as the main link and description the little text below.</p>
<p><img src="view/seo_package/img/help/meta_title_desc.png" alt="" class="img-thumbnail"/></p>
<p>Google is truncating your title after 67 characters but will index a few more, to get this easy to visualise the title field will become orange in case of bypassing 67 chars and red in case of bypassing 85 chars.<br/>The limit for description are ~300 chars for truncating and a bit more for indexing.</p>
<p><span style="color:#fc7402">Orange color</span> means your text will surely be truncated but will be fully indexed anyway.<br /><span style="color:#f23333">Red color</span> means some words at the end of your text won\'t be indexed.</p>
<p><b>Important:</b> default database field of opencart for meta description is limited to 255 chars, so if you want to have meta descriptions for 300 chars you should change the actual limit. To do so go into PHPMyAdmin > table oc_product_description > edit meta_description field and set 350 as the limit instead of 255.</p>';
$_['entry_analytics_code'] = 'Google Analytics code:';
$_['text_info_analytics_tab'] = 'Google Analytics';
$_['text_info_analytics'] = '<h4>Verify your website on Google Analytics</h4>
<p>You can have detailled information of your website SEO using google analytics, for that connect to <a href="https://www.google.com/webmasters/">https://www.google.com/webmasters/</a> and click on ADD A PROPERTY, then choose the HTML tag verification method like on the image below.</p>
<p><img src="view/seo_package/img/help/gg_analytics.png" alt="" class="img-thumbnail"/></p>
<p>Copy the code given by google here to activate the verification of your website. Now you should be able to verify on google page.</p>';

// Tab seo configuration
$_['tab_seo_options']      	= 'SEO Configuration';
$_['text_seo_package_status']	= 'SEO Package status:';
$_['text_seo_components']	= 'Components:';
$_['text_seo_tab_general_1']	= 'Components';
$_['text_seo_tab_general_2']	= 'Language tag';
$_['text_seo_tab_general_3']	= 'Hreflang';
$_['text_seo_tab_general_4']	= 'Keyword options';
$_['text_seo_tab_general_5']	= 'Auto update';
$_['text_seo_tab_general_6']	= 'Pagination';
$_['text_seo_tab_general_7']	= 'Cache';
$_['text_seo_tab_general_8']	= 'Canonical links';
$_['text_seo_tab_general_9']	= '';
$_['text_seo_tab_general_10']	= 'Reviews';
$_['text_seo_tab_general_11']	= 'Request headers';
$_['text_seo_tab_general_12']	= 'Sitemap';
$_['text_seo_tab_general_13']	= 'Meta robots';
$_['text_seo_tab_general_14']	= 'Redirections';
$_['text_seo_tab_general_16']	= 'Modules SEO';
$_['text_info_general']		= 'These settings impact the global functioning of SEOs, they take effect immediately and can be changed at any time.';
$_['text_info_general_3']		= 'Hreflang tag allow search engines to know the url of current page for other languages.<br/>Once activated it will be included in all pages of your website, and also into the seo package sitemap (feed > seo package sitemap).<br/> More information : <a href="https://support.google.com/webmasters/answer/189077?hl=en" target="new">here</a>';
$_['text_info_general_6']		= 'Rewrite pagination links SEO friendly, for example website.com/category?page=3 will become website.com/category/page-3';
$_['text_info_general_7']		= 'The cache feature will speed up your website by caching all url links instead of calculating them each time.<br/>Warning: this feature is experimental and may not work on all configurations, if you have another cache module or cache integrated with your theme disable this option.';
$_['text_info_general_8']		= 'Canonical links are informing search engines that if it find a same page elsewhere on the website it have to only consider one link, this is important in order to avoid duplicate content penalties';
$_['text_info_general_10']		= 'In default opencart reviews are loaded dynamically by ajax, that make search engines to not see the content of reviews which would be valuable content for your website, enable this option to be able to insert a block containing the user reviews in HTML in order to make search engines to be able to see them.<br /><br />You have to insert manually this code in your product/product.tpl template : <b>&lt;?php echo $seo_reviews; ?&gt;</b><br /><br /> Then you can style it as you want, container class is <b>.seo_reviews</b>, item class is <b>.seo_review</b>';
$_['text_info_general_12']		= 'The sitemap have to be configured into feeds section, please click on the button below to configure it.';
$_['text_seopackage_sitemap']		= 'SEO Package Sitemap';
$_['text_seo_pagination']		= 'Enable SEO pagination<span class="help">Warning: this is not compatible with ajax pagination included some themes, if it doesn\'t work you will have to disable seo pagination or ajax pagination of the theme</span>';
$_['text_seo_pagination_fix'] = 'Prev/next fix:<span class="help">Fix opencart 2.2+ issue with prev/next in subcategories</span>';
$_['text_seo_pagination_canonical'] = 'Canonical with pagination:<span class="help">Set canonical link of pagination pages to include the page number (not recommended)</span>';
$_['text_seo_canonical']		= 'Canonical:<span class="help">Enable canonical for all pages</span>';
$_['text_seo_absolute']		= 'Absolute category path:';
$_['text_seo_absolute_help']		= 'Allow to use same keyword for sub-categories and something else (ex: <br/>/laptop/apple<br/>/desktop/apple<br/>/apple (manufacturer))<br/>If you give keyword for manufacturer, it cannot be used for top category (/apple and /apple), only subcategories';
$_['text_seo_reviews']		= 'SEO reviews:<span class="help">Insert reviews in HTML content</span>';
$_['text_seo_extension']		= 'Extension:<span class="help">Add the extension of your choice at the end of a product keyword (ex: .html)</span>';
$_['text_seo_flag_tag']				= 'Tag after domain';
$_['text_seo_flag_store']				= 'Tag as subdomain';
$_['text_seo_flag']				= 'Language tag mode:';
$_['text_seo_flag_short']				= 'Short tag:';
$_['text_seo_flag_upper']	= 'Tag in uppercase:';
$_['text_seo_flag_default']	= 'No tag for default:';
$_['text_seo_urlcache']		= 'URL Cache:<span class="help">Speed up page loading by using url caching</span>';
$_['text_seo_redirect_dynamic']		= 'Redirect dynamic links:<span class="help">Dynamic links (route=product/product&product_id=32) will be automatically redirected to their friendly url if it exists. The redirection is 301 so search engine will stop to index it and take only friendly url as reference.</span>';
$_['text_seo_redirect_canonical']		= 'Redirect to canonical:<span class="help">This is for friendly urls, it checks if the current link is the canonical link, if not it will be redirected to the canonical. This avoid to have multiple urls active for same item. The redirection is 301.</span>';
$_['text_seo_redirect_canonical_1']		= 'Redirect all links except category links';
$_['text_seo_redirect_canonical_2']		= 'Redirect all links including category links';
$_['text_seo_redirect_http']	      	= 'HTTP mode:<span class="help">Use this to force your website to use SSL or www, if an url is not correct a 301 redirection will be made.</span>';
$_['text_seo_redirect_ssl']	      	    = 'Force SSL value, don\'t change WWW';
$_['text_seo_redirect_www']	      	    = 'Force WWW value, don\'t change SSL';
$_['text_seo_redirect_sslwww']	      	= 'Force both SSL and WWW values';
$_['text_seo_redirect_http_1']	      	= 'No-SSL, no-WWW - http://example.com';
$_['text_seo_redirect_http_2']	      	= 'No-SSL, WWW - http://www.example.com';
$_['text_seo_redirect_http_3']	      	= 'SSL, no-WWW - https://example.com';
$_['text_seo_redirect_http_4']	      	= 'SSL, WWW - https://www.example.com';
$_['text_seo_redirect_http_5']	      	= 'SSL - https://(www.)example.com';
$_['text_seo_redirect_http_6']	      	= 'No-SSL - http://(www.)example.com';
$_['text_seo_redirect_http_7']	      	= 'WWW - http(s)://www.example.com';
$_['text_seo_redirect_http_8']	      	= 'No-WWW - http(s)://example.com';
$_['text_seo_special_group']		= 'Special price group:<span class="help">[price] tag can calculate the special price, define here which customer group you want to use for calculating it, if disabled then only default price will be displayed</span>';
$_['text_seo_format_tag']		= 'Tag formatting:<span class="help">Add commas between each words to product tags when generating in mass update or auto-update</span>';
$_['text_seo_banner']		= 'Banner links rewrite:<span class="help">Dynamically generate seo link on banners (used in banner, carousel, slideshow modules)</span>';
$_['text_seo_banner_help']	= 'In banners section, do not enter the seo link (/category/product_name) but enter instead the default opencart link : <b>index.php?route=product/product&path=10_21&product_id=54</b>.<br />You can also strip out the index.php, like this : <b>product/product&path=23&product_id=48</b>';
$_['text_seo_hreflang']			= 'Enable hreflang tag:';
$_['text_seo_substore']			= 'Enable multi-store rewriting:';
$_['text_seo_substore_config'] = 'Actual configuration:';
$_['text_no_language_defined'] = 'No language defined';
$_['text_info_transform']		= 'All these settings define the way that the keyword will be generated when saving an item or using the mass update.';
$_['text_seo_whitespace']		= 'Spaces:<span class="help">Replace space chars by...</span>';
$_['text_seo_lowercase']		= 'Lowercase:<span class="help">QWERTY => qwerty</span>';
$_['text_seo_remove']		= 'Remove words:<span class="help">Remove some words when generating the urls, can be used to remove common words like "the, a, ...", put a comma between each one</span>';
$_['text_seo_duplicate']			= 'Duplicates:<span class="help">Allow to use same keyword for distinct language version of an item</span>';
$_['text_seo_ascii']				= 'ASCII mode:<span class="help">Replace accentuated chars by their ascii equivalent<br/>"éàôï" => "eaoi"<br/>Supported languages: All latin (French, Italian, Spanish, etc), Arabic, Bulgarian, Croatian, Czech, German, Greek, Latvian, Lithunanian, Polish, Romanian, Russian, Serbian, Slovenian, Turkish, Ukrainian</span>';
$_['text_seo_autofill']				= 'Auto fill';
$_['text_seo_autofill_on']		= 'on:';
$_['text_seo_autofill_desc']		= 'Auto fill:<span class="help">If left the field blank on insert or edit, a value will be created automatically based on the pattern in mass update tab.<br/><br/>This works for : <br/>- products<br/>- categories<br/>- informations</span>';
$_['text_seo_autourl']			= 'Auto URL:<span class="help">If left blank on insert or edit, seo url keyword will be generated automatically using the parameter set in "Mass update" tab<br/>This works for products, categories and informations</span>';
$_['text_seo_autotitle']			= 'Auto title and desc for other langs:<span class="help">If left blank on insert or edit, titles and descriptions of other languages will copy the default language title and description<br/>This works for products, categories and informations</span>';
$_['text_headers_lastmod'] = 'Last-Modified:<span class="help">Add last modified date in headers</span>';
$_['text_all']						= 'All';
$_['text_insert']						= 'Insert';
$_['text_edit']						= 'Edit';
$_['text_fix_search']   = 'Fix search url:';
$_['text_fix_search_help']   = '<span class="help">Search url cannot be friendly for the top search bar because the url is hardcoded in javascript, enable this option if you want to have the search url rewritten. If it is not working with your theme please contact us.</span>';
$_['text_fix_cart']   = 'Fix cart remove issue:';
$_['text_fix_cart_help']   = '<span class="help">When there is friendly url for checkout/cart the remove of a product is not updating the current screen, enable this to fix this issue.</span>';

// Tab store seo
$_['tab_seo_store']      			= 'Store SEO';
$_['text_info_store']				= '<h4>Store SEO</h4>
<p>In this section you can customize the meta title, h1, meta keywords and description on home page for each store and each language!</p><p>Anything entered here will bypass the values entered in opencart settings.</p>
<h4>Meta Title prefix and suffix</h4>
<p>Use this parameter to add some text before or after all your website meta titles, they can be defined for each store and each language.</p>
<p>For example if you want to have your title like <b>"Product title | My store"</b> just put <b>" | My store"</b> in suffix.</p>';
$_['text_info_seo_titles_tab']				= 'SEO titles (H1, H2, H3)';
$_['text_info_seo_titles']				= '<h4>SEO titles (H1, H2, H3)</h4>
<p>SEO titles are not automatically applied to your theme because this will be changing your design, so you have to manually insert them in your themplates.<br/><br/>Files to modify (.tpl or .twig):<br/><code style="padding:0">/catalog/view/theme/[theme]/template/common/home<br/>/catalog/view/theme/[theme]/template/product/product<br/>/catalog/view/theme/[theme]/template/product/category<br/>/catalog/view/theme/[theme]/template/product/information</code><br/><br/>Insert these codes for .tpl (please not $heading_title is automatically containing $seo_h1, so it is generally not necessary to put seo h1, just h2 and h3): <br/><code style="padding:0">&lt;h1&gt;&lt;?php echo $seo_h1; ?&gt;&lt;/h1&gt;<br/>&lt;h2&gt;&lt;?php echo $seo_h2; ?&gt;&lt;/h2&gt;<br/>&lt;h3&gt;&lt;?php echo $seo_h3; ?&gt;&lt;/h3&gt;</code><br/><br/>Or these codes for .twig  (please not {{ heading_title }} is automatically containing {{ seo_h1 }}, so it is generally not necessary to put seo h1, just h2 and h3): <br/><code style="padding:0">&lt;h1&gt;{{ seo_h1 }}&lt;/h1&gt;<br/>&lt;h2&gt;{{ seo_h2 }}&lt;/h2&gt;<br/>&lt;h3&gt;{{ seo_h3 }}&lt;/h3&gt;</code><br/></p>
<p>Consider that elements with display:none may not be considered by search engines, so you may want to insert only some of these depending your template (h1 is the most important).</p>';
$_['entry_robots']      = 'Enable meta robots';
$_['store_seo_global'] = 'Global settings';
$_['store_seo_home'] = 'Homepage only';
$_['entry_robots_default']      = 'Default value';
$_['entry_store_seo_title']      = 'Meta Title:';
$_['entry_store_seo_title_extra'] = 'Meta Title prefix and suffix:';
$_['entry_store_title']      		= 'Title H1:';
$_['entry_store_h2']      	  	= 'Title H2:';
$_['entry_store_h3']      	  	= 'Title H3:';
$_['entry_store_desc']      		= 'Meta Description:';
$_['entry_store_keywords']	= 'Meta Keywords:';
$_['info_store_heading']	= 'See information below to include in your theme';

// Tab rich snippets
$_['tab_seo_snippets']			= 'Rich Snippets';
$_['text_seo_tab_snippet_1']		= 'Google Microdata (Rich Cards)';
$_['text_seo_tab_snippet_2']		= 'Facebook Open Graph';
$_['text_seo_tab_snippet_3']		= 'Twitter Card';
$_['text_seo_tab_snippet_3']		= 'Twitter Card';
$_['text_seo_tab_snippet_4']		= 'Google Publisher';
$_['tab_microdata_1']		        = 'Product';
$_['tab_microdata_2']		        = 'Organization';
$_['tab_microdata_3']		        = 'Store';
$_['tab_microdata_4']		        = 'Website';
$_['tab_microdata_5']		        = 'Place';
$_['tab_microdata_6']		        = 'Breadcrumbs';
$_['entry_snippet_pricerange']	= 'Price range:';
$_['entry_snippet_same_as']		  = 'Same as:';
$_['entry_enable_microdata']		= 'Enable Google Microdata:';
$_['entry_microdata_search']		= 'Search box';
$_['entry_microdata_logo']		  = 'Logo';
$_['entry_microdata_address']	  = 'Address';
$_['entry_snippet_contact']		  = 'Contacts';
$_['entry_microdata_gps']		    = 'GPS coordinates';
$_['entry_gps_lat']		          = 'Latitude';
$_['entry_gps_long']		        = 'Longitude';
$_['entry_address_street']      = 'Street';
$_['entry_address_city']        = 'Locality';
$_['entry_address_region']      = 'Region';
$_['entry_address_code']        = 'Postal code';
$_['entry_address_country']     = 'Country';
$_['entry_email']		            = 'Email';
$_['entry_phone']		            = 'Phone';
$_['entry_product_data']		    = 'Include product data:';
$_['entry_snippet_data']		    = 'Include data:';
$_['entry_model']		            = 'Model';
$_['entry_description']		      = 'Description (based on meta description)';
$_['entry_reviews']		          = 'Reviews';
$_['entry_upc']		              = 'UPC';
$_['entry_mpn']		              = 'MPN';
$_['entry_ean']		              = 'EAN';
$_['entry_isbn']		            = 'ISBN';
$_['entry_rating']		          = 'Average rating';
$_['entry_manufacturer']		    = 'Manufacturer';
$_['entry_brand']		            = 'Manufacturer';
$_['entry_enable_opengraph']		= 'Enable Facebook Open Graph:';
$_['entry_opengraph_id']		    = 'Facebook App ID:';
$_['entry_enable_tcard']		    = 'Enable Twitter Card:';
$_['entry_twitter_nick']		    = 'Twitter nickname (optional):';
$_['entry_twitter_home_type']		= 'Home page type:';
$_['entry_twitter_summary']		  = 'Summary';
$_['entry_twitter_summary_large'] = 'Summary with large image';
$_['entry_enable_gpublisher']		    = 'Enable Google Publisher:';
$_['entry_gpublisher_url']		    = 'Google+ url:';


// Tab friendly urls
$_['tab_seo_friendly']				= 'Friendly URLs';
$_['text_seo_export_urls']		= 'Export URLs';
$_['text_seo_export_urls_tooltip'] = 'Export Friendly URLs and send them to the developer for integration in official package';
$_['text_seo_reset_urls']  		= 'Restore default URLs';
$_['text_seo_reset_urls_tooltip']= 'If the current language does not have predefined urls the module will load english version';
$_['text_info_friendly']			= 'Here you can manage the friendly urls, edit them as you want.<br/>You have also the possibility to add new url, it works for example for any custom module you installed, just fill the 1st field with the value in route (?route=mymodule/action) and the 2nd field with the keyword you want to appear in the url.';
$_['text_seo_friendly']			= 'Common Pages Urls';
$_['info_seo_friendly']			= 'Enable this component in order to rewrite urls for common pages urls and param urls';
$_['info_seo_absolute']			= 'Enable this component in order to use absolute urls';
$_['info_seo_404']			    = 'Enable this component to activate the logging of 404 error pages';
$_['info_seo_redirect']			= 'Enable this component to activate 301 redirections';
$_['text_seo_cat_slash']			= 'Final slash on category';
$_['text_seo_cat_slash_help']			= 'Insert a final slash at the end of category urls';
$_['text_seo_redir_reviews'] = 'Redirect orhpan reviews:<span class="help">If a review page index.php?route=product/product/review is not accessed through ajax request then redirect 301 to the product page. This prevent these review snippet to be indexed.</span>';
$_['text_seo_remove_urls'] = 'Remove all entries';
$_['text_seo_remove_redirected'] = 'Remove redirected entries';
$_['text_seo_add_url']      = 'Add new entry';

// Tab full product path
$_['tab_seo_fpp']			= 'Path Manager';
// Text
$_['tab_fpp_product']   = 'Product';
$_['tab_fpp_category']   = 'Category';
$_['tab_fpp_manufacturer']   = 'Manufacturer';
$_['tab_fpp_search']   = 'Search/Tag';
$_['tab_fpp_common']   = 'Common';
$_['text_fpp_cat_canonical']   = 'Category canonical:';
$_['text_fpp_cat_mode_0']   = 'Direct link';
$_['text_fpp_cat_mode_1']   = 'Full path';
$_['text_fpp_cat_canonical_help']   = 'What kind of link you want to give to search engines ?<br/><b>Direct link</b>: /category (default)<br/><b>Full path</b>: /cat1/cat2/category<br/><br/>With direct link path mode the canonical is automatically set on directl link too';
$_['text_fpp_mode']   = 'Product path mode:';
$_['text_fpp_mode_0']   = 'Direct link';
$_['text_fpp_mode_1']   = 'Shortest path';
$_['text_fpp_mode_2']   = 'Largest path';
$_['text_fpp_mode_3']   = 'Manufacturer path';
$_['text_fpp_mode_4']   = 'Last category';
$_['text_fpp_slash']   = 'Final slash';
$_['text_fpp_slash_mode_0']   = 'No final slash';
$_['text_fpp_slash_mode_1']   = 'Final slash on categories';
$_['text_fpp_slash_mode_2']   = 'Final slash on all urls';
$_['text_fpp_slash_help']   = 'Insert a final slash on urls, this is matter of preference, there is no SEO impact.';

$_['text_fpp_bc_mode'] = 'Breadcrumbs mode:';
$_['text_fpp_breadcrumbs_fix'] = 'Breadcrumbs generator:';
$_['text_fpp_breadcrumbs_0']   = 'Default';
$_['text_fpp_breadcrumbs_1']   = 'Generate if empty';
$_['text_fpp_breadcrumbs_2']   = 'Always generate';

$_['text_fpp_mode_help']   = '<span class="help"><b>Direct link:</b> direct link to product, no category included (ex: /product_name), this is default opencart behaviour<br/>
																		  <b>Shortest path:</b> shortest path by default, can be altered by banned categories (ex: /category/product_name)<br/>
																		  <b>Largest path:</b> largest path by default, can be altered by banned categories (ex: /category/sub-category/product_name)<br/>
																		  <b>Last category:</b> only the last category of the product will be displayed, if you have a product in /category/sub-category/product_name the link will be /sub-category/product_name<br/>
																		  <b>Manufacturer path:</b> manufacturer path instead of categories (ex: /manufacturer/product_name)</span>';
$_['text_fpp_breadcrumbs_help']   = '<span class="help"><b>Default:</b> default opencart behaviour: will display breadcrumbs coming from categories<br/>
																		  <b>Generate if empty:</b> generate breadcrumbs only when it is not already available, so category breadcrumb is preserved (recommended)<br/>
																		  <b>Always generate:</b> overwrite also the category breadcrumbs, so the only breadcrumbs you will get is the one generated by the module<br/></span>';
$_['text_fpp_bypasscat'] = 'Rewrite product path in categories:';
$_['text_fpp_bypasscat_help'] = '<span class="help">If disabled, the product link from categories remains the same in order to preserve normal behaviour and breadcrumbs.<br/>If enabled, the product link from categories is overwritten with path generated by the module.<br>In any case canonical link is updated with good value so google will only see the url generated by the module for a given product.</span>';
$_['text_fpp_directcat'] = 'Category path mode:';
$_['text_fpp_directcat_help'] = 'What kind of link you want to display on your website ?<br/><b>Direct link</b>: /category<br/><b>Full path</b>: /cat1/cat2/category (default)';
$_['text_fpp_homelink'] = 'Rewrite home link:';
$_['text_fpp_homelink_help'] = '<span class="help">Set homepage link to mystore.com instead of mystore.com/index.php?route=common/home</span>';
$_['text_fpp_depth']   		= 'Max levels:';
$_['text_fpp_depth_help']   = '<span class="help">Maximum category depth you want to display, for example if you have a product in /cat/subcat/subcat/product and set this option to 2 the link will become /cat/subcat/product<br/>This option works in largest and shortest path modes</span>';
$_['text_fpp_unlimited']   = 'Unlimited';
$_['text_fpp_brand_parent']   = 'Manufacturer parent:';
$_['text_fpp_brand_parent_help']   = '<span class="help">Include the manufacturers inside the manufacturer list url.<br/>For example if your manufacturer list is /brand, the manufacturer apple will appear this way /brand/apple instead of direct /apple</span>';
$_['text_fpp_remove_search']   = 'Remove search/tag parameters:';
$_['text_fpp_remove_search_help']   = '<span class="help">Remove the search or tag parameter (?search=something, ?tag=something) from product urls in search results (products urls only, not search page url itself)</span>';
$_['text_fpp_seo_tag']		= 'Seo tag:<span class="help">For tag urls (route=product/search&tag=something) define the keyword to use for nice url, for example if you set "tag" the result url will be /tag/something</span>, let empty to disable';
$_['entry_category']		= 'Banned categories:<span class="help">Choose the categories that will never be displayed in case of multiple paths</span>';

// Tab mass update
$_['tab_seo_update']       = 'Mass Update';
$_['text_info_update']     = 'Be careful when using this function since it will overwrite all your keywords.<br/>You can use the simulate function to check the result before really update.<br/>Select the language flags to update only these languages.';
$_['text_cleanup']				= 'Clean up:<span class="help">Remove old urls in database, make a clean up if you have troubles with some urls</span>';
$_['text_cache']					= 'URL cache:<span class="help">Generate or delete url cache</span>';
$_['text_redirection']					= 'Dynamic redirection:<span class="help">Save all actual urls for further redirection, then you can change the seo keyword, google will keep the track.</span>';
$_['text_cache_create_btn']= 'Generate cache';
$_['text_redirect_create_btn']= 'Generate redirection';
$_['text_cache_delete_btn']= 'Clear cache';
$_['text_cleanup_btn']		= 'Clean up';
$_['text_cleanup_duplicate_btn']		= 'Remove duplicate url alias';
$_['text_cleanup_done']		= 'Clean up done, %d entries deleted';
$_['text_seo_languages']   = 'Select languages';
$_['text_seo_simulate']    = 'Simulation:<span class="help">No changes are made while this button is on</span>';
$_['text_seo_empty_only']    = 'Update empty values only:<span class="help">Check off to overwrite all values</span>';
$_['text_seo_redirect']    = 'Redirection';
$_['text_seo_redirect_mode']    = 'Url redirection:<span class="help">Automatically insert a redirection for old urls</span>';
$_['text_image_name_lang'] = 'Image names can be set in only one language, please choose one and click on generate again';
$_['text_enable']   	 		 = 'Enable';
$_['text_deleted']   	 	 = 'Deleted';

// Tab cron
$_['tab_seo_cron'] 			= 'Cron';
$_['text_info_cron']			= 'You can make mass update using cron jobs, copy the file <b>seo_package_cli.php</b> from "_extra files" folder (preferably into a directory outside of web root) and configure your cron with the path to that file.<br/>The script will use the settings configured on this page.<br/>Warning: cron jobs may not be able generate unlimited items depending on your server limitations and number of items you have you may face error on using cron, it is recommended to use the "empty only" parameter to limit the number of items you are going to update using cron.<br/><br/>Use this cron command (must be adapted to your server php path):<br/>/[path_to_php]/php [path_to_your_root_folder]/seo_package_cli.php<br/><br/>Or this one for substores:<br/>/[path_to_php]/php [path_to_your_root_folder]/seo_package_cli.php store=X (replace X by the store ID)';
$_['text_seo_cron_update'] = 'Update:';
$_['text_clear_logs'] = 'Clear logs';
$_['text_tab_cron_1'] = 'Configuration';
$_['text_tab_cron_2'] = 'Report';
$_['text_cli_log_save'] = 'Save log file';
$_['text_cli_log_too_big'] = 'Your log file is too big (%s) to be displayed here - you can download it or clear it with buttons below';

// Tab about
$_['tab_seo_about']			 = 'About';

$_['text_nothing_changed']    				= 'Zero items';
$_['text_seo_no_language']    				= 'No language selected';
$_['text_seo_fullscreen']    						= 'Fullscreen';
$_['text_seo_show_old']    						= 'Display old value';
$_['text_seo_change_count']    				= 'entries changed';
$_['text_seo_old_value']    						= 'Old value';
$_['text_seo_new_value']    					= 'New value';
$_['text_seo_item']    					= 'Item';
$_['text_simulation']    					= 'Simulation mode';
$_['text_write']    					    = 'Write mode';
$_['text_empty_only']    					    = 'Empty values only';
$_['text_all_values']    					    = 'All values';
$_['text_seo_update_info']    					= '1. Enable or disable simulation mode<br/>2. Select if you want to update only empty items or all items<br/>3. Click on the Generate button of your choice<br/>4. Results will be displayed here';
$_['text_seo_simulation_mode']    			= '<span>SIMULATION MODE</span><br/>No changes will be made to database';
$_['text_seo_write_mode']		    			= '<span>WRITE MODE</span><br/>Modifications will be saved';
$_['text_seo_product']							= 'Product';
$_['text_seo_category']							= 'Category';
$_['text_seo_manufacturer']					= 'Manufacturer';
$_['text_seo_information']						= 'Information';
$_['text_seo_cache']								= 'Name';
$_['text_seo_cleanup']							= 'Entry (url)';
$_['text_seo_type_product']					= 'Products';
$_['text_seo_type_category']					= 'Categories';
$_['text_seo_type_manufacturer']			= 'Manufacturers';
$_['text_seo_type_information']				= 'Informations';
$_['text_seo_type_redirect']				= 'Dynamic redirection';
$_['text_seo_mode_product']					= 'Products';
$_['text_seo_mode_category']					= 'Categories';
$_['text_seo_mode_manufacturer']			= 'Manufacturers';
$_['text_seo_mode_information']				= 'Informations';
$_['text_seo_mode_url_alias']				= 'Url Alias';
$_['text_seo_mode_duplicate']				= 'Remove duplicate';
$_['text_seo_type_redirection']					= 'Dynamic redirection';
$_['text_seo_type_report']						= 'Report';
$_['text_seo_type_cache']						= 'Cache';
$_['text_seo_type_cleanup']					= 'Clean up';
$_['text_seo_generator_product']			= 'Products:';
$_['text_seo_generator_product_desc']	= '<span class="help">Available patterns:<br/><b>[name]</b> : Product name<br/><b>[model]</b> : Model<br/><b>[category]</b> : Category name<br/><b>[brand]</b> : Brand name<br/><b>[desc]</b> : Description extract<br/><b>[desc_sentence]</b> : 1st sentence<br/><b>[current]</b> : Current value<br/><b>{aa|bb|cc}</b> : Random values<br/><b>{en}..{/en}</b> : Only for lang<br/><br/>Other : <b>[parent_category]</b> <b>[upc]</b> <b>[sku]</b> <b>[ean]</b> <b>[jan]</b> <b>[isbn]</b> <b>[mpn]</b> <b>[location]</b> <b>[price]</b> <b>[lang]</b> <b>[lang_id]</b> <b>[prod_id]</b> <b>[cat_id]</b></span>';
$_['text_seo_generator_category']			= 'Categories:';
$_['text_seo_generator_category_desc']	= '<span class="help">Available patterns:<br/><b>[name]</b> : Category name<br/><b>[desc]</b> : Description extract<br/><b>[current]</b> : Current value<br/><b>{aa|bb|cc}</b> : Random values<br/><b>{en}..{/en}</b> : Only for lang<br/><br/><b>[parent]</b> : Parent category name<br/><b>[lowest_price]</b> : Lowest product price<br/><b>[highest_price]</b> : Highest product price<br/><br/>Other : <b>[lang]</b> <b>[lang_id]</b> <b>[cat_id]</b></span>';
$_['text_seo_generator_information']		= 'Informations pages:';
$_['text_seo_generator_information_desc']= '<span class="help">Available patterns:<br/><b>[name]</b> : Information title<br/><b>[desc]</b> : Description extract<br/><b>[current]</b> : Current value<br/><b>{aa|bb|cc}</b> : Random values<br/><b>{en}..{/en}</b> : Only for lang<br/><br/>Other : <b>[lang]</b> <b>[lang_id]</b></span>';
$_['text_seo_generator_manufacturer']	= 'Manufacturers:';
$_['text_seo_generator_manufacturer_desc']= '<span class="help">Available patterns:<br/><b>[name]</b> : Manufacturer name<br/><b>[current]</b> : Current value<br/><b>{aa|bb|cc}</b> : Random values<br/><b>{en}..{/en}</b> : Only for lang</span>';
$_['text_seo_mode_url']					= 'SEO URLs';
$_['text_seo_generator_redirect']	= 'Generate dynamic redirections';
$_['text_seo_mode_title']				= 'Meta Title';
$_['seo_title_prefix']				= 'Prefix';
$_['seo_title_suffix']				= 'Suffix';
$_['text_seo_mode_h1']				  = 'SEO H1';
$_['text_seo_mode_h2']				  = 'SEO H2';
$_['text_seo_mode_h3']				  = 'SEO H3';
$_['text_seo_mode_image_name']  = 'Image name';
$_['text_seo_mode_image_alt']  = 'Image alt';
$_['text_seo_mode_image_title']  = 'Image title';
$_['text_seo_mode_keyword'] 		= 'Meta Keywords';
$_['text_seo_mode_description']		= 'Meta Description';
$_['text_seo_mode_related']		= 'Related products';
$_['text_seo_mode_tag']				= 'Tags';
$_['text_seo_mode_create']			= 'Generate';
$_['text_seo_mode_delete']			= 'Delete';
$_['text_seo_report']			= 'Report';
$_['text_seo_generator_url']			= 'Generate URLs';
$_['text_seo_generator_title']			= 'Generate Meta Title';
$_['text_seo_generator_keywords'] = 'Generate Meta Keywords';
$_['text_seo_generator_desc']		= 'Generate Meta Description';
$_['text_seo_generator_full_desc']		= 'Generate Description';
$_['text_seo_generator_store_copy_i']		= 'Copy store data from default store';
$_['text_seo_generator_store_copy']		= 'Copy store SEO data';
$_['text_seo_generator_tag']			= 'Generate Tags';
$_['text_seo_generator_h1']			= 'Generate SEO H1';
$_['text_seo_generator_h2']			= 'Generate SEO H2';
$_['text_seo_generator_h3']			= 'Generate SEO H3';
$_['text_seo_generator_imgalt']	= 'Generate Image Alt';
$_['text_seo_generator_imgtitle']	= 'Generate Image Title';
$_['text_seo_generator_imgname'] = 'Generate Image Name';
$_['text_seo_generator_related'] = 'Generate Related Products';
$_['text_seo_generator_related_no']	= 'Qty:';
$_['text_seo_generator_related_relevance'] = 'Relevance (0-10):';
$_['text_seo_generator_related_samecat'] = 'Same category';
$_['text_query']		= 'Query';
$_['text_keyword']		= 'Keyword';
$_['text_status']		= 'Status';
$_['text_empty']		= 'Empty';
$_['text_duplicate']		= 'Duplicate';
$_['text_report']		= 'Report';
$_['text_url_alias_report_btn']		= 'Url alias report';

$_['text_seo_result']      = 'Result:';

$_['text_module']          = 'Modules';
$_['text_success']         = 'Success: You have modified module SEO module!';

$_['text_man_ext']				 = 'Manufacturer extended';

$_['text_seo_confirm']		 = 'Are you sure ?';
$_['text_description']		 = 'Description';


// Full product path

// Help sections

$_['tab_info_request'] = 'Request headers';
$_['title_common_overview'] = 'Url components';
$_['text_info_common_overview'] = '
<p><b>Url components quick description, check dedicated section for more information.</b></p>
<h4>Absolute url</h4>
<p>Use this component to set friendly url to any custom module, works with full url instead of url keyword.</p>
<p>http://website.com/index.php?<b>route=blog/blog&path=12&post=32</b> &nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp;&nbsp; http://website.com/<b>blog/blog-cat/this-is-a-blog-post</b></p>
<h4>Common Page Url</h4>
<p>Use this component to set friendly url to default opencart pages (account, contact, checkout, ...), handles only the route= parameter.</p>
<p>http://website.com/index.php?<b>route=account/register</b> &nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp;&nbsp; http://website.com/<b>my-account/register</b></p>
<h4>Param url</h4>
<p>This component lists the seo url parameters from custom modules, so you can quick check them, you can create new parameters but it may not work on some modules so absolute url is recommended because it will work in any case.</p>
<p>http://website.com/some-category?<b>super_filter=42</b> &nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp;&nbsp; http://website.com/some-category/<b>filter-blue</b></p>
</ul>';
$_['text_info_absolute'] = '
<h4>Absolute Url - Handle any custom module url</h4>
<p>Opencart is working by default with url keywords, for example <b>/desktop/pc/some-computer</b>, from this url opencart is searching in database each part to determine to what it relates (category, product, information, etc), then it will compute this link to an understandable one for the system which will look like <b>index.php?route=product/product&path=12_31&product_id=54</b>.</p>
<p>With absolute url component you can define an url not using the keyword part but the full url itself, it is no use for product/information/categories etc but it can be very handy for making to work with any custom module.</p>
<p>It is working with unlimited parameters in source url and unlimited levels in seo url.</p>
<h4>Set up a new absolute url</h4>
<p>Example, transform <b>http://website.com/index.php?route=blog/blog&post=32</b> into <b>http://website.com/blog/this-is-a-blog-post</b>.</p>
<ol>
<li>Click on <span class="gkd-badge"><i class="fa fa-plus" style="color:#4CBD35"></i> Add new entry</span></li>
<li>Insert in query field <b>blog/blog&post=32</b> (do not insert index.php?route=)</li>
<li>in Full seo url field <b>blog/this-is-a-blog-post</b></li>
</ol>
</ul>';
$_['text_info_common'] = '
<h4>Common Page Url - Give friendly url to default opencart pages (account, contact, checkout, ...)</h4>
<p>By default opencart is not rewritting the common page urls, they remain this way <b>index.php?route=account/login</b>.</p>
<p>With common page url component you can define an seo url for all these pages </p>
<p>For example you can rewrite <b>index.php?route=account/register</b> to <b>register</b>, just put <b>account/register</b> in query (do not insert index.php?route=), and put <b>register</b> in seo url field.</p>
<p>Here you can not insert any parameter, for example <b>account/register&amp;param=value</b> won\'t work, you have to use absolute url for such link or insert the parameter into parameter url</p>
<h4>Get predefined urls</h4>
<p>Complete SEO comes with predefined urls for all common opencart pages, there various languages available and they will be automatically retrieved for current selected language if exists, if not it will get english urls instead.</p>
<p>Warning: using restore default urls will replace all existent common page urls listed for current language.</p>
<ol>
<li>Click on <span class="gkd-badge"><i class="fa fa-caret-down"></i></span> on the bottom button to get access to advanced options.</li>
<li>Then click on <span class="gkd-badge"><i class="fa fa-magic" style="color:#FB7C00"></i> Restore default URLs</span></li>
<li>If the keywords are available for current language they will be displayed, if not english language will be displayed and you will have to translate.</li>
<li>You translated a new language and want us to integrate in main package? then click on <span class="gkd-badge"><i class="fa fa-save" style="color:#4276D2"></i> Export URLs</span> and send us export file at support@geekodev.com</li>
</ol>
<h4>Set up a new common page url</h4>
<p>Example, transform <b>http://website.com/index.php?route=account/register</b> into <b>http://website.com/my-account/register</b>.</p>
<ol>
<li>Click on <span class="gkd-badge"><i class="fa fa-plus" style="color:#4CBD35"></i> Add new entry</span></li>
<li>Insert in query field <b>account/register</b> (do not insert route=)</li>
<li>in Full seo url field <b>my-account/register</b></li>
</ol>
</ul>';
$_['text_info_special'] = '
<h4>Param url - Manage seo keywords of parameters in url</h4>
<p>If you have a custom module which is handling seo keywords, its keywords will generally appear there, so you can easily give a look on them and change if necessary.</p>
<p>If your custom module does not manage seo url automatically then it is recommended to use Absolute Url component to handle the urls. You can also use a combination of Common Page and Param url to handle it but Absolute url is easier for that, so this component is recommended only for view and not for url creation.</p>
<h4>Set up a new redirection</h4>
<p><span class="gkd-badge"><i class="fa fa-plus" style="color:#4CBD35"></i> Add new entry</span> click on this button and follow the instructions to set your url redirection.</p>
</ul>';
$_['text_info_404'] = '
<h4>Not found (404) manager</h4>
<p>This section lists all url accessed on your website that are actually not existant or that opencart system have not been able to forward to any content. For example when you arrive on such page:</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/not_found.png" alt=""/></p>
<p>In such case Complete SEO Package will automatically save this url so you will be able to easily check all not found urls in this table and how many times they have been requested.</p>
<h4>Create a redirection from a not found url</h4>
<p>Click on the button <img src="view/seo_package/img/help/btn_plus.png"/> to a easily add a redirection for this url, once added your redirection will appear into "Url redirection" tab, and here the url will appear in <span class="text-success">green color</span> to indicate that this url already have a redirection.</p>
<h4>Remove actual entries</h4>
<p>These entries are for your information only, there is no impact to remove them, to do so just click on one of the following buttons:</p>
<ul class="list-unstyled">
<li style="margin-top:12px"><span class="gkd-badge"><i class="fa fa-minus" style="color:#ED5555"></i> Remove redirected entries</span> this will remove all urls marked as <span class="text-success">green</span> which means any url that already have his redirection set</li>
<li style="margin-top:12px"><span class="gkd-badge"><i class="fa fa-close" style="color:#ED5555"></i> Remove all entries</span> this will remove all urls in this table, marked green or not, don\'t worry this is not deleting the redirections made on these urls</li>
</ul>';
$_['text_info_redirections'] = '
<h4>Url redirection</h4>
<p>Here you can define your own URL redirections, this is using the redirection 301, it means search engines will consider the new url as the valid one.</p>
<p>If you need to change the URL of a page as it is shown in search engine results, we recommend that you use a server-side 301 redirect. This is the best way to ensure that users and search engines are directed to the correct page. The 301 status code means that a page has permanently moved to a new location.</p>
<p>301 redirects are particularly useful if you have any url not found on your website.</p>
<h4>Set up a new redirection</h4>
<p><span class="gkd-badge"><i class="fa fa-plus" style="color:#4CBD35"></i> Add new entry</span> click on this button and follow the instructions to set your url redirection.</p>';
$_['text_info_request'] = '<h4>Request headers</h4>
<p>Request headers are part of the HTTP protocol, they are sent on each request made to the server.<br/>Here you will be able to change some parameters related to request headers, such optimizations can improve performance for the end user and also for search engine crawling robots.</p>
<h5>Last-Modified</h5>
<p>Include the last modified date of the actual item, improves performance for user (browser will fetch page from cache if not updated) and for crawling robots. For products the date will be the one of the last edit of product or the one of the last review if any. It is highly recommended to activate this setting.</p><p><img class="img-thumbnail" src="view/seo_package/img/help/headers-last-modified.png" alt=""/></p>';
$_['help_fb_appid_tab'] = 'Facebook App ID';
$_['help_microdata'] = '
<h4>Google microdata</h4>
<p>Microdata is widely used by search engines to format the search result in better way, for example a product can display the price and review rating directly in search results : </p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/microdata-product.jpg" alt=""/></p>
<p>Complete SEO Package is using the latest JSON-LD format to include the microdata on your website. Basic informations are included (category, description, image, price, stock) and you can select extra data you want to display.</p>
<h4>Benefits of using microdata</h4>
<p><ul>
  <li>Eye catching results - Drawing a search users attention from your competitors and to your own result.</li>
  <li>Potential CTR increase - Possibly increasing click through rates and lowering the chance of the user bouncing as they have more information on the page before clicking through.</li>
  <li>Providing quality results - Offering results that are closer to user specifications.</li>
</ul></p>
<h4>Testing tool</h4>
<p>Use the following testing tool to check your actual microdata: <a href="https://search.google.com/structured-data/testing-tool" target="_blank">Google structured data testing tool</a></p>
';
$_['help_fb_appid'] = '
<h4>Facebook App ID</h4>
<p>You must fill your facebook App ID in order to get this feature working, you will find it in the settings of your developper panel: <a href="http://facebook.com/developers">http://facebook.com/developers</a>.</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/settings_app-id.gif" alt=""/></p>
';
$_['help_fb_setup_tab'] = 'How to use Facebook Opengraph';
$_['help_fb_setup']	= '
<h4>Install the Facebook Developer Application</h4>
<p>The first step in creating an application in Facebok is to install the Facebook Developer application.</p>
<p>To do that, log in to Facebook and then visit the URL <a href="http://facebook.com/developers">http://facebook.com/developers</a>.</p>
<p>If this is the first time you’ve installed the Developer Application, you will see the Request for Permission dialog show below:</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/permission.jpg" alt="" /></p>
<p>Click the <b>Allow</b> button to proceed.</p>
<h4>Creating the Facebook Application for your Website</h4>
<p>Now that you have the Developer App installed, click on the<b> Create New App</b> button.<br/><img class="img-thumbnail" src="view/seo_package/img/help/create-new-app.gif" alt=""/></p>
<p>Give your application an "App Display Name" (the name displayed to users).</p>
<p>For purposes of this tutorial, you don’t need to have a "Namespace".</p>
<p>Click the "I agree to Facebook Platform Policies" box; then click the <b>Continue</b> button.<br/><img class="img-thumbnail" src="view/seo_package/img/help/dialog_new-app.gif" alt=""/></p>
<p>On the next screen, enter the security phrase and then click <b>Submit</b>.</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/new-app_captcha.gif" alt=""/></p>
<p>There are a lot of options you can tweak related to your application. In this post, we are going to focus on the basics needed to get your website set up with a Facebook App ID.</p>
<h4>The Settings Tab</h4>
<p>This is where you do the basic set up for your app</p>
<p><img class="img-thumbnail" src="view/seo_package/img/help/settings_app-id.gif" alt=""/></p>
<p>App ID is now set up. Your App ID is the value you’ll be using to integrate your website with Facebook’s APIs so you can add the Social Plugins (Like Button, Send Button, Comments Box, etc.).</p>
<p>You don’t need to add an icon. If your website has a favicon, it will be displayed next to your site’s URL in Facebook Insights.</p>
<p><b>Basic info:</b></p>
<p><ul>
<li><b>App Display Name:</b> Make this the same as the original value you provided</li>
<li><b>App Namespace:</b> Leave blank</li>
<li><b>Contact Email:</b> Where you want Facebook to send emails regarding your app</li>
<li><b>App Domain:</b> just put “mydomain.com” where “mydomain.com” is your website’s domain URL (TLD)</li>
<li><b>Category:</b> Select a category from the pulldown list (optional)</li>
</ul></p>
<p>Your website is now an “object” in Facebook’s Open Graph, with its own App ID.</p>
';
$_['help_flag_mode'] = '
<h4>Tag after domain</h4>
<p>Language prefix mode permits to add the language code just after the domain name:</p>
<p><code>http://example.com/<b>en</b></code><br/><code>http://example.com/<b>fr</b></code>
<p>It can be useful to have a good separation between each language in multilingual websites.</p>
<p>This parameter can be enabled anytime and take effect immediately, there is no need to re-generate the urls.</p>
<h4>Extra options</h4>
<table class="table table-bordered">
<tr><th style="width:220px">Option</th><th>Effect</th></tr>
<tr><td><code>Short tag</code></td><td>Display <b>/en</b> instead of <b>/en-gb</b> in case you have full format defined</td></tr>
<tr><td><code>No tag for default</code></td><td>Default language won\'t display the language tag</td></tr>
<tr><td><code>Tag in uppercase</code></td><td>Display tag in uppercase <b>/EN, /FR</b></td></tr>
</table>
';
$_['help_store_mode'] = '
<h4>Tag as subdomain</h4>
<p>Enable this option if you want your links to be written with specific store depending the language. For example if you have 2 stores defined like this :</p>
<p><code>http://<b>en</b>.domain.com</code><br/><code>http://<b>fr</b>.domain.com</code></p>
<p>By default opencart allows to change language but stay on same domain, if you enable this option and change the language, you will be redirected to the other domain. Also the hreflang links will be correctly updated with corresponding store url.</p>
<p>This setting is using your stores configuration, so you have to configure the stores correctly to get this working, also note that this is not limited to subdomains, you could also use separate domains names for each language:</p>
<p><code>http://<b>english-store</b>.com</code><br/><code>http://<b>french-store</b>.com</code></p>
<p>If you make any modification on configuration in Settings > Stores, come back here and save settings again.</p>
<h5>Actual configuration</h5>
<p>In this section you can see how are actually binded your stores to each language, you must have only one store for each language in order to get this option working properly, if a store have no defined language you will get the message "<span class="text-danger">No language defined</span>", in this case it is necessary you define a language for this store in Settings > Stores.</p>
';


// Error
$_['error_permission'] = 'Warning: You do not have permission to modify this module!';
$_['error_module_disabled'] = 'Complete SEO Package is currently disabled, you can enable it in SEO Configuration tab.';
$_['error_friendly_disabled'] = 'Warning: Common Page Url component is disabled, you can edit all values but they will be active on front only when you activate this component in SEO Configuration';
$_['error_404_disabled'] = 'Warning: 404 Manager component is disabled, the logging of not found pages will be active only when you activate this component in SEO Configuration';
$_['error_absolute_disabled'] = 'Warning: Absolute Url component is disabled, you can edit all values but they will be active on front only when you activate this component in SEO Configuration';
$_['error_redirect_disabled'] = 'Warning: Url Redirection component is disabled, you can edit all values but they will be active on front only when you activate this component in SEO Configuration';
?>
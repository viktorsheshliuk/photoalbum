	<?php if (isset($remarketing_google_json) && $remarketing_google_json) { ?>
	<script>
	if (typeof sendGoogleRemarketing !== 'undefined') {
		sendGoogleRemarketing(<?php echo json_encode($remarketing_google_json); ?>);
	}
	</script> 
	<?php } ?>
	<?php if (!empty($remarketing_code)) echo $remarketing_code; ?> 
	<?php if (isset($ecommerce_status) && $ecommerce_status && !empty($ga4_datalayer)) { ?>
	<script>
	window.dataLayer = window.dataLayer || [];
	dataLayer.push({ ecommerce: null });
	dataLayer.push(<?php echo json_encode($ga4_datalayer); ?>); 
	</script> 
	<?php } ?>
	<?php if (isset($ga4_product) && $ga4_product) { ?>
	<script>
	if (typeof sendGa4Details !== 'undefined') {
		sendGa4Details(<?php echo json_encode($ga4_product); ?>, <?php echo ($measurement_ga4_status) ? 'true' : 'false'; ?>);
	} 
	</script>
	<?php } ?>
	<?php if (isset($ga4_json) && $ga4_json) { ?>
	<script>
	window.ecommerce_ga4_products = window.ecommerce_ga4_products || {};
	ecommerce_ga4_product_data = <?php echo json_encode($ga4_json); ?>;
	if (typeof sendGa4Impressions !== 'undefined') {
		sendGa4Impressions(ecommerce_ga4_product_data, <?php echo (isset($view_search_results) && $view_search_results) ? 'true' : 'false'; ?>, <?php echo ($measurement_ga4_status) ? 'true' : 'false'; ?>);
	}
	ecommerce_ga4_products = $.extend(ecommerce_ga4_products, ecommerce_ga4_product_data);
	  </script>
	<?php } ?>
	<?php if (isset($facebook_remarketing_status) && $facebook_remarketing_status && !empty($facebook_data_json)) { ?>
	<script>
	if (typeof sendFacebookDetails !== 'undefined') {
		sendFacebookDetails(<?php echo json_encode($facebook_data_json); ?>);
	}
	  </script>
	<?php } ?> 
	<?php if (isset($tiktok_remarketing_status) && $tiktok_remarketing_status && !empty($tiktok_data_json)) { ?>
	<script>
	if (typeof sendTiktokDetails !== 'undefined') {
		sendTiktokDetails(<?php echo json_encode($tiktok_data_json); ?>);
	}
	  </script>
	<?php } ?> 
	<?php if (isset($facebook_remarketing_status) && $facebook_remarketing_status && !empty($facebook_data_json_category)) { ?>
	<script>
	if (typeof sendFacebookCategoryDetails !== 'undefined') {
		sendFacebookCategoryDetails(<?php echo json_encode($facebook_data_json_category); ?>, <?php echo (isset($view_search_results) && $view_search_results) ? 'true' : 'false'; ?>);
	}
	  </script>
	<?php } ?>

	<?php if (isset($esputnik_remarketing_status) && $esputnik_remarketing_status && !empty($esputnik_data_json)) { ?>
	<script>
	if (typeof sendEsputnikDetails !== 'undefined') {
		sendEsputnikDetails(<?php echo json_encode($esputnik_data_json); ?>);
	}
	</script>
	<?php } ?> 
	<?php if (isset($esputnik_remarketing_status) && $esputnik_remarketing_status && !empty($esputnik_data_category_json)) { ?>
	<script>
	if (typeof sendEsputnikCategoryDetails !== 'undefined') {
		sendEsputnikCategoryDetails(<?php echo json_encode($esputnik_data_category_json); ?>);
	}
	</script>
	<?php } ?>
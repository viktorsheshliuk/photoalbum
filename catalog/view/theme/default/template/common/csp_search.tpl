<div id="search" class="input-group">
  <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control input-lg" />
  <span class="input-group-btn">
    <button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
  </span>
</div>
<script type="text/javascript"><!--
$(document).ready(function() { $('#search input[name=\'search\']').parent().find('button').off('click'); $('#search input[name=\'search\']').parent().find('button').on('click', function() { var url = '<?php echo isset($csp_search_url_param) ? $csp_search_url_param : HTTP_SERVER.'index.php?route=product/search&search=%search%'; ?>'; var value = $('header #search input[name=\'search\']').val(); if (value) {url = url.replace('%search%', encodeURIComponent(encodeURIComponent(encodeURIComponent(value))));} else {url = '<?php echo isset($csp_search_url) ? $csp_search_url : HTTP_SERVER.'index.php?route=product/search'; ?>';} location = url; });});
--></script>
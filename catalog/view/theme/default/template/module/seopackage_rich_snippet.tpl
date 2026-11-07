<?php if ($type == 'microdata') { ?>
<?php if ($page == 'category') { ?>
<?php } else { ?>
<!-- Microdata -->
<div itemscope="itemscope" itemtype="http://schema.org/Product">
  <meta itemprop="url" content="<?php echo $product_url; ?>">
  <meta itemprop="name" content="<?php echo $heading_title; ?>">
  <meta itemprop="image" content="<?php echo $thumb; ?>">
  <?php if (!empty($config['model'])) { ?>
  <meta itemprop="model" content="<?php echo $model; ?>">
  <?php } if (!empty($config['desc'])) { ?>
  <meta itemprop="description" content="<?php echo strip_tags($product_info['meta_description']); ?>">
  <?php } if (!empty($config['brand'])) { ?>
  <meta itemprop="manufacturer" content="<?php echo $manufacturer; ?>">
  <?php } ?>
  
  <div itemscope="itemscope" itemtype="http://schema.org/Offer">
    <meta itemprop="name" content="<?php echo $heading_title; ?>">
    <meta itemprop="category" content="<?php echo $category; ?>">
    <meta itemprop="price" content="<?php echo $special ? $special : $price; ?>">
    <meta itemprop="priceCurrency" content="<?php echo $currency; ?>">
    <?php if ($product_info['quantity'] > 0) { ?><link itemprop="availability" href="http://schema.org/InStock">
<?php } ?>
  </div>

<?php if (!empty($reviews)) { ?>
  
  <?php $review_total = 0; foreach ($reviews as $review) { ?>
  <div itemprop="review" itemscope="itemscope" itemtype="http://schema.org/Review">
    <meta itemprop="name" content="<?php echo $heading_title; ?>">
    <meta itemprop="author" content="<?php echo $review['author']; ?>">
    <meta itemprop="datePublished" content="<?php echo date('Y-m-d', strtotime($review['date_added'])); ?>">
    <meta itemprop="description" content="<?php echo $review['text']; ?>">
    <div itemprop="reviewRating" itemscope="itemscope" itemtype="http://schema.org/Rating">
      <meta itemprop="ratingValue" content="<?php echo $review['rating']; ?>">
    </div>
  </div>
  <?php $review_total += $review['rating']; ?>
  <?php } ?>
  
  <div itemprop="aggregateRating" itemscope="itemscope" itemtype="http://schema.org/AggregateRating">
    <meta itemprop="ratingValue" content="<?php echo round($review_total / count($reviews), 1); ?>">
    <meta itemprop="reviewCount" content="<?php echo count($reviews); ?>">
  </div>
<?php } ?>
<?php } ?>
</div>
<?php } elseif ($type == 'opengraph') { ?>
<!-- Opengraph -->
<?php if (!empty($config['page_id'])) { ?>
<meta property="fb:app_id" content="<?php echo $config['page_id']; ?>"/>
<?php } ?>
<?php if ($page == 'home') { ?>
<meta property="og:type" content="website">
<?php if (!empty($config_name)) { ?>
<meta property="og:site_name" content="<?php echo $config_name; ?>"/>
<?php } ?>
<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:image" content="<?php echo $logo; ?>"/>
<meta property="og:description" content="<?php echo $desc; ?>"/>
<?php } else if ($page == 'info') { ?>
<meta property="og:type" content="article"/> 
<meta property="og:url" content="<?php echo $url; ?>"/> 
<meta property="og:title" content="<?php echo $heading_title; ?>"/>
<?php } else if ($page == 'product') { ?>
<meta property="og:type" content="product"/>
<meta property="og:title" content="<?php echo !empty($product_info['meta_title']) ? $product_info['meta_title'] : $heading_title; ?>"/>
<meta property="og:url" content="<?php echo $product_url; ?>"/>
<meta property="product:price:amount" content="<?php echo $special ? $special : $price; ?>"/>
<meta property="product:availability" content="<?php  echo ($product_info['quantity'] > 0) ? 'in stock' : 'out of stock'; ?>"/>
<meta property="product:price:currency" content="<?php echo $currency; ?>"/>
<meta property="og:image" content="<?php echo str_replace(' ', '%20', $thumb); ?>"/>
<?php if (!empty($config['desc'])) { ?><meta property="og:description" content="<?php echo strip_tags($product_info['meta_description']); ?>"/><?php } ?>
<?php } else if ($page == 'category' && !empty($title)) { ?>
<meta property="og:type" content="article"/>
<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:url" content="<?php echo $url; ?>"/>
<meta property="og:image" content="<?php echo $image; ?>"/>
<meta property="og:description" content="<?php echo $description; ?>"/>
<?php } ?>


<?php } elseif ($type == 'tcard') { ?>
<!-- Twittercard -->
<?php if ($page == 'home') { ?>
<meta name="twitter:card" content="<?php echo !empty($config['home_type']) ? $config['home_type'] : 'summary'; ?>"/>
<meta name="twitter:description" content="<?php echo $desc; ?>"/>
<meta name="twitter:title" content="<?php echo $title; ?>"/>
<meta name="twitter:domain" content="<?php echo $url; ?>"/>
<meta name="twitter:image" content="<?php echo $logo; ?>"/>
<?php } else if ($page == 'product') { ?>
<meta name="twitter:card" content="product"/>
<meta name="twitter:title" content="<?php echo $heading_title; ?>"/>
<meta name="twitter:domain" content="<?php echo $product_url; ?>"/>
<meta name="twitter:image" content="<?php echo $thumb; ?>"/>
<?php if (!empty($config['desc'])) { ?><meta name="twitter:description" content="<?php echo strip_tags($product_info['meta_description']); ?>"/><?php } ?>
<?php } ?>
<?php if (!empty($config['nick'])) { ?><meta name="twitter:creator" content="<?php echo $config['nick']; ?>"/>
<meta name="twitter:site" content="<?php echo $config['nick']; ?>"/><?php } ?>

<?php } elseif ($type == 'gpublisher' && $url) { ?>
<!-- Google Publisher -->
<link rel="publisher" href="<?php echo $url; ?>"/>

<?php } ?>

<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://greencraft.design/another-product
 * @since      1.0.0
 *
 * @package    Another_Product
 * @subpackage Another_Product/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<style type="text/css" media="screen">
    .cn_another_product {
          position: relative;
        border: 1px solid #e6e1e0;
        padding: 10px;
    }
    strong.another_product_title {
        font-size: 16px;
        font-weight: 800;
    }
    .similar_title{
        font-size: 15px;
        font-weight: 800; 
    }
    .star_suaranteed {
        margin: 8px 0px;
    }
    .cn_star {
        float: left;
        margin-right: 10px;
    }
    .cn_star i {
        color: orange;
        font-size: 20px;
    }
    .cn_guaranteed {
        color: #6B6565;
        font-weight: bold;
        font-size: 16px;
        line-height: 1;
    }
    span.cn_amount {
        color: #F3716D;
        font-weight: bold;
        font-size: 16px;
    }
    .cn_logo img {
        max-width: 90%!important;
        margin: 22px 0px 10px;
    }
    .cn_logo {
        text-align: center;
    }
    .save_percent {
        background: #f3716d;
        position: absolute;
        top: 0;
        left: 0;
        color: #fff;
        padding: 2px 10px;
        font-weight: bold;
    }
    .similar_consider{
      display: none;
    }
    @media only screen and (max-width: 600px) {
      .cn_star i {
        font-size: 14px;
        float: left;
    }
      .cn_col-3.cn_col-md-4 {
          padding: 5px !important;
      }
      .cn_guaranteed{
        font-size: 15px;
      }
      strong.another_product_title {
        font-size: 14px;
        font-weight: 800;
      }
      .similar_consider{
        display: block;
        margin-bottom: 10px;
      }

      .cn_logo_main{
        display: none;
      }
      .save_percent {
          float: right;
          right: 0;
          left: unset;
          z-index: 99;
      }
      .notice_text{
        line-height: 1.2;
        font-size: 12px;
      }
    }
    
</style>
<div class="cn_another_product">
  <?php
  //print_r($cn_product);

   $product_sale_price=$product->get_price();
  
  if ($product_sale_price) {
    $product_price=$product_sale_price;
  }else{
    $product_price=$product_regular_price;
  }
  

  $another_sale_price=$another_product->get_sale_price();
  $another_regular_price=$another_product->get_regular_price();

  if ($another_sale_price) {
    $another_price=$another_sale_price;
  }else{
    $another_price=$another_regular_price;
  }

  $prod_def = $product_price-$another_price;
  $percent=$prod_def*100/$product_price;

  ?>
  <div class="save_percent">SAVE <?php echo round($percent,2); ?> %</div>
  <div class="row">
    
    <div class="cn_col-md-12 similar_consider">
      <strong class="similar_title">Similar item to consider</strong>
    </div>
    <div class="cn_col-md-4 cn_logo_main">
      <div class="cn_logo">
        <img src="<?php echo $upload_logo; ?>">
        <p><?php echo $tagline_text; ?></p>
      </div>
    </div>
    <div class="cn_col-md-8">
      <div class="row">
        <div class="cn_col-3 cn_col-md-4">
          <a href="<?php echo get_the_permalink($another_product_id); ?>">
          <img class="another_product_img" src="<?php echo $another_product_img ?>" alt="">
        </a>
        </div>
        <div class="cn_col-9 cn_col-md-8">
          <div class="another_product_title_div">
            <strong class="another_product_title"><a href="<?php echo get_the_permalink($another_product_id); ?>"><?php echo $another_product_title; ?></a></strong>
          </div>
          <div class="star_suaranteed">
            <div class="cn_star">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i> 
            </div>
            <div class="cn_guaranteed">
              100% Guaranteed
            </div>
          </div>
          <div class="cn_another_product_price">
            <p class="price">
              <?php if ($another_sale_price): ?>
              <del style="margin-right: 10px;">
                <span class=""><bdi><span class=""><?php echo  $currency_symbol; ?></span><?php echo $another_product->get_regular_price(); ?></bdi></span>
              </del> 
              <?php endif ?>
              <ins>
                <span class="cn_amount"><bdi><span><?php echo  $currency_symbol; ?></span><?php echo $another_price; ?></bdi></span>
              </ins>
            </p>
            <p class="notice_text"><?php echo $notice_text; ?> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
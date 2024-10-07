<?php
/*
    Template Name: Order / Заявка
*/
get_header();
$var                  = variables();
$assets               = $var['assets'];
$region_id            = $_GET['region_id'] ?? '';
$category             = $_GET['category_id'] ?? '';
$product_id             = $_GET['product_id'] ?? '';
$term_region          = $region_id ? get_term_by( 'term_id', $region_id, 'regions' ) : '';
$id                   = get_the_ID();
$form_title           = carbon_get_post_meta( $id, 'order_form_title' );
$short_code           = carbon_get_post_meta( $id, 'order_form_short_code' );
$error                = carbon_get_post_meta( $id, 'order_form_error' );
$page_title           = get_the_title();
$title                = _l( 'Продати зернові та олійні', 1 );
$category_name_suffix = '';
$args                 = array(
	'post_type'      => 'products',
	'post_status'    => 'publish',
	'posts_per_page' => - 1,
);

?>

<main class="content">
    <section class="order-section section order-page-js">
        <div class="container">
            <div class="order-container">

                <div class="order-title">
                    <h1>
						<?php echo $page_title; ?>
                    </h1>
                </div>
                <div class="order-columns ">
                    <div class="order-column">
						<?php if ( $category ):
							$category_term = get_term_by( 'term_id', $category, 'categories' );
							$args['tax_query'] = array(
								array(
									'taxonomy' => 'categories',
									'field'    => 'term_id',
									'terms'    => array( $category ),
								)
							);
							$category_type = carbon_get_term_meta( $category, 'category_type' );
							if ( $category_type == 'reception' ) {
								$category_name_suffix = _l( 'Прием/покупка (суффикс категории)', 1 );
							} elseif ( $category_type == 'shipment' ) {
								$category_name_suffix = _l( 'Отгрузка/продажа (суффикс категории)', 1 );
							}
							?>
                            <div class="order-items-title">
								<?php echo $category_term->name . ' ' . $category_name_suffix; ?>
                            </div>
							<?php
							$query = new WP_Query( $args );
							if ( $query->have_posts() ) :
								?>
                                <ul class="order-items">
									<?php while ( $query->have_posts() ): $query->the_post();
										$_id = get_the_ID();
                                        $attr = $product_id == $_id ? 'checked' : '';
										?>
                                        <li class="order-item">
                                            <div class="checkbox-wrapper form-group ">
                                                <div class="checked-group ">
                                                    <div class="checked-item">
                                                        <label class="check-item">
                                                            <input class="check_st trigger-input product-item-input"
                                                                   data-trigger="#quantity<?php echo $category . $_id ?>"
                                                                   name="items[]"
                                                                   <?php echo $attr; ?>
                                                                   value="<?php echo get_the_title( $_id ) ?>"
                                                                   type="checkbox">
                                                            <span> </span>
                                                            <i class="check-item__text"><?php echo get_the_title( $_id ) ?></i>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group full " <?php echo  $product_id != $_id ? 'style="display: none"' : ''; ?>
                                                 id="quantity<?php echo $category . $_id ?>">
                                                <input class="input_st product-item-input-qnt" name="items_quantity[]"
                                                       type="text"
                                                       placeholder="<?php _l( 'Кількість' ) ?>">
                                            </div>
                                        </li>
									<?php endwhile; ?>
                                </ul>
							<?php endif;
							wp_reset_postdata();
							wp_reset_query();
							?>
						<?php else:
							$categories = get_terms( array(
								'taxonomy'   => 'categories',
								'hide_empty' => false,
							) );
							if ( $categories ):
								foreach ( $categories as $category_term ):
									$_args = $args;
									$_args['tax_query'] = array(
										array(
											'taxonomy' => 'categories',
											'field'    => 'term_id',
											'terms'    => array( $category_term->term_id ),
										)
									);
									$category_type = carbon_get_term_meta( $category_term->term_id, 'category_type' );
									if ( $category_type == 'reception' ) {
										$category_name_suffix = _l( 'Прием/покупка (суффикс категории)', 1 );
									} elseif ( $category_type == 'shipment' ) {
										$category_name_suffix = _l( 'Отгрузка/продажа (суффикс категории)', 1 );
									}
									?>
                                    <div class="order-items-title">
										<?php echo $category_term->name . ' ' . $category_name_suffix; ?>
                                    </div>
									<?php
									$query = new WP_Query( $_args );
									if ( $query->have_posts() ) :
										?>
                                        <ul class="order-items">
											<?php while ( $query->have_posts() ): $query->the_post();
												$_id = get_the_ID();
												$attr = $product_id == $_id ? 'checked' : '';
												?>
                                                <li class="order-item">
                                                    <div class="checkbox-wrapper form-group ">
                                                        <div class="checked-group ">
                                                            <div class="checked-item">
                                                                <label class="check-item">
                                                                    <input class="check_st trigger-input product-item-input"
                                                                           data-trigger="#quantity<?php echo $category . $_id ?>"
                                                                           name="items[]"
	                                                                    <?php echo $attr; ?>
                                                                           value="<?php echo get_the_title( $_id ) ?>"
                                                                           type="checkbox">
                                                                    <span> </span>
                                                                    <i class="check-item__text"><?php echo get_the_title( $_id ) ?></i>
                                                                </label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group full " <?php echo  $product_id != $_id ? 'style="display: none"' : ''; ?>
                                                         id="quantity<?php echo $category . $_id ?>">
                                                        <input class="input_st product-item-input-qnt"
                                                               name="items_quantity[]"
                                                               type="text"
                                                               placeholder="<?php _l( 'Кількість' ) ?>">
                                                    </div>
                                                </li>
											<?php endwhile; ?>
                                        </ul>
									<?php endif;
									wp_reset_postdata();
									wp_reset_query();
								endforeach;
							endif;
						endif;
						?>
                    </div>
                    <div class="order-column">
                        <div class="order-form__title">
							<?php echo $form_title ?>
                        </div>
                        <div class="order-form-container">
							<?php echo $short_code ? do_shortcode( $short_code ) : '' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    var msgError = '<?php echo $error; ?>';
</script>

<?php get_footer(); ?>

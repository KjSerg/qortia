<?php
$queried_object = get_queried_object();
$term_id        = $queried_object->term_id;
if ( $page = carbon_get_term_meta( $term_id, 'term_page' ) ) {
	$page_id = $page[0]['id'];
	if ( get_post( $page_id ) && get_post_status( $page_id ) == 'publish' ) {
		header( 'Location: ' . get_the_permalink( $page_id ) . '?term_id=' . $term_id );
		die();
	}
}
get_header();
$var              = variables();
$assets           = $var['assets'];
$categories_image = carbon_get_term_meta( $term_id, 'categories_image' );
$categories_image = $categories_image ? _u( $categories_image, 1 ) : $assets . 'img/head_partners.webp';
?>

    <main class="content">
        <section class="section-head section-head-fuel dark_section">
            <img src="<?php echo $categories_image ?>" alt=""/>
            <div class="decor-line">
                <div class="decor-line__item"></div>
                <div class="decor-line__item"></div>
                <div class="decor-line__item"></div>
            </div>
            <div class="container head_in">
                <div class="head-content">
                    <div class="head-content__title" data-aos="fade-up" data-aos-delay="200">
						<?php echo $queried_object->name ?>
                    </div>
                    <div class="head-content__text" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-group">
							<?php echo $queried_object->description ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="section-catalog pad_section">
            <div class="container">
                <div class="catalog-group js-tab">
                    <div class="catalog-content" data-aos="fade-up" data-aos-delay="400">
                        <div class="catalog-content__item js-tab-item active" data-target="target_1">
                            <div class="products">

								<?php if ( have_posts() ): while ( have_posts() ) : the_post();
									$_id = get_the_ID();
									if ( get_post( $_id ) ):
										$img = get_the_post_thumbnail_url( $_id ) ?: $assets . 'img/fi.jpg';
										?>

                                        <a class="product-item"
                                           href="<?php echo get_the_permalink( $_id ) ?>">
                                            <div class="product-item__media">
                                                <img src="<?php echo $img; ?>" alt=""/>
                                            </div>
                                            <div class="product-item__title">
												<?php echo get_the_title( $_id ) ?>
                                            </div>
                                        </a>

									<?php endif; endwhile; endif; ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

<?php get_footer(); ?>
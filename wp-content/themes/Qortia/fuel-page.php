<?php
/*
    Template Name: Products / Продукция
*/
get_header();
$var     = variables();
$assets  = $var['assets'];
$id      = get_the_ID();
$screens = carbon_get_post_meta( $id, 'screens_fuel' ); ?>

    <main class="content">
		<?php if ( ! empty( $screens ) ) :
			foreach ( $screens as $index => $screen ) :
				$index = $index + 1;
				if ( $screen['_type'] == 'screen_1' ) :
					if ( ! $screen['screen_off'] ) : ?>

                        <section class="section-head section-head-fuel dark_section">
                            <img src="<?php _u( $screen['bg_image'] ) ?>" alt=""/>
                            <div class="decor-line">
                                <div class="decor-line__item"></div>
                                <div class="decor-line__item"></div>
                                <div class="decor-line__item"></div>
                            </div>
                            <div class="container head_in">
                                <div class="head-content">
                                    <div class="head-content__title" data-aos="fade-up" data-aos-delay="200">
										<?php _t( $screen['title'] ) ?>
                                    </div>
                                    <div class="head-content__text" data-aos="fade-up" data-aos-delay="400">
                                        <div class="text-group">
											<?php _t( $screen['text'] ) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

					<?php
					endif;
                elseif ( $screen['_type'] == 'screen_2' ) :
					if ( ! $screen['screen_off'] ) : ?>


                        <section class="section-catalog pad_section">
                            <div class="container">
                                <div class="catalog-group js-tab">
                                    <div class="catalog-nav" data-aos="fade-up" data-aos-delay="200">
                                        <div class="catalog-nav__item js-tab-link active" data-target="target_1">
											<?php echo $screen['title'] ?>
                                        </div>
                                    </div>
                                    <div class="catalog-content" data-aos="fade-up" data-aos-delay="400">
                                        <div class="catalog-content__item js-tab-item active" data-target="target_1">
                                            <div class="products">

												<?php if ( $list = $screen['list'] ): foreach ( $list as $item ):
													$_id = $item['id'];
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

													<?php endif; endforeach; endif; ?>

												<?php
												if ( $promo_list = $screen['promo_list'] ):
													foreach ( $promo_list as $item ):
														$button_link = $item['button_link'];
														$pos = strpos( $button_link, '#' );
														$_cls = $pos === false ? '' : 'modal_open';
														?>
                                                        <div class="product-item product-order">
                                                            <div class="product-order__top">
                                                                <div class="product-order__title">
																	<?php echo $item['title'] ?>
                                                                </div>
                                                                <div class="product-order__text">
																	<?php echo $item['text'] ?>
                                                                </div>
                                                            </div>
                                                            <a class="btn_st <?php echo $_cls; ?>"
                                                               href="<?php echo $button_link ?>">
																<?php echo $item['button_text'] ?>
                                                            </a>
                                                        </div>
													<?php endforeach; endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

					<?php
					endif;
                elseif ( $screen['_type'] == 'screen_2_1' ) :
					if ( ! $screen['screen_off'] ) :
						if ( $tabs = $screen['tabs'] ) :
							?>

                            <section class="section-catalog pad_section">
                                <div class="container">
                                    <div class="catalog-group js-tab">
                                        <div class="catalog-nav" data-aos="fade-up" data-aos-delay="200">
											<?php foreach ( $tabs as $j => $tab ): ?>
                                                <div class="catalog-nav__item js-tab-link <?php echo $j == 0 ? 'active' : '' ?> "
                                                     data-target="target_<?php echo $index . $j; ?>">
													<?php echo $tab['title'] ?>
                                                </div>
											<?php endforeach; ?>
                                        </div>
                                        <div class="catalog-content" data-aos="fade-up" data-aos-delay="400">
											<?php foreach ( $tabs as $j => $tab ): ?>
                                                <div class="catalog-content__item js-tab-item <?php echo $j == 0 ? 'active' : '' ?>"
                                                     data-target="target_<?php echo $index . $j; ?>">
                                                    <div class="products">

														<?php if ( $list = $tab['list'] ): foreach ( $list as $item ):
															$_id = $item['id'];
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

															<?php endif; endforeach; endif; ?>

														<?php
														if ( $promo_list = $tab['promo_list'] ):
															foreach ( $promo_list as $item ):
																$button_link = $item['button_link'];
																$pos = strpos( $button_link, '#' );
																$_cls = $pos === false ? '' : 'modal_open';
																?>
                                                                <div class="product-item product-order">
                                                                    <div class="product-order__top">
                                                                        <div class="product-order__title">
																			<?php echo $item['title'] ?>
                                                                        </div>
                                                                        <div class="product-order__text">
																			<?php echo $item['text'] ?>
                                                                        </div>
                                                                    </div>
                                                                    <a class="btn_st <?php echo $_cls; ?>"
                                                                       href="<?php echo $button_link ?>">
																		<?php echo $item['button_text'] ?>
                                                                    </a>
                                                                </div>
															<?php endforeach; endif; ?>

                                                    </div>
                                                </div>
											<?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </section>

						<?php
						endif;
					endif;
                elseif ( $screen['_type'] == 'screen_3' ) :
					if ( ! $screen['screen_off'] ) : ?>

                        <section class="section-advantage-main pad_section b_top">
                            <div class="container">
                                <div class="advantage-main">
                                    <div class="advantage-main__left">
                                        <div class="title-section">
                                            <div class="title-section__main" data-aos="fade-up" data-aos-delay="200">
												<?php echo $screen['title']; ?>
                                            </div>
                                            <div class="title-section__subtitle" data-aos="fade-up"
                                                 data-aos-delay="400">
												<?php echo $screen['text']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="advantage-main__right">
                                        <div class="advantage-main__list">
											<?php
											$delay = 200;
											if ( $list = $screen['list'] ): foreach ( $list as $item ): ?>
                                                <div class="advantage-main__list-item" data-aos="fade-up"
                                                     data-aos-delay="<?php echo $delay; ?>">
                                                    <div class="advantage-main__list-item-ico">
                                                        <img src="<?php _u( $item['image'] ) ?>" alt=""/>
                                                    </div>
                                                    <div class="advantage-main__list-item-title">
														<?php echo $item['title'] ?>
                                                    </div>
                                                    <div class="advantage-main__list-item-text">
														<?php echo $item['text'] ?>
                                                    </div>
                                                </div>
												<?php $delay = $delay + 200; endforeach; endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

					<?php
					endif;
                elseif ( $screen['_type'] == 'screen_prices' ) :
					the_prices_section( $screen );
                elseif ( $screen['_type'] == 'screen_9' ) :
					the_map_section( $screen );
                elseif ( $screen['_type'] == 'screen_10' ) :
					the_contact_screen( $screen );

				endif;
			endforeach;
		endif; ?>

    </main>
<?php get_footer(); ?>
<?php
get_header();
$var                   = variables();
$assets                = $var['assets'];
$set                   = $var['setting_home'];
$id                    = get_the_ID();
$screens               = carbon_get_post_meta( $id, 'screens_product' );
$regionsActive         = get_terms( array(
	'taxonomy'   => 'regions',
	'hide_empty' => true,
) );
$category              = get_the_terms( $id, 'categories' );
$category_type         = $category ? carbon_get_term_meta( $category[0]->term_id, 'category_type' ) : false;
$points                = get_points_by_point_type( $category_type ?: false );
$list_currencies       = get_currencies_value();
$category_name_suffix  = '';
$_category_name_suffix = '';
if ( $category_type == 'reception' ) {
	$category_name_suffix = _l( 'Отгрузка/продажа (текст кнопки)', 1 );
} elseif ( $category_type == 'shipment' ) {
	$category_name_suffix = _l( 'Прием/покупка (текст кнопки)', 1 );
}
if ( $category_type == 'reception' ) {
	$_category_name_suffix = _l( 'Прием/покупка (суффикс категории)', 1 );
} elseif ( $category_type == 'shipment' ) {
	$_category_name_suffix = _l( 'Отгрузка/продажа (суффикс категории)', 1 );
}
?>


    <main class="content">
		<?php if ( ! empty( $screens ) ) :
			foreach ( $screens as $index => $screen ) :
				$index = $index + 1;
				if ( $screen['_type'] == 'screen_1' ) :
					if ( ! $screen['screen_off'] ) : ?>

                        <section class="section-head  dark_section">
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
                elseif ( $screen['_type'] == 'screen_prices' ) :
					?>

                    <section class="section-price pad_section b_top">
                        <div class="container">
                            <div class="title-section text-center">
                                <div class="title-section__main" data-aos="fade-up" data-aos-delay="200">
									<?php echo $screen['title']; ?>
                                </div>
                            </div>
                            <div class="price-wrap" data-aos="fade-up" data-aos-delay="400">
                                <div class="price-wrap__top">
                                    <div class="price-wrap__title">
										<?php echo $screen['text']; ?>
                                    </div>
									<?php if ( $regionsActive ): ?>
                                        <div class="price-city">
                                            <select class="select_st price-region-select">
                                                <option selected value=""><?php _l( 'Оберіть регіон' ) ?></option>
												<?php foreach ( $regionsActive as $region ): ?>
                                                    <option value="<?php echo $region->slug ?>">
														<?php echo $region->name ?>
                                                    </option>
												<?php endforeach; ?>
                                            </select>
                                        </div>
									<?php endif; ?>
                                </div>

                                <div class="price-wrap__table">
                                    <div class="table sortable-table single-product-table">
                                        <div class="table-row table-row--head">
                                            <div class="table-column">
												<?php _l( 'Назва пункту' ) ?>
                                                <div class="table-column__icon">
                                                    <img src="<?php echo $assets; ?>img/arrow-down.svg" alt=""/>
                                                </div>

                                            </div>
                                            <div class="table-column">
												<?php _l( 'Адреса' ) ?>
                                                <div class="table-column__icon">
                                                    <img src="<?php echo $assets; ?>img/arrow-down.svg" alt=""/>
                                                </div>
                                            </div>
                                            <div class="table-column" data-code="USD">
												<?php _l( 'Ціна в доларах' ) ?>
                                                <div class="table-column__icon">
                                                    <img src="<?php echo $assets; ?>img/arrow-down.svg" alt=""/>
                                                </div>
                                            </div>
                                            <div class="table-column" data-code="UAH">
												<?php _l( 'Гривні' ) ?>
                                                <div class="table-column__icon">
                                                    <img src="<?php echo $assets; ?>img/arrow-down.svg" alt=""/>
                                                </div>
                                            </div>
											<?php if ( $list_currencies ) {
												foreach ( $list_currencies as $code => $currency ) {
													if ( $code !== 'UAH' && $code !== 'USD' ) {
														$currency = $code == 'UAHVAT' ? _l( 'Гривні, з ПДВ', 1 ) : $currency;
														?>
                                                        <div class="table-column" data-code="<?php echo $code; ?>">
															<?php echo $currency; ?>
                                                            <div class="table-column__icon">
                                                                <img src="<?php echo $assets; ?>img/arrow-down.svg"
                                                                     alt=""/>
                                                            </div>
                                                        </div>
														<?php
													}
												}
											} ?>
                                            <div class="table-column not-active"></div>
                                        </div>
										<?php if ( $points ): foreach ( $points as $point_id ):
											$_regions = get_the_terms( $point_id, 'regions' );
											$region_id = $_regions ? $_regions[0]->term_id : 0;
											$region_slug = $_regions ? $_regions[0]->slug : 0;
											$sub_test = false;
											?>
                                            <div class="table-row" data-region='<?php echo $region_slug; ?>'>
                                                <div class="table-column">
													<?php echo get_the_title( $point_id ) ?>
                                                </div>
                                                <div class="table-column">
													<?php echo carbon_get_post_meta( $point_id, 'point_address' ) ?>
                                                </div>
												<?php
												the_single_product_prices( array(
													'point_id'      => $point_id,
													'category_type' => $category_type,
													'id'            => $id,
													'region_id'     => $region_id,
													'qnt'           => 1,
												) );
												?>
                                                <div class="table-column ">
                                                    <a class="btn_long modal_open calculate-modal-btn"
                                                       data-region-id="<?php echo $region_id ?>"
                                                       data-point-id="<?php echo $point_id ?>"
                                                       href="#calculate-single">
                                                        <span><?php echo $category_name_suffix ?: _l( 'Розрахувати точну вартість', 1 ); ?></span>
                                                    </a>
                                                </div>
                                            </div>
										<?php endforeach; endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

				<?php
                elseif ( $screen['_type'] == 'screen_9' ) :
					the_map_section( $screen );
				endif;
			endforeach;
		endif; ?>

		<?php the_main_contact_section(); ?>

    </main>

<?php
$term_id    = $_GET['term_id'] ?? '';
$page_id    = get_the_ID();
$categories = get_terms( array(
	'taxonomy'   => 'categories',
	'hide_empty' => false,
) );

?>
    <div class="modal modal-calculate" id="calculate-single">
        <div class="modal-content">
            <div class="modal-title">
                <div class="modal-title__main">
					<?php _l( 'Увійдіть в особистий кабінет або залиште заявку' ) ?>
                </div>
            </div>
            <div class="step-form">
                <div class="step-form__item active">
                    <div class="step-form__top">
                        <div class="step-form__top-item active">01</div>
                        <div class="step-form__top-item">02</div>
                    </div>
                    <div class="step-form__content">
                        <form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" novalidate
                              id="calculate-single-form" class="form-js calculate-form js-tab"
                              enctype="multipart/form-data">
                            <input type="hidden" name="action" value="new_calculation">
                            <input type="hidden" name="selected_region" value="" class="selected-region">
                            <input type="hidden" name="selected_point" value="" class="selected-point">
                            <div class="form-horizontal ">
								<?php
								if ( $category ):
									$category = $category[0];

									$args              = array(
										'post_type'      => 'products',
										'post_status'    => 'publish',
										'posts_per_page' => - 1,
									);
									$args['tax_query'] = array(
										array(
											'taxonomy' => 'categories',
											'field'    => 'term_id',
											'terms'    => array( $category->term_id ),
										)
									);
									?>
                                    <input type="hidden" name="category[]"
                                           value="<?php echo $category->slug ?>">
                                    <div class="form-group half">
                                        <div class="form-label"><?php echo $category->name . ' ' . $_category_name_suffix; ?></div>
										<?php $query = new WP_Query( $args );
										if ( $query->have_posts() ) :
											?>
                                            <select class="select_st "
                                                    id="<?php echo $category->slug ?>"
                                                    required="required"
                                                    name="product[]">
                                                <option disabled="" <?php echo get_post_type( $page_id ) != 'products' ? 'selected' : ''; ?> >
													<?php _l( 'Оберіть' ) ?>
                                                </option>
												<?php while ( $query->have_posts() ): $query->the_post();
													$_id  = get_the_ID();
													$attr = $page_id == $_id ? 'selected' : '';
													?>
                                                    <option value="<?php echo $_id; ?>" <?php echo $attr; ?>>
														<?php echo get_the_title( $_id ) ?>
                                                    </option>
												<?php endwhile; ?>
                                            </select>
										<?php endif;
										wp_reset_postdata();
										wp_reset_query();
										?>
                                    </div>
								<?php endif; ?>
                                <div class="form-group half">
                                    <div class="form-label">Кількість</div>
                                    <input class="input_st " type="text"
                                           name="qnt[]"
                                           required="required"
                                           placeholder="<?php _l( 'Кількість в тонах' ) ?>">
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="form-group half">
                                    <input class="input_st " type="text" name="name"
                                           placeholder="<?php _l( 'Введіть ваше імʼя' ) ?>" required="required">
                                </div>
                                <div class="form-group half">
                                    <input class="input_st " type="text"
                                           name="organization" placeholder="<?php _l( 'Назва підприємства' ) ?>">
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="form-group half">
                                    <input class="input_st " type="tel" name="tel"
                                           data-placeholder="+38(999)999-99-99"
                                           placeholder="<?php _l( 'Ваш номер телефону' ) ?>" required="required">
                                </div>
                                <div class="form-group half">
                                    <input class="input_st " type="email" name="email"
                                           placeholder="<?php _l( 'Ваш E-mail' ) ?>"
                                           data-reg="[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])">
                                </div>
                            </div>

                            <div class="form-horizontal">
                                <div class="form-group half">
                                    <div class="checkbox-wrapper form-group ">
                                        <div class="checked-group ">
                                            <div class="checked-item">
                                                <label class="check-item">
                                                    <input class="check_st " name="consent" data-required=""
                                                           value="yes"
                                                           type="checkbox" checked="">
                                                    <span> </span>
                                                    <i class="check-item__text">
														<?php _l( 'Натискаючи на кнопку “надіслати”, ви погоджуєтесь з Політикою Конфіденційності' ) ?>

                                                    </i>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group half">
                                    <button class="btn_st " type="submit">
                                        <span><?php echo $category_name_suffix ?: _l( 'Розрахувати точну вартість', 1 ); ?></span>
                                    </button>
                                    <a class="btn_st next-step" style="display:none;" href="#">
										<?php echo $category_name_suffix ?: _l( 'Розрахувати точну вартість', 1 ); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="step-form__item">
                    <div class="step-form__top">
                        <div class="step-form__top-item active">01</div>
                        <div class="step-form__top-item active"> 02</div>
                    </div>
                    <div class="step-form__info">

                    </div>
                    <div class="form-bot__step">
                        <a class="back-step" href="#"><?php _l( 'Назад' ) ?></a>
                        <form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" novalidate
                              id="set-calculate-status-form-main" class="form-js set-calculate-status-form"
                              enctype="multipart/form-data">
                            <input type="hidden" name="action" value="set_status_calculation">
                            <input type="hidden" name="id" class="calculation-id" value="">
                            <button class="btn_st " type="submit">
                                <span></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer(); ?>
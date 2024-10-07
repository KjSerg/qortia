<?php
/*
    Template Name: Partners / Партнерам
*/ ?>
<?php get_header();
global $post; ?>
<?php $id = get_the_ID(); ?>
<?php $screens = carbon_get_post_meta( $id, 'screens_partners' ); ?>
<?php $screens_home = carbon_get_post_meta( get_option( 'page_on_front' ), 'screens_front' ); ?>

    <main class="content">
		<?php if ( ! empty( $screens ) ) :
			foreach ( $screens as $index => $screen ) :
				$index = $index + 1;
				if ( $screen['_type'] == 'screen_1' ) :
					if ( ! $screen['screen_off'] ) : ?>
                        <section class="section-head dark_section">
                            <img src="<?php echo wp_get_attachment_url( $screen['bg_image'] ); ?>" alt=""/>
                            <div class="decor-line">
                                <div class="decor-line__item"></div>
                                <div class="decor-line__item"></div>
                                <div class="decor-line__item"></div>
                            </div>
                            <div class="container head_in">
                                <div class="head-content">
                                    <div class="head-content__title" data-aos="fade-up"
                                         data-aos-delay="200"><?php echo $screen['title']; ?></div>
									<?php if ( $text = $screen['text'] ) : ?>
                                        <div class="head-content__text" data-aos="fade-up" data-aos-delay="400">
                                            <div class="text-group">
												<?php echo wpautop( $text ); ?>
                                            </div>
                                        </div>
									<?php
									endif; ?>
                                </div>
                            </div>
                        </section>

					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_2' ) :
					if ( ! $screen['screen_off'] ) : ?>

                        <section class="section-advantage-main pad_section">
                            <div class="container">
                                <div class="advantage-main">
                                    <div class="advantage-main__left">
                                        <div class="title-section">
                                            <div class="title-section__main" data-aos="fade-up"
                                                 data-aos-delay="200"><?php echo $screen['title']; ?></div>
											<?php if ( $text = $screen['sub_title'] ) : ?>
                                                <div class="title-section__subtitle" data-aos="fade-up"
                                                     data-aos-delay="400"><?php echo $text; ?></div>
											<?php endif; ?>
                                        </div>
                                    </div>
									<?php if ( $advantages_list = $screen['advantages_list'] ) : $d = 200; ?>
                                        <div class="advantage-main__right">
                                            <div class="advantage-main__list">
												<?php foreach ( $advantages_list as $item ) : ?>
                                                    <div class="advantage-main__list-item" data-aos="fade-up"
                                                         data-aos-delay="<?php echo $d; ?>">
														<?php if ( $advantages_ico = $item['advantages_ico'] ) : ?>
                                                            <div class="advantage-main__list-item-ico">
                                                                <img src="<?php echo wp_get_attachment_url( $advantages_ico ); ?>"
                                                                     alt=""/>
                                                            </div>
														<?php
														endif; ?>

                                                        <div class="advantage-main__list-item-title"><?php echo $item['advantages_title']; ?> </div>
                                                        <div class="advantage-main__list-item-text"><?php echo $item['advantages_text']; ?></div>
                                                    </div>
													<?php $d = $d + 200;
												endforeach; ?>
                                            </div>
                                        </div>
									<?php endif; ?>
                                </div>
                            </div>
                        </section>
					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_3' ) :
					if ( ! $screen['screen_off'] ) : ?>

                        <section class="section-cooperate pad_section b_top">
                            <div class="container">
                                <div class="title-section">
                                    <div class="title-section__main" data-aos="fade-up"
                                         data-aos-delay="200"><?php echo $screen['title']; ?></div>
                                </div>
								<?php if ( $list = $screen['list'] ) : $d = 1;
									$j = 200; ?>
                                    <div class="cooperate">
										<?php foreach ( $list as $item ) : ?>
                                            <div class="cooperate-item active" data-aos="fade-up"
                                                 data-aos-delay="<?php echo $j; ?>">
                                                <div class="cooperate-item__count"><span><?php echo $d; ?></span></div>
                                                <div class="cooperate-item__title"><?php echo $item['list_title']; ?> </div>
                                                <div class="cooperate-item__text"><?php echo $item['list_text']; ?></div>
                                            </div>
											<?php $d = $d + 1;
											$j       = $j + 200;
										endforeach; ?>
                                    </div>
								<?php endif; ?>
                            </div>
                        </section>
					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_4' ) :
					if ( ! $screen['screen_off'] ) : ?>
                        <section class="section-partners pad_section">
                            <div class="container">
                                <div class="title-section">
                                    <div class="title-section__main" data-aos="fade-up"
                                         data-aos-delay="200"><?php echo $screen['title']; ?></div>
									<?php if ( $text = $screen['sub_title'] ) : ?>
                                        <div class="title-section__subtitle" data-aos="fade-up"
                                             data-aos-delay="400"><?php echo $text; ?></div>
									<?php endif; ?>
                                </div>
								<?php if ( $slides = $screen['logos'] ) : ?>
                                    <div class="partners-slider" data-aos="fade-up" data-aos-delay="600">
										<?php foreach ( $slides as $slide ) : ?>
                                            <div>
                                                <div class="partners-item"><img
                                                            src="<?php echo wp_get_attachment_url( $slide ); ?>"
                                                            alt=""/></div>
                                            </div>
										<?php endforeach; ?>
                                    </div>

                                    <div class="rev-slider" dir="rtl" data-aos="fade-up" data-aos-delay="800">
                                        <div class="partners-slider_rev">
											<?php foreach ( $slides as $slide ) : ?>
                                                <div>
                                                    <div class="partners-item"><img
                                                                src="<?php echo wp_get_attachment_url( $slide ); ?>"
                                                                alt=""/></div>
                                                </div>
											<?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="partners-slider" data-aos="fade-up" data-aos-delay="1000">
										<?php foreach ( $slides as $slide ) : ?>
                                            <div>
                                                <div class="partners-item"><img
                                                            src="<?php echo wp_get_attachment_url( $slide ); ?>"
                                                            alt=""/></div>
                                            </div>
										<?php endforeach; ?>
                                    </div>
								<?php
								endif; ?>
                            </div>
                        </section>


					<?php
					endif;
				endif;
			endforeach;
		endif; ?>

		<?php if ( ! empty( $screens_home ) ) :
			foreach ( $screens_home as $index => $screen ) :
				$index = $index + 1;
				if ( $screen['_type'] == 'screen_10' ) :
					if ( ! $screen['screen_off'] ) : ?>
                        <section class="section-form pad_section b_top">
                            <div class="container">
                                <div class="form-contact">
                                    <div class="form-contact__left">
                                        <div class="title-section">
                                            <div class="title-section__main" data-aos="fade-up"
                                                 data-aos-delay="200"><?php echo $screen['title']; ?></div>
											<?php if ( $text = $screen['text'] ) : ?>
                                                <div class="title-section__subtitle" data-aos="fade-up"
                                                     data-aos-delay="400"><?php echo $text; ?></div>
											<?php endif; ?>
                                        </div>
										<?php if ( $contacts_ = $screen['contacts'] ) : ?>
                                            <div class="contact-list" data-aos="fade-up" data-aos-delay="600">
												<?php foreach ( $contacts_ as $item ) : ?>
                                                    <div class="contact-list__item">
                                                        <div class="contact-list__item-name"><?php echo $item['contacts_title']; ?></div>
                                                        <div class="contact-list__item-main"><?php echo $item['contacts_main']; ?></div>
                                                    </div>
												<?php
												endforeach; ?>
                                            </div>
										<?php endif; ?>

                                    </div>
									<?php if ( $shortcode_form = $screen['shortcode_form'] ) : ?>
                                        <div class="form-contact__right" data-aos="fade-up" data-aos-delay="400">

											<?php echo do_shortcode( $shortcode_form ); ?>

                                        </div>
									<?php endif; ?>
                                </div>
                            </div>
                        </section>
					<?php
					endif;
				endif;
			endforeach;
		endif; ?>

    </main>
<?php get_footer(); ?>
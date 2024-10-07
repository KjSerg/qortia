<?php
/*
    Template Name: Home / Главная 
*/ ?>
<?php get_header();
global $post; ?>
<?php $id = get_the_ID(); ?>
<?php $screens = carbon_get_post_meta( $id, 'screens_front' ); ?>

    <main class="content">
		<?php if ( ! empty( $screens ) ) :
			foreach ( $screens as $index => $screen ) :
				$index = $index + 1;
				if ( $screen['_type'] == 'screen_1' ) :
					if ( ! $screen['screen_off'] ) : ?>

                        <section class="section-head dark_section">
                            <div class="videoBox">
                                <video autoplay="" loop="" muted="" playsinline="">
                                    <source src="<?php echo wp_get_attachment_url( $screen['video'] ); ?>"
                                            type="video/mp4"/>
                                </video>
                            </div>
                            <div class="decor-line">
                                <div class="decor-line__item"></div>
                                <div class="decor-line__item"></div>
                                <div class="decor-line__item"></div>
                            </div>
                            <div class="container">
                                <div class="head-content">
                                    <div class="head-content__title" data-aos="fade-up"
                                         data-aos-delay="200"><?php echo $screen['title']; ?></div>
									<?php $title_btn = $screen['title_btn'];
									$link_btn        = $screen['link_btn'];
									?>
									<?php if ( $title_btn && $link_btn ) : ?>
                                        <div class="btn-wrap" data-aos="fade-up" data-aos-delay="400">
                                            <a class="btn_st modal_open"
                                               href="<?php echo $link_btn; ?>"><?php echo $title_btn; ?></a>
                                        </div>
									<?php endif; ?>
                                </div>

                                <div class="scroll-link" style="opacity: 0">
                                    <div class="scroll-link__text">
                                        <div class="scroll-link__text-item"><?php _l( 'Детальніше' ); ?></div>
                                        <div class="scroll-link__text-item"></div>
                                    </div>
                                    <div class="scroll-link__btn"><img
                                                src="<?php echo get_template_directory_uri() ?>/assets/img/chewron-down.svg"
                                                alt=""/></div>
                                </div>
                            </div>
                        </section>


					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_2' ) :
					if ( ! $screen['screen_off'] ) : ?>
                        <section class="section-video pad_section">
                            <div class="container">
								<?php if ( $video_list = $screen['video_list'] ) : $d = 0; ?>
                                    <div class="video-list">
										<?php foreach ( $video_list as $item ) :
											$l = $item['link'];
                                            ?>
                                            <div class="video-list__item">
                                                <div class="video-list__item-main <?php echo $l ? 'cursor-pointer' : ''; ?>" data-aos="fade-up"
                                                     data-aos-delay="<?php echo $d; ?>">
                                                    <div class="video-list__item-video">
                                                        <video autoplay="" loop="" muted="" playsinline="">
                                                            <source src="<?php echo wp_get_attachment_url( $item['video_list_main'] ); ?>"
                                                                    type="video/mp4"/>
                                                        </video>
                                                    </div>
													<?php if ( $l ): ?>
                                                        <a href="<?php echo $l; ?>"
                                                           class="video-list__item__title"><?php echo $item['video_list_title']; ?></a>
													<?php else: ?>
                                                        <div class="video-list__item__title">
															<?php echo $item['video_list_title']; ?>
                                                        </div>
													<?php endif; ?>
                                                </div>
                                            </div>
											<?php $d = $d + 200;
										endforeach; ?>
                                    </div>

								<?php endif; ?>

                            </div>
                        </section>

					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_3' ) :
					if ( ! $screen['screen_off'] ) : ?>


                        <section class="section-advantages pad_section">
                            <img class="decor_name"
                                 src="<?php echo get_template_directory_uri() ?>/assets/img/decor-name.svg" alt=""/>
                            <div class="container">
								<?php if ( $title = $screen['title'] ) : ?>
                                    <div class="title-section text-center" data-aos="fade-up" data-aos-delay="200">
                                        <div class="title-section__main"><?php echo $title; ?></div>
                                    </div>
								<?php endif; ?>
								<?php if ( $advantages_list = $screen['advantages_list'] ) : $d = 200; ?>
                                    <div class="advantages">
										<?php foreach ( $advantages_list as $item ) : ?>

                                            <div class="advantages-item" data-aos="fade-up"
                                                 data-aos-delay="<?php echo $d; ?>">
                                                <div class="advantages-item__media"
                                                     style="background:<?php echo $item['advantages_color']; ?>">

													<?php echo the_image( $item['advantages_ico'] ); ?>

                                                </div>
                                                <div class="advantages-item__title"><?php echo $item['advantages_title']; ?> </div>
                                            </div>

											<?php $d = $d + 200;
										endforeach; ?>
                                    </div>
								<?php endif; ?>

                            </div>
                        </section>


					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_4' ) :
					if ( ! $screen['screen_off'] ) : ?>
                        <section class="section-stats dark_section pad_section">
                            <img class="decor_name"
                                 src="<?php echo get_template_directory_uri() ?>/assets/img/decor-name.svg" alt=""/>
                            <div class="container">
                                <div class="stats-group">
                                    <div class="stats-group__left">
                                        <div class="title-section">
                                            <div class="title-section__main" data-aos="fade-up"
                                                 data-aos-delay="200"><?php echo $screen['title']; ?></div>
											<?php if ( $sub_title = $screen['sub_title'] ) : ?>
                                                <div class="title-section__subtitle" data-aos="fade-up"
                                                     data-aos-delay="400"><?php echo $sub_title; ?></div>
											<?php endif; ?>
                                        </div>
                                    </div>
									<?php if ( $achievements_list = $screen['achievements_list'] ) : $d = 200; ?>
                                        <div class="stats-group__right">
                                            <div class="stats">
												<?php foreach ( $achievements_list as $item ) : ?>
                                                    <div class="stats-item" data-aos="fade-up"
                                                         data-aos-delay="<?php echo $d; ?>">
                                                        <div class="stats-item__ico">
															<?php echo the_image( $item['achievements_list_ico'] ); ?>
                                                        </div>
                                                        <div class="stats-item__title"><?php echo $item['achievements_list_title']; ?></div>
                                                        <div class="stats-item__subtitle"><?php echo $item['achievements_list_text']; ?></div>
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

                elseif ( $screen['_type'] == 'screen_5' ) :
					if ( ! $screen['screen_off'] ) : ?>
                        <section class="section-about">
                            <div class="container">
                                <div class="about-group">
									<?php if ( $about_list = $screen['about_list'] ) : $d = 200; ?>
                                        <div class="about-group__left">
                                            <div class="about-media">
												<?php foreach ( $about_list as $item ) : ?>
                                                    <div class="about-media__item" data-aos="fade-up"
                                                         data-aos-delay="<?php echo $d; ?>">
                                                        <img src="<?php echo wp_get_attachment_url( $item['about_list_image'] ); ?>"
                                                             alt=""/>
                                                    </div>

													<?php $d = $d + 200;
												endforeach; ?>
                                            </div>
                                        </div>
									<?php endif; ?>

                                    <div class="about-group__right">
                                        <div class="title-section" data-aos="fade-up" data-aos-delay="200">
                                            <div class="title-section__main"><?php echo $screen['title']; ?></div>
                                        </div>

                                        <div class="text-group" data-aos="fade-up" data-aos-delay="400">
											<?php echo wpautop( $screen['text'] ); ?>
                                        </div>


										<?php $title_btn = $screen['title_btn'];
										$link_btn        = $screen['link_btn'];
										?>
										<?php if ( $title_btn && $link_btn ) : ?>
                                            <div class="btn-wrap" data-aos="fade-up" data-aos-delay="600">
                                                <a class="btn_st modal_open"
                                                   href="<?php echo $link_btn; ?>"><?php echo $title_btn; ?></a>
                                            </div>
										<?php endif; ?>

                                    </div>

                                </div>
                            </div>
                        </section>
					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_6' ) :
					if ( ! $screen['screen_off'] ) : ?>

                        <section class="section-history pad_section b_top">
                            <div class="container">
                                <div class="history-group">
                                    <div class="history-group__left">
                                        <div class="title-section">
                                            <div class="title-section__main"><?php echo $screen['title']; ?></div>
                                        </div>
                                        <div class="history-year"></div>
                                    </div>
									<?php if ( $history_list = $screen['history_list'] ) : ?>
                                        <div class="history-group__right">
                                            <div class="history-list">
												<?php foreach ( $history_list as $item ) : ?>
                                                    <div class="history-list__item"
                                                         data-year="<?php echo $item['history_list_title']; ?>">
                                                        <div class="text-group">
                                                            <h3><?php echo $item['history_list_title']; ?></h3>
															<?php echo wpautop( $item['history_list_text'] ); ?>
                                                        </div>
                                                    </div>
												<?php
												endforeach; ?>
                                            </div>


                                        </div>
									<?php endif; ?>
                                </div>
                            </div>
                        </section>

					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_7' ) :
					if ( ! $screen['screen_off'] ) : ?>
                        <section class="section-approach dark_section pad_section">
                            <div class="container">
                                <div class="approach-group">
									<?php if ( $contacts = $screen['contacts'] ) : $d = 200; ?>
                                        <div class="approach-group__left">
                                            <div class="approach-social">
												<?php foreach ( $contacts as $item ) : ?>
                                                    <a class="approach-social__item"
                                                       href="<?php echo $item['contacts_link']; ?>" data-aos="fade-up"
                                                       data-aos-delay="<?php echo $d; ?>">
                                                        <div class="approach-social__item-main">
                                                            <div class="approach-social__item-ico"
                                                                 style="background:<?php echo $item['contacts_color']; ?>">
																<?php echo the_image( $item['contacts_icon'] ); ?>
                                                            </div>
                                                            <div class="approach-social__item-title"><?php echo $item['contacts_title']; ?></div>
                                                        </div>
                                                    </a>
													<?php $d = $d + 200;
												endforeach; ?>
                                            </div>
                                        </div>
									<?php endif; ?>
                                    <div class="approach-group__right">
                                        <div class="title-section" data-aos="fade-up" data-aos-delay="200">
                                            <div class="title-section__main"><?php echo $screen['title']; ?></div>
                                        </div>
                                        <div class="text-group" data-aos="fade-up" data-aos-delay="600">
											<?php echo wpautop( $screen['text'] ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_8' ) :
					if ( ! $screen['screen_off'] ) : ?>

                        <section class="section-join pad_section">
                            <div class="container">
                                <div class="join-group">
                                    <div class="join-group__left">
                                        <div class="title-section">
                                            <div class="title-section__main" data-aos="fade-up"
                                                 data-aos-delay="200"><?php echo $screen['title']; ?></div>
											<?php if ( $subtitle = $screen['subtitle'] ) : ?>
                                                <div class="title-section__subtitle" data-aos="fade-up"
                                                     data-aos-delay="400"><?php echo $subtitle; ?></div>
											<?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="join-group__right">
										<?php if ( $text_form = $screen['text_form'] ) : ?>
                                            <div class="text-group" data-aos="fade-up" data-aos-delay="200">
												<?php echo wpautop( $text_form ); ?>
                                            </div>
										<?php endif; ?>
                                        <div class="join-form" data-aos="fade-up" data-aos-delay="400">

											<?php if ( $shortcode_form = $screen['shortcode_form'] ) : ?>
												<?php echo do_shortcode( $shortcode_form ); ?>
											<?php endif; ?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>

					<?php
					endif;

                elseif ( $screen['_type'] == 'screen_9' ) :
					the_map_section( $screen );
                elseif ( $screen['_type'] == 'screen_10' ) :
					the_contact_screen( $screen );
				endif;
			endforeach;
		endif; ?>

    </main>
<?php get_footer(); ?>
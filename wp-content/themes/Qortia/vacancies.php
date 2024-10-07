<?php
/*
    Template Name: Career / Карьера
*/ ?>
<?php get_header();
global $post; ?>
<?php $id = get_the_ID(); ?>
<?php $screens = carbon_get_post_meta($id, 'screens_career'); ?>
<?php $screens_home = carbon_get_post_meta(get_option('page_on_front'), 'screens_front'); ?>
<main class="content">
    <?php if (!empty($screens)) :
        foreach ($screens as $index => $screen) :
            $index = $index + 1;
            if ($screen['_type'] == 'screen_1') :
                if (!$screen['screen_off']) : ?>
                    <section class="section-head dark_section">
                        <img src="<?php echo wp_get_attachment_url($screen['bg_image']); ?>" alt="" />
                        <div class="decor-line">
                            <div class="decor-line__item"> </div>
                            <div class="decor-line__item"> </div>
                            <div class="decor-line__item"> </div>
                        </div>
                        <div class="container head_in">
                            <div class="head-content">
                                <div class="head-content__title" data-aos="fade-up" data-aos-delay="200"><?php echo $screen['title']; ?></div>
                                <?php if ($text = $screen['text']) : ?>
                                    <div class="head-content__text" data-aos="fade-up" data-aos-delay="400">
                                        <div class="text-group">
                                            <?php echo wpautop($text); ?>
                                        </div>
                                    </div>
                                <?php
                                endif; ?>
                            </div>
                        </div>
                    </section>

                <?php
                endif;

            elseif ($screen['_type'] == 'screen_2') :
                if (!$screen['screen_off']) : ?>
                    <section class="section-vacancies pad_section">
                        <div class="container">
                            <div class="title-section" data-aos="fade-up" data-aos-delay="200">
                                <div class="title-section__main"><?php echo $screen['title']; ?></div>
                            </div>

                            <div class="vacancies">
                                <div class="vacancies-group js-collapse" data-aos="fade-up" data-aos-delay="400">
                                    <?php if ($list_left = $screen['vacancies_list_left']) : ?>
                                        <div class="vacancies-group__column">

                                            <?php foreach ($list_left as $item) : ?>
                                                <?php $id_ = $item['id'] ?>
                                                <?php
                                                $price = carbon_get_post_meta($id_, 'price');
                                                $place = carbon_get_post_meta($id_, 'place');
                                                $list_description = carbon_get_post_meta($id_, 'list_description');

                                                ?>

                                                <div class="vacancies-item js-collapse-item">
                                                    <div class="vacancies-item__top">
                                                        <div class="vacancies-item__top-info">
                                                            <div class="vacancies-item__position"><?php echo get_the_title($id_); ?></div>
                                                            <div class="vacancies-item__salary"><?php echo $price; ?></div>
                                                            <div class="vacancies-item__place"><?php echo $place; ?></div>
                                                        </div>
                                                        <div class="vacancies-item__top-btn">
                                                            <a class="modal_open" href="#vacancies" data-title="<?php echo get_the_title($id_); ?>"><?php _l('Відгукнутись'); ?> </a>
                                                            <a class="more-info js-collapse-title" href="#"><?php _l('Детальніше'); ?> </a>
                                                        </div>
                                                    </div>

                                                    <div class="vacancies-item__content js-collapse-content">
                                                        <?php if ($list_description) : ?>
                                                            <ul>
                                                                <?php foreach ($list_description as $item) : ?>
                                                                    <li> <span><?php echo $item['list_description_name']; ?></span><strong><?php echo $item['list_description_value']; ?></strong></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php
                                                        endif; ?>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>


                                        </div>
                                    <?php
                                    endif; ?>

                                    <?php if ($list_right = $screen['vacancies_list_right']) : ?>
                                        <div class="vacancies-group__column">

                                            <?php foreach ($list_right as $item) : ?>
                                                <?php $id_ = $item['id'] ?>
                                                <?php
                                                $price = carbon_get_post_meta($id_, 'price');
                                                $place = carbon_get_post_meta($id_, 'place');
                                                $list_description = carbon_get_post_meta($id_, 'list_description');

                                                ?>

                                                <div class="vacancies-item js-collapse-item">
                                                    <div class="vacancies-item__top">
                                                        <div class="vacancies-item__top-info">
                                                            <div class="vacancies-item__position"><?php echo get_the_title($id_); ?></div>
                                                            <div class="vacancies-item__salary"><?php echo $price; ?></div>
                                                            <div class="vacancies-item__place"><?php echo $place; ?></div>
                                                        </div>
                                                        <div class="vacancies-item__top-btn">
                                                            <a class="modal_open" href="#vacancies" data-title="<?php echo get_the_title($id_); ?>"><?php _l('Відгукнутись'); ?> </a>
                                                            <a class="more-info js-collapse-title" href="#"><?php _l('Детальніше'); ?> </a>
                                                        </div>
                                                    </div>

                                                    <div class="vacancies-item__content js-collapse-content">
                                                        <?php if ($list_description) : ?>
                                                            <ul>
                                                                <?php foreach ($list_description as $item) : ?>
                                                                    <li> <span><?php echo $item['list_description_name']; ?></span><strong><?php echo $item['list_description_value']; ?></strong></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php
                                                        endif; ?>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>


                                        </div>
                                    <?php
                                    endif; ?>
                                </div>

                            </div>
                            <div class="modal modal-big" id="vacancies">
                                <div class="modal-content">
                                    <?php if ($title_modal = carbon_get_post_meta($id, 'title_modal')) : ?>
                                        <div class="modal-title">
                                            <div class="modal-title__main"><?php echo $title_modal; ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($shortcode_form = carbon_get_post_meta($id, 'shortcode_form')) : ?>
                                        <?php echo do_shortcode($shortcode_form); ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </section>
                <?php
                endif;

            elseif ($screen['_type'] == 'screen_3') :
                if (!$screen['screen_off']) : ?>

                    <section class="section-stats dark_section pad_section">
                        <img class="decor_name" src="<?php echo get_template_directory_uri() ?>/assets/img/decor-name.svg" alt="" />
                        <div class="container">
                            <div class="stats-group">
                                <div class="stats-group__left big">
                                    <div class="title-section">
                                        <div class="title-section__main" data-aos="fade-up" data-aos-delay="200"><?php echo $screen['title']; ?></div>
                                        <?php if ($sub_title =  $screen['sub_title']) :  ?>
                                            <div class="title-section__subtitle" data-aos="fade-up" data-aos-delay="400"><?php echo $sub_title; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($advantages_list =  $screen['advantages_list']) : $d = 200; ?>
                                    <div class="stats-group__right sm">
                                        <div class="stats">
                                            <?php foreach ($advantages_list as $item) : ?>
                                                <div class="stats-item" data-aos="fade-up" data-aos-delay="<?php echo $d; ?>">
                                                    <div class="stats-item__title"><?php echo $item['advantages_title']; ?></div>
                                                    <div class="stats-item__subtitle"><?php echo $item['advantages_text']; ?></div>
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

            elseif ($screen['_type'] == 'screen_4') :
                if (!$screen['screen_off']) : ?>
                    <section class="section-team pad_section">
                        <div class="container">
                            <div class="title-section" data-aos="fade-up" data-aos-delay="200">
                                <div class="title-section__main"><?php echo $screen['title']; ?></div>
                            </div>
                            <?php if ($sub_title =  $screen['sub_title']) :  ?>
                                <div class="text-group" data-aos="fade-up" data-aos-delay="400">
                                    <p><?php echo $sub_title; ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($team_list =  $screen['team_list']) : $d = 200; ?>
                                <div class="team">
                                    <?php foreach ($team_list as $item) : ?>
                                        <div class="team-item" data-aos="fade-up" data-aos-delay="<?php echo $d; ?>">
                                            <div class="team-item__photo">
                                                <img src="<?php echo wp_get_attachment_url($item['team_image']); ?>" alt="" />
                                            </div>
                                            <div class="team-item__name"><?php echo $item['team_title']; ?></div>
                                            <div class="team-item__position"><?php echo $item['team_text']; ?></div>
                                        </div>
                                    <?php $d = $d + 200;
                                    endforeach; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </section>
    <?php
                endif;
            endif;
        endforeach;
    endif; ?>

    <?php if (!empty($screens_home)) :
        foreach ($screens_home as $index => $screen) :
            $index = $index + 1;
            if ($screen['_type'] == 'screen_10') :
                if (!$screen['screen_off']) : ?>
                    <section class="section-form pad_section b_top">
                        <div class="container">
                            <div class="form-contact">
                                <div class="form-contact__left">
                                    <div class="title-section">
                                        <div class="title-section__main" data-aos="fade-up" data-aos-delay="200"><?php echo $screen['title']; ?></div>
                                        <?php if ($text =  $screen['text']) : ?>
                                            <div class="title-section__subtitle" data-aos="fade-up" data-aos-delay="400"><?php echo $text; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($contacts_ =  $screen['contacts']) : ?>
                                        <div class="contact-list" data-aos="fade-up" data-aos-delay="600">
                                            <?php foreach ($contacts_ as $item) : ?>
                                                <div class="contact-list__item">
                                                    <div class="contact-list__item-name"><?php echo $item['contacts_title']; ?></div>
                                                    <div class="contact-list__item-main"><?php echo $item['contacts_main']; ?></div>
                                                </div>
                                            <?php
                                            endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <?php if ($shortcode_form = $screen['shortcode_form']) : ?>
                                    <div class="form-contact__right" data-aos="fade-up" data-aos-delay="400">

                                        <?php echo do_shortcode($shortcode_form); ?>

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
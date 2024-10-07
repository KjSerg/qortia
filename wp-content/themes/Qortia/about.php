<?php
/*
    Template Name: About us / О нас 
*/ ?>
<?php get_header();
global $post; ?>
<?php $id = get_the_ID(); ?>
<?php $screens = carbon_get_post_meta($id, 'screens_about'); ?>
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

                    <section class="section-stats dark_section pad_section">
                        <img class="decor_name" src="<?php echo get_template_directory_uri() ?>/assets/img/decor-name.svg" alt="" />
                        <div class="container">
                            <div class="stats-group">
                                <div class="stats-group__left">
                                    <div class="title-section">
                                        <div class="title-section__main" data-aos="fade-up" data-aos-delay="200"><?php echo $screen['title']; ?></div>
                                        <?php if ($sub_title = $screen['sub_title']) : ?>
                                            <div class="title-section__subtitle" data-aos="fade-up" data-aos-delay="400"><?php echo $sub_title; ?></div>
                                        <?php
                                        endif; ?>
                                    </div>
                                </div>
                                <?php if ($achievements_list =  $screen['achievements_list']) : $d = 200; ?>
                                    <div class="stats-group__right">
                                        <div class="stats">
                                            <?php foreach ($achievements_list as $item) : ?>
                                                <div class="stats-item" data-aos="fade-up" data-aos-delay="<?php echo $d; ?>">
                                                    <div class="stats-item__ico">
                                                        <?php echo the_image($item['achievements_list_ico']); ?>
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

            elseif ($screen['_type'] == 'screen_3') :
                if (!$screen['screen_off']) : ?>
                    <section class="section-history pad_section b_top">
                        <div class="container">
                            <div class="history-group">
                                <div class="history-group__left">
                                    <div class="title-section">
                                        <div class="title-section__main"><?php echo $screen['title']; ?></div>
                                    </div>
                                    <div class="history-year"> </div>
                                </div>
                                <?php if ($history_list =  $screen['history_list']) : ?>
                                    <div class="history-group__right">
                                        <div class="history-list">
                                            <?php foreach ($history_list as $item) : ?>
                                                <div class="history-list__item" data-year="<?php echo $item['history_list_title']; ?>">
                                                    <div class="text-group">
                                                        <h3><?php echo $item['history_list_title']; ?></h3>
                                                        <?php echo wpautop($item['history_list_text']); ?>
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

            elseif ($screen['_type'] == 'screen_4') :
                if (!$screen['screen_off']) : ?>
                    <section class="section-stats dark_section pad_section">
                        <img class="decor_name" src="<?php echo get_template_directory_uri() ?>/assets/img/decor-name.svg" alt="" />
                        <div class="container">
                            <div class="stats-group">
                                <div class="stats-group__left">
                                    <div class="title-section">
                                        <div class="title-section__main" data-aos="fade-up" data-aos-delay="200"><?php echo $screen['title']; ?></div>
                                        <?php if ($sub_title = $screen['sub_title']) : ?>
                                            <div class="title-section__subtitle" data-aos="fade-up" data-aos-delay="400"><?php echo $sub_title; ?></div>
                                        <?php
                                        endif; ?>
                                    </div>
                                </div>

                                <?php if ($achievements_list =  $screen['achievements_list']) : $d = 200; ?>
                                    <div class="stats-group__right" data-aos="fade-up" data-aos-delay="200">
                                        <div class="stats-slider">
                                            <?php foreach ($achievements_list as $item) : ?>
                                                <div>
                                                    <div class="stats-item">
                                                        <div class="stats-item__ico">
                                                            <?php echo the_image($item['achievements_list_ico']); ?>
                                                        </div>
                                                        <div class="stats-item__title"><?php echo $item['achievements_list_title']; ?></div>
                                                        <div class="stats-item__subtitle"><?php echo $item['achievements_list_text']; ?></div>
                                                    </div>
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

            elseif ($screen['_type'] == 'screen_5') :
                if (!$screen['screen_off']) : ?>

                    <section class="section-text-media pad_section b_top">
                        <div class="container">

                            <div class="text-media <?php if ($screen['rev_block']) { ?>reverse<?php } ?>">
                                <div class="text-media__left">
                                    <div class="title-section">
                                        <div class="title-section__main" data-aos="fade-up" data-aos-delay="200"><?php echo $screen['title']; ?></div>
                                    </div>
                                    <div class="text-group" data-aos="fade-up" data-aos-delay="400">
                                        <?php echo wpautop($screen['text']); ?>
                                    </div>
                                    <?php $title_btn =  $screen['title_btn'];
                                    $link_btn =  $screen['link_btn'];
                                    ?>
                                    <?php if ($title_btn && $link_btn) : ?>
                                        <div class="btn-wrap" data-aos="fade-up" data-aos-delay="600">
                                            <a class="btn_st modal_open" href="<?php echo $link_btn; ?>"><?php echo $title_btn; ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-media__right" data-aos="fade-up" data-aos-delay="200">
                                    <div class="text-media__main"> <img src="<?php echo wp_get_attachment_url($screen['image']); ?>" alt="" /></div>
                                </div>
                            </div>
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
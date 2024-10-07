<?php
/*
    Template Name: Contacts / Контакты
*/ ?>
<?php get_header();
global $post; ?>
<?php $id = get_the_ID(); ?>
<?php $screens = carbon_get_post_meta($id, 'screens_contact'); ?>
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
                                    <?php if ($contacts_ =  $screen['contacts']) : $d = 600; ?>
                                        <?php foreach ($contacts_ as $item) : ?>
                                            <div class="contact-list" data-aos="fade-up" data-aos-delay="<?php echo $d; ?>">
                                                <?php if ($contacts_row =  $item['contacts_row']) : ?>
                                                    <?php foreach ($contacts_row as $item_) : ?>
                                                        <div class="contact-list__item">
                                                            <div class="contact-list__item-name"><?php echo $item_['contacts_title']; ?></div>
                                                            <div class="contact-list__item-main"><?php echo $item_['contacts_main']; ?></div>
                                                        </div>
                                                    <?php
                                                    endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php $d = $d + 200;
                                        endforeach; ?>
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
<?php get_header();
global $post; ?>
<?php $id = get_the_ID(); ?>
<main class="content main-error">
    <div class="decor-line">
        <div class="decor-line__item"> </div>
        <div class="decor-line__item"> </div>
        <div class="decor-line__item"> </div>
    </div>
    <section class="section-error">
        <div class="container">
            <div class="error-content">
                <div class="error-content__media">
                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/404.svg" alt="" />
                </div>
                <div class="error-content__title"><?php _l('Сторінку не знайдено'); ?></div>
                <a class="btn_bg" href="<?php echo get_home_url(); ?>">
                    <span><?php _l('На головну'); ?></span>
                </a>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
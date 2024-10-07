<?php
/*
    Template Name: Text template / Текстовый шаблон
*/ ?>
<?php get_header();
global $post; ?>
<?php $id = get_the_ID(); ?>

<main class="content">
    <section class="section-text-media pad_section b_top">
        <div class="container">

            <div class="title-section">
                <div class="title-section__main"><?php echo the_title(); ?></div>
            </div>

            <div class="text-group">
            <?php echo the_content(); ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
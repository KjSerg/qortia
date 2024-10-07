<!doctype <?php language_attributes(); ?>>
<html class="no-js  page">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries--><!-- WARNING: Respond.js doesn't work if you view the page via file://--><!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script><script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <title><?php wp_title(); ?> </title>
    <?php
    wp_head();
//    ob_start("apple_favicon");
//    wp_head();
//    ob_end_flush();
    ?>
</head>

<body>
    <header class="header" >
        <div class="container">
            <div class="header-content">
                <?php if ($crb_logo = carbon_get_theme_option('crb_logo')) : ?>
                    <a class="logo" href="<?php echo get_home_url(); ?>">
                        <?php  the_image($crb_logo); ?>
                    </a>
                <?php endif; ?>

                <?php if ($menu = carbon_get_post_meta(get_option('page_on_front'), 'menu_list_main')) : ?>
                    <nav class="navigation">

                        <ul>
                            <?php foreach ($menu as $item) :  ?>
                                <li>
                                    <a href="<?php echo $item['menu_list_main_link']; ?>"><?php echo $item['menu_list_main_text']; ?></a>

                                    <?php if ($menu_sub = $item['menu_list_main_sub']) : ?>
                                        <div class="sub-nav">
                                            <div class="sub-nav__content">
                                                <?php if ($menu_sub_title = $item['menu_list_main_title']) : ?>
                                                    <div class="sub-nav__title"><?php echo $menu_sub_title; ?></div>
                                                <?php endif; ?>

                                                <div class="sub-nav__group">

                                                    <div class="sub-nav__list">
                                                        <ul>
                                                            <?php foreach ($menu_sub as $item_) :  ?>

                                                                <li> <a href="<?php echo $item_['menu_list_main_link_sub']; ?>" <?php if ($menu_image = $item_['menu_list_main_image_sub']) : ?> data-img="<?php echo wp_get_attachment_url($menu_image); ?> <?php endif; ?>"><?php echo $item_['menu_list_main_title_sub']; ?></a></li>
                                                            <?php
                                                            endforeach; ?>
                                                        </ul>
                                                    </div>

                                                    <?php if ($menu_sub_image = $item['menu_list_main_image']) : ?>
                                                        <div class="sub-nav__media">
                                                            <img src="<?php echo wp_get_attachment_url($menu_sub_image); ?>" alt="" />
                                                            <span></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php
                            endforeach; ?>

                        </ul>

                    </nav>
                <?php endif; ?>

                <div class="header-right">
                    <?php if ($link_head = carbon_get_theme_option('link_head')) : ?>
                        <a class="header-link" href="<?php echo $link_head; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" style="enable-background:new 0 0 19 19" viewBox="0 0 19 19">
                                <path d="M16.8 0H2.2C1 0 0 1 0 2.2v3h1.5v-3c0-.4.3-.7.7-.7h14.5c.4 0 .7.3.7.7v14.5c0 .4-.3.7-.7.7H2.2c-.4 0-.7-.3-.7-.7v-3H0v3C0 18 1 19 2.2 19h14.5c1.2 0 2.2-1 2.2-2.2V2.2C19 1 18 0 16.8 0z" style="fill:#fff" />
                                <path d="m8.9 4.9-1 1 2.8 2.8H0v1.5h10.7L7.9 13l1 1 4.6-4.6-4.6-4.5z" style="fill:#fff" />
                            </svg>
                            <span><?php _l('Увійти в кабінет'); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php $language_switcher = wp_get_nav_menu_items('lang'); ?>
                    <?php if ($language_switcher) : ?>
                        <div class="language">
                            <?php foreach ($language_switcher as $item) : if (is_current_lang($item)) : ?>
                                    <div class="language-active"><?php echo $item->title; ?></div>
                            <?php endif;
                            endforeach; ?>
                            <div class="language-drop">
                                <ul>
                                    <?php foreach ($language_switcher as $item) : if (!is_current_lang($item)) : ?>
                                            <li> <a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></li>
                                    <?php endif;
                                    endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($tel_head = carbon_get_theme_option('tel_head')) : ?>
                        <a class="header-link" href="tel:<?php echo preg_replace('/[^+-a-zA-Z0-9_\.]/', '', $tel_head); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" style="enable-background:new 0 0 19.5 19.5" viewBox="0 0 19.5 19.5">
                                <path d="M4.3 0c-.4 0-.8.1-1.1.4L.7 2.9C0 3.6-.2 4.5.1 5.4c.6 1.8 2.3 5.3 5.4 8.5 3.2 3.2 6.7 4.7 8.5 5.4.9.3 1.9.1 2.6-.5l2.4-2.4c.6-.6.6-1.7 0-2.3l-3-3c-.6-.6-1.7-.6-2.3 0l-1.5 1.5c-.5-.3-1.8-.9-3.1-2.1C7.9 9.3 7.2 8 7 7.4l1.5-1.5c.6-.6.6-1.7 0-2.3l-.1-.1-3-3.1C5 .1 4.7 0 4.3 0zm0 1.5c.1 0 .1 0 .2.1l3 3.1.1.1V5l-2 1.7-.4.4.2.5s.9 2.3 2.7 4l.2.1c1.7 1.6 3.8 2.5 3.8 2.5l.5.2 2.2-2.2c.1-.1.1-.1.2 0l3.1 3.1c.1.1.1.1 0 .2l-2.3 2.3c-.4.2-.8.3-1.2.2-1.7-.7-5-2.1-7.9-5.1-3-3-4.5-6.3-5.1-8-.1-.3 0-.8.2-1l2.3-2.3c.1-.1.1-.1.2-.1z" style="fill:#fff" />
                            </svg>
                            <span><?php echo $tel_head; ?> </span>
                        </a>
                    <?php endif; ?>
                    <div class="tog-nav"> </div>
                </div>
            </div>
        </div>
    </header>
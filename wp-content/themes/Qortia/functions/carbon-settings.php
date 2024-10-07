<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);
	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_modals  = array(
		'plural_name'   => 'модальные окна',
		'singular_name' => 'модальное окно',
	);
	Container::make( 'theme_options', "Настройки сайта" )
	         ->add_tab( 'Логотип', array(
		         Field::make( 'image', 'crb_logo', 'Логотип' )
		              ->set_width( 33 )
		              ->set_required( true ),
	         ) )
	         ->add_tab( 'Соцсети в футере', array(
		         Field::make( 'complex', 'social_list_footer', 'Соцсети в футере' )
		              ->setup_labels( $labels )
		              ->add_fields( array(
			              Field::make( 'image', 'social_list_footer_ico', 'Иконка' )->set_required( true ),
			              Field::make( 'text', 'social_list_footer_link', 'Ссылка' )->set_required( true ),
		              ) )
	         ) )
	         ->add_tab( 'Номер телефона в шапке', array(
		         Field::make( 'text', 'tel_head', 'Телефон' )->set_required( true ),
	         ) )
	         ->add_tab( 'Ccылка в кабинет', array(
		         Field::make( 'text', 'link_head', 'Ccылка' ),
	         ) );
	Container::make( 'theme_options', "Настройки карты" )
	         ->add_tab( 'Google', array(
		         Field::make( 'text', 'google_map_api_key' )
		              ->set_required( true ),
	         ) );
	Container::make( 'theme_options', "Настройки страниц" )
	         ->set_page_parent( 'edit.php?post_type=page' )
	         ->add_fields( array(
		         Field::make( 'association', 'order_page', __( 'Страница заказа' ) )
		              ->set_max( 1 )
		              ->set_types( array(
			              array(
				              'type'      => 'post',
				              'post_type' => 'page',
			              )
		              ) ),
	         ) );
	Container::make( 'theme_options', "Динамические переменные" )
	         ->set_page_parent( 'edit.php?post_type=formulas' )
	         ->add_fields( array(
		         Field::make( 'complex', 'variables', 'Переменные' )
		              ->setup_labels( $labels )
		              ->add_fields( array(
			              Field::make( 'text', 'variable_name', 'Название' )->set_width( 50 )->set_required( true ),
			              Field::make( 'text', 'variable_value', 'Значение' )->set_width( 50 )
			                   ->set_attribute( 'type', 'number' )
			                   ->set_help_text( 'Если это денежная единица то указывайте в долларах или конвертируйте в доллар' )
			                   ->set_required( true ),
		              ) )
	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_front_page' );
function crb_attach_in_front_page() {


	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);

	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_columns = array(
		'plural_name'   => 'колонки',
		'singular_name' => 'колонку',
	);
	$labels_tabs    = array(
		'plural_name'   => 'вкладки',
		'singular_name' => 'вкладку',
	);
	Container::make( 'post_meta', 'Секции на главной странице' )
	         ->show_on_template( 'index.php' )
	         ->add_fields( array(
		         Field::make( 'complex', 'screens_front', 'Секции' )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( $screens_labels )
		              ->add_fields( 'screen_1', 'Секция 1 ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "file", "video", "Видео" )->set_required( true ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "text", "title_btn", "Текст кнопки" ),
			              Field::make( "text", "link_btn", "Ссылка кнопки" ),
		              ) )
		              ->add_fields( 'screen_2', 'Секция 2 - Список видео', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( 'complex', 'video_list', 'Список' )->set_max( 4 )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'file', 'video_list_main', 'Видео' )->set_required( true )->set_width( 20 ),
				                   Field::make( 'text', 'video_list_title', 'Заголовок' )->set_required( true )->set_width( 40 ),
				                   Field::make( 'text', 'link', 'Ссылка' )->set_attribute( 'type', 'url' )->set_width( 40 ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_3', 'Секция 3 - Преимущества', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" ),
			              Field::make( 'complex', 'advantages_list', 'Список' )->set_max( 3 )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'advantages_ico', 'Иконка' )->set_required( true ),
				                   Field::make( 'color', 'advantages_color', 'Цвет' )->set_required( true ),
				                   Field::make( 'text', 'advantages_title', 'Заголовок' )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_4', 'Секция 4 - Достижения', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "sub_title", "Подзаголовок" ),
			              Field::make( 'complex', 'achievements_list', 'Список' )->set_max( 3 )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'achievements_list_ico', 'Иконка' )->set_required( true ),
				                   Field::make( 'text', 'achievements_list_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'text', 'achievements_list_text', 'Текст' )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_5', 'Секция 5 - О нас', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" ),
			              Field::make( "rich_text", "text", "Текст" ),
			              Field::make( "text", "title_btn", "Текст кнопки" ),
			              Field::make( "text", "link_btn", "Ссылка кнопки" ),

			              Field::make( 'complex', 'about_list', 'Список изображений' )->set_required( true )->set_max( 4 )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'about_list_image', 'Изображения' )->set_required( true ),

			                   ) )
		              ) )
		              ->add_fields( 'screen_6', 'Секция 6 - История', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),

			              Field::make( 'complex', 'history_list', 'История' )->set_required( true )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'text', 'history_list_title', 'Заголовок' )->set_required( true ),
				                   Field::make( "rich_text", "history_list_text", "Текст" )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_7', 'Секция 7 - Подход', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" )->set_required( true ),

			              Field::make( 'complex', 'contacts', 'Контакт' )->set_required( true )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'contacts_icon', 'Иконка' )->set_required( true ),
				                   Field::make( 'color', 'contacts_color', 'Цвет' )->set_required( true ),
				                   Field::make( 'text', 'contacts_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'text', 'contacts_link', 'Ссылка' )->set_required( true ),

			                   ) )
		              ) )
		              ->add_fields( 'screen_8', 'Секция 8 - Присоединиться к платформе', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "subtitle", "Подзаголовок" ),
			              Field::make( "rich_text", "text_form", "Текст" ),
			              Field::make( "text", "shortcode_form", "Шорткод формы" )->set_required( true ),

		              ) )
		              ->add_fields( 'screen_9', 'Секция 9 - Всегда рядом', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "rich_text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "text", "Подзаголовок" ),


		              ) )
		              ->add_fields( 'screen_10', 'Секция 10 - Контакты', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "rich_text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "text", "Подзаголовок" ),
			              Field::make( 'complex', 'contacts', 'Контакты' )->set_required( true )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'text', 'contacts_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'text', 'contacts_main', 'Контакт' )->set_required( true ),

			                   ) ),
			              Field::make( "text", "shortcode_form", "Шорткод формы" )->set_required( true ),

		              ) )
	         ) );

	Container::make( 'post_meta', "Дополнительные настройки" )
	         ->show_on_template( 'index.php' )
	         ->add_tab( 'Меню в хедере', array(
		         Field::make( 'complex', 'menu_list_main', 'Меню в хедере' )->set_max( 5 )
		              ->setup_labels( $labels )
		              ->set_layout( 'tabbed-vertical' )
		              ->add_fields( array(
			              Field::make( 'text', 'menu_list_main_text', 'Текст' )->set_required( true ),
			              Field::make( 'text', 'menu_list_main_link', 'Ссылка' )->set_required( true ),

			              Field::make( 'image', 'menu_list_main_image', 'Картинка' ),
			              Field::make( 'text', 'menu_list_main_title', 'Заголовок подменю' ),

			              Field::make( 'complex', 'menu_list_main_sub', 'Подменю' )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'text', 'menu_list_main_title_sub', 'Текст' )->set_required( true ),
				                   Field::make( 'text', 'menu_list_main_link_sub', 'Ссылка' )->set_required( true ),
				                   Field::make( 'image', 'menu_list_main_image_sub', 'Картинка' ),

			                   ) )
		              ) )
		              ->set_header_template( '
								    <% if (menu_list_main_text) { %>
								         <%- menu_list_main_text %>
								    <% } %>
								' )
	         ) )
	         ->add_tab( 'Контакты в футере', array(
		         Field::make( 'image', 'contact_code', 'QR Code' ),
		         Field::make( 'complex', 'contact_list_footer', 'Контакты в футере' )
		              ->setup_labels( $labels )
		              ->add_fields( array(
			              Field::make( 'image', 'contact_list_footer_icon', 'Иконка' ),
			              Field::make( 'text', 'contact_list_footer_title', 'Контакт' )->set_required( true ),

		              ) )
	         ) )
	         ->add_tab( 'Список в футере', array(
		         Field::make( 'complex', 'footer_list', 'Список' )->set_max( 2 )
		              ->setup_labels( $labels )
		              ->add_fields( array(
			              Field::make( 'text', 'footer_list_title', 'Текст' )->set_required( true ),
		              ) )
	         ) )
	         ->add_tab(
		         'Слоган в футере',
		         array(
			         Field::make( 'text', 'quote_footer', 'Слоган' ),

		         )
	         );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_about_page' );
function crb_attach_in_about_page() {


	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);

	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_columns = array(
		'plural_name'   => 'колонки',
		'singular_name' => 'колонку',
	);
	$labels_tabs    = array(
		'plural_name'   => 'вкладки',
		'singular_name' => 'вкладку',
	);
	Container::make( 'post_meta', 'Секции на странице о нас' )
	         ->show_on_template( 'about.php' )
	         ->add_fields( array(
		         Field::make( 'complex', 'screens_about', 'Секции' )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( $screens_labels )
		              ->add_fields( 'screen_1', 'Секция 1 ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "image", "bg_image", "Фоновое изображение" )->set_required( true ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" ),

		              ) )
		              ->add_fields( 'screen_2', 'Секция 2 - Достижения', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "sub_title", "Подзаголовок" ),
			              Field::make( 'complex', 'achievements_list', 'Список' )->set_max( 3 )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'achievements_list_ico', 'Иконка' )->set_required( true ),
				                   Field::make( 'text', 'achievements_list_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'text', 'achievements_list_text', 'Текст' )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_3', 'Секция 3 - История', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),

			              Field::make( 'complex', 'history_list', 'История' )->set_required( true )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'text', 'history_list_title', 'Заголовок' )->set_required( true ),
				                   Field::make( "rich_text", "history_list_text", "Текст" )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_4', 'Секция 4 - Наши ценности', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "sub_title", "Подзаголовок" ),
			              Field::make( 'complex', 'achievements_list', 'Список' )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'achievements_list_ico', 'Иконка' )->set_required( true ),
				                   Field::make( 'text', 'achievements_list_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'text', 'achievements_list_text', 'Текст' )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_5', 'Секция 5 - Текст с картинкой', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( 'checkbox', 'rev_block', 'Развернуть блок?' ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" )->set_required( true ),
			              Field::make( "text", "title_btn", "Текст кнопки" ),
			              Field::make( "text", "link_btn", "Ссылка кнопки" ),
			              Field::make( 'image', 'image', 'Изображение' )->set_required( true ),
		              ) )


	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_partners_page' );
function crb_attach_in_partners_page() {


	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);

	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_columns = array(
		'plural_name'   => 'колонки',
		'singular_name' => 'колонку',
	);
	$labels_tabs    = array(
		'plural_name'   => 'вкладки',
		'singular_name' => 'вкладку',
	);
	Container::make( 'post_meta', 'Секции на странице Партнерам' )
	         ->show_on_template( 'partners.php' )
	         ->add_fields( array(
		         Field::make( 'complex', 'screens_partners', 'Секции' )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( $screens_labels )
		              ->add_fields( 'screen_1', 'Секция 1 ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "image", "bg_image", "Фоновое изображение" )->set_required( true ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" ),

		              ) )
		              ->add_fields( 'screen_2', 'Секция 2 - Преимущества', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "sub_title", "Подзаголовок" ),
			              Field::make( 'complex', 'advantages_list', 'Список' )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'advantages_ico', 'Иконка' ),
				                   Field::make( 'text', 'advantages_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'textarea', 'advantages_text', 'Текст' )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_3', 'Секция 3 - Партнерство', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( 'complex', 'list', 'Список' )->set_max( 4 )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'text', 'list_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'textarea', 'list_text', 'Текст' )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_4', 'Секция 4 - Партнеры', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "sub_title", "Подзаголовок" ),
			              Field::make( 'media_gallery', 'logos', 'Логотипы' )->set_required( true ),
		              ) )


	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_contact_page' );
function crb_attach_in_contact_page() {


	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);

	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_columns = array(
		'plural_name'   => 'колонки',
		'singular_name' => 'колонку',
	);
	$labels_tabs    = array(
		'plural_name'   => 'вкладки',
		'singular_name' => 'вкладку',
	);
	Container::make( 'post_meta', 'Секции на странице контактов' )
	         ->show_on_template( 'contact.php' )
	         ->add_fields( array(
		         Field::make( 'complex', 'screens_contact', 'Секции' )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( $screens_labels )
		              ->add_fields( 'screen_1', 'Секция 1 ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "image", "bg_image", "Фоновое изображение" )->set_required( true ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" ),

		              ) )
		              ->add_fields( 'screen_2', 'Секция 2 - Контакты', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "text", "Подзаголовок" ),
			              Field::make( 'complex', 'contacts', 'Контакты' )->set_required( true )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'complex', 'contacts_row', 'Список контактов' )->set_required( true )
				                        ->setup_labels( $labels )
				                        ->add_fields( array(
					                        Field::make( 'text', 'contacts_title', 'Заголовок' )->set_required( true ),
					                        Field::make( 'text', 'contacts_main', 'Контакт' )->set_required( true ),

				                        ) ),

			                   ) ),
			              Field::make( "text", "shortcode_form", "Шорткод формы" )->set_required( true ),

		              ) )


	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_career_page' );
function crb_attach_in_career_page() {


	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);

	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_columns = array(
		'plural_name'   => 'колонки',
		'singular_name' => 'колонку',
	);
	$labels_tabs    = array(
		'plural_name'   => 'вкладки',
		'singular_name' => 'вкладку',
	);
	Container::make( 'post_meta', 'Секции на странице Карьера' )
	         ->show_on_template( 'vacancies.php' )
	         ->add_fields( array(

		         Field::make( 'complex', 'screens_career', 'Секции' )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( $screens_labels )
		              ->add_fields( 'screen_1', 'Секция 1 ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "image", "bg_image", "Фоновое изображение" )->set_required( true ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" ),

		              ) )
		              ->add_fields( 'screen_2', 'Секция 2 - Вакансии', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( 'association', 'vacancies_list_left', 'Вакансии, левая колонка' )
			                   ->set_types( array(
				                   array(
					                   'type'      => 'post',
					                   'post_type' => 'vacancies',
				                   )
			                   ) ),
			              Field::make( 'association', 'vacancies_list_right', 'Вакансии, правая колонка' )
			                   ->set_types( array(
				                   array(
					                   'type'      => 'post',
					                   'post_type' => 'vacancies',
				                   )
			                   ) ),
		              ) )
		              ->add_fields( 'screen_3', 'Секция 3 - Преимущества', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "sub_title", "Подзаголовок" ),
			              Field::make( 'complex', 'advantages_list', 'Список' )->set_max( 3 )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'text', 'advantages_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'textarea', 'advantages_text', 'Текст' )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_4', 'Секция 4 - Команда', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "sub_title", "Подзаголовок" ),
			              Field::make( 'complex', 'team_list', 'Команда' )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'team_image', 'Фото' )->set_required( true ),
				                   Field::make( 'text', 'team_title', 'Имя' )->set_required( true ),
				                   Field::make( 'text', 'team_text', 'Должность' )->set_required( true ),
			                   ) )
		              ) ),
		         Field::make( "separator", "crb_vacancies_modal", "Настройка модального окна" ),
		         Field::make( "text", "title_modal", "Заголовок" )->set_required( true ),
		         Field::make( "text", "shortcode_form", "Шорткод формы" )->set_required( true ),


	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_vacancies_item' );
function crb_attach_theme_vacancies_item() {
	$labels = array(
		'plural_name'   => 'елемент',
		'singular_name' => 'елемент',
	);
	Container::make( 'post_meta', 'Настройка' )
	         ->show_on_post_type( 'vacancies' )
	         ->add_fields(
		         array(
			         Field::make( "text", "price", "Зарплата" )->set_required( true ),
			         Field::make( "text", "place", "Место" )->set_required( true ),

			         Field::make( 'complex', 'list_description', 'Список' )->set_required( true )
			              ->setup_labels( $labels )
			              ->add_fields( array(
				              Field::make( 'text', 'list_description_name', 'Название' )->set_required( true ),
				              Field::make( 'text', 'list_description_value', 'Значение' )->set_required( true ),
			              ) ),


		         )
	         );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_invest_page' );
function crb_attach_in_invest_page() {


	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);

	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_columns = array(
		'plural_name'   => 'колонки',
		'singular_name' => 'колонку',
	);
	$labels_tabs    = array(
		'plural_name'   => 'вкладки',
		'singular_name' => 'вкладку',
	);
	Container::make( 'post_meta', 'Секции на странице Инвесторам' )
	         ->show_on_template( 'invest.php' )
	         ->add_fields( array(

		         Field::make( 'complex', 'screens_invest', 'Секции' )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( $screens_labels )
		              ->add_fields( 'screen_1', 'Секция 1 ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "image", "bg_image", "Фоновое изображение" )->set_required( true ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" ),

		              ) )
		              ->add_fields( 'screen_2', 'Секция 2 - Преимущества', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "sub_title", "Подзаголовок" ),
			              Field::make( 'complex', 'advantages_list', 'Список' )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'image', 'advantages_ico', 'Иконка' ),
				                   Field::make( 'text', 'advantages_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'textarea', 'advantages_text', 'Текст' )->set_required( true ),
			                   ) )
		              ) )
		              ->add_fields( 'screen_3', 'Секция 3 - Текст с картинкой', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( 'checkbox', 'rev_block', 'Развернуть блок?' ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" )->set_required( true ),
			              Field::make( "text", "title_btn", "Текст кнопки" ),
			              Field::make( "text", "link_btn", "Ссылка кнопки" ),
			              Field::make( 'image', 'image', 'Изображение' )->set_required( true ),
		              ) )


	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_products_page' );
function crb_attach_in_products_page() {
	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);
	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_columns = array(
		'plural_name'   => 'колонки',
		'singular_name' => 'колонку',
	);
	$labels_tabs    = array(
		'plural_name'   => 'вкладки',
		'singular_name' => 'вкладку',
	);
	Container::make( 'post_meta', 'Секции на странице' )
	         ->show_on_template( 'fuel-page.php' )
	         ->add_fields( array(

		         Field::make( 'complex', 'screens_fuel', 'Секции' )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( $screens_labels )
		              ->add_fields( 'screen_1', 'Баннер ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "rich_text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" ),
			              Field::make( "separator", "crb_style_inform1", "Изображение" ),
			              Field::make( "image", "bg_image", "Фоновое изображение" )->set_required( true ),

		              ) )
		              ->add_fields( 'screen_2_1', ' Продукция вкладки ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Вкладки" ),

			              Field::make( 'complex', 'tabs', 'Вкладки' )->set_required( true )
			                   ->setup_labels( $labels_tabs )
			                   ->set_layout( 'tabbed-horizontal' )
			                   ->add_fields( array(
				                   Field::make( "text", "title", "Заголовок" )->set_required( true ),
				                   Field::make( "separator", "crb_style_inform1", "Продукция" ),
				                   Field::make( 'association', 'list', __( 'Продукция' ) )
				                        ->set_required( true )
				                        ->set_types( array(
					                        array(
						                        'type'      => 'post',
						                        'post_type' => 'products',
					                        )
				                        ) ),
				                   Field::make( "separator", "crb_style_inform2", "Промо" ),
				                   Field::make( 'complex', 'promo_list', 'Список' )
				                        ->setup_labels( $labels )
				                        ->add_fields( array(
					                        Field::make( "text", "title", "Заголовок" )->set_required( true ),
					                        Field::make( "text", "text", "Текст" ),
					                        Field::make( "text", "button_text", "Текст кнопки" )->set_required( true )->set_width( 50 ),
					                        Field::make( "text", "button_link", "URL кнопки" )->set_required( true )->set_width( 50 ),
				                        ) )
			                   ) )
			                   ->set_header_template( '
								    <% if (title) { %>
								         <%- title %>
								    <% } %>
								' )

		              ) )
		              ->add_fields( 'screen_3', ' Преимущества ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" ),


			              Field::make( "separator", "crb_style_inform2", "Список" ),
			              Field::make( 'complex', 'list', 'Список' )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( "image", "image", "Иконка" )->set_required( true )->set_width( 50 ),
				                   Field::make( "text", "title", "Заголовок" )->set_required( true )->set_width( 50 ),
				                   Field::make( "text", "text", "Текст" ),
			                   ) )

		              ) )
		              ->add_fields( 'screen_prices', ' Цены ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "text", "text", "Текст" ),

		              ) )
		              ->add_fields( 'screen_9', 'Всегда рядом', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "rich_text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "text", "Подзаголовок" ),


		              ) )
		              ->add_fields( 'screen_10', 'Контакты', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "rich_text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "text", "Подзаголовок" ),
			              Field::make( 'complex', 'contacts', 'Контакты' )->set_required( true )
			                   ->setup_labels( $labels )
			                   ->add_fields( array(
				                   Field::make( 'text', 'contacts_title', 'Заголовок' )->set_required( true ),
				                   Field::make( 'text', 'contacts_main', 'Контакт' )->set_required( true ),

			                   ) ),
			              Field::make( "text", "shortcode_form", "Шорткод формы" )->set_required( true ),

		              ) )

	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_order_page' );
function crb_attach_in_order_page() {
	Container::make( 'post_meta', 'Настройки' )
	         ->show_on_template( 'order-page.php' )
	         ->add_fields( array(
		         Field::make( "text", "order_form_title", "Заголовок формы" ),
		         Field::make( "text", "order_form_short_code", "Шорткод формы" )->set_required( true ),
		         Field::make( 'html', 'crb_information_text', '' )
		              ->set_html( '<p>Заявка с продукцией додастся к тела формы</p>' ),

		         Field::make( "text", "order_form_error", "Сообщение ошибки" ),
	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_products' );
function crb_attach_in_products() {
	$screens_labels = array(
		'plural_name'   => 'секции',
		'singular_name' => 'секцию',
	);
	$labels         = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$labels_columns = array(
		'plural_name'   => 'колонки',
		'singular_name' => 'колонку',
	);
	$labels_tabs    = array(
		'plural_name'   => 'вкладки',
		'singular_name' => 'вкладку',
	);

	Container::make( 'post_meta', 'Секции на странице' )
	         ->show_on_post_type( array( 'products' ) )
	         ->add_fields( array(

		         Field::make( 'complex', 'screens_product', 'Секции' )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( $screens_labels )
		              ->add_fields( 'screen_1', 'Баннер ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "rich_text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "rich_text", "text", "Текст" ),
			              Field::make( "separator", "crb_style_inform1", "Изображение" ),
			              Field::make( "image", "bg_image", "Фоновое изображение" )->set_required( true ),

		              ) )
		              ->add_fields( 'screen_9', 'Всегда рядом', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "rich_text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "textarea", "text", "Подзаголовок" ),


		              ) )
		              ->add_fields( 'screen_prices', ' Цены ', array(
			              Field::make( "separator", "crb_style_screen_off", "Отключить секцию?" ),
			              Field::make( 'checkbox', 'screen_off', 'Отключить секцию?' ),
			              Field::make( "separator", "crb_style_inform", "Информация" ),
			              Field::make( "text", "title", "Заголовок" )->set_required( true ),
			              Field::make( "text", "text", "Текст" ),

		              ) )
	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_formulas' );
function crb_attach_in_formulas() {
	$labels = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	Container::make( 'post_meta', 'Формула' )
	         ->show_on_post_type( array( 'formulas' ) )
	         ->add_fields( array(
		         Field::make( 'html', 'crb_information_text', "После сохранения вы увидете формулу прописью" )
		              ->set_html( 'html_information_for_formula' ),
		         Field::make( 'complex', 'constructor', 'Конструктор' )
		              ->set_required( true )
		              ->set_layout( 'tabbed-horizontal' )
		              ->setup_labels( $labels )
		              ->add_fields( 'number', 'число ', array(
			              Field::make( "text", "num", "число" )->set_required( true )->set_attribute( 'type', 'number' )
		              ) )
		              ->add_fields( 'coefficient', 'коэффициент ', array(
			              Field::make( "separator", "separator", "коэффициент это динамическое значение задается в пункте выгрузки или загрузки (по-умолчанию 1)" )
		              ) )
		              ->add_fields( 'logistics', 'Услуги логистики ', array(
			              Field::make( "separator", "separator", "Услуги логистики это динамическое значение задается в пункте выгрузки или загрузки (по-умолчанию 0)" )
		              ) )
		              ->add_fields( 'service', 'услуги пункта приемки ', array(
			              Field::make( "separator", "separator", "услуги пункта приемки это динамическое значение задается в пункте выгрузки или загрузки, $/тн" )
		              ) )
		              ->add_fields( 'qnt', 'количество ', array(
			              Field::make( "separator", "separator", "количество это динамическое значение" )
		              ) )
		              ->add_fields( 'distance', 'росстояние ', array(
			              Field::make( "separator", "separator", "росстояние это динамическое значение" )
		              ) )
		              ->add_fields( 'currency', 'валюта ', array(
			              Field::make( 'select', 'currency', __( 'валюта' ) )->set_required( true )
			                   ->add_options( 'get_currencies_value' )
			                   ->set_help_text( '<a target="_blank" href="https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json">Ресурс API для розробників НБУ</a> <hr> Оновление раз в 4 часа' )
		              ) )
		              ->add_fields( 'operation', 'действие ', array(
			              Field::make( 'select', 'operation', __( 'действие' ) )
			                   ->set_required( true )
			                   ->add_options(
				                   array(
					                   '+' => '+',
					                   '-' => '-',
					                   '×' => '×',
					                   '÷' => '÷',
				                   )
			                   )
		              ) )
		              ->set_header_template( '
						    <% if (operation) { %>
						        <%- operation %>
						    <% } %>
						' )
		              ->add_fields( 'formulas', '( формула ) ', array(
			              Field::make( 'association', 'formulas', __( 'формула' ) )
			                   ->set_help_text( 'для начала создайте нужную' )
			                   ->set_required( true )
			                   ->set_max( 1 )
			                   ->set_types( array(
				                   array(
					                   'type'      => 'post',
					                   'post_type' => 'formulas',
				                   )
			                   ) )
		              ) )
		              ->add_fields( 'variable', 'переменная ', array(
			              Field::make( 'select', 'variable', __( 'переменная' ) )
			                   ->set_required( true )
			                   ->add_options(
				                   'get_variables'
			                   )
		              ) )
		              ->add_fields( 'condition', 'условие ', array(
			              Field::make( 'separator', 'crb_separator', __( 'ЕСЛИ/IF' ) ),
			              Field::make( 'association', 'formulas', __( 'результат формулы' ) )
			                   ->set_help_text( 'для начала создайте нужную' )
			                   ->set_required( true )
			                   ->set_max( 1 )
			                   ->set_types( array(
				                   array(
					                   'type'      => 'post',
					                   'post_type' => 'formulas',
				                   )
			                   ) ),
			              Field::make( 'select', 'operation', __( 'оператор' ) )
			                   ->set_required( true )
			                   ->add_options(
				                   array(
					                   '>'  => '>',
					                   '<'  => '<',
					                   '>=' => '>=',
					                   '<=' => '<=',
					                   '!=' => '!=',
					                   '==' => '==',
				                   )
			                   ),
			              Field::make( "text", "num", "числу" )
			                   ->set_width( 50 )
			                   ->set_required( true )->set_attribute( 'type', 'number' ),
			              Field::make( "text", "num2", "второе число" )
			                   ->set_help_text( 'если поле заполнено то будет проверятся условие до этого числа <hr> (<strong>"=="</strong> - входит в диапазон, <strong>"!="</strong> - не входит) ' )
			                   ->set_width( 50 )->set_attribute( 'type', 'number' ),
			              Field::make( 'separator', 'crb_separator1', __( 'TO/TRUE' ) ),
			              Field::make( "text", "true_result", "ВОЗВРАТИТЬ ЗНАЧЕНИЕ ЕСЛИ УСЛОВИЕ ВЫПОЛНИЛОСЬ" )->set_required( true )->set_attribute( 'type', 'number' ),
			              Field::make( 'separator', 'crb_separator2', __( 'ИНАЧЕ/FALSE' ) ),
			              Field::make( "text", "false_result", "ВОЗВРАТИТЬ ЗНАЧЕНИЕ ЕСЛИ УСЛОВИЕ не ВЫПОЛНИЛОСЬ" )
			                   ->set_help_text( 'оставьте пустым чтобы проверять только на истину' )
			                   ->set_attribute( 'type', 'number' ),
		              ) )

	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_modal_windows' );
function crb_attach_in_modal_windows() {
	$labels = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	Container::make( 'post_meta', 'Форма' )
	         ->show_on_post_type( 'windows' )
	         ->add_fields( array(
		         Field::make( "text", "window_id", "ID окна (уникальное значение)" )
		              ->set_attribute( 'pattern', '^[a-z0-9\-]+$' )
		              ->set_help_text( 'Латинское слово без пробелов. Возможный символ: "-" <br> <strong> Значение идентификатора не должно повторяться!</strong>' )
		              ->set_required( true ),
		         Field::make( 'select', 'window_max_width', __( 'Максимальная ширина окна' ) )
		              ->set_required( true )
		              ->set_options( array(
			              'modal-big' => '1220px',
			              'modal-md'  => '870px',
		              ) ),
		         Field::make( 'text', 'window_short_code', __( 'Шорткод' ) ),
		         Field::make( "separator", "crb_style_inform2", "или" ),
		         Field::make( 'association', 'window_form', __( 'Форма' ) )
		              ->set_max( 1 )
		              ->set_types( array(
			              array(
				              'type'      => 'post',
				              'post_type' => 'contact_form',
			              )
		              ) ),

	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_points' );
function crb_attach_in_points() {
	$labels = array(
		'plural_name'   => 'элементы',
		'singular_name' => 'элемент',
	);
	$user   = current_user_can( 'administrator' ) ? 'administrator' : 'not-administrator';
	Container::make( 'post_meta', 'Адрес' )
	         ->where( 'current_user_role', 'IN', array( 'administrator' ) )
	         ->where( 'post_type', '=', 'points' )
	         ->add_fields( array(
		         Field::make( 'separator', 'crb_separator', __( 'Адрес' ) ),
		         Field::make( "text", "point_address", "Адрес" )->set_required( true )
		              ->set_help_text( __( 'прописью' ) ),
		         Field::make( 'separator', 'crb_separator1', __( 'Координаты' ) ),
		         Field::make( 'map', 'crb_company_location', __( 'Размещение' ) )
		              ->set_position( '50.4628488', '30.5508842', '14' )
		              ->set_help_text( __( 'перетащите булавку на карте, чтобы выбрать местоположение' ) )
	         ) );

	Container::make( 'post_meta', 'Настройки' )
	         ->where( 'post_type', '=', 'points' )
	         ->add_fields( array(
		         Field::make( 'separator', 'crb_separator2', __( 'Статус' ) ),
		         Field::make( 'select', 'point_type', __( 'Выберите статус пункта' ) )
		              ->set_options( array(
			              'point' => "Пункт приема/отгрузки",
			              'basis' => "Базис"
		              ) ),
		         Field::make( 'separator', 'crb_separator3', __( 'Продукция' ) ),
		         Field::make( 'complex', 'point_products', 'Продукция' )
		              ->set_layout( 'tabbed-horizontal' )
		              ->set_conditional_logic( array(
			              'relation' => 'AND',
			              array(
				              'field'   => 'point_type',
				              'value'   => 'point',
				              'compare' => '=',
			              )
		              ) )
		              ->setup_labels( $labels )
		              ->add_fields( array(
			              Field::make( 'select', 'point_type', __( 'Выберите статус пункта' ) )
			                   ->set_options( array(
				                   'reception' => "прием",
				                   'shipment'  => "отгрузка "
			                   ) ),
			              Field::make( 'multiselect', 'products', __( 'Выберите товары или товар' ) )
			                   ->set_required( true )
			                   ->add_options( 'get_products_for_select' ),
			              Field::make( 'select', 'basis', __( 'Базис' ) )
			                   ->set_help_text( '<a target="_blank" href="/wp-admin/post-new.php?post_type=points">Создайте если нет</a>' )
			                   ->add_options( 'get_basis_for_select' ),
			              Field::make( "text", "point_price", "Услуги пункта приемки, тон" )
			                   ->set_attribute( 'data-user', $user )
			                   ->set_attribute( 'type', 'number' )->set_required( true )->set_width( 50 ),

			              Field::make( 'select', 'point_price_currency', __( 'Базовая валюта стоимости услуг' ) )
			                   ->set_required( true )->set_width( 50 )
			                   ->add_options( 'get_currencies_value' )
			                   ->set_help_text( '<a target="_blank" href="https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json">Ресурс API для розробників НБУ</a> <hr> Оновление раз в 4 часа' ),

			              Field::make( "text", "point_logistics_price", "Услуги логистики" )->set_attribute( 'data-user', $user )
			                   ->set_attribute( 'type', 'number' )->set_width( 50 ),
			              Field::make( 'select', 'point_logistics_price_price_currency', __( 'Базовая валюта стоимости услуг логистики' ) )
			                   ->set_required( true )->set_width( 50 )
			                   ->add_options( 'get_currencies_value' )
			                   ->set_help_text( '<a target="_blank" href="https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json">Ресурс API для розробників НБУ</a> <hr> Оновление раз в 4 часа' ),


			              Field::make( "text", "point_coef", "Коефициент пункта приемки" )->set_attribute( 'data-user', $user )
			                   ->set_attribute( 'type', 'number' )->set_required( true ),
			              Field::make( 'select', 'formulas', __( 'Формула доставки' ) )
			                   ->add_options( 'get_formulas_for_select' ),
			              Field::make( 'multiselect', 'currency', __( 'Валюты, которые отображаются согласно курса НБУ по отношению к базовой валюте' ) )
			                   ->set_required( true )
			                   ->add_options( 'get_currencies_value' )
			                   ->set_help_text( '<a target="_blank" href="https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json">Ресурс API для розробників НБУ</a> <hr> Оновление раз в 4 часа' ),


		              ) )->set_header_template( '
						  Товары  <%- $_index + 1 %>. 
						  <% if (point_type) { %><%- point_type %><% } %>
						' ),
		         Field::make( 'complex', 'point_basis_products', 'Продукция' )
		              ->set_conditional_logic( array(
			              'relation' => 'AND',
			              array(
				              'field'   => 'point_type',
				              'value'   => 'basis',
				              'compare' => '=',
			              )
		              ) )
		              ->setup_labels( $labels )
		              ->set_layout( 'tabbed-horizontal' )
		              ->add_fields( array(

			              Field::make( 'separator', 'crb_separator1', __( 'Товар в базисе' ) ),
			              Field::make( 'select', 'point_type', __( 'Выберите статус пункта' ) )
			                   ->set_options( array(
				                   'reception' => "прием",
				                   'shipment'  => "отгрузка "
			                   ) ),
			              Field::make( 'association', 'product', __( 'Товар' ) )
			                   ->set_max( 1 )
			                   ->set_types( array(
				                   array(
					                   'type'      => 'post',
					                   'post_type' => 'products',
				                   )
			                   ) ),

			              Field::make( 'association', 'regions', __( 'Регионы' ) )
			                   ->set_types( array(
				                   array(
					                   'type'     => 'term',
					                   'taxonomy' => 'regions',
				                   )
			                   ) ),

			              Field::make( "text", "point_product_price", "Цена товара в базисе" )->set_attribute( 'data-user', $user )
			                   ->set_attribute( 'type', 'number' )->set_required( true )->set_width( 50 ),
			              Field::make( 'select', 'base_currency', __( 'Базовая валюта цены товара' ) )
			                   ->set_required( true )->set_width( 50 )
			                   ->add_options( 'get_currencies_value' )
			                   ->set_help_text( '<a target="_blank" href="https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json">Ресурс API для розробників НБУ</a> <hr> Оновление раз в 4 часа' ),
			              Field::make( "text", "point_price", "Услуги пункта приемки, тон" )
			                   ->set_attribute( 'data-user', $user )
			                   ->set_width( 50 )
			                   ->set_attribute( 'type', 'number' )->set_required( true ),
			              Field::make( 'select', 'point_price_currency', __( 'Базовая валюта стоимости услуг' ) )
			                   ->set_required( true )->set_width( 50 )
			                   ->add_options( 'get_currencies_value' )
			                   ->set_help_text( '<a target="_blank" href="https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json">Ресурс API для розробників НБУ</a> <hr> Оновление раз в 4 часа' ),

			              Field::make( "text", "point_logistics_price", "Услуги логистики" )->set_attribute( 'data-user', $user )
			                   ->set_attribute( 'type', 'number' )->set_width( 50 ),
			              Field::make( 'select', 'point_logistics_price_price_currency', __( 'Базовая валюта стоимости услуг логистики' ) )
			                   ->set_required( true )->set_width( 50 )
			                   ->add_options( 'get_currencies_value' )
			                   ->set_help_text( '<a target="_blank" href="https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json">Ресурс API для розробників НБУ</a> <hr> Оновление раз в 4 часа' ),


			              Field::make( "text", "point_coef", "Коефициент пункта приемки" )->set_attribute( 'data-user', $user )
			                   ->set_attribute( 'type', 'number' )->set_required( true ),
			              Field::make( 'select', 'formulas', __( 'Формула доставки' ) )
			                   ->add_options( 'get_formulas_for_select' ),
			              Field::make( 'multiselect', 'currency', __( 'Валюты, которые отображаются согласно курса НБУ по отношению к базовой валюте' ) )
			                   ->set_required( true )
			                   ->add_options( 'get_currencies_value' )
			                   ->set_help_text( '<a target="_blank" href="https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json">Ресурс API для розробників НБУ</a> <hr> Оновление раз в 4 часа' )
		              ) )->set_header_template( '
						  Товар в базисе  <%- $_index + 1 %>. 
						    <% if (point_type) { %><%- point_type %><% } %>
						' )
	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_applications' );
function crb_attach_in_applications() {
	Container::make( 'post_meta', 'Информация' )
	         ->show_on_post_type( 'applications' )
	         ->add_tab( __( 'Товар' ), array(
		         Field::make( 'separator', 'crb_data', __( 'Товар' ) ),
		         Field::make( 'select', 'application_status', __( 'Статус' ) )
		              ->set_options( array(
			              'not_confirmed' => "Не подтверждено",
			              'confirmed'     => "Подтверждено "
		              ) ),
		         Field::make( "complex", "application_products", "Товары" )
		              ->add_fields( array(
			              Field::make( "text", "product", "Товар" )->set_width( 25 ),
			              Field::make( "text", "product_id", "ID товара" )->set_width( 25 ),
			              Field::make( "text", "qnt", "Количество" )->set_width( 25 ),
			              Field::make( "text", "price", "Цена" )->set_width( 25 ),
		              ) ),
	         ) )
	         ->add_tab( __( 'Адрес' ), array(
		         Field::make( 'separator', 'crb_separator1111', __( 'Пункт' ) ),
		         Field::make( "text", "application_point_id", "Пункт ID" )->set_width( 50 ),
		         Field::make( "text", "application_point", "Пункт" )->set_width( 50 ),
		         Field::make( 'separator', 'crb_separator', __( 'Адрес' ) ),
		         Field::make( "text", "application_address", "Адрес" ),
		         Field::make( "text", "application_city", "Город" ),
		         Field::make( "text", "application_region", "Регион" ),
		         Field::make( "text", "application_post_code", "Почтовый индекс" ),
		         Field::make( 'separator', 'crb_separator1', __( 'Координаты' ) ),
		         Field::make( 'map', 'application_location', __( 'Размещение' ) )
		              ->set_help_text( __( 'перетащите булавку на карте, чтобы выбрать местоположение' ) ),
	         ) )
	         ->add_tab( __( 'Персональные данные' ), array(
		         Field::make( 'separator', 'crb_user_data', __( 'Персональные данные' ) ),
		         Field::make( "text", "application_name", "ФИО" )->set_width( 50 ),
		         Field::make( "text", "application_organization", "Компания" )->set_width( 50 ),
		         Field::make( "text", "application_tel", "Телефон" )->set_width( 50 ),
		         Field::make( "text", "application_email", "Email" )->set_width( 50 ),
	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_categories' );
function crb_attach_in_categories() {
	Container::make( 'term_meta', 'Настройки' )
	         ->show_on_taxonomy( 'categories' )
	         ->add_fields( array(
		         Field::make( 'select', 'category_type', __( 'Выберите фильтрацию категории' ) )
		              ->set_options( array(
			              ''          => "все",
			              'reception' => "прием",
			              'shipment'  => "отгрузка "
		              ) ),
		         Field::make( 'association', 'term_page', __( 'Страница категории' ) )
		              ->set_max( 1 )
		              ->set_types( array(
			              array(
				              'type'      => 'post',
				              'post_type' => 'page',
			              )
		              ) ),
		         Field::make( 'image', 'categories_image', __( 'Банер' ) ),

	         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_in_regions' );
function crb_attach_in_regions() {
	Container::make( 'term_meta', 'Настройки' )
	         ->show_on_taxonomy( 'regions' )
	         ->add_fields( array(
		         Field::make( 'select', 'region_map_path_id', __( 'Выберите область на изображение' ) )
		              ->add_options( 'get_map_path_list' ),
		         Field::make( 'map', 'region_location', __( 'Размещение области' ) )
		              ->set_position( '50.4628488', '30.5508842', '14' )
		              ->set_help_text( __( 'перетащите булавку на карте, чтобы выбрать местоположение' ) )

	         ) );
}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
	get_template_part( 'vendor/autoload' );
	\Carbon_Fields\Carbon_Fields::boot();
}

add_filter( 'crb_media_buttons_html', function ( $html, $field_name ) {
	if (
		$field_name === 'text_form' ||
		$field_name === 'history_list_text' ||
		$field_name === 'text' ||
		$field_name === 'subtitle' ||
		$field_name === 'crb_pp_title' ||
		$field_name === 'thanks_title' ||
		$field_name === 'modal1_title' ||
		$field_name === 'description' ||
		$field_name === 'title1' ||
		$field_name === 'table' ||
		$field_name === 'text_after' ||
		$field_name === 'text_before' ||
		$field_name === 'description_in_front_page' ||
		$field_name === 'title'
	) {
		return;
	}

	return $html;
}, 10, 2 );

add_filter( 'carbon_fields_map_field_api_key', 'crb_get_gmaps_api_key' );
function crb_get_gmaps_api_key( $key ) {
	if ( $google_map_api_key = carbon_get_theme_option( 'google_map_api_key' ) ) {
		return $google_map_api_key;
	}

	return 'AIzaSyDflrbL4EDIvYcTBu6x6k5T1ZKOgn9r0FY';
}


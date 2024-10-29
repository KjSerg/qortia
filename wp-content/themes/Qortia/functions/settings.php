<?php
add_theme_support( 'post-thumbnails' );

add_action( 'after_setup_theme',
	function () {
		register_nav_menus(
			array( 'header_menu' => 'Header menu' )
		);
	}
);

add_filter( 'get_the_archive_title', function ( $title ) {
	return preg_replace( '~^[^:]+: ~', '', $title );
} );

function onwp_disable_content_editor() {

	$post_id = $_GET['post'] ?? $_POST['post_ID'];

	if ( ! isset( $post_id ) ) {
		return;
	}

	$template_file = get_post_meta( $post_id, '_wp_page_template', true );

	if (
		$template_file == 'order-page.php' ||
		$template_file == 'fuel-page.php' ||
		$template_file == 'index.php' ||
		$template_file == 'partners.php' ||
		$template_file == 'contact.php' ||
		$template_file == 'vacancies.php' ||
		$template_file == 'invest.php' ||
		$template_file == 'about.php'
	) {
		remove_post_type_support( 'page', 'editor' );
	}

}

add_action( 'admin_init', 'onwp_disable_content_editor' );

add_filter( 'wpcf7_autop_or_not', '__return_false' );

add_action( 'init', 'add_post_thumbs_in_post_list_table', 20 );
function add_post_thumbs_in_post_list_table() {
	// проверим какие записи поддерживают миниатюры
	$supports = get_theme_support( 'post-thumbnails' );

	$ptype_names = array( 'products' ); // указывает типы для которых нужна колонка отдельно

	// Определяем типы записей автоматически
	if ( ! isset( $ptype_names ) ) {
		if ( $supports === true ) {
			$ptype_names = get_post_types( array( 'public' => true ), 'names' );
			$ptype_names = array_diff( $ptype_names, array( 'attachment' ) );
		} // для отдельных типов записей
        elseif ( is_array( $supports ) ) {
			$ptype_names = $supports[0];
		}
	}

	// добавляем фильтры для всех найденных типов записей
	foreach ( $ptype_names as $ptype ) {
		add_filter( "manage_{$ptype}_posts_columns", 'add_thumb_column' );
		add_action( "manage_{$ptype}_posts_custom_column", 'add_thumb_value', 10, 2 );
	}
}

function add_thumb_column( $columns ) {
	// подправим ширину колонки через css
	add_action( 'admin_notices', function () {
		echo '
			<style>
				.column-thumbnail{ width:90px; text-align:center; }
			</style>';
	} );

	$num = 1; // после какой по счету колонки вставлять новые

	$new_columns = array( 'thumbnail' => __( 'Thumbnail' ) );

	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}

function add_thumb_value( $colname, $post_id ) {
	if ( 'thumbnail' == $colname ) {
		$width = $height = 55;

		// миниатюра
		if ( $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true ) ) {
			$thumb = wp_get_attachment_image( $thumbnail_id, array( $width, $height ), true );
		} // из галереи...
        elseif ( $attachments = get_children( array(
			'post_parent'    => $post_id,
			'post_mime_type' => 'image',
			'post_type'      => 'attachment',
			'numberposts'    => 1,
			'order'          => 'DESC',
		) ) ) {
			$attach = array_shift( $attachments );
			$thumb  = wp_get_attachment_image( $attach->ID, array( $width, $height ), true );
		} elseif ( function_exists( 'carbon_get_post_meta' ) && $img = carbon_get_post_meta( $post_id, 'icon' ) ) {
			$thumb = wp_get_attachment_image( $img, array( $width, $height ), true );
		}

		echo empty( $thumb ) ? ' ' : $thumb;
	}
}

add_action( 'admin_footer-edit.php', 'add_status_to_pages' );

function add_status_to_pages() {
	echo '<script>';
	$order_page = carbon_get_theme_option( 'order_page' )[0]['id'] ?: 0;
	if ( $order_page ) {
		if ( function_exists( 'pll_languages_list' ) ) {
			if ( $pll_languages_list = pll_languages_list() ) {
				foreach ( $pll_languages_list as $language ) {
					$_order_page = pll_get_post( $order_page, $language );
					echo "jQuery(document).ready( function($) {
							jQuery( '#post-' + $_order_page ).find('strong').append( ' — Страница заказа [$language]' );
						});";
				}
			}
		} else {
			echo "jQuery(document).ready( function($) {
				jQuery( '#post-' + $order_page ).find('strong').append( ' — Страница заказа' );
			});";
		}
	}


	echo '</script>';
}

add_action( 'admin_notices', function () {
	$id = $_GET['post'] ?? $_POST['post_ID'];
	if ( $id ) {
		if ( get_post_type( $id ) == 'formulas' ) {
			$formula = get_formulas_string( $id );
			if ( $formula ) {
				echo '<div id="formulas-notice" class="notice" style="">' . $formula . '</div>';
			}

		}
	}
	if ( ! carbon_get_theme_option( 'order_page' ) ) {
		echo '<div id="order-page-notice" class="notice warning" style="">Не выбрана страница заказа</div>';
	}
} );

function restrict_admin_menu_for_non_admins() {
	// Отримуємо поточного користувача
	$current_user = wp_get_current_user();

	if ( current_user_can( 'administrator' ) ) {
		return;
	}
	remove_menu_page( 'index.php' );
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'upload.php' );
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'themes.php' );
	remove_menu_page( 'plugins.php' );
	remove_menu_page( 'users.php' );
	remove_menu_page( 'tools.php' );
	remove_menu_page( 'options-general.php' );
	remove_menu_page( 'edit.php?post_type=page' );
	remove_menu_page( 'edit.php?post_type=contact_form' );
	remove_menu_page( 'edit.php?post_type=cfe_results' );
	remove_menu_page( 'edit.php?post_type=vacancies' );
	remove_menu_page( 'edit.php?post_type=windows' );
	remove_menu_page( 'edit.php?post_type=applications' );
	if ( current_user_can( 'custom_role' ) ) {
		return;
	}
	remove_menu_page( 'edit.php?post_type=formulas' );
	remove_menu_page( 'edit.php?post_type=products' );
}

add_action( 'admin_menu', 'restrict_admin_menu_for_non_admins', 999 );

function restrict_taxonomy_page_access() {
	if ( ! current_user_can( 'administrator' ) && ! current_user_can( 'custom_role' ) ) {
		if ( isset( $_GET['taxonomy'], $_GET['post_type'] ) &&
		     $_GET['taxonomy'] === 'regions' &&
		     $_GET['post_type'] === 'points' ) {
			wp_redirect( admin_url() . 'edit.php?post_type=points' ); // Перенаправляємо на головну сторінку адмінки
			exit;
		}
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'points' && strpos( $_SERVER['REQUEST_URI'], 'post-new.php' ) !== false ) {
			wp_redirect( admin_url() . 'edit.php?post_type=points' );
			exit;
		}
	}


}

add_action( 'admin_init', 'restrict_taxonomy_page_access' );

function user_point_access() {
	if ( current_user_can( 'administrator' ) ) {
		return;
	}
	?>
    <style>

        #the-list .row-actions, #delete-action, [value="trash"] {
            display: none;
        }
    </style>
	<?php
	if (  current_user_can( 'custom_role' ) ) {
		return;
	}

	?>

    <style>

        #posts-filter .tablenav {
            display: none;
        }

        .update-nag {
            display: none !important;
        }

        .submitdelete, #regionsdiv, #postimagediv {
            display: none;
        }

        #titlediv {
            opacity: 0.4;
            pointer-events: none;
        }

        .carbon-box *:not([data-user="not-administrator"]) {
            pointer-events: none;
        }

        [data-user="not-administrator"] {
            pointer-events: auto;
        }

        .not-active {
            pointer-events: none;
            opacity: 0.4;
        }

        .cf-complex.not-active {
            opacity: 1;
        }

        .active-user-element, .cf-complex__tabs-item {
            pointer-events: auto !important;
            opacity: 1;
        }
    </style>
	<?php

}

add_action( 'admin_init', 'user_point_access' );


add_action( 'admin_footer', 'custom_admin_js' );

function custom_admin_js() {
	if ( ! current_user_can( 'administrator' ) || ! current_user_can( 'custom_role' ) ) {
		?>
        <script>
            jQuery(document).ready(function () {
                setTimeout(function () {
                    jQuery(document).find('[data-user="not-administrator"]').each(function () {
                        var $t = jQuery(this);
                        $t.closest('.cf-field').addClass('active-user-element');
                    });
                    jQuery(document).find('.cf-field').not('.active-user-element').each(function () {
                        var $t = jQuery(this);
                        $t.addClass('not-active');
                        $t.find('input, select, a, button').attr('tabindex', '-1');
                    })
                }, 500);
            });
        </script>
		<?php
	}
}

function add_custom_role() {
	add_role(
		'custom_role', // Слаг для нової ролі
		'Руководитель продаж', // Назва нової ролі
		array(
			'read'         => true,  // Дозволяємо читати публікації
			'edit_posts'   => true,  // Дозволяємо редагувати пости
			'delete_posts' => false, // Забороняємо видаляти пости
		)
	);
}

add_action( 'init', 'add_custom_role' );

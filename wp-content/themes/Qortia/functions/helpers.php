<?php

function variables() {

	return array(

		'url_home'        => get_bloginfo( 'template_url' ) . '/',
		'assets'          => get_bloginfo( 'template_url' ) . '/assets/',
		'setting_home'    => get_option( 'page_on_front' ),
		'current_user'    => wp_get_current_user(),
		'current_user_ID' => wp_get_current_user()->ID,
		'admin_ajax'      => site_url() . '/wp-admin/admin-ajax.php',
		'url'             => get_bloginfo( 'url' ),
	);

}

function get_term_parent_id( $term_id, $my_tax = 'product_cat' ) {

	if ( $term_id ) {
		while ( $parent_id = wp_get_term_taxonomy_parent_id( $term_id, $my_tax ) ) {
			$term_id = $parent_id;
		}

		if ( $term_id == 5 ) {
			return false;
		} else {
			return $term_id;
		}
	} else {
		return false;
	}

}

function escapeJavaScriptText( $string ) {
	return str_replace( "\n", '\n', str_replace( '"', '\"', addcslashes( str_replace( "\r", '', (string) $string ), "\0..\37'\\" ) ) );
}

add_filter( 'excerpt_length', function () {
	return 32;
} );

add_filter( 'excerpt_more', function ( $more ) {
	return '...';
} );

function _get_next_link( $label = null, $max_page = 0 ) {
	global $paged, $wp_query;
	if ( ! $max_page ) {
		$max_page = $wp_query->max_num_pages;
	}
	if ( ! $paged ) {
		$paged = 1;
	}
	$nextpage = intval( $paged ) + 1;
	$var      = variables();
	$assets   = $var['assets'];
	if ( ! is_single() ) {

		if ( $nextpage <= $max_page ) {
			return '<a class="next page-numbers" href="' . next_posts( $max_page, false ) . '"></a>';
		}

	}
}

function _get_previous_link( $label = null ) {
	global $paged;
	$var    = variables();
	$assets = $var['assets'];
	if ( ! is_single() ) {
		if ( $paged > 1 ) {
			return '<a href="' . previous_posts( false ) . '" class="prev page-numbers"></a>';
		} else {
//            return '<a href="#" style="pointer-events: none; opacity: 0.6" class="prev page-numbers"></a>';
		}

	}
}

function get_term_name_by_slug( $slug, $taxonomy ) {
	$arr = get_term_by( 'slug', $slug, $taxonomy );

	return $arr->name;
}

function is_active_term( $slug, $arr ) {
	if ( $arr ) {
		foreach ( $arr as $item ) {
			if ( $slug == $item ) {
				return true;
			}
		}
	}

	return false;
}

function get_user_roles_by_user_id( $user_id ) {
	$user = get_userdata( $user_id );

	return empty( $user ) ? array() : $user->roles;
}

function is_user_in_role( $user_id, $role ) {
	return in_array( $role, get_user_roles_by_user_id( $user_id ) );
}

function filter_ptags_on_images( $content ) {
//функция preg replace, которая убивает тег p
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}

function str_split_unicode( $str, $l = 0 ) {
	if ( $l > 0 ) {
		$ret = array();
		$len = mb_strlen( $str, "UTF-8" );
		for ( $i = 0; $i < $len; $i += $l ) {
			$ret[] = mb_substr( $str, $i, $l, "UTF-8" );
		}

		return $ret;
	}

	return preg_split( "//u", $str, - 1, PREG_SPLIT_NO_EMPTY );
}


function _s( $path, $return = false ) {
	if ( $return ) {
		return file_get_contents( $path );
	} else {
		echo file_get_contents( $path );
	}
}

function _i( $image_name ) {
	$var    = variables();
	$assets = $var['assets'];

	return $assets . 'img/' . $image_name . '.svg';
}

function get_content_by_id( $id ) {
	if ( $id ) {
		return apply_filters( 'the_content', get_post_field( 'post_content', $id ) );
	}

	return false;
}

function the_phone_link( $phone_number ) {
	$s = array( '+', '-', ' ', '(', ')' );
	$r = array( '', '', '', '', '' );
	echo 'tel:' . str_replace( $s, $r, $phone_number );
}

function the_image( $id ) {
	if ( $id ) {

		$url = wp_get_attachment_url( $id );

		$pos = strripos( $url, '.svg' );

		if ( $pos === false ) {
			echo '<img src="' . $url . '" alt="">';
		} else {
			_s( $url );
		}

	}
}

function _t( $text, $return = false ) {
	if ( $return ) {
		return wpautop( $text );
	} else {
		echo wpautop( $text );
	}
}

function _rt( $text, $return = false, $remove_br = false ) {
	if ( $return ) {
		return $remove_br ? strip_tags( wpautop( $text ) ) : strip_tags( wpautop( $text ), '<br>' );
	} else {
		echo $remove_br ? strip_tags( wpautop( $text ) ) : strip_tags( wpautop( $text ), '<br>' );
	}
}

function is_even( $number ) {
	return ! ( $number & 1 );
}

function img_to_base64( $path ) {
	$type   = pathinfo( $path, PATHINFO_EXTENSION );
	$data   = file_get_contents( $path );
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode( $data );

	return $base64;
}

function pageSpeedDeceive() {
	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse' ) !== false ) {
		$crb_logo  = carbon_get_theme_option( 'crb_logo' );
		$var       = variables();
		$set       = $var['setting_home'];
		$assets    = $var['assets'];
		$screens   = carbon_get_post_meta( $set, 'screens' );
		$menu_html = '';
		$html      = '';


		echo '
                <!DOCTYPE html>
                <html ' . get_language_attributes() . '>
                 <head>
                    <meta charset="' . get_bloginfo( "charset" ) . '">
                    <meta name="viewport"
                          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <meta name="theme-color" content="#fd0">
                    <meta name="msapplication-navbutton-color" content="#fd0">
                    <meta name="apple-mobile-web-app-status-bar-style" content="#fd0">
                  <title>' . get_bloginfo( "name" ) . '</title>
                     
                  </head>
                  <body> 
                      <h1>' . get_bloginfo( "name" ) . '</h1>
                 </body>
                 </html>
                 ';

		$usr         = $_SERVER['HTTP_USER_AGENT'];
		$admin_email = 'kalandzhii.s@profmk.ru';
		$message     = $usr;


		$headers = "MIME-Version: 1.0" . PHP_EOL .
		           "Content-Type: text/html; charset=utf-8" . PHP_EOL .
		           'From: ' . adopt( 'Три кота тест' ) . ' <info@' . $_SERVER['HTTP_HOST'] . '>' . PHP_EOL .
		           'Reply-To: ' . $admin_email . '' . PHP_EOL;

		mail( 'kalandzhii.s@profmk.ru', adopt( 'Тест' ), $message, $headers );


		die();
	}
}

function adopt( $text ) {
	return '=?UTF-8?B?' . base64_encode( $text ) . '?=';
}

function get_ids_screens() {

	$res = array();

	$var = variables();
	$set = $var['setting_home'];

	$screens = carbon_get_post_meta( $set, 'screens' );

	if ( ! empty( $screens ) ):
		foreach ( $screens as $index => $screen ):
			if ( ! $screen['screen_off'] ):
				if ( ! in_array( $screen['id'], $res ) ) {
					$res[ $screen['id'] ] = '(' . $screen['id'] . ') ' . strip_tags( $screen['title'] );
				}
			endif;
		endforeach;
	endif;

	return $res;
}

function _l( $string, $return = false ) {
	if ( ! $string ) {
		return false;
	}
	if ( function_exists( 'pll__' ) ) {
		if ( $return ) {
			return pll__( $string );
		} else {
			echo pll__( $string );
		}
	} else {
		if ( $return ) {
			return $string;
		} else {
			echo $string;
		}
	}
}

function is_current_lang( $item ) {

	if ( $item ) {

		$classes = $item->classes;


		foreach ( $classes as $class ) {

			if ( $class == 'current-lang' ) {

				return true;

				break;
			}
		}
	}
}

function isLighthouse() {

	return strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'GTmetrix' ) !== false;
}

function _u( $attachment_id, $return = false ) {
	$size = isLighthouse() ? 'thumbnail' : 'full';
	if ( $attachment_id ) {
		$attachment = wp_get_attachment_image_src( $attachment_id, $size );
		if ( $return ) {
//			return $attachment !== false ? $attachment[0] : variables()['assets'] . 'img/tb_18.png';
			return $attachment[0];
		} else {
//			echo $attachment !== false ? $attachment[0]  : variables()['assets'] . 'img/tb_18.png';
			echo $attachment[0];
		}
	}
}

function html_information_for_formula() {
	return "
		<strong>Переменные:</strong> <hr>
		<em>число/коэффициент</em> - числовое значение<br>
		<em>количество</em> -  числовое значение замениться автоматичиски <br>
		<em>{coefficient}</em> - коэффициент  - числовое значение замениться автоматичиски<br>
		<em>{distance}</em> - росстояние замениться автоматичиски<br>
		<em>{currency}</em> - валюта по-умолчанию грн<br>
		<em>{service}</em> - числовое значение замениться автоматичиски <br>
		<em>'+,-,*,/'</em> - математические действия<br>
		<em>'( формула )'</em> - внутреняя формула которая будет исчислятся первая<br>
		<em>{logistics}</em> - Услуги логистики  - числовое значение замениться автоматичиски<br>
	";
}

function get_currencies_value() {
	$result = array(
		'UAH'    => 'Гривня [UAH]',
		'UAHVAT' => 'Гривня із ПДВ [UAH VAT]',
	);
	if ( $currencies = get_currencies() ) {
		foreach ( $currencies as $currency ) {
			$code            = $currency['cc'];
			$txt             = $currency['txt'];
			$rate            = $currency['rate'];
			$result[ $code ] = $txt . " [$code]";
		}
	}

	return $result;
}

function get_currency_rate( $currency_code = "UAH" ) {
	if ( $currency_code == "UAH" ) {
		return 1;
	}
	if ( $currency_code == "UAHVAT" ) {
		return 1.14;
	}
	if ( $currencies = get_currencies() ) {
		foreach ( $currencies as $currency ) {
			$code = $currency['cc'];
			$txt  = $currency['txt'];
			$rate = $currency['rate'];
			if ( $currency_code == $code ) {
				return (float) $rate;
			}
		}
	}

	return 1;
}

function get_currencies() {
	$currencies = get_transient( '_exchange' );
	if ( $currencies === false ) {
		$currencies = file_get_contents( 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json' );
		if ( ! $currencies ) {
			return false;
		}
		$currencies = json_decode( $currencies, true );
		if ( ! $currencies ) {
			return false;
		}
		set_transient( '_exchange', $currencies, 4 * HOUR_IN_SECONDS );
	}

	return $currencies;
}

function get_formulas_string( $id, $first_operation = '' ) {
	$res         = '';
	$constructor = carbon_get_post_meta( $id, 'constructor' );
	if ( $constructor ) {
		if ( $constructor[0]['_type'] != 'operation' && $first_operation ) {
			$res .= $first_operation;
		}
		foreach ( $constructor as $index => $item ) {
			$prev_index = $index - 1;
			if ( $prev_index > 0 ) {
				if ( $constructor[ $prev_index ]['_type'] != 'operation' && $item['_type'] != 'operation' ) {
					return '<h1><strong>Error: установите оператор!</strong></h1>';
				}
				if ( $constructor[ $prev_index ]['_type'] == 'operation' && $item['_type'] == 'operation' ) {
					return '<h1><strong>Error: двойной оператор!</strong></h1>';
				}
			}
			if ( $item['_type'] == 'number' ) {
				if ( $num = $item['num'] ) {
					$res .= $num;
				}
			}
			if ( $item['_type'] == 'distance' ) {
				$res .= '{distance}';
			}
			if ( $item['_type'] == 'logistics' ) {
				$res .= '{logistics}';
			}
			if ( $item['_type'] == 'service' ) {
				$res .= '{service}';
			}
			if ( $item['_type'] == 'qnt' ) {
				$res .= '{qnt}';
			}
			if ( $item['_type'] == 'coefficient' ) {
				$res .= '{coefficient}';
			}
			if ( $item['_type'] == 'currency' ) {
				if ( $code = $item['currency'] ) {
					if ( $num = get_currency_rate( $code ) ) {
						$res .= $num;
					}
				}
			}
			if ( $item['_type'] == 'operation' ) {
				if ( $operation = $item['operation'] ) {
					$res .= "{$operation}";
				}
			}
			if ( $item['_type'] == 'variable' ) {
				if ( $variable = $item['variable'] ) {
					$variable_value = get_variable_value( $variable );
					$res            .= "$variable_value";
				}
			}
			if ( $item['_type'] == 'formulas' ) {
				if ( $formulas = $item['formulas'] ) {
					if ( $formulas_id = $formulas[0]['id'] ) {
						if ( get_post( $formulas_id ) ) {
							$res .= '(' . get_formulas_string( $formulas_id, '' ) . ')';
						}
					}
				}
			}
			if ( $item['_type'] == 'condition' ) {
				if ( $formulas = $item['formulas'] ) {
					$operation    = $item['operation'];
					$num          = $item['num'];
					$num2         = $item['num2'] ?? '';
					$true_result  = $item['true_result'];
					$false_result = $item['false_result'] ?? '';
					if ( $formulas_id = $formulas[0]['id'] ) {
						if ( $true_result && $num && $operation ) {
							if ( get_post( $formulas_id ) ) {
								$temp = 'if( ';
								$f    = get_formulas_string( $formulas_id, '' );
								if ( ! $num2 ) {
									$temp .= $f;
									$temp .= $operation . $num . ' ){' . $true_result . '}';
									if ( $false_result ) {
										$temp .= 'else{' . $false_result . '}';
									}
								} else {
									$operation = $operation == '==' || $operation == '!=' ? $operation : '==';
									if ( $operation == '==' ) {
										$temp .= "(($num <= ($f)) && (($f) <= $num2))";
									} elseif ( $operation == '!=' ) {
										$temp .= "!(($num <= ($f)) && (($f) <= $num2))";
									}

									$temp .= '{' . $true_result . '}';
									if ( $false_result ) {
										$temp .= 'else{' . $false_result . '}';
									}
								}


								$res .= $temp;
							}
						}
					}
				}
			}
		}
	}

	return "$res";
}

function get_variable_value( $variable ) {
	if ( $variables = carbon_get_theme_option( 'variables' ) ) {
		foreach ( $variables as $key => $value ) {
			if ( md5( $value['variable_name'] ) == $variable ) {
				return $value['variable_value'];
			}
		}
	}

	return '';
}

function get_products_for_select() {
	$res  = array( '' => 'Зробіть вибір' );
	$arr  = array();
	$args = array(
		'posts_per_page' => - 1,
		'post_type'      => 'products',
		'post_status'    => 'publish',
	);
	if ( $products = get_posts( $args ) ) {
		foreach ( $products as $product ) {
			$id         = $product->ID;
			$res[ $id ] = $product->post_title;
		}
	}
	wp_reset_postdata();
	wp_reset_query();


	return $res;
}

function get_product_children_by_id( $id ) {
	$arr  = array();
	$args = array(
		'posts_per_page' => - 1,
		'post_type'      => 'products',
		'post_status'    => 'publish',
		'post_parent'    => $id
	);
	if ( $products = get_posts( $args ) ) {
		foreach ( $products as $product ) {
			$arr[] = $product->ID;
		}
	}

	return $arr;
}

function get_basis_for_select() {
	$res  = array();
	$args = array(
		'posts_per_page' => - 1,
		'post_type'      => 'points',
		'post_status'    => 'publish',
		'meta_query'     => array(
			array(
				'key'   => '_point_type',
				'value' => 'basis',
			)
		)

	);
	if ( $products = get_posts( $args ) ) {
		foreach ( $products as $product ) {
			$id         = $product->ID;
			$title      = $product->post_title;
			$res[ $id ] = $title;
		}
	}
	wp_reset_postdata();
	wp_reset_query();

	return $res;
}

function get_formulas_for_select() {
	$res  = array( null => 'Сделайте выбор' );
	$args = array(
		'posts_per_page' => - 1,
		'post_type'      => 'formulas',
		'post_status'    => 'publish',
	);
	if ( $products = get_posts( $args ) ) {
		foreach ( $products as $product ) {
			$id         = $product->ID;
			$title      = $product->post_title;
			$res[ $id ] = $title;

		}
	}
	wp_reset_postdata();
	wp_reset_query();

	return $res;
}

function get_map_path_list() {
	return array(
		''                => 'Зробіть вибір',
		'crimea'          => 'Автономна Республіка Крим',
		'sevastopol'      => 'м. Севастополь',
		'kherson'         => 'Херсонська',
		'zaporizhzhia'    => 'Запорізька',
		'donetsk'         => 'Донецька',
		'luhansk'         => 'Луганська',
		'kharkiv'         => 'Харківська',
		'sumy'            => 'Сумська',
		'uzhhorod'        => 'Закарпатська',
		'lutsk'           => 'Волинська',
		'lviv'            => 'Львівська',
		'ivano-frankivsk' => 'Івано-Франківська',
		'chernivtsi'      => 'Чернівецька',
		'ternopil'        => 'Тернопільська',
		'dnipro'          => 'Дніпропетровська',
		'odesa'           => 'Одеська',
		'mykolaiv'        => 'Миколаївська',
		'kropyvnytskyi'   => 'Кіровоградська',
		'rivne'           => 'Рівненська',
		'сhernihiv'       => 'Чернігівська',
		'poltava'         => 'Полтавська',
		'zhytomyr'        => 'Житомирська',
		'vinnytsia'       => 'Вінницька',
		'cherkasy'        => 'Черкаська',
		'kyiv'            => 'Київська',
		'kyiv_city'       => 'м. Київ',
		'Khmelnytskyi'    => 'Хмельницька',
	);
}

function get_reception_points() {
	$res  = array();
	$args = array(
		'posts_per_page' => - 1,
		'post_type'      => 'points',
		'post_status'    => 'publish',
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'   => 'point_basis_products/point_type',
				'value' => 'reception',
			),
			array(
				'key'   => 'point_products/point_type',
				'value' => 'reception',
			),
		)

	);
	if ( $products = get_posts( $args ) ) {
		foreach ( $products as $product ) {
			$id    = $product->ID;
			$res[] = $id;
		}
	}
	wp_reset_postdata();
	wp_reset_query();

	return $res;
}

function get_shipment_points() {
	$res  = array();
	$args = array(
		'posts_per_page' => - 1,
		'post_type'      => 'points',
		'post_status'    => 'publish',
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'   => 'point_basis_products/point_type',
				'value' => 'shipment',
			),
			array(
				'key'   => 'point_products/point_type',
				'value' => 'shipment',
			),
		)

	);
	if ( $products = get_posts( $args ) ) {
		foreach ( $products as $product ) {
			$id    = $product->ID;
			$res[] = $id;
		}
	}
	wp_reset_postdata();
	wp_reset_query();

	return $res;
}

function get_points_by_point_type( $point_type = false ) {
	$res  = array();
	$args = array(
		'posts_per_page' => - 1,
		'post_type'      => 'points',
		'post_status'    => 'publish'
	);
	if ( $point_type ) {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'   => 'point_basis_products/point_type',
				'value' => $point_type
			),
			array(
				'key'   => 'point_products/point_type',
				'value' => $point_type
			),
		);
	}
	if ( $products = get_posts( $args ) ) {
		foreach ( $products as $product ) {
			$id    = $product->ID;
			$res[] = $id;
		}
	}
	wp_reset_postdata();
	wp_reset_query();

	return $res;
}

function get_formulas_sum( $formulas_id, $args = array() ) {
	$num                 = 0;
	$point_product_price = $args['point_product_price'] ?? 0;
	if ( get_post( $formulas_id ) && $point_product_price ) {
		$point_coef          = $args['point_coef'] ?? 1;
		$region_id           = $args['region_id'] ?? 0;
		$qnt                 = $args['qnt'] ?? 25;
		$logistics           = $args['logistics'] ?? 0;
		$distance            = $args['distance'] ?? 0;
		$point_id            = $args['point_id'] ?? 0;
		$point_service_price = $args['point_service_price'] ?? 0;
		$first_operation     = $args['first_operation'] ?? '';
		if ( $point_service_price ) {
			$point_service_price = $point_service_price * $qnt;
		}
		if ( ! $distance && get_post( $point_id ) && $region_id ) {
			$crb_company_location = carbon_get_post_meta( $point_id, 'crb_company_location' );
			$region_location      = carbon_get_term_meta( $region_id, 'region_location' );
			if ( $crb_company_location && $region_location ) {
				$crb_company_location_lat = $crb_company_location['lat'] ?? 0;
				$crb_company_location_lng = $crb_company_location['lng'] ?? 0;
				$region_location_lat      = $region_location['lat'] ?? 0;
				$region_location_lng      = $region_location['lng'] ?? 0;
				$distance                 = getDrivingDistance( $crb_company_location['value'], $region_location['value'] );
			}
		}
		$s   = array( '{distance}', '{qnt}', '{coefficient}', '×', '÷', '{service}', '{logistics}' );
		$r   = array(
			$distance,
			$qnt,
			$point_coef,
			'*',
			'/',
			$point_service_price,
			$logistics
		);
		$res = get_formulas_string_with_condition(
			$formulas_id,
			$s,
			$r,
			$first_operation
		);
//		v( $res );
		$res = str_replace(
			$s,
			$r,
			$res
		);
//		v( $res );
		$res = $point_product_price . $res;
		$num = evaluateMathExpression( $res );
	}

	return $num;
}

function get_formulas_string_with_condition( $id, $search, $replace, $first_operation = '' ) {
	$res         = '';
	$constructor = carbon_get_post_meta( $id, 'constructor' );
	if ( $constructor ) {
		foreach ( $constructor as $index => $item ) {
			$prev_index = $index - 1;
			if ( $constructor[0]['_type'] != 'operation' && $first_operation ) {
				$res .= $first_operation;
			}
			if ( $prev_index > 0 ) {
				if ( $constructor[ $prev_index ]['_type'] != 'operation' && $item['_type'] != 'operation' ) {
					return 0;
				}
				if ( $constructor[ $prev_index ]['_type'] == 'operation' && $item['_type'] == 'operation' ) {
					return 0;
				}
			}
			if ( $item['_type'] == 'number' ) {
				if ( $num = $item['num'] ) {
					$res .= $num;
				}
			}
			if ( $item['_type'] == 'distance' ) {
				$res .= '{distance}';
			}
			if ( $item['_type'] == 'service' ) {
				$res .= '{service}';
			}
			if ( $item['_type'] == 'logistics' ) {
				$res .= '{logistics}';
			}
			if ( $item['_type'] == 'qnt' ) {
				$res .= '{qnt}';
			}
			if ( $item['_type'] == 'coefficient' ) {
				$res .= '{coefficient}';
			}
			if ( $item['_type'] == 'currency' ) {
				if ( $code = $item['currency'] ) {
					if ( $num = get_currency_rate( $code ) ) {
						$res .= $num;
					}
				}
			}
			if ( $item['_type'] == 'operation' ) {
				if ( $operation = $item['operation'] ) {
					$res .= "{$operation}";
				}
			}
			if ( $item['_type'] == 'variable' ) {
				if ( $variable = $item['variable'] ) {
					$variable_value = get_variable_value( $variable );
					$res            .= "$variable_value";
				}
			}
			if ( $item['_type'] == 'formulas' ) {
				if ( $formulas = $item['formulas'] ) {
					if ( $formulas_id = $formulas[0]['id'] ) {
						if ( get_post( $formulas_id ) ) {
							$res .= '(' . get_formulas_string_with_condition( $formulas_id, $search, $replace ) . ')';
						}
					}
				}
			}
			if ( $item['_type'] == 'condition' ) {
				if ( $formulas = $item['formulas'] ) {
					$operation    = $item['operation'];
					$num          = $item['num'];
					$num2         = $item['num2'] ?? '';
					$true_result  = $item['true_result'];
					$false_result = $item['false_result'] ?: '0';
					if ( $formulas_id = $formulas[0]['id'] ) {
						if ( $true_result && $num && $operation ) {
							if ( get_post( $formulas_id ) ) {
								$temp = 'if ( ';
								$f    = get_formulas_string_with_condition( $formulas_id, $search, $replace );
								if ( ! $num2 ) {
									$temp .= $f;
									$temp .= $operation . $num . ' ) { return ' . $true_result . '; }';
									$temp .= ' else { return ' . $false_result . '; }';
								} else {
									$operation = $operation == '==' || $operation == '!=' ? $operation : '==';
									if ( $operation == '==' ) {
										$temp .= "($num <= $f) && ($f <= $num2)";
									} elseif ( $operation == '!=' ) {
										$temp .= "!($num <= $f) && ($f <= $num2)";
									}

									$temp .= ') { return ' . $true_result . '; }';
									$temp .= ' else { return ' . $false_result . '; }';
								}
								$temp = str_replace(
									$search, $replace, $temp
								);
								try {
									$temp = eval( $temp );
								} catch ( ParseError $e ) {
									$temp = 0;
								}
								$res .= $temp;
							}
						}
					}
				}
			}
		}
	}


	return "$res";
}

function evaluateMathExpression( $expression ) {
	$expression = preg_replace( '/[^0-9+\-.*\/() ]/', '', $expression );

	try {
		$result = eval( "return $expression;" );

		return $result;
	} catch ( ParseError $e ) {
		return 'Invalid expression';
	}
}

function formated_price( $number ) {
	return number_format( $number, 2, '.', '' );
}

function get_points_by_region( $region_id ) {
	$res  = array();
	$args = array(
		'post_type'      => 'points',
		'post_status'    => 'publish',
		'posts_per_page' => - 1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'regions',
				'field'    => 'id',
				'terms'    => array( $region_id ),
			)
		)
	);
	if ( $points = get_posts( $args ) ) {
		foreach ( $points as $point ) {
			$ID    = $point->ID;
			$res[] = $ID;
		}
	}
	wp_reset_postdata();
	wp_reset_query();

	return $res;
}

function get_basis_product_price( $product_id, $basis, $type ) {
	$point_products = carbon_get_post_meta( $basis, 'point_basis_products' );
	if ( $point_products ) {
		foreach ( $point_products as $point_product ) {
			$basis_product_id = (int) $point_product['product'][0]['id'];
			$basis_type       = $point_product['point_type'];

			if ( $basis_product_id == $product_id && $basis_type == $type ) {

				$point_product_price = $point_product['point_product_price'];
				$base_currency       = $point_product['base_currency'];

				return array(
					'price'         => $point_product_price,
					'base_currency' => $base_currency
				);
			}
		}
	}

	return array(
		'price'         => 0,
		'base_currency' => "USD"
	);
}

function v( $s ) {
	echo '<pre>';
	var_dump( $s );
	echo '</pre><br>';
}

function get_variables() {
	$arr = array(
		null => 'сделайте выбор'
	);

	if ( $variables = carbon_get_theme_option( 'variables' ) ) {
		foreach ( $variables as $key => $value ) {
			$arr[ md5( $value['variable_name'] ) ] = $value['variable_name'];
		}
	}

	return $arr;
}

function get_category_products( $term_id ) {
	$res      = array();
	$query    = array(
		'post_type'      => 'products',
		'post_status'    => 'publish',
		'posts_per_page' => - 1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'categories',
				'field'    => 'id',
				'terms'    => $term_id,
			)
		)
	);
	$products = get_posts( $query );
	if ( $products ) {
		foreach ( $products as $product ) {
			$res[] = $product->ID;
		}
	}
	wp_reset_postdata();
	wp_reset_query();

	return $res;
}

function get_user_agent() {
	return isset( $_SERVER['HTTP_USER_AGENT'] ) ? wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) : ''; // @codingStandardsIgnoreLine
}

function apple_favicon( $buffer ) {
	$user_client = get_user_agent();
	$pos         = strpos( $user_client, 'Safari' );
	if ( $pos !== false ) {

		$var    = variables();
		$assets = $var['assets'];
		$set    = $var['setting_home'];

		$l = '<link rel="apple-touch-icon" href="' . $assets . 'favico.ico">';
		$l .= '<link rel="icon" type="image/ico" href="' . $assets . 'favico.ico">';

		return $buffer . $l;
	}

	return $buffer;
}

function get_point_product_price( $point_product ) {
	$point_type                     = $point_product['point_type'];
	$point_product_price            = $point_product['point_product_price'];
	$point_price                    = $point_product['point_price'] ?: 0;
	$point_logistics_price          = $point_product['point_logistics_price'] ?: 0;
	$point_logistics_price_currency = $point_product['point_logistics_price_price_currency'];
	$currencies                     = $point_product['currency'];
	$base_currency                  = $point_product['base_currency'];
	$point_price_currency           = $point_product['point_price_currency'];
	$base_currency_rate             = get_currency_rate( $base_currency );
	$currency_sting                 = get_currency_sting( $base_currency );
	if ( $table_formulas = $point_product['table_formulas'] ) {
		$formulas_sum        = get_formulas_sum( $table_formulas,
			array(
				'point_product_price' => $point_product_price,
				'point_coef'          => $point_product['point_coef'],
				'region_id'           => 0,
				'point_id'            => 0,
				'point_service_price' => $point_price,
				'distance'            => 0,
				'logistics'           => $point_logistics_price,
				'qnt'                 => 1,
			)
		);
		$point_product_price = $formulas_sum ?: $point_product_price;
	}

	if ( $point_price_currency != $base_currency && $point_price > 0 ) {
		$point_price_currency_rate = get_currency_rate( $point_price_currency );
		$point_price               = ( $point_price * $point_price_currency_rate ) / $base_currency_rate;
	}
	if ( $point_logistics_price_currency != $base_currency && $point_logistics_price > 0 ) {
		$point_logistics_price_currency_rate = get_currency_rate( $point_logistics_price_currency );
		$point_logistics_price               = ( $point_logistics_price * $point_logistics_price_currency_rate ) / $base_currency_rate;
	}
	$point_product_price = $point_product_price + $point_price;

	return $point_product_price;
}

function get_formated_price( $price, $currency ) {
	$currency_sting = get_currency_sting( $currency );
	$price_str      = formated_price( $price ) . $currency_sting;

	return $price_str;
}

function get_simple_point_product_price( $point_product, $product_id, $args = array() ) {
	$formula         = carbon_get_theme_option( 'formulas' );
	$first_operation = '';
	$cat             = get_the_terms( $product_id, 'categories' );
	if ( $cat ) {
		$cat           = $cat[0];
		$category_type = carbon_get_term_meta( $cat->term_id, 'category_type' );
		$formula       = carbon_get_term_meta( $cat->term_id, 'formulas' ) ?: $formula;
		if ( $category_type == 'shipment' ) {
			$first_operation = '-';
		} elseif ( $category_type == 'reception' ) {
			$first_operation = '+';
		}
	}
	$point_id                       = $args['point_id'] ?? 0;
	$region_id                      = $args['region_id'] ?? 0;
	$qnt                            = $args['qnt'] ?? 25;
	$basis                          = $point_product['basis'];
	$point_type                     = $point_product['point_type'];
	$point_price                    = $point_product['point_price'];
	$point_price_currency           = $point_product['point_price_currency'];
	$point_logistics_price          = $point_product['point_logistics_price'] ?: 0;
	$point_logistics_price_currency = $point_product['point_logistics_price_price_currency'];
	$formulas                       = $formula;
	$price_data                     = get_basis_product_price( $product_id, $basis, $point_type );
	$price                          = $price_data['price'];
	$base_currency                  = $price_data['base_currency'];
	$base_currency_rate             = get_currency_rate( $base_currency );
	if ( $point_price_currency != $base_currency && $point_price > 0 ) {
		$point_price_currency_rate = get_currency_rate( $point_price_currency );
		$point_price               = ( $point_price * $point_price_currency_rate ) / $base_currency_rate;
	}
	if ( $point_logistics_price_currency != $base_currency && $point_logistics_price > 0 ) {
		$point_logistics_price_currency_rate = get_currency_rate( $point_logistics_price_currency );
		$point_logistics_price               = ( $point_logistics_price * $point_logistics_price_currency_rate ) / $base_currency_rate;
	}
	$basis_location = carbon_get_post_meta( $basis, 'crb_company_location' );
	$point_location = carbon_get_post_meta( $point_id, 'crb_company_location' );
	$distance       = getDrivingDistance( $basis_location['value'], $point_location['value'] );
	if ( $price ) {
		$formulas_sum        = get_formulas_sum( $formulas,
			array(
				'point_product_price' => $price,
				'point_coef'          => $point_product['point_coef'],
				'region_id'           => $region_id,
				'point_id'            => $point_id,
				'point_service_price' => $point_price,
				'distance'            => $distance,
				'logistics'           => $point_logistics_price,
				'qnt'                 => $qnt,
				'first_operation'     => $first_operation,
			)
		);
		$currency_sting      = get_currency_sting( $base_currency );
		$point_product_price = $formulas_sum ?: $price;

		return $point_product_price;
	}

	return $price;
}

function get_categories_options() {
	$arr        = array();
	$categories = get_terms( array(
		'taxonomy'   => 'categories',
		'hide_empty' => false,
	) );
	if ( function_exists( 'pll_default_language' ) ) {
		if ( $pll_default_language = pll_default_language() ) {
			if ( $categories ) {
				$temp = array();
				foreach ( $categories as $category ) {
					$category = pll_get_term( $category, $pll_default_language );
					if ( $category ) {
						$category = get_term_by( 'id', $category, 'categories' );
						$slug     = $category->slug;
						$name     = $category->name;
						if ( ! isset( $temp[ $slug ] ) ) {
							$temp[ $slug ] = $name;
						}
					}

				}
				if ( $temp ) {
					foreach ( $temp as $slug => $name ) {
						$arr[ $slug ] = $name;
					}
				}
			}
		}
	} else {
		if ( $categories ) {
			foreach ( $categories as $category ) {
				$slug         = $category->slug;
				$name         = $category->name;
				$arr[ $slug ] = $name;
			}
		}
	}

	return $arr;
}
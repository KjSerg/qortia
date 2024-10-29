<?php

add_action( 'wp_ajax_nopriv_new_calculation', 'new_calculation' );
add_action( 'wp_ajax_new_calculation', 'new_calculation' );
function new_calculation_old() {
	$res                  = array();
	$lat                  = $_POST['lat'] ?? '';
	$lng                  = $_POST['lng'] ?? '';
	$city                 = $_POST['city'] ?? '';
	$region               = $_POST['region'] ?? '';
	$country              = $_POST['country'] ?? '';
	$post_code            = $_POST['post_code'] ?? '';
	$address              = $_POST['address'] ?? '';
	$category_slug        = $_POST['category'] ?? '';
	$products             = $_POST['product'] ?? '';
	$_qnts                = $_POST['qnt'] ?? '';
	$name                 = $_POST['name'] ?? '';
	$organization         = $_POST['organization'] ?? '';
	$tel                  = $_POST['tel'] ?? '';
	$email                = $_POST['email'] ?? '';
	$selected_region      = $_POST['selected_region'] ?? '';
	$selected_point       = $_POST['selected_point'] ?? '';
	$contact              = ( $tel || $email );
	$html                 = '<ul>';
	$application          = 0;
	$application_products = array();
	if ( $contact && $products ) {
		$post_title     = $name . ' - ' . $contact;
		$post_data      = array(
			'post_type'   => 'applications',
			'post_title'  => $post_title,
			'post_status' => 'pending',
		);
		$application_id = wp_insert_post( $post_data, true );
		$application    = get_post( $application_id );
		if ( $application ) {
			$category                 = false;
			$application_price        = 0;
			$application_price_string = 0;
			$location                 = array();
			$category_type            = '';
			if ( $lat && $lng && $address ) {
				$location = array(
					'value'   => "$lat,$lng",
					'lat'     => (float) $lat,
					'lng'     => (float) $lng,
					'zoom'    => 10,
					'address' => $address,
				);
			}
			carbon_set_post_meta( $application_id, 'application_status', 'not_confirmed' );
			carbon_set_post_meta( $application_id, 'application_address', $address );
			carbon_set_post_meta( $application_id, 'application_city', $city );
			carbon_set_post_meta( $application_id, 'application_region', $region );
			carbon_set_post_meta( $application_id, 'application_post_code', $post_code );
			carbon_set_post_meta( $application_id, 'application_location', $location );
			carbon_set_post_meta( $application_id, 'application_name', $name );
			carbon_set_post_meta( $application_id, 'application_organization', $organization );
			carbon_set_post_meta( $application_id, 'application_tel', $tel );
			carbon_set_post_meta( $application_id, 'application_email', $email );
			if ( $selected_point ) {
				carbon_set_post_meta( $application_id, 'application_point_id', $selected_point );
				carbon_set_post_meta( $application_id, 'application_point', get_the_title( $selected_point ) );
			}


			if ( $organization ) {
				$html .= '<li><span>' . _l( 'Підприємство', 1 ) . '</span><strong>' . $organization . ' </strong></li>';
			}
			$res['$products'] = $products;
			$qnts             = array();
			foreach ( $_qnts as $qnt ) {
				if ( $qnt !== '' ) {
					$qnts[] = $qnt;
				}
			}
			foreach ( $products as $index => $productID ) {
				$res['$qnts']           = $qnts;
				$price_to_region        = 0;
				$price_to_region_string = 0;
				$temp                   = array( 'product' => '', 'product_id' => '', 'qnt' => '', 'price' => '' );
				if ( $qnts && isset( $qnts[ $index ] ) && $qnts[ $index ] > 0 && get_post( $productID ) ) {
					$suitable_point_ID  = $selected_point ?: 0;
					$qnt                = $qnts[ $index ] ?? 1;
					$temp['qnt']        = $qnt;
					$temp['product']    = get_the_title( $productID );
					$temp['product_id'] = $productID;
					$category           = get_the_terms( $productID, 'categories' );
					if ( $category ) {
						$category             = $category[0];
						$category_type        = carbon_get_term_meta( $category->term_id, 'category_type' );
						$category_name_suffix = '';
						if ( $category_type == 'shipment' ) {
							$category_name_suffix = _l( 'Прием/покупка (текст кнопки)', 1 );
						} elseif ( $category_type == 'reception' ) {
							$category_name_suffix = _l( 'Отгрузка/продажа (текст кнопки)', 1 );
						}
						$res['button_text'] = $category_name_suffix;
						$points             = get_points_by_point_type( $category_type ?: false );
						if ( ! $suitable_point_ID ) {
							if ( $lat && $lng && $address ) {
								if ( $points ) {
									$suitable = array();
									foreach ( $points as $point_id ) {
										$point_products = carbon_get_post_meta( $point_id, 'point_basis_products' );
										if ( $point_products ) {
											foreach ( $point_products as $point_product ) {
												$point_type      = $point_product['point_type'];
												$point_type_test = true;
												if ( $category_type ) {
													$point_type_test = $category_type == $point_type;
												}
												if ( $point_type_test ) {
													$_regions     = $point_product['regions'];
													$product_id   = $point_product['product'][0]['id'];
													$product_test = $product_id == $productID;
													if ( $product_test && in_array( $category, get_the_terms( $product_id, 'categories' ) ) ) {
														$crb_company_location  = carbon_get_post_meta( $point_id, 'crb_company_location' );
														$distance              = getDrivingDistance( $crb_company_location['value'], "$lat,$lng" );
														$suitable[ $point_id ] = $distance;
													}
												}
											}
										}
										$point_products = carbon_get_post_meta( $point_id, 'point_products' );
										if ( $point_products ) {
											foreach ( $point_products as $point_product ) {
												$point_type      = $point_product['point_type'];
												$point_type_test = true;
												if ( $category_type ) {
													$point_type_test = $category_type == $point_type;
												}
												if ( $point_type_test ) {
													$products = $point_product['products'];
													if ( $products ) {
														foreach ( $products as $product_id ) {
															$product_test = $product_id == $productID;
															if ( $product_test && in_array( $category, get_the_terms( $product_id, 'categories' ) ) ) {
																$crb_company_location  = carbon_get_post_meta( $point_id, 'crb_company_location' );
																$distance              = getDrivingDistance( $crb_company_location['value'], "$lat,$lng" );
																$suitable[ $point_id ] = $distance;
															}
														}
													}
												}
											}
										}
									}
									if ( $suitable ) {
										$d = 0;
										foreach ( $suitable as $_point_id => $_point_distance ) {
											if ( $d == 0 ) {
												$suitable_point_ID = $_point_id;
												$d                 = $_point_distance;
											} else {
												if ( $_point_distance < $d ) {
													$suitable_point_ID = $_point_id;
													$d                 = $_point_distance;
												}
											}
										}
										$res['d'] = $d;
									}
									$res['suitable_point_ID'] = $suitable_point_ID;
									$res['suitable']          = $suitable;

								}
							}
						}
						if ( $suitable_point_ID ) {
							$point_products = carbon_get_post_meta( $suitable_point_ID, 'point_basis_products' );
							if ( $point_products ) {
								foreach ( $point_products as $point_product ) {
									$point_type      = $point_product['point_type'];
									$point_type_test = true;
									if ( $category_type ) {
										$point_type_test = $category_type == $point_type;
									}
									if ( $point_type_test ) {
										$_regions     = $point_product['regions'];
										$product_id   = $point_product['product'][0]['id'];
										$product_test = $product_id == $productID;
										if ( $product_test && in_array( $category, get_the_terms( $product_id, 'categories' ) ) ) {
											$point_product_price  = $point_product['point_product_price'];
											$point_price          = $point_product['point_price'];
											$formulas             = $point_product['formulas'];
											$currencies           = $point_product['currency'];
											$base_currency        = $point_product['base_currency'];
											$point_price_currency = $point_product['point_price_currency'];
											$base_currency_rate   = get_currency_rate( $base_currency );
											$currency_sting       = get_currency_sting( $base_currency );
											if ( $point_price_currency != $base_currency && $point_price > 0 ) {
												$point_price_currency_rate = get_currency_rate( $point_price_currency );
												$point_price               = ( $point_price * $point_price_currency_rate ) / $base_currency_rate;
											}
											$point_product_price = $point_product_price * $qnt;
											if ( $point_price ) {
												$point_price         = $point_price * $qnt;
												$point_product_price = $point_product_price + $point_price;
											}
											$point_logistics_price          = $point_product['point_logistics_price'] ?: 0;
											$point_logistics_price_currency = $point_product['point_logistics_price_price_currency'];
											if ( $point_logistics_price_currency != $base_currency && $point_logistics_price > 0 ) {
												$point_logistics_price_currency_rate = get_currency_rate( $point_logistics_price_currency );
												$point_logistics_price               = ( $point_logistics_price * $point_logistics_price_currency_rate ) / $base_currency_rate;
											}

											if ( $selected_region ) {
												$_regions = $point_product['regions'];
												if ( $_regions ) {
													foreach ( $_regions as $_region ) {
														if ( $_region['id'] == $selected_region && ! $price_to_region ) {
															$formulas_sum           = get_formulas_sum( $formulas,
																array(
																	'point_product_price' => $point_product_price,
																	'point_coef'          => $point_product['point_coef'],
																	'region_id'           => $selected_region,
																	'point_id'            => $suitable_point_ID,
																	'point_service_price' => $point_price,
																	'qnt'                 => $qnt,

																	'logistics' => $point_logistics_price,
																)
															);
															$point_product_price    = $formulas_sum;
															$price_to_region        = $formulas_sum;
															$price_to_region_string = formated_price( $price_to_region ) . $currency_sting;
														}
													}
												}
											}
											$application_price_string = formated_price( $point_product_price ) . $currency_sting;
											if ( $currencies ) {
												$UAH           = $point_product_price * $base_currency_rate;
												$UAH_to_region = $price_to_region * $base_currency_rate;
												foreach ( $currencies as $code ) {
													if ( $code != $base_currency ) {
														$rate                     = get_currency_rate( $code );
														$_point_product_price     = $UAH / $rate;
														$_currency_sting          = get_currency_sting( $code );
														$application_price_string .= ', ' . formated_price( $_point_product_price ) . $_currency_sting;
														if ( $price_to_region ) {
															$price_to_region_string .= ', ' . formated_price( $UAH_to_region / $rate ) . $_currency_sting;
														}
													}
												}
											}
											$temp['price'] = $application_price_string;
										}
									}
								}
							}
							$point_products = carbon_get_post_meta( $suitable_point_ID, 'point_products' );
							if ( $point_products ) {
								foreach ( $point_products as $point_product ) {
									$point_type      = $point_product['point_type'];
									$point_type_test = true;
									if ( $category_type ) {
										$point_type_test = $category_type == $point_type;
									}
									if ( $point_type_test ) {
										$products = $point_product['products'];
										if ( $products ) {
											foreach ( $products as $product_id ) {
												$product_test = $product_id == $productID;
												if ( $product_test && in_array( $category, get_the_terms( $product_id, 'categories' ) ) ) {
													$basis = $point_product['basis'];
													if ( $basis && get_post( $basis ) ) {
														$regions              = get_the_terms( $suitable_point_ID, 'regions' );
														$region_id            = $regions ? get_the_terms( $suitable_point_ID, 'regions' )[0]->term_id : 0;
														$point_price          = $point_product['point_price'];
														$formulas             = $point_product['formulas'];
														$currencies           = $point_product['currency'];
														$point_type           = $point_product['point_type'];
														$price_data           = get_basis_product_price( $product_id, $basis, $point_type );
														$price                = $price_data['price'];
														$base_currency        = $price_data['base_currency'];
														$point_price_currency = $point_product['point_price_currency'];
														$base_currency_rate   = get_currency_rate( $base_currency );
														$currency_sting       = get_currency_sting( $base_currency );
														if ( $point_price_currency != $base_currency && $point_price > 0 ) {
															$point_price_currency_rate = get_currency_rate( $point_price_currency );
															$point_price               = ( $point_price * $point_price_currency_rate ) / $base_currency_rate;
														}
														$basis_location = carbon_get_post_meta( $basis, 'crb_company_location' );
														$point_location = carbon_get_post_meta( $point_id, 'crb_company_location' );
														$distance       = getDrivingDistance( $basis_location['value'], $point_location['value'] );
														if ( $price ):
															$price                          = $price * $qnt;
															$point_logistics_price          = $point_product['point_logistics_price'] ?: 0;
															$point_logistics_price_currency = $point_product['point_logistics_price_price_currency'];
															if ( $point_logistics_price_currency != $base_currency && $point_logistics_price > 0 ) {
																$point_logistics_price_currency_rate = get_currency_rate( $point_logistics_price_currency );
																$point_logistics_price               = ( $point_logistics_price * $point_logistics_price_currency_rate ) / $base_currency_rate;
															}

															$formulas_sum = get_formulas_sum( $formulas,
																array(
																	'point_product_price' => $price,
																	'point_coef'          => $point_product['point_coef'],
																	'region_id'           => $region_id,
																	'point_id'            => $point_id,
																	'point_service_price' => $point_price,
																	'distance'            => $distance,
																	'logistics'           => $point_logistics_price,
																)
															);

															$point_product_price      = is_numeric( $formulas_sum ) ? $formulas_sum : $price;
															$application_price_string = formated_price( $point_product_price ) . $currency_sting;
															if ( $currencies ) {
																$UAH = $point_product_price * $base_currency_rate;
																foreach ( $currencies as $code ) {
																	if ( $code != $base_currency ) {
																		$rate                     = get_currency_rate( $code );
																		$_point_product_price     = $UAH / $rate;
																		$_currency_sting          = get_currency_sting( $code );
																		$_price_str               = formated_price( $_point_product_price ) . $_currency_sting;
																		$application_price_string .= ', ' . formated_price( $_price_str ) . ' ' . $code;
																	}
																}
															}
														endif;
													}
												}
											}
										}
									}
								}
							}
						}
						if ( $application_price_string ) {
							$html .= '<li><span>' . _l( 'ціна за вашою адресою', 1 ) . '</span><strong>' . $application_price_string . ' </strong></li>';
						}
						if ( $city ) {
							$html .= '<li><span>' . _l( 'Місто', 1 ) . '</span><strong>' . $city . ' </strong></li>';
						}
						if ( $product_title = get_the_title( $productID ) ) {
							$html .= '<li><span>' . _l( 'Товар', 1 ) . '</span><strong>' . $product_title . ' </strong></li>';
						}
						if ( $qnt ) {
							$unit      = get_the_terms( $productID, 'units' );
							$unit_name = $unit ? $unit[0]->name : '';
							$html      .= '<li><span>' . _l( 'Кількість', 1 ) . '</span><strong>' . $qnt . $unit_name . ' </strong></li>';
						}
						if ( $suitable_point_ID ) {
							if ( ! $selected_point ) {
								$html .= '<li><span>' . _l( 'Ближайший пункт', 1 ) . '</span><strong>' . get_the_title( $suitable_point_ID ) . ' </strong></li>';
							}
							$html .= '<li><span>' . _l( 'Адрес пункта', 1 ) . '</span><strong>' . carbon_get_post_meta( $suitable_point_ID, 'point_address' ) . ' </strong></li>';
						}
						if ( $price_to_region_string && $selected_region ) {
							$html .= '<li><span>' . _l( 'Ціна в регіоні', 1 ) . '</span><strong>' . $price_to_region_string . ' </strong></li>';
						}
						$html .= '<li class="separator"></li>';
					}
					if ( ! $suitable_point_ID ) {
						$html .= '<li>' . _l( 'Очікуйте на звязок із менеджером', 1 ) . '</li>';
					}
				}
				$application_products[] = $temp;
			}
			$res['ID']                   = $application_id;
			$res['application_products'] = $application_products;
			carbon_set_post_meta( $application_id, 'application_products', $application_products );
		} else {
			$html .= '<li>' . $application_id->get_error_message() . '</li>';
		}
	} else {
		$html .= '<li>' . _l( 'Помилка', 1 ) . '</li>';
	}
	$html        .= '</ul>';
	$res['html'] = $html;
	echo json_encode( $res );
	die();
}

function new_calculation() {
	$res                  = array();
	$lat                  = $_POST['lat'] ?? '';
	$lng                  = $_POST['lng'] ?? '';
	$city                 = $_POST['city'] ?? '';
	$region               = $_POST['region'] ?? '';
	$country              = $_POST['country'] ?? '';
	$post_code            = $_POST['post_code'] ?? '';
	$address              = $_POST['address'] ?? '';
	$category_slug        = $_POST['category'] ?? '';
	$products             = $_POST['product'] ?? '';
	$_qnts                = $_POST['qnt'] ?? '';
	$name                 = $_POST['name'] ?? '';
	$organization         = $_POST['organization'] ?? '';
	$tel                  = $_POST['tel'] ?? '';
	$email                = $_POST['email'] ?? '';
	$selected_region      = $_POST['selected_region'] ?? '';
	$selected_point       = $_POST['selected_point'] ?? '';
	$contact              = ( $tel || $email );
	$html                 = '<ul>';
	$application          = 0;
	$application_products = array();
	if ( $contact && $products ) {
		$post_title     = $name . ' - ' . $contact;
		$post_data      = array(
			'post_type'   => 'applications',
			'post_title'  => $post_title,
			'post_status' => 'pending',
		);
		$application_id = wp_insert_post( $post_data, true );
		$application    = get_post( $application_id );
		if ( $application ) {
			$results                  = array();
			$category                 = false;
			$application_price        = 0;
			$application_price_string = 0;
			$location                 = array();
			$category_type            = '';
			if ( $lat && $lng && $address ) {
				$location = array(
					'value'   => "$lat,$lng",
					'lat'     => (float) $lat,
					'lng'     => (float) $lng,
					'zoom'    => 10,
					'address' => $address,
				);
			}
			carbon_set_post_meta( $application_id, 'application_status', 'not_confirmed' );
			carbon_set_post_meta( $application_id, 'application_address', $address );
			carbon_set_post_meta( $application_id, 'application_city', $city );
			carbon_set_post_meta( $application_id, 'application_region', $region );
			carbon_set_post_meta( $application_id, 'application_post_code', $post_code );
			carbon_set_post_meta( $application_id, 'application_location', $location );
			carbon_set_post_meta( $application_id, 'application_name', $name );
			carbon_set_post_meta( $application_id, 'application_organization', $organization );
			carbon_set_post_meta( $application_id, 'application_tel', $tel );
			carbon_set_post_meta( $application_id, 'application_email', $email );
			if ( $selected_point ) {
				carbon_set_post_meta( $application_id, 'application_point_id', $selected_point );
				carbon_set_post_meta( $application_id, 'application_point', get_the_title( $selected_point ) );
			}
			if ( $organization ) {
				$html .= '<li><span>' . _l( 'Підприємство', 1 ) . '</span><strong>' . $organization . ' </strong></li>';
			}
			$res['$products'] = $products;
			$qnts             = array();
			foreach ( $_qnts as $qnt ) {
				if ( $qnt !== '' ) {
					$qnts[] = $qnt;
				}
			}
			foreach ( $products as $index => $productID ) {
				$res['$qnts']           = $qnts;
				$price_to_region        = 0;
				$price_to_region_string = 0;
				$temp                   = array( 'product' => '', 'product_id' => '', 'qnt' => '', 'price' => '' );
				$formula                = carbon_get_theme_option( 'formulas' );
				$first_operation        = '';
				if ( $qnts && isset( $qnts[ $index ] ) && $qnts[ $index ] > 0 && get_post( $productID ) ) {
					$suitable_point_ID  = $selected_point ?: 0;
					$qnt                = $qnts[ $index ] ?? 1;
					$temp['qnt']        = $qnt;
					$temp['product']    = get_the_title( $productID );
					$temp['product_id'] = $productID;
					$category           = get_the_terms( $productID, 'categories' );
					if ( $category ) {
						$category             = $category[0];
						$category_type        = carbon_get_term_meta( $category->term_id, 'category_type' );
						$formula              = carbon_get_term_meta( $category->term_id, 'formulas' ) ?: $formula;
						$category_name_suffix = '';
						if ( $category_type == 'shipment' ) {
							$category_name_suffix = _l( 'Прием/покупка (текст кнопки)', 1 );
							$first_operation      = '-';
						} elseif ( $category_type == 'reception' ) {
							$category_name_suffix = _l( 'Отгрузка/продажа (текст кнопки)', 1 );
							$first_operation      = '+';
						}
						$res['button_text']        = $category_name_suffix;
						$points                    = get_points_by_point_type( $category_type ?: false );
						$res['$suitable_point_ID'] = $suitable_point_ID;
						if ( ! $suitable_point_ID ) {
							if ( $lat && $lng && $address ) {
								if ( $points ) {
									$suitable = array();
									$currency = '';
									foreach ( $points as $point_id ) {
										$point_products = carbon_get_post_meta( $point_id, 'point_basis_products' );
										if ( $point_products ) {
											foreach ( $point_products as $point_product ) {
												$point_type      = $point_product['point_type'];
												$point_type_test = true;
												if ( $category_type ) {
													$point_type_test = $category_type == $point_type;
												}
												if ( $point_type_test ) {
													$_regions     = $point_product['regions'];
													$product_id   = $point_product['product'][0]['id'];
													$product_test = $product_id == $productID;
													if ( $product_test && in_array( $category, get_the_terms( $product_id, 'categories' ) ) ) {
														$crb_company_location           = carbon_get_post_meta( $point_id, 'crb_company_location' );
														$distance                       = getDrivingDistance( $crb_company_location['value'], "$lat,$lng" );
														$point_product_price            = $point_product['point_product_price'];
														$product_id                     = $point_product['product'][0]['id'];
														$currencies                     = $point_product['currency'];
														$base_currency                  = $point_product['base_currency'];
														$point_price                    = $point_product['point_price'];
														$formulas                       = $point_product['formulas'];
														$point_logistics_price          = $point_product['point_logistics_price'] ?: 0;
														$point_logistics_price_currency = $point_product['point_logistics_price_price_currency'];
														$point_price_currency           = $point_product['point_price_currency'];
														$base_currency_rate             = get_currency_rate( $base_currency );
														$currency                       = $currency ?: $base_currency;
														if ( $currency != $base_currency ) {
															$UAH                 = $point_product_price * $base_currency_rate;
															$rate                = get_currency_rate( $currency );
															$point_product_price = $UAH / $rate;
														}
														$formulas_sum          = get_formulas_sum( $formulas,
															array(
																'point_product_price' => $point_product_price,
																'point_coef'          => $point_product['point_coef'],
																'point_id'            => $point_id,
																'point_service_price' => $point_price,
																'distance'            => $distance,
																'logistics'           => $point_logistics_price,
																'qnt'                 => $qnt,
															)
														);
														$suitable[ $point_id ] = array(
															'distance'            => $distance,
															'sum'                 => ( $formulas_sum * $qnt ),
															'currency'            => $base_currency,
															'price'               => $formulas_sum,
															'point_product_price' => $point_product_price,
														);
													}
												}
											}
										}
										$point_products = carbon_get_post_meta( $point_id, 'point_products' );
										if ( $point_products ) {
											foreach ( $point_products as $point_product ) {
												$point_type      = $point_product['point_type'];
												$point_type_test = true;
												if ( $category_type ) {
													$point_type_test = $category_type == $point_type;
												}
												if ( $point_type_test ) {
													$products = $point_product['products'];
													if ( $products ) {
														foreach ( $products as $product_id ) {
															$product_test = $product_id == $productID;
															if ( $product_test && in_array( $category, get_the_terms( $product_id, 'categories' ) ) ) {
																$crb_company_location = carbon_get_post_meta( $point_id, 'crb_company_location' );
																$distance             = getDrivingDistance( $crb_company_location['value'], "$lat,$lng" );

																$basis = $point_product['basis'];
																if ( $basis && get_post( $basis ) ) {
																	$price_data          = get_basis_product_price( $product_id, $basis, $point_type );
																	$price               = $price_data['price'];
																	$base_currency       = $price_data['base_currency'];
																	$currency            = $currency ?: $base_currency;
																	$base_currency_rate  = get_currency_rate( $base_currency );
																	$point_product_price = get_simple_point_product_price( $point_product, $product_id, array(
																		'point_id'  => $point_id,
																		'region_id' => $selected_region,
																		'qnt'       => $qnt
																	) );
																	if ( $currency != $base_currency ) {
																		$UAH                 = $point_product_price * $base_currency_rate;
																		$rate                = get_currency_rate( $currency );
																		$point_product_price = $UAH / $rate;
																	}
																	$suitable[ $point_id ] = array(
																		'distance'            => $distance,
																		'sum'                 => ( $point_product_price * $qnt ),
																		'currency'            => $base_currency,
																		'price'               => $point_product_price,
																		'point_product_price' => $price,
																	);
																}
															}
														}
													}
												}
											}
										}
									}
									if ( $suitable ) {
										$d   = 0;
										$max = 0;
										$min = 0;
										foreach ( $suitable as $_point_id => $data ) {
											$sum = $data['sum'] ?? 0;
											$sum = (float) $sum;
											if ( $category_type == 'shipment' ) {
												if ( $min == 0 ) {
													$min               = $sum;
													$suitable_point_ID = $_point_id;
												}
												if ( $sum < $min ) {
													$min               = $sum;
													$suitable_point_ID = $_point_id;
												}
											} elseif ( $category_type == 'reception' ) {
												if ( $max < $sum ) {
													$max               = $sum;
													$suitable_point_ID = $_point_id;
												}
											}
										}
										$res['d']   = $d;
										$res['max'] = $max;
										$res['min'] = $min;
									}
									$res['suitable_point_ID'] = $suitable_point_ID;
									$res['suitable']          = $suitable;
								}
							}
						}
						$res['$suitable_point_ID1'] = $suitable_point_ID;
						$res['$qnt']                = $qnt;
						if ( $suitable_point_ID ) {
							$point_products = carbon_get_post_meta( $suitable_point_ID, 'point_basis_products' );
							if ( $point_products ) {
								foreach ( $point_products as $point_product ) {
									$point_type      = $point_product['point_type'];
									$point_type_test = true;
									if ( $category_type ) {
										$point_type_test = $category_type == $point_type;
									}
									if ( $point_type_test ) {
										$_regions     = $point_product['regions'];
										$product_id   = $point_product['product'][0]['id'];
										$product_test = $product_id == $productID;
										if ( $product_test && in_array( $category, get_the_terms( $product_id, 'categories' ) ) ) {
											$point_product_price  = $point_product['point_product_price'];
											$point_price          = $point_product['point_price'];
											$formulas             = $formula;
											$currencies           = $point_product['currency'];
											$base_currency        = $point_product['base_currency'];
											$point_price_currency = $point_product['point_price_currency'];
											$base_currency_rate   = get_currency_rate( $base_currency );
											$currency_sting       = get_currency_sting( $base_currency );
											if ( $point_price_currency != $base_currency && $point_price > 0 ) {
												$point_price_currency_rate = get_currency_rate( $point_price_currency );
												$point_price               = ( $point_price * $point_price_currency_rate ) / $base_currency_rate;
											}
											$point_product_price = $point_product_price * $qnt;
											if ( $point_price ) {
												$point_price         = $point_price * $qnt;
												$point_product_price = $point_product_price + $point_price;
											}
											$point_logistics_price          = $point_product['point_logistics_price'] ?: 0;
											$point_logistics_price_currency = $point_product['point_logistics_price_price_currency'];
											if ( $point_logistics_price_currency != $base_currency && $point_logistics_price > 0 ) {
												$point_logistics_price_currency_rate = get_currency_rate( $point_logistics_price_currency );
												$point_logistics_price               = ( $point_logistics_price * $point_logistics_price_currency_rate ) / $base_currency_rate;
											}
											if ( $selected_region ) {
												$_regions = $point_product['regions'];
												if ( $_regions ) {
													foreach ( $_regions as $_region ) {
														if ( $_region['id'] == $selected_region && ! $price_to_region ) {
															$formulas_sum           = get_formulas_sum( $formulas,
																array(
																	'point_product_price' => $point_product_price,
																	'point_coef'          => $point_product['point_coef'],
																	'region_id'           => $selected_region,
																	'point_id'            => $suitable_point_ID,
																	'point_service_price' => $point_price,
																	'qnt'                 => $qnt,
																	'logistics'           => $point_logistics_price,
																	'first_operation'     => $first_operation,
																)
															);
															$point_product_price    = $formulas_sum;
															$price_to_region        = $formulas_sum;
															$price_to_region_string = formated_price( $price_to_region ) . $currency_sting;
														}
													}
												}
											}
											$application_price_string = formated_price( ( $point_product_price ) ) . $currency_sting;
											if ( $currencies ) {
												$UAH           = $point_product_price * $base_currency_rate;
												$UAH_to_region = $price_to_region * $base_currency_rate;
												foreach ( $currencies as $code ) {
													if ( $code != $base_currency ) {
														$rate                     = get_currency_rate( $code );
														$_point_product_price     = $UAH / $rate;
														$_point_product_price     = $_point_product_price * $qnt;
														$_currency_sting          = get_currency_sting( $code );
														$application_price_string .= ', ' . formated_price( $_point_product_price ) . $_currency_sting;
														if ( $price_to_region ) {
															$price_to_region_string .= ', ' . formated_price( $UAH_to_region / $rate ) . $_currency_sting;
														}
													}
												}
											}
											$temp['price'] = $application_price_string;
										}
									}
								}
							}
							$point_products = carbon_get_post_meta( $suitable_point_ID, 'point_products' );
							if ( $point_products ) {
								foreach ( $point_products as $point_product ) {
									$point_type      = $point_product['point_type'];
									$point_type_test = true;
									if ( $category_type ) {
										$point_type_test = $category_type == $point_type;
									}
									if ( $point_type_test ) {
										$products = $point_product['products'];
										if ( $products ) {
											foreach ( $products as $product_id ) {
												$product_test = $product_id == $productID;
												if ( $product_test && in_array( $category, get_the_terms( $product_id, 'categories' ) ) ) {
													$basis = $point_product['basis'];
													if ( $basis && get_post( $basis ) ) {
														$regions                             = get_the_terms( $suitable_point_ID, 'regions' );
														$region_id                           = $regions ? get_the_terms( $suitable_point_ID, 'regions' )[0]->term_id : 0;
														$point_price                         = $point_product['point_price'];
														$res[ $product_id . '$point_price' ] = $point_price;
														$formulas                            = $formula;
														$currencies                          = $point_product['currency'];
														$point_type                          = $point_product['point_type'];
														$price_data                          = get_basis_product_price( $product_id, $basis, $point_type );
														$price                               = $price_data['price'];
														$res[ $product_id . '$price' ]       = $price;
														$base_currency                       = $price_data['base_currency'];
														$point_price_currency                = $point_product['point_price_currency'];
														$base_currency_rate                  = get_currency_rate( $base_currency );
														$currency_sting                      = get_currency_sting( $base_currency );
														if ( $point_price_currency != $base_currency && $point_price > 0 ) {
															$point_price_currency_rate = get_currency_rate( $point_price_currency );
															$point_price               = ( $point_price * $point_price_currency_rate ) / $base_currency_rate;
														}
														$res[ $product_id . '$point_price1' ] = $point_price;
														$basis_location                       = carbon_get_post_meta( $basis, 'crb_company_location' );
														$point_location                       = carbon_get_post_meta( $point_id, 'crb_company_location' );
														$distance                             = getDrivingDistance( $basis_location['value'], $point_location['value'] );
														if ( $price ):
															$price                          = $price * $qnt;
															$res[ $product_id . '$price1' ] = $point_price;
															$point_logistics_price          = $point_product['point_logistics_price'] ?: 0;
															$point_logistics_price_currency = $point_product['point_logistics_price_price_currency'];
															if ( $point_logistics_price_currency != $base_currency && $point_logistics_price > 0 ) {
																$point_logistics_price_currency_rate = get_currency_rate( $point_logistics_price_currency );
																$point_logistics_price               = ( $point_logistics_price * $point_logistics_price_currency_rate ) / $base_currency_rate;
															}

															$formulas_sum = get_formulas_sum( $formulas,
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

															$res[ $product_id . '$formulas_sum' ] = $formulas_sum;
															$point_product_price                  = is_numeric( $formulas_sum ) ? $formulas_sum : $price;
															$application_price_string             = formated_price( ( $point_product_price ) ) . $currency_sting;
															if ( $currencies ) {
																$UAH = $point_product_price * $base_currency_rate;
																foreach ( $currencies as $code ) {
																	if ( $code != $base_currency ) {
																		$rate                     = get_currency_rate( $code );
																		$_point_product_price     = $UAH / $rate;
																		$_currency_sting          = get_currency_sting( $code );
																		$_price_str               = $_point_product_price;
																		$_price_str               = formated_price( $_price_str ) . $_currency_sting;
																		$application_price_string .= ', ' . formated_price( $_price_str ) . ' ' . $code;
																	}
																}
															}
														endif;
													}
												}
											}
										}
									}
								}
							}
						}
						if ( $application_price_string ) {
							$html .= '<li><span>' . _l( 'Найкраща ціна', 1 ) . '</span><strong>' . $application_price_string . ' </strong></li>';
						}
						if ( $city ) {
							$html .= '<li><span>' . _l( 'Місто', 1 ) . '</span><strong>' . $city . ' </strong></li>';
						}
						if ( $product_title = get_the_title( $productID ) ) {
							$html .= '<li><span>' . _l( 'Товар', 1 ) . '</span><strong>' . $product_title . ' </strong></li>';
						}
						if ( $qnt ) {
							$unit      = get_the_terms( $productID, 'units' );
							$unit_name = $unit ? $unit[0]->name : '';
							$html      .= '<li><span>' . _l( 'Кількість', 1 ) . '</span><strong>' . $qnt . $unit_name . ' </strong></li>';
						}
						if ( $suitable_point_ID ) {
							if ( ! $selected_point ) {
								$html .= '<li><span>' . _l( 'Ближайший пункт', 1 ) . '</span><strong>' . get_the_title( $suitable_point_ID ) . ' </strong></li>';
							}
							$html .= '<li><span>' . _l( 'Адрес пункта', 1 ) . '</span><strong>' . carbon_get_post_meta( $suitable_point_ID, 'point_address' ) . ' </strong></li>';
						}
						if ( $price_to_region_string && $selected_region ) {
							$html .= '<li><span>' . _l( 'Ціна в регіоні', 1 ) . '</span><strong>' . $price_to_region_string . ' </strong></li>';
						}
						$html .= '<li class="separator"></li>';
					}
					if ( ! $suitable_point_ID ) {
						$html .= '<li>' . _l( 'Очікуйте на звязок із менеджером', 1 ) . '</li>';
					}
				}
				$application_products[] = $temp;
			}
			$res['ID']                   = $application_id;
			$res['application_products'] = $application_products;
			carbon_set_post_meta( $application_id, 'application_products', $application_products );
		} else {
			$html .= '<li>' . $application_id->get_error_message() . '</li>';
		}
	} else {
		$html .= '<li>' . _l( 'Помилка', 1 ) . '</li>';
	}
	$html        .= '</ul>';
	$res['html'] = $html;
	echo json_encode( $res );
	die();
}

add_action( 'wp_ajax_nopriv_set_status_calculation', 'set_status_calculation' );
add_action( 'wp_ajax_set_status_calculation', 'set_status_calculation' );
function set_status_calculation() {
	$id = $_POST['id'] ?? '';
	if ( $id && get_post( $id ) ) {
		carbon_set_post_meta( $id, 'application_status', 'confirmed' );
		$application_product    = carbon_get_post_meta( $id, 'application_product' );
		$application_product_id = carbon_get_post_meta( $id, 'application_product_id' );
		$application_price      = carbon_get_post_meta( $id, 'application_price' );
		$application_address    = carbon_get_post_meta( $id, 'application_address' );
		$application_name       = carbon_get_post_meta( $id, 'application_name' );
		$application_tel        = carbon_get_post_meta( $id, 'application_tel' );
		$application_qnt        = carbon_get_post_meta( $id, 'application_qnt' );
		$c                      = true;
		$message                = '';
		$message                .=
			( ( $c = ! $c ) ? ' <tr>' : ' <tr style="background-color: #f8f8f8;"> ' ) . "
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' ><b> Имя</b></td>
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' > $application_name</td>
                        </tr>
                    ";
		$message                .=
			( ( $c = ! $c ) ? ' <tr>' : ' <tr style="background-color: #f8f8f8;"> ' ) . "
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' ><b> Телефон</b></td>
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' > $application_tel</td>
                        </tr>
                    ";
		$message                .=
			( ( $c = ! $c ) ? ' <tr>' : ' <tr style="background-color: #f8f8f8;"> ' ) . "
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' ><b> Адрес</b></td>
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' > $application_address</td>
                        </tr>
                    ";
		$message                .=
			( ( $c = ! $c ) ? ' <tr>' : ' <tr style="background-color: #f8f8f8;"> ' ) . "
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' ><b> Количество</b></td>
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' > $application_qnt</td>
                        </tr>
                    ";
		$message                .=
			( ( $c = ! $c ) ? ' <tr>' : ' <tr style="background-color: #f8f8f8;"> ' ) . "
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' ><b> $application_product  [ID:$application_product_id]</b></td>
                        <td style='padding: 10px; border: #e9e9e9 1px solid;' > $application_price</td>
                        </tr>
                    ";
		$project_name           = get_bloginfo( 'name' );
		$email                  = get_bloginfo( 'admin_email' );
		$headers                = "MIME-Version:1.0" . PHP_EOL .
		                          "Content-Type:text/html; charset=utf-8" . PHP_EOL .
		                          'From:' . adopt( $project_name ) . ' <application@' . $_SERVER['HTTP_HOST'] . '>' . PHP_EOL .
		                          'Reply-To: ' . $email . '' . PHP_EOL;
		wp_mail( $email, $project_name, $message, $headers );
		echo json_encode( array(
			'msg' => _l( 'Дякуємо за замовлення, наш менеджер зв’яжеться з вами найближчим часом', 1 )
		) );
	}
	die();
}

add_action( 'wp_ajax_nopriv_get_products_form_row', 'get_products_form_row' );
add_action( 'wp_ajax_get_products_form_row', 'get_products_form_row' );
function get_products_form_row() {
	$category = $_POST['category'] ?? '';
	$res      = array();
	$args     = array(
		'post_type'      => 'products',
		'post_status'    => 'publish',
		'posts_per_page' => - 1,
	);
	if ( $category ) {
		$category          = get_term_by( 'slug', $category, 'categories' );
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'categories',
				'field'    => 'term_id',
				'terms'    => array( $category->term_id ),
			)
		);
	}
	$time = time();
	ob_start();
	?>
    <div class="form-horizontal ">
        <div class="form-group half">
			<?php $query = new WP_Query( $args );
			if ( $query->have_posts() ) :
				?>
                <select class="select_st product-select trigger-select"
                        id="<?php echo $category->slug ?>"
                        data-trigger="#<?php echo $time; ?>"
                        name="product[]">
                    <option value="">
						<?php _l( 'Оберіть' ) ?>
                    </option>
					<?php while ( $query->have_posts() ): $query->the_post();
						$_id = get_the_ID();
						?>
                        <option value="<?php echo $_id; ?>">
							<?php echo get_the_title( $_id ) ?>
                        </option>
					<?php endwhile; ?>
                </select>
			<?php endif;
			wp_reset_postdata();
			wp_reset_query();
			?>
        </div>
        <div class="form-group half">
            <input class="input_st "
                   type="text"
                   name="qnt[]"
                   id="<?php echo $time; ?>"
                   placeholder="<?php _l( 'Кількість в тонах' ) ?>">
        </div>
    </div>
	<?php
	$res['html'] = ob_get_contents();
	ob_end_clean();
	echo json_encode( $res );
	die();
}
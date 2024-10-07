<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-content__left">
				<?php if ( $quote_footer = carbon_get_post_meta( get_option( 'page_on_front' ), 'quote_footer' ) ) : ?>
                    <div class="footer-quote"><?php echo do_shortcode( $quote_footer ); ?></div>
				<?php endif; ?>
				<?php if ( $social_list_footer = carbon_get_theme_option( 'social_list_footer' ) ) : ?>
                    <ul class="social">
						<?php foreach ( $social_list_footer as $soc_item ) : ?>
                            <li>
                                <a href="<?php echo $soc_item['social_list_footer_link']; ?>" target="_blank">
									<?php echo the_image( $soc_item['social_list_footer_ico'] ); ?>
                                </a>
                            </li>
						<?php
						endforeach; ?>
                    </ul>
				<?php endif; ?>
            </div>
			<?php if ( $footer_list = carbon_get_post_meta( get_option( 'page_on_front' ), 'footer_list' ) ) : ?>
                <ul class="footer-list">
					<?php foreach ( $footer_list as $list_item ) : ?>
                        <li><?php echo $list_item['footer_list_title']; ?></li>
					<?php
					endforeach; ?>
                </ul>
			<?php endif; ?>

			<?php if ( $contact_list_footer = carbon_get_post_meta( get_option( 'page_on_front' ), 'contact_list_footer' ) ) : ?>
                <div class="footer-contact">
					<?php if ( $contact_code = carbon_get_post_meta( get_option( 'page_on_front' ), 'contact_code' ) ) : ?>
                        <div class="footer-contact__qr"><img src="<?php echo wp_get_attachment_url( $contact_code ); ?>"
                                                             alt=""/></div>
					<?php endif; ?>

                    <ul class="footer-contact__list">
						<?php foreach ( $contact_list_footer as $contact_item ) : ?>
                            <li>
								<?php if ( $contact_ico = $contact_item['contact_list_footer_icon'] ) : ?>
                                    <span> <img src="<?php echo wp_get_attachment_url( $contact_ico ); ?>"
                                                alt=""/></span>
								<?php endif; ?>
								<?php echo $contact_item['contact_list_footer_title']; ?>
                            </li>
						<?php
						endforeach; ?>
                    </ul>
                </div>
			<?php endif; ?>
        </div>
    </div>
</footer>

<div class="modal modal-sm" id="thanks">
    <div class="modal-content">
        <div class="modal-title">

            <div class="modal-title__subtitle js-thanks"></div>
        </div>

    </div>
</div>

<script>
    var admin_ajax = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
    var order_post_type = '<?php echo $_GET['post_type'] ?? 'grain'; ?>';
    var locationErrorString = '<?php _l( 'Вибріть адресу із запропонованих' ); ?>';
    var emailErrorString = '<?php _l( 'Поле пошти повино містити симоли: "@", "." а також символи і/або цифри між ними.' ); ?>';
</script>

<?php
wp_footer();
the_modals();
the_calculate();


?>

<?php if ( $google_map_api_key = carbon_get_theme_option( 'google_map_api_key' ) ): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_map_api_key; ?>&amp;;libraries=places&amp;callback=initAutocomplete&amp;libraries=places&amp;v=weekly&amp;language=uk"
            id="google-map-api" defer=""></script>
<?php endif; ?>

</body>

</html>
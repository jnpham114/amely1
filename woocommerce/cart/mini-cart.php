<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( amely_get_option( 'minicart_message_pos' ) == 'top' && ! WC()->cart->is_empty() ) { ?>
	<p class="minicart-message"><?php echo amely_get_option( 'minicart_message' ) ?></p>
<?php } ?>
<p class="widget_minicart_title"><?php esc_html_e( 'Cart', 'amely' ); ?>
	<a href="#" class="close-on-mobile hidden-xl-up">&times;</a>
	<span class="undo">
						<?php esc_html_e( 'Item removed.', 'amely' ) ?>
		<a href="#"><?php esc_html_e( 'Undo', 'amely' ); ?></a>
					</span>
</p>
<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

	<li class="woocommerce-mini-cart__empty-message empty<?php echo WC()->cart->is_empty() ? '' : ' hidden'; ?>"><?php esc_html_e( 'No products in the cart.',
			'amely' ); ?></li>

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product',
				$cart_item['data'],
				$cart_item,
				$cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id',
				$cart_item['product_id'],
				$cart_item,
				$cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible',
					true,
					$cart_item,
					$cart_item_key )
			) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name',
					$_product->get_title(),
					$cart_item,
					$cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail',
					$_product->get_image(),
					$cart_item,
					$cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price',
					WC()->cart->get_product_price( $_product ),
					$cart_item,
					$cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink',
					$_product->is_visible() ? $_product->get_permalink( $cart_item ) : '',
					$cart_item,
					$cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class',
					'mini_cart_item',
					$cart_item,
					$cart_item_key ) ); ?>">
					<?php
					echo apply_filters( 'woocommerce_cart_item_remove_link',
						sprintf( '<a href="%s" class="remove" title="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_html__( 'Remove this item', 'amely' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() ) ),
						$cart_item_key );
					?>
					<?php if ( ! $_product->is_visible() ) : ?>
						<?php echo str_replace( array(
							'http:',
							'https:',
						),
							'',
							$thumbnail ); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>" class="minicart_item_product_image">
							<?php echo str_replace( array(
								'http:',
								'https:',
							),
								'',
								$thumbnail ); ?>
						</a>
					<?php endif; ?>

					<div class="minicart_item_right">
						<div class="product-title"><a
								href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>"><?php echo wp_kses_post( $product_name ); ?></a>
						</div>
						<div class="minicart_item_details">
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity',
								'<span class="quantity">' . sprintf( '%s &times; %s',
									$cart_item['quantity'],
									$product_price ) . '</span>',
								$cart_item,
								$cart_item_key ); ?>
						</div>
					</div>

					<span class="ajax-loading"></span>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<p class="woocommerce-mini-cart__total total"><strong><?php esc_html_e( 'Subtotal', 'amely' ); ?>
			:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
		   class="button wc-forward"><?php esc_html_e( 'View Cart', 'amely' ); ?></a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
		   class="button checkout alt-button wc-forward"><?php esc_html_e( 'Checkout', 'amely' ); ?></a>
	</p>

<?php endif; ?>

<?php if ( amely_get_option( 'minicart_message_pos' ) == 'bottom' && ! WC()->cart->is_empty() ) { ?>
	<p class="minicart-message"><?php echo do_shortcode( amely_get_option( 'minicart_message' ) ); ?></p>
<?php } ?>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>

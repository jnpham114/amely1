<?php

/**
 * ThemeMove Banner 4 Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Banner4 extends WPBakeryShortCode {

	public function shortcode_css( $css_id ) {

		$atts  = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$cssID = '#' . $css_id;
		$css   = '';

		$text_position   = $atts['text_position'] ? $atts['text_position'] : 'top-left';
		$custom_position = $atts['custom_position'] ? $atts['custom_position'] : '';

		$color_hashtag = $atts['color_desc'] ? $atts['color_hashtag'] : '#f8f8f8';
		$color_desc    = $atts['color_desc'] ? $atts['color_desc'] : '#696969';
		$color_content = $atts['color_content'] ? $atts['color_content'] : SECONDARY_COLOR;

		$button_style        = $atts['button_style'] ? $atts['button_style'] : '';
		$button_color        = $atts['button_color'] ? $atts['button_color'] : '#ffffff';
		$button_bg_color     = $atts['button_bg_color'] ? $atts['button_bg_color'] : SECONDARY_COLOR;
		$button_border_color = $atts['button_border_color'] ? $atts['button_border_color'] : SECONDARY_COLOR;

		$button_color_hover        = $atts['button_color_hover'] ? $atts['button_color_hover'] : '#ffffff';
		$button_bg_color_hover     = $atts['button_bg_color_hover'] ? $atts['button_bg_color_hover'] : PRIMARY_COLOR;
		$button_border_color_hover = $atts['button_border_color_hover'] ? $atts['button_border_color_hover'] : PRIMARY_COLOR;

		$css .= $cssID . ' .banner-hashtag{color:' . $color_hashtag . '}';
		$css .= $cssID . ' .banner-desc{color:' . $color_desc . '}';
		$css .= $cssID . ' .banner-text,' . $cssID . ' .banner-text h1,' . $cssID . ' .banner-text h2,' . $cssID . ' .banner-text h3,' . $cssID . ' .banner-text h4,' . $cssID . ' .banner-text h5,' . $cssID . ' .banner-text h6{color:' . $color_content . '}';

		if ( $button_style == 'link' ) {
			$css .= $cssID . ' .banner-button{color:' . $button_color . ';}';
			$css .= $cssID . ' .banner-button:after{background-color:' . $button_color . ';}';
			$css .= $cssID . ':hover .banner-button{color:' . $button_color_hover . ';}';
			$css .= $cssID . ':hover .banner-button:after{background-color:' . $button_bg_color_hover . ';}';
		}

		if ( $button_style == 'custom' ) {
			$css .= $cssID . ' .banner-button{color:' . $button_color . ';background-color:' . $button_bg_color . ';border-color:' . $button_border_color . ';}';
			$css .= $cssID . ':hover .banner-button{color:' . $button_color_hover . ';background-color:' . $button_bg_color_hover . ';border-color:' . $button_border_color_hover . ';}';
		}

		if ( $text_position == 'custom' ) {
			$css .= $cssID . ' .banner-content{' . $custom_position . '}';
		}

		global $amely_shortcode_css;
		$amely_shortcode_css .= Amely_Helper::text2line( $css );
	}

	/**
	 *
	 * Custom title in backend, show image instead of icon
	 *
	 * @param $param
	 * @param $value
	 *
	 * @return string
	 */
	public function singleParamHtmlHolder( $param, $value ) {

		$output = '';

		$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
		$type       = isset( $param['type'] ) ? $param['type'] : '';
		$class      = isset( $param['class'] ) ? $param['class'] : '';

		if ( 'attach_image' === $param['type'] && 'image' === $param_name ) {
			$output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';
			$element_icon = $this->settings( 'icon' );
			$img          = wpb_getImageBySize( array(
				'attach_id'  => (int) preg_replace( '/[^\d]/', '', $value ),
				'thumb_size' => 'thumbnail',
				'class'      => 'attachment-thumbnail vc_general vc_element-icon tm-element-icon-none',
			) );
			$this->setSettings( 'logo',
				( $img ? $img['thumbnail'] : '<img width="150" height="150" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail vc_general vc_element-icon amely-element-icon-banner"  data-name="' . $param_name . '" alt="' . esc_attr('image') . '" title="' . esc_attr('image') . '" style="display: none;" />' ) . '<span class="no_image_image vc_element-icon' . ( ! empty( $element_icon ) ? ' ' . $element_icon : '' ) . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '" /><a href="#" class="column_edit_trigger' . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '">' . esc_html__( 'Add image',
					'amely' ) . '</a>' );
			$output .= $this->outputCustomTitle( $this->settings['name'] );
		} elseif ( ! empty( $param['holder'] ) ) {
			if ( 'input' === $param['holder'] ) {
				$output .= '<' . $param['holder'] . ' readonly="true" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '">';
			} elseif ( in_array( $param['holder'],
				array(
					'img',
					'iframe',
				) ) ) {
				$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" src="' . $value . '">';
			} elseif ( 'hidden' !== $param['holder'] ) {
				$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
			}
		}

		if ( ! empty( $param['admin_label'] ) && true === $param['admin_label'] ) {
			$output .= '<span class="vc_admin_label admin_label_' . $param['param_name'] . ( empty( $value ) ? ' hidden-label' : '' ) . '"><label>' . $param['heading'] . '</label>: ' . $value . '</span>';
		}

		return $output;
	}

	protected function outputTitle( $title ) {
		return '';
	}

	protected function outputCustomTitle( $title ) {
		return '<h4 class="wpb_element_title">' . $title . ' ' . $this->settings( 'logo' ) . '</h4>';
	}
}

vc_map( array(
	'name'        => esc_html__( 'Banner4', 'amely' ),
	'description' => esc_html__( 'Banner image with special style', 'amely' ),
	'base'        => 'amely_banner4',
	'icon'        => 'amely-element-icon-banner4',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'params'      => array(

		// General
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Image Source', 'amely' ),
			'param_name'  => 'source',
			'value'       => array(
				esc_html__( 'Media library', 'amely' ) => 'media_library',
				esc_html__( 'External link', 'amely' ) => 'external_link',
			),
			'std'         => 'media_library',
			'description' => esc_html__( 'Select image source.', 'amely' ),
		),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Banner Image', 'amely' ),
			'param_name'  => 'image',
			'value'       => '',
			'description' => esc_html__( 'Select an image from media library.', 'amely' ),
			'dependency'  => array(
				'element' => 'source',
				'value'   => 'media_library',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'External Link', 'amely' ),
			'param_name'  => 'custom_src',
			'description' => esc_html__( 'Select external link.', 'amely' ),
			'dependency'  => array(
				'element' => 'source',
				'value'   => 'external_link',
			),
		),
		array(
			'heading'    => esc_html__( 'Banner Link', 'amely' ),
			'type'       => 'vc_link',
			'param_name' => 'link',
		),
		array(
			'heading'     => esc_html__( 'Image Position', 'amely' ),
			'description' => esc_html__( 'Select image position', 'amely' ),
			'type'        => 'dropdown',
			'param_name'  => 'image_position',
			'value'       => array(
				esc_html__( 'Left', 'amely' )   => 'left',
				esc_html__( 'Right', 'amely' )  => 'right',
				esc_html__( 'Top', 'amely' )    => 'top',
				esc_html__( 'Bottom', 'amely' ) => 'bottom',
			),
		),
		array(
			'heading'     => esc_html__( 'Hashtag Text', 'amely' ),
			'description' => esc_html__( 'The banner hashtag', 'amely' ),
			'type'        => 'textfield',
			'param_name'  => 'hashtag',
		),
		array(
			'heading'     => esc_html__( 'Description', 'amely' ),
			'description' => esc_html__( 'A short text display before the banner text', 'amely' ),
			'type'        => 'textarea',
			'param_name'  => 'desc',
		),
		array(
			'heading'     => esc_html__( 'Title', 'amely' ),
			'description' => esc_html__( 'The banner title', 'amely' ),
			'type'        => 'textarea_html',
			'param_name'  => 'content',
		),
		array(
			'heading'     => esc_html__( 'Text Position', 'amely' ),
			'description' => esc_html__( 'Select the position for title and description', 'amely' ),
			'type'        => 'dropdown',
			'param_name'  => 'text_position',
			'value'       => array(
				esc_html__( 'Top Left', 'amely' )      => 'top-left',
				esc_html__( 'Top Right', 'amely' )     => 'top-right',
				esc_html__( 'Top Center', 'amely' )    => 'top-center',
				esc_html__( 'Middle Left', 'amely' )   => 'middle-left',
				esc_html__( 'Middle Right', 'amely' )  => 'middle-right',
				esc_html__( 'Middle Center', 'amely' ) => 'middle-center',
				esc_html__( 'Bottom Left', 'amely' )   => 'bottom-left',
				esc_html__( 'Bottom Right', 'amely' )  => 'bottom-right',
				esc_html__( 'Bottom Center', 'amely' ) => 'bottom-center',
				esc_html__( 'Custom', 'amely' )        => 'custom',
			),
		),
		array(
			'heading'     => esc_html__( 'Custom position', 'amely' ),
			'description' => esc_html__( 'Custom position of the banner text. E.g: top:30%;left:30%;', 'amely' ),
			'type'        => 'textfield',
			'param_name'  => 'custom_position',
			'dependency'  => array(
				'element' => 'text_position',
				'value'   => 'custom',
			),
		),
		array(
			'heading'     => esc_html__( 'Text Alignment', 'amely' ),
			'description' => esc_html__( 'Horizontal alignment of banner text', 'amely' ),
			'type'        => 'dropdown',
			'param_name'  => 'text_align',
			'value'       => array(
				esc_html__( 'Left', 'amely' )   => 'left',
				esc_html__( 'Center', 'amely' ) => 'center',
				esc_html__( 'Right', 'amely' )  => 'right',
			),
		),
		Amely_VC::get_param( 'el_class' ),

		// Color
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Hashtag Color', 'amely' ),
			'param_name' => 'color_hashtag',
			'value'      => '#f8f8f8',
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Description Color', 'amely' ),
			'param_name' => 'color_desc',
			'value'      => '#333333',
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Banner Text Color', 'amely' ),
			'param_name' => 'color_content',
			'value'      => '#333333',
		),


		// Button
		array(
			'group'       => esc_html__( 'Button', 'amely' ),
			'heading'     => esc_html__( 'Button Text', 'amely' ),
			'description' => esc_html__( 'Enter button text', 'amely' ),
			'type'        => 'textfield',
			'param_name'  => 'button_text',
		),
		array(
			'group'       => esc_html__( 'Button', 'amely' ),
			'heading'     => esc_html__( 'Button Visibility', 'amely' ),
			'description' => esc_html__( 'Select button visibility', 'amely' ),
			'type'        => 'dropdown',
			'param_name'  => 'button_visibility',
			'value'       => array(
				esc_html__( 'Always visible', 'amely' ) => 'always',
				esc_html__( 'When hover', 'amely' )     => 'hover',
				esc_html__( 'Hidden', 'amely' )         => 'hidden',
			),
		),
		array(
			'group'       => esc_html__( 'Button', 'amely' ),
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Button Style', 'amely' ),
			'param_name'  => 'button_style',
			'value'       => array(
				esc_html__( 'Default', 'amely' )     => '',
				esc_html__( 'Alternative', 'amely' ) => 'alt',
				esc_html__( 'Link', 'amely' )        => 'link',
				esc_html__( 'Custom', 'amely' )      => 'custom',
			),
			'description' => esc_html__( 'Select button style.', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'Button', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Text Color', 'amely' ),
			'param_name' => 'button_color',
			'value'      => '#fff',
			'dependency' => array(
				'element' => 'button_style',
				'value'   => array( 'custom', 'link' ),
			),
		),
		array(
			'group'      => esc_html__( 'Button', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Text Color (on hover)', 'amely' ),
			'param_name' => 'button_color_hover',
			'value'      => '#fff',
			'dependency' => array(
				'element' => 'button_style',
				'value'   => array( 'custom', 'link' ),
			),
		),
		array(
			'group'      => esc_html__( 'Button', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'amely' ),
			'param_name' => 'button_bg_color',
			'value'      => amely_get_option( 'secondary_color' ),
			'dependency' => array(
				'element' => 'button_style',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Button', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color (on hover)', 'amely' ),
			'param_name' => 'button_bg_color_hover',
			'value'      => amely_get_option( 'primary_color' ),
			'dependency' => array(
				'element' => 'button_style',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Button', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'amely' ),
			'param_name' => 'button_border_color',
			'value'      => amely_get_option( 'secondary_color' ),
			'dependency' => array(
				'element' => 'button_style',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Button', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color (on hover)', 'amely' ),
			'param_name' => 'button_border_color_hover',
			'value'      => amely_get_option( 'primary_color' ),
			'dependency' => array(
				'element' => 'button_style',
				'value'   => 'custom',
			),
		),

		// Animation
		array(
			'group'      => esc_html__( 'Animation', 'amely' ),
			'type'       => 'animation_style',
			'heading'    => esc_html__( 'Banner Animation', 'amely' ),
			'param_name' => 'animation',
			'settings'   => array(
				'type' => array( 'in', 'other' ),
			),
		),

		Amely_VC::get_param( 'css' ),

	),
) );

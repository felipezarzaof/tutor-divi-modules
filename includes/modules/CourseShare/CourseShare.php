<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseShare extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_share';
	public $vb_support = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	public function init() {
		// Module name & icon
		$this->name			= esc_html__('Tutor Course Share', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'label' => array(
						'title'    => esc_html__('Label', 'tutor-divi-modules'),
					),
					'icons' => array(
						'title'    => esc_html__('Icons', 'tutor-divi-modules'),
					),
				),
			),
		);

        $wrapper 				= '%%order_class%% .tutor-social-share';
        $icon_wrapper_selector	= '%%order_class%% .tutor-social-share-wrap';
		$icon_selector   		= '%%order_class%% .tutor-social-share-wrap button i';
		$button_selector		= '%%order_class%% .tutor-social-share-wrap button';
        $label_selector			= '%%order_class%% .tutor-social-share > label';

		$this->advanced_fields = array(
			'fonts'				=> array(
				'label' => array(
					'label'        		=> esc_html__('Label', 'tutor-divi-modules'),
					'css'          		=> array(
						'main'	=> $label_selector,
					),
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'label',
					'hide_text_align'	=> true,
				),
			),
			// 'borders'    => array(
			
			// 	'default'            => array(),
			// 	'image'              => array(
			// 		'css'             => array(
			// 			'main' => array(
			// 				'border_radii'  => $icon_selector,
			// 				'border_styles' => $icon_selector,
			// 			),
			// 		),
			// 		'tab_slug'        => 'advanced',
			// 		'toggle_slug'     => 'icons',
			// 	),
			// ),	
			'borders'        => array(
				'icons' => array(
					'css'      => array(
						'main' => array(
							'border_radii'	=>  "{$this->main_css_element} .tutor-social-share-wrap i",//$icon_selector,
							'border_styles' => $icon_selector,
						),
					),
					'defaults' => array(
						'border_radii' => 'on|3px|3px|3px|3px',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'icons',
				),
			),	
				
			'text'				=> false,
		);
	}

	/**
	 * Module's specific fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_fields() {
		$fields = array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__share',
					),
				)
			),
			'__share'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseShare',
					'get_props',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			//general settings tab main_content toggle
			'share_label'	=> array(
				'label'				=> esc_html__('Label', 'tutor-divi-modules'),
				'type'				=> 'yes_no_button',
				'option_category'	=> 'configuration',
				'options'			=> array(
					'off'	=> esc_html__('Hide', 'tutor-divi-modules'),
					'on'	=> esc_html__('Show', 'tutor-divi-modules')
				),
				'default_on_front'	=> "on",
				'toggle_slug'		=> 'main_content',	
			),
			'shape'			=> array(
				'label'				=> esc_html__( 'Shape', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'options'			=> array(
					'rounded'	=> esc_html__( 'Rounded', 'tutor-divi-modules' ),
					'circle'	=> esc_html__( 'Circle', 'tutor-divi-modules' ),
					'square'	=> esc_html__( 'Square', 'tutor-divi-modules' ),
				),
				'default'			=> 'rounded',
				'option_category'	=> 'layout',
				'toggle_slug'		=> 'main_content'
			),
			'alignment'		=> array(
				'label'				=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'left',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),

			//advanced tab icon settings
			'color'			=> array(
				'label'				=> esc_html__( 'Color', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'options'			=> array(
					'official'	=> esc_html__( 'Official Color', 'tutor-divi-modules' ),
					'custom'	=> esc_html__( 'Custom', 'tutor-divi-modules' )
				),
				'default'			=> 'official',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons'
			),
			'icon_color'	=> array(
				'label'				=> esc_html__( 'Icon Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons',
				'show_if'			=> array(
					'color'		=> 'custom'
				)
			),
			'shape_color'	=> array(
				'label'				=> esc_html__( 'Shape Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons',
				'show_if'			=> array(
					'color'		=> 'custom'
				)				
			),
			'icon_size'		=> array(
				'label'				=> esc_html__( 'Icon Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default_unit'		=> 'px',
				'default'			=> '14',
				'range_settings'	=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons',		
				'mobile_options'	=> true	
			),
			//box_padding
			// 'icon_padding'	=> array(
			// 	'label'			=> esc_html__( 'Padding', 'tutor-divi-modules' ),
			// 	'type'			=> 'custom_padding',
			// 	'default'		=> '10px|10px|10px|10px',
			// 	'default_unit'	=> 'px',
			// 	'tab_slug'		=> 'advanced',
			// 	'toggle_slug'	=> 'icons'
			// ),
			'icon_padding'	=> array(
				'label'			=> esc_html__( 'Padding', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'default'		=> '10px',
				'default_unit'	=> 'px',
				'range_settings'	=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'icons'
			),
			'icon_spacing'		=> array(
				'label'				=> esc_html__( 'Spacing', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default_unit'		=> 'px',
				'default'			=> '14',
				'range_settings'	=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons',	
				'mobile_options'	=> true		
			),
		);

		return $fields;
	}

	/**
	 * computed value
	 * @return string | array course level
	 */
	public static function get_props( $args = [] ) {
		$course_id 			= $args[ 'course' ];
		$is_enable_share	= get_tutor_option('disable_course_share');
		$share_icons		= tutils()->tutor_social_share_icons();

		$props = [
			'is_enable_share'	=> $is_enable_share,
			'social_icon'		=> $share_icons
		];

		return $props;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		ob_start();
		include_once dtlms_get_template('course/share');
		return ob_get_clean();
	}

	/**
	 * Render module output
	 *
	 * @since 1.0.0
	 *
	 * @param array  $attrs       List of unprocessed attributes
	 * @param string $content     Content being processed
	 * @param string $render_slug Slug of module that is used for rendering output
	 *
	 * @return string module's rendered output
	 */
	public function render($attrs, $content = null, $render_slug) {
		//selectors
        $wrapper 				= '%%order_class%% .tutor-social-share';
        $icon_wrapper_selector	= '%%order_class%% .tutor-social-share-wrap';
		$icon_selector			= '%%order_class%% .tutor-social-share-wrap i';
        $label_selector			= '%%order_class%% .tutor-social-share > label';
		
		//props
		$alignment 				= $this->props['alignment'];
		$alignment_tablet 		= isset($this->props['alignment_tablet']) ? $this->props['alignment_tablet'] : $alignment;
		$alignment_phone 		= isset($this->props['alignment_phone']) ? $this->props['alignment_phone'] : $alignment;
		$color					= $this->props['color'];
		$icon_color				= $this->props['icon_color'];
		$shape_color			= $this->props['shape_color'];

		$icon_size				= $this->props['icon_size'];
		$icon_size_tablet		= $this->props['icon_size_tablet'];
		$icon_size_phone		= $this->props['icon_size_phone'];

		$icon_padding			= $this->props['icon_padding'];

		$icon_spacing			= $this->props['icon_spacing'];
		$icon_spacing_tablet	= $this->props['icon_spacing_tablet'];
		$icon_spacing_phone		= $this->props['icon_spacing_phone'];

		//set styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $wrapper,
				'declaration'	=> 'display:flex;column-gap: 10px;'
			)
		);
		/**
		 * set social icon official color
		 */

		//fb icon styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $icon_wrapper_selector. ' .tutor-icon-facebook',
				'declaration'	=> 'color: #fff; background-color: #3b5998;'
			)
		);

		//twitter icon styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $icon_wrapper_selector. ' .tutor-icon-twitter',
				'declaration'	=> 'color: #fff; background-color: #1da1f2;'
			)
		);

		//linkedin icon styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $icon_wrapper_selector. ' .tutor-icon-linkedin',
				'declaration'	=> 'color: #fff; background-color: #0077b5;'
			)
		);
		//tumblr icon styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $icon_wrapper_selector. ' .tutor-icon-tumblr',
				'declaration'	=> 'color: #fff; background-color: #000;'
			)
		);

		if( $color === 'custom' ) {
		 //if custom color 
			if( '' !== $icon_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'		=> $icon_wrapper_selector. ' .tutor-icon-facebook , '. $icon_wrapper_selector. ' .tutor-icon-twitter , '. $icon_wrapper_selector.' .tutor-icon-linkedin , '. $icon_wrapper_selector.' .tutor-icon-tumblr',
						'declaration'	=> sprintf(
							'color: %1$s !important;',
							esc_html($icon_color)
						)
					)
				);
			}
			if( '' !== $shape_color ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'		=> $icon_wrapper_selector. ' .tutor-icon-facebook , '. $icon_wrapper_selector. ' .tutor-icon-twitter , '. $icon_wrapper_selector.' .tutor-icon-linkedin , '. $icon_wrapper_selector.' .tutor-icon-tumblr',
						'declaration'	=> sprintf(
							'background-color: %1$s !important;',
							esc_html($shape_color)
						)
					)
				);
			}			
		}

		//icon size
		if( '' !== $icon_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s !important;',
						$icon_size
					)
				)
			);
		}
		if( '' !== $icon_size_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s !important;',
						$icon_size_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);
		}
		if( '' !== $icon_size_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s !important;',
						$icon_size_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);
		}

		//icon spacing
		//icon display flex default
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector' 		=> $icon_wrapper_selector,
				'declaration'	=> 'display: flex !important;'
			)
		);
		if( '' !== $icon_spacing ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> $icon_wrapper_selector,
					'declaration'	=> sprintf(
						'column-gap: %1$s !important;',
						$icon_spacing
					)
				)
			);			
		}
		if( '' !== $icon_spacing_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> $icon_wrapper_selector,
					'declaration'	=> sprintf(
						'column-gap: %1$s !important;',
						$icon_spacing_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);			
		}
		if( '' !== $icon_spacing_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> $icon_wrapper_selector,
					'declaration'	=> sprintf(
						'column-gap: %1$s !important;',
						$icon_spacing_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);			
		}

		//icon padding
		if( '' !== $icon_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> $icon_selector,
					'declaration'	=> sprintf(
						'padding: %1$s !important;',
						$icon_padding
					)
				)
			);			
		}
		//set styles end

		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseShare;

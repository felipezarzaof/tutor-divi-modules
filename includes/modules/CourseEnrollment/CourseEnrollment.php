<?php

/**
* Tutor Course Enrollment Module for Divi Builder
* @since 1.0.0
*/
use TutorLMS\Divi\Helper;

class CourseEnrollment extends ET_Builder_Module {

	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_enrollment';
	public $vb_support = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

    public function init() {
		// Module name & icon
		$this->name			= esc_html__('Tutor Course Enrollment', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition 
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content'  => esc_html__( 'Content', 'tutor-divi-modules' ),
					'customize_btn' => esc_html__( 'Button', 'tutor-divi-modules' ),
				),
			),
			'advanced' => array(
                'toggles'   => array(
                    'enrollment_button'     => esc_html__( 'Button', 'tutor-divi-modules' ),
                    'start_continue_button' => esc_html__( 'Start/Continue Button', 'tutor-divi-modules' ),
                    'complete_button'       => esc_html__( 'Complete Button', 'tutor-divi-modules' ),
                    'enrolled_info'         => esc_html__( 'Enrolled Info', 'tutor-divi-modules' ),
                )
			),
		);

        //advanced fiedls settings
        $this->advanced_fields = array(
            'fonts'         => array(

                'label_font'    => array(
                    'label'         => esc_html__( 'Label', 'tutor-divi-modules' ),
                    'css'   => array(
                        'main'      => 'selector',   
                    ),
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'enrolled_info'
                ),
                'date_font'    => array(
                    'label'         => esc_html__( 'Date', 'tutor-divi-modules' ),
                    'css'   => array(
                        'main'      => 'selector',   
                    ),
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'enrolled_info'
                ),
            ),

            'button'        => array(

                'enrollment_button' => array(
                    'label'         => esc_html__( 'Enroll Button', 'tutor-divi-modules' ),
                    'css'           => array(
                        'main'  => 'selctor'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'enrollment_button' ,
                    'show_if'       => array(
                        'preview_mode'  => 'enrollment'
                    )  
                ),
                'add_to_cart_button' => array(
                    'label'         => esc_html__( 'Add to Cart Button', 'tutor-divi-modules' ),
                    'css'           => array(
                        'main'  => 'selctor'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'enrollment_button' ,
                    'show_if'       => array(
                        'preview_mode'  => 'enrollment'
                    )  
                ),
                'start_continue_button' => array(
                    'label'         => esc_html__( 'Start/Continue Button', 'tutor-divi-modules' ),
                    'css'           => array(
                        'main'  => 'selctor'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'start_continue_button'   
                ),
                'complete_button' => array(
                    'label'         => esc_html__( 'Button', 'tutor-divi-modules' ),
                    'css'           => array(
                        'main'  => 'selctor'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'complete_button'   
                ),
                'gradebook_button' => array(
                    'label'         => esc_html__( 'Gradebook Button', 'tutor-divi-modules' ),
                    'css'           => array(
                        'main'  => 'selctor'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'complete_button'   
                ),
            )

        );
    }

    public function get_fields() {
        return array(
            'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__enrollment',
					),
				)
			),
            '__enrollment'  => array(
                'type'          => 'computed',
                'computed_callback' => array(
                    'CourseEnrollment',
                    'get_props'
                ),
                'computed_depends_on'   => array(
                    'course'
                ),
                'computed_minimum'      => array(
                    'course'
                )
            ),
            //general tab main_content toggle
            'preview_mode'      => array(
                'label'             => esc_html__( 'Preview Mode', 'tutor-divi-modules' ),
                'type'              => 'select',
                'options'           => array(
                    'enrollment'  => esc_html__( 'Enrollment', 'tutor-divi-modules' ),
                    'enrolled'    => esc_html__( 'Enrolled', 'tutor-divi-modules' ),
                ),
                'default'           => 'enrollment',
                'toggle_slug'       => 'main_content'
            ),
            //general tab customize_btn toggle
			'alignment'		=> array(
				'label'				=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'center',
				'toggle_slug'		=> 'customize_btn',
				'mobile_options'	=> true
			),
            'size'      => array(
                'label'             => esc_html__( 'Size', 'tutor-divi-modules' ),
                'type'              => 'select',
                'option_category'   => 'basic_option',
                'options'           => array(
                    'small'     => esc_html__( 'Small', 'tutor-divi-modules' ),
                    'medium'    => esc_html__( 'Medium', 'tutor-divi-modules' ),
                    'large'     => esc_html__( 'Large', 'tutor-divi-modules' ),
                ),
                'default'           => 'medium',
                'toggle_slug'       => 'customize_btn'
            ),
            'btn_width'      => array(
                'label'             => esc_html__( 'Width', 'tutor-divi-modules' ),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'options'           => array(
                    'auto'      => esc_html__( 'Auto', 'tutor-divi-modules' ),
                    'fill'      => esc_html__( 'Fill', 'tutor-divi-modules' ),
                    'fixed'     => esc_html__( 'Fixed', 'tutor-divi-modules' ),
                ),
                'default'           => 'fill',
                'toggle_slug'       => 'customize_btn'
            ),
            //advanced tab enrolled_info toggle
			'icon_size'			=> array(
				'label'				=> esc_html__( 'Icon Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '10px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'enrolled_info',
				'mobile_options'	=> true
			),
            'icon_color'    => array(
                'label'         => esc_html__( 'Icon Color', 'tutor-divi-modules' ),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'enrolled_info'
            ),
            'label_color'    => array(
                'label'         => esc_html__( 'Label Color', 'tutor-divi-modules' ),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'enrolled_info'
            ),
            'date_color'    => array(
                'label'         => esc_html__( 'Date Color', 'tutor-divi-modules' ),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'enrolled_info'
            ),
        );
    }
	/**
	 * Get props
	 */
    public static function get_props( $args = [] ) {

    }

	/**
	 * Get content
	 *
	 * @return string
	 */
    public function get_content( $args = [] ) {
        ob_start();
        $is_enrolled = tutils()->is_enrolled();
        $is_administrator = current_user_can('administrator');
        $is_instructor = tutor_utils()->is_instructor_of_this_course();
        $course_content_access = (bool) get_tutor_option('course_content_access_for_ia');
      
        $template = 'enrolment_box';
        if ($is_enrolled || ($course_content_access && ($is_administrator || $is_instructor))) {
            $template = 'enrolled-box';
        } else {
            $template = 'enrolment-box';
        }
        include_once dtlms_get_template  ('course/'.$template);        
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
    public function render ( $attrs, $content = null, $render_slug ) {
        //selectors
        $wrapper                = '%%order_class%% .tutor-divi-enroll-buttons-wrapper';
        $three_buttons_wrapper  = '%%order_class%% .tutor-lead-info-btn-group';
        $enroll_box_selector    = '%%order_class%% .tutor-single-add-to-cart-box';
        //props
        $alignment              = $this->props['alignment'];
        $alignment_tablet       = isset($this->props['alignment_tablet']) && $this->props['alignment_tablet'] !== '' ? $this->props['alignment_tablet'] : $alignment;
        $alignment_phone        = isset($this->props['alignment_phone']) && $this->props['alignment_phone'] !== '' ? $this->props['alignment_phone'] : $alignment;

        $alignment              = ($alignment === 'left' ? 'flex-start' : ($alignment === 'right' ? 'flex-end' : ''));
        $alignment_tablet       = ($alignment_tablet === 'left' ? 'flex-start' : ($alignment_tablet === 'right' ? 'flex-end' : ''));
        $alignment_phone        = ($alignment_phone === 'left' ? 'flex-start' : ($alignment_phone === 'right' ? 'flex-end' : ''));

        //set styles 
        if( $alignment !== '' ) {
            //enrolled_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $three_buttons_wrapper,
                    'declaration'   => sprintf(
                        'align-items: %1$s;',
                        $alignment
                    )
                )
            );

            //enrollment_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-purchase-box',
                    'declaration'   => sprintf(
                        'align-items: %1$s;',
                        $alignment
                    )
                )
            );
        }

        if( $alignment_tablet !== '' ) {
            //enrolled_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $three_buttons_wrapper,
                    'declaration'   => sprintf(
                        'align-items: %1$s;',
                        $alignment_tablet
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_980')
                )
            );

            //enrollment_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-purchase-box',
                    'declaration'   => sprintf(
                        'align-items: %1$s;',
                        $alignment_tablet
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_980')
                )
            );
        }
        if( $alignment_phone !== '' ) {
            //enrolled_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $three_buttons_wrapper,
                    'declaration'   => sprintf(
                        'align-items: %1$s;',
                        $alignment_phone
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
                )
            );

            //enrollment_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-purchase-box',
                    'declaration'   => sprintf(
                        'align-items: %1$s;',
                        $alignment_phone
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
                )
            );
        }

        //set styles end

        $output = self::get_content( $this->props );
        if( '' === $output) {
            return '';
        }
        return $this->_render_module_wrapper( $output, $render_slug );
    }

}
new CourseEnrollment;


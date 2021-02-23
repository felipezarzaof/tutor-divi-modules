<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseLevel extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_level';
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
		$this->name			= esc_html__('Tutor Course Level', 'tutor-divi-modules');
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
					'label_text' => array(
						'title'    => esc_html__('Label', 'tutor-divi-modules'),
					),
					'value_text' => array(
						'title'    => esc_html__('Value', 'tutor-divi-modules'),
					),
				),
			),
		);
		
		$selector = '%%order_class%% .tutor-single-course-meta ul li.tutor-course-level';
		$this->advanced_fields = array(
			'fonts'          => array(
				'label_text' => array(
					'label'        => esc_html__('Label', 'tutor-divi-modules'),
					'css'          => array(
						'main' => $selector.' strong',
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'course_level_label_value_style',
					'sub_toggle'		=> 'label_subtoggle'
				),
				'value_text' => array(
					'label'        		=> esc_html__('Name', 'tutor-divi-modules'),
					'css'          		=> array(
						'main' => $selector,
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'course_level_label_value_style',
					'sub_toggle'		=> 'value_subtoggle'
				),
			),
			'button'		=> false,
			'text'			=> false
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
						'__level',
					),
				)
			),
			'__level'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseLevel',
					'get_props',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			//general tab settings content toggle
			'course_level_label'	=> array(
				'label'			=> esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'			=> 'text',
				'default'		=> 'Course Level:',
				'toggle_slug'	=> 'main_content'
			),
			'layout'		=> array(
				'label'				=> esc_html__( 'Layout', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'option_category'	=> 'layout',
				'options'			=> array(
					'row'		=> esc_html__( 'Left', 'tutor-divi-modules' ),
					'column'	=> esc_html__( 'Up', 'tutor-divi-modules' )
				),
				'default'			=> 'row',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
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
			'gap'			=> array(
				'label'				=> esc_html__( 'Gap', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'option_category'	=> 'layout',
				'default_unit'		=> 'px',
				'default'			=> '5',
				'range_settings'	=> array(
					'min'		=> '1',
					'max'		=> '100',
					'step'		=> '1'
				),
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),			
		);

		return $fields;
	}

	/**
	 * custom tabs for label & value
	 */
	public function get_settings_modal_toggles () {
		return array(
			'advanced'	=> array(
				'toggles'	=> array(
					'course_level_label_value_style'		=> array(
						'priority'		=> 24,
						'sub_toggles'	=> array(
							'label_subtoggle'	=> array(
								'name'	=> esc_html__('Label', 'tutor-divi-modules')
							),
							'value_subtoggle'	=> array(
								'name'	=> esc_html__('Value', 'tutor-divi-modules')
							),
						),
						'tabbed_subtoggles' => true,
						'title' => esc_html__('Style', 'tutor-divi-modules'),
					),
				)
			)
		);
	}

	/**
	 * computed value
	 * @return string | array course level
	 */
	public function get_props( $args = [] ) {
		$course_id = $args['course'];
		$disable_course_level = get_tutor_option('disable_course_level');
		$level = get_tutor_course_level( $course_id ) ? get_tutor_course_level( $course_id ) : __('All Level', 'tutor-divi-modules');
		$props = array(
			'is_disable_level'	=> $disable_course_level,
			'level'				=> $level
		);
		return $props;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);
		ob_start();
		if ($course) {
			include_once dtlms_get_template('course/level');
		}

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

		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseLevel;

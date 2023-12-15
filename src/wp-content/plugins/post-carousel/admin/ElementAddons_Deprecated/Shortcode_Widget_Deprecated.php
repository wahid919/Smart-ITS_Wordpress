<?php
/**
 * The plugin elementor addons Initializer.
 *
 * @link       https://shapedplugin.com/
 * @since      2.4.2
 *
 * @package    Smart_Post_Show
 * @subpackage Smart_Post_Show/Admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

/**
 * Elementor smart post show free shortcode Widget.
 *
 * @since 2.4.1
 */
class Shortcode_Widget_Deprecated extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 2.4.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'smart_post_show_free_shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * @since 2.4.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Smart Post Show Deprecated', 'post-carousel' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 2.2.5
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'icon-sps-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 2.2.5
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'deprecated' );
	}

	/**
	 * Get all post list.
	 *
	 * @since 2.2.5
	 * @return array
	 */
	public function sp_pcp_post_list() {
		$post_list    = array();
		$sp_pcp_posts = new \WP_Query(
			array(
				'post_type'      => 'sp_post_carousel',
				'post_status'    => 'publish',
				'posts_per_page' => 10000,
			)
		);
		$posts        = $sp_pcp_posts->posts;
		foreach ( $posts as $post ) {
			$post_list[ $post->ID ] = $post->post_title;
		}
		krsort( $post_list );
		return $post_list;
	}

	/**
	 * Controls register.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Content', 'post-carousel' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'sp_smart_post_show_free_shortcode',
			array(
				'label'       => __( 'Smart Post Show Shortcode(s)', 'post-carousel' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'default'     => '',
				'options'     => $this->sp_pcp_post_list(),
			)
		);

		$this->add_control(
			'deprecated_notice',
			array(
				'type'            => \Elementor\Controls_Manager::DEPRECATED_NOTICE,
				'widget'          => 'Smart Post Show Deprecated',
				'since'           => '2.4.13',
				'last'            => '2.6.0',
				'plugin'          => 'Smart Post Show',
				'replacement'     => 'Smart Post Show',
				'content_classes' => 'sp-post-carousel-elementor-widget-deprecated',
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render smart post show free shortcode widget output on the frontend.
	 *
	 * @since 2.4.1
	 * @access protected
	 */
	protected function render() {

		$settings         = $this->get_settings_for_display();
		$sp_pcp_shortcode = $settings['sp_smart_post_show_free_shortcode'];

		if ( '' === $sp_pcp_shortcode ) {
			echo '<div style="text-align: center; margin-top: 0; padding: 10px" class="elementor-add-section-drag-title">Select a shortcode</div>';
			return;
		}

		$generator_id = $sp_pcp_shortcode;

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$pcp_gl_id = $generator_id; // Smart Post Show global ID for Shortcode metaboxes.

			// Preset Layouts.
			$layout = get_post_meta( $pcp_gl_id, 'sp_pcp_layouts', true );

			// All the visible options for the Shortcode like – Global, Filter, Display, Popup, Typography etc.
			$view_options  = get_post_meta( $pcp_gl_id, 'sp_pcp_view_options', true );
			$section_title = get_the_title( $pcp_gl_id );

			SP_PC_Output::pc_html_show( $view_options, $layout, $pcp_gl_id, $section_title );
			?>
			<script src="<?php echo esc_url( SP_PC_URL . 'public/assets/js/scripts.min.js' ); ?>" ></script>
			<?php
		} else {
			echo do_shortcode( '[smart_post_show id="' . $generator_id . '"]' );
		}

	}

}

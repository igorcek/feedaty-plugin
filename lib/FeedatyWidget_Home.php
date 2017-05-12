<?php 

class FeedatyWidget_Home extends WP_Widget{
	
	
	private $slug;

	public function __construct() {
		$this->slug = get_option('wid-store-style');

		$wf = new FeedatyWidgetFactory(new FeedatyCurlCaller());
		$widget_ops = array(
				'classname' => "Feedaty home medium no reviews",
				'description' => $wf->getWidgetCode($this->slug, 'description'),
		);
		parent::__construct( $this->slug, "Feedaty ".$wf->getWidgetCode($this->slug, 'name_shown'), $widget_ops );
	}
	

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args ['before_widget'];
		echo $instance['codice'];
		echo $args ['after_widget'];
	}
	
	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$curlCaller = new FeedatyCurlCaller();
			$factory = new FeedatyWidgetFactory($curlCaller);
		$info = esc_textarea( $instance['info'] );
		?>
		<p>
			<textarea readonly class="widefat"
				id="<?php echo esc_attr($this->get_field_id('codice'));?>"
				name="<?php echo esc_attr($this->get_field_name('codice'));?>"
				rows="5" cols="40"><?php echo $factory->getWidgetCode($this->slug, 'html_embed').$curlCaller->getMerchantRichSnippet();?></textarea>
		</p>
		<?php 		
	}
	
	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance ['title'] = (! empty ( $new_instance ['title'] )) ? strip_tags ( $new_instance ['title'] ) : '';
		$instance['codice'] = ($new_instance['codice']);		
		return $instance;	
	}
}
<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.opushive.com
 * @since      1.0.0
 *
 * @package    Popup_On_Yt_Video_End
 * @subpackage Popup_On_Yt_Video_End/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Popup_On_Yt_Video_End
 * @subpackage Popup_On_Yt_Video_End/public
 * @author     Opus Hive <valentine@opushive.com>
 */
class Popup_On_Yt_Video_End_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Popup_On_Yt_Video_End_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Popup_On_Yt_Video_End_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/popup-on-yt-video-end-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Popup_On_Yt_Video_End_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Popup_On_Yt_Video_End_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_script('yt-frame-api', "https://www.youtube.com/iframe_api");
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/popup-on-yt-video-end-public.js', array( 'jquery', 'thickbox', 'yt-frame-api'), $this->version, false );

	}
	public function init()
	{
		if(!is_admin()){
			add_thickbox();
		}
		add_shortcode( 'popup-on-youtube-end', array($this, 'youtube_event_pop') );
	}
	public function youtube_event_pop($atts = [], $content = null, $tag = '')
	{
		try{
			$default = array(
				"iframe-id" => "yt-".uniqid(),
				"selector" => "",
				"youtube-id" => "",
				"css" => "",
				"modal_width" => "400",
				"modal_height" => "300",
				"title" => "",
			);

			//fix error on wordpress 4.2.13 
			
			//$atts = array("iframe-id='hello'", "youtube-id='2BB1j_sxJMk'" );
			$keys = array_keys($atts);

			if(!array_key_exists('iframe-id', $atts) && is_int($keys[0]) ){
				$normalized = array();
				foreach ($atts as $value) {
					$key_value = explode("=", $value);
					$normalized[$key_value[0]] =  trim($key_value[1], ",' ");
				}
				$atts = $normalized;
			}

			//end fix
			$atts = array_change_key_case((array)$atts, CASE_LOWER);
			$values = shortcode_atts($default, $atts, $tag);
			$id = $values["iframe-id"];
			$href = sprintf("#TB_inline?height=%s&width=%s&inlineId=popup-{$id}", $values['modal_height'], $values['modal_width']);

			ob_start();
			?>
					<?php if(isset($values["css"])&& !empty($values["css"])) : ?>
						<style>
							<?php echo $values["css"]; ?>
						</style>
					<?php endif;?>
	                <?php if (isset($values["youtube-id"]) && !empty($values["youtube-id"])) : ?>
	                	<div class="yt-with-popup-at-end">
	                    	<div id="<?php echo esc_attr( $id );?>"></div>
	                	</div>
	                <?php endif; ?>
	                <div  id="<?php echo 'popup-'.$id; ?>" style="display:none">
						<?php echo apply_filters('the_content', $content); ?>
					</div>    

			<?php

			$html = ob_get_clean();

			/* prepare embeded script for youtube api */



			$popyt = array(
				"selector" => isset($values["selector"]) && !empty($values["selector"]) ? $values["selector"] : "#{$id}" ,
				"activator" => "#activator-{$id}",
				"url" => $href,
				"title" => $values["title"],
			);

			if (isset($values["youtube-id"]) && !empty($values["youtube-id"])) :

				$popyt['videoId'] = $values["youtube-id"];

			endif;

			wp_localize_script("yt-frame-api" , "PopupYT", $popyt);

			wp_enqueue_script("yt-frame-api");
			wp_enqueue_script($this->plugin_name);


			return $html;
			
		}catch(Exception $e) {
			//error_log($e);
			echo ($e->getMessage());
		}
	}

}

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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/popup-on-yt-video-end-public.js', array( 'jquery' ), $this->version, false );

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
				"iframe-id" => "",
				"youtube-id" => "",
				"css" => "",
			);
			//fix error on wordpress 4.2.13 
			
			//$atts = array("iframe-id='hello'", "youtube-id='2BB1j_sxJMk'" );
			if(!array_key_exists('iframe-id', $atts) && strpos($atts[0], "iframe-id") !== false ){
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
			$href = "#TB_inline?height=300&width=400&inlineId=popup-{$id}";

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
	                <a id="<?php echo 'activator-'.esc_attr( $id );?>" href="<?php echo $href; ?>" class="thickbox" style="display:none">Display content</a>
	                <div  id="<?php echo 'popup-'.$id; ?>" style="display:none">
						<?php echo apply_filters('the_content', $content); ?>
					</div>    

			<?php

			/* prepare embeded script for youtube api */

			$html = ob_get_clean();
			ob_start();
			?>
				var player;
				function onYouTubeIframeAPIReady() {
				    // first video
				    player = new YT.Player('<?php echo $id;  ?>', {
				    	<?php if (isset($values["youtube-id"]) && !empty($values["youtube-id"])) : ?>
				    		<?php echo "videoId: '{$values['youtube-id']}', ";?>
				    	<?php endif; ?>
				        events: {
				            'onReady': function(){ console.log("Ready!"); },
				            'onStateChange': onPlayerStateChange
				        }
				    });
				}

				function onPlayerStateChange(event) {
				    if (event.data == YT.PlayerState.ENDED) {
				    	jQuery("#activator-<?php echo esc_attr( $id ); ?>").click();
				        console.log('player stopped');
				    }
				}

			<?php
			$frameScript = ob_get_clean();

			wp_enqueue_script("yt-frame-api");

			wp_add_inline_script( "yt-frame-api", $frameScript, 'after' );

			return $html;
			
		}catch(Exception $e){
			//error_log($e);
			var_dump($e->getMessage());
		}
	}

}

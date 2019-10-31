<?php
/**
 * WPHEALTHTRACKER UI Display Template Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_UI_Display_Template', false ) ) :
	/**
	 * WPHEALTHTRACKER_UI_Display_Template Class.
	 */
	class WPHEALTHTRACKER_UI_Display_Template {

		public static function output_open_display_container( $title, $iconurl ) {
			return '<div class="wphealthtracker-display-container">
            <p class="wphealthtracker-display-top-title"><img class="wphealthtracker-display-title-icon" src="' . $iconurl . '" />' . $title . '</p>
            <div class="wphealthtracker-display-inner-container">';
		}

		public static function output_open_display_stats_container( $title, $iconurl ) {
			return '<div class="wphealthtracker-display-container">
            <div class="wphealthtracker-stats-title-inner-div"><img class="wphealthtracker-display-title-icon-stats" src="' . $iconurl . '" /><img class="wphealthtracker-display-title-icon-stats-plus" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'plus.svg" /><img class="wphealthtracker-display-title-icon-stats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg" /></div><p class="wphealthtracker-display-top-title-stats">' . $title . '</p>
            <div class="wphealthtracker-display-inner-container">';
		}

		public static function output_close_display_container() {
			return '</div></div>';
		}

		public static function output_template_advert() {
			return '<div class="wphealthtracker-display-container">
              <div id="wphealthtracker-display-advert-site-div">
                  <div id="wphealthtracker-display-advert-visit-me-title">For Everything WPHEALTHTRACKER</div>
                  <a target="_blank" id="wphealthtracker-display-advert-visit-me-link" href="http://wphealthtracker.com/">
                    <img src="http://wpbooklist.com/wp-content/uploads/2017/08/Screenshot-2017-08-29-14.24.55.png">
                    WPHEALTHTRACKER.com
                  </a>
              </div>
              <p id="wphealthtracker-display-advert-email-me">E-mail with questions, issues, concerns, suggestions, or anything else at <a href="mailto:general@wphealthtracker.com">General@wphealthtracker.com</a></p>
              <div id="wphealthtracker-display-advert-money-container">
                  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="VUVFXRUQ462UU">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                  </form>

                  <a target="_blank" id="wphealthtracker-patreon-link" href="http://patreon.com/user?u=3614120"><img id="wphealthtracker-patreon-img" src="' . WPHEALTHTRACKER_ROOT_IMG_URL . 'patreon.png"></a>
                  <a href="https://ko-fi.com/A8385C9" target="_blank"><img height="34" style="border:0px;height:34px;" src="' . WPHEALTHTRACKER_ROOT_IMG_URL . 'kofi1.png" border="0" alt="Buy Me a Coffee at ko-fi.com"></a>
                  <p>And be sure to <a target="_blank" href="https://wordpress.org/support/plugin/wphealthtracker/reviews/">leave a 5-star review of WPHEALTHTRACKER!</a></p>
              </div>
            </div>';
		}

	}

endif;



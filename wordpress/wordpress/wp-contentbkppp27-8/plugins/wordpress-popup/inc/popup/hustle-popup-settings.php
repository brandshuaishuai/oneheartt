<?php

class Hustle_Popup_Settings extends Hustle_Meta {

	public function get_defaults() {
		$base = $this->get_settings_base_defaults();

		// Specific for popups.
		$settings = array_merge( $base, array(
			'allow_scroll_page' => '0',
			'close_on_background_click' => '1',
			'auto_hide' => '0',
			'auto_hide_unit' => 'seconds',
			'auto_hide_time' => '5',
		));

		return $settings;
	}
}

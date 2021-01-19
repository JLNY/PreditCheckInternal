<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Admin
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

/**
 * Abstract subclass of Genesis_Admin which adds support for displaying a form.
 *
 * This class must be extended when creating an admin page with a form, and the
 * settings_form() method must be defined in the subclass.
 *
 * @since 1.8.0
 *
 * @package Genesis\Admin
 */
abstract class Genesis_Admin_Form extends Genesis_Admin {

	/**
	 * Output settings page form elements.
	 *
	 * Must be overridden in a subclass, or it obviously won't work.
	 *
	 * @since 1.8.0
	 */
	abstract public function form();

	/**
	 * Normal settings page admin.
	 *
	 * Includes the necessary markup, form elements, etc.
	 * Hook to {$this->pagehook}_settings_page_form to insert table and settings form.
	 *
	 * Can be overridden in a child class to achieve complete control over the settings page output.
	 *
	 * @since 1.8.0
	 */
	public function admin() {

		include GENESIS_VIEWS_DIR . '/pages/genesis-admin-form.php';

	}

	/**
	 * Initialize the settings page, by hooking the form into the page.
	 *
	 * @since 1.8.0
	 */
	public function settings_init() {

		add_action( "{$this->pagehook}_settings_page_form", [ $this, 'form' ] );

	}

}

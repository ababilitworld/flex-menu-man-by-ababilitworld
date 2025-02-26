<?php
namespace Ababilitworld\FlexMenuManByAbabilitworld\Package\Wordpress\Menu\Concrete;

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

use Ababilitworld\{
    FlexTraitByAbabilitworld\Standard\Standard,
    FlexMenuManByAbabilitworld\Package\Menu\Base\Menu as BaseMenu,
};

use const Ababilitworld\FlexMenuManByAbabilitworld\{
    PLUGIN_NAME,
    PLUGIN_DIR,
    PLUGIN_URL,
    PLUGIN_FILE,
    PLUGIN_VERSION
};

if ( ! class_exists( __NAMESPACE__.'\Menu' ) ) 
{
    /**
     * Concrete Class ThemeSettingsMenu
     * Implements the WordPress admin menu for theme settings
     */
    class Menu extends BaseMenu
    {
        protected string $menu_slug = 'theme-settings';

        /**
         * Constructor to define submenus
         */
        public function __construct()
        {
            parent::__construct();

            // Add submenus dynamically
            $this->add_submenu('Color Schemes', 'Color Schemes', 'edit.php?post_type=color_scheme', null);
            $this->add_submenu('Active Color Scheme', 'Active Color Scheme', 'active-color-scheme', [$this, 'active_color_scheme_page']);
        }

        /**
         * Renders the main settings page
         */
        public function render_page(): void
        {
            echo '<h1>Theme Settings</h1>';
        }

        /**
         * Get the page title
         */
        protected function get_page_title(): string
        {
            return 'Theme Settings';
        }

        /**
         * Get the menu title
         */
        protected function get_menu_title(): string
        {
            return 'Theme Settings';
        }

        /**
         * Renders the active color scheme page
         */
        public function active_color_scheme_page(): void
        {
            echo '<h1>Active Color Scheme</h1>';
        }
    }

    // Usage Example
    if (is_admin()) {
        new ThemeSettingsMenu();
    }

}
	
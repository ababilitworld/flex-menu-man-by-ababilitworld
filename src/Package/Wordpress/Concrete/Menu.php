<?php
namespace Ababilitworld\FlexMenuManByAbabilitworld\Package\Wordpress\Concrete;

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

use Ababilitworld\{
    FlexTraitByAbabilitworld\Standard\Standard,
    FlexMenuManByAbabilitworld\Package\Wordpress\Base\Menu as BaseMenu,
};

use const Ababilitworld\FlexMenuManByAbabilitworld\{
    PLUGIN_NAME,
    PLUGIN_DIR,
    PLUGIN_URL,
    PLUGIN_FILE,
    PLUGIN_VERSION
};

if (!class_exists(__NAMESPACE__.'\Menu')) 
{
    /**
     * Concrete Class ThemeSettingsMenu
     * Implements the WordPress admin menu for theme settings
     */
    class Menu extends BaseMenu
    {
        /**
         * Constructor to define menu properties and submenus
         */
        public function __construct()
        {
            $this->page_title    = 'Theme Settings';
            $this->menu_title    = 'Theme Settings';
            $this->capability    = 'manage_options';
            $this->menu_slug     = 'theme-settings';
            $this->callback      = [$this, 'render_page'];
            $this->menu_icon     = 'dashicons-admin-customizer';
            $this->menu_position = 80; // Position after 'Appearance'

            parent::__construct();

            // Add submenus dynamically
            $this->add_submenu([
                'page_title' => 'Color Schemes',
                'menu_title' => 'Color Schemes',
                'capability' => 'manage_options',
                'slug'       => 'theme-settings-color-schemes',
                'callback'   => [$this, 'render_submenu']
            ]);

            $this->add_submenu([
                'page_title' => 'Typography',
                'menu_title' => 'Typography',
                'capability' => 'manage_options',
                'slug'       => 'theme-settings-typography',
                'callback'   => [$this, 'render_submenu']
            ]);
        }

        /**
         * Renders the main settings page
         */
        public function render_page(): void
        {
            echo '<div class="wrap"><h1>Theme Settings</h1></div>';
        }

        /**
         * Renders the submenu pages
         */
        public function render_submenu(): void
        {
            echo '<div class="wrap"><h1>Under Construction !!!</h1></div>';
        }

        /**
         * Get the page title
         */
        protected function get_page_title(): string
        {
            return $this->page_title;
        }

        /**
         * Get the menu title
         */
        protected function get_menu_title(): string
        {
            return $this->menu_title;
        }

        /**
         * Get the menu capability
         */
        protected function get_menu_capability(): string
        {
            return $this->capability;
        }

        /**
         * Get the menu slug
         */
        protected function get_menu_slug(): string
        {
            return $this->menu_slug;
        }

        /**
         * Get the callback function
         */
        protected function get_callback(): callable
        {
            return $this->callback;
        }
    }
}
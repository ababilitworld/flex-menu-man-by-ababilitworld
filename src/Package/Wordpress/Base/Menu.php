<?php
namespace Ababilitworld\FlexMenuManByAbabilitworld\Package\Wordpress\Base;

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

use Ababilitworld\{
    FlexTraitByAbabilitworld\Standard\Standard,
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
     * Abstract Class BaseMenu
     * Defines the structure for WordPress menu classes
     */
    abstract class Menu
    {
        use Standard;

        /**
         * Holds the menu slug
         * @var string
         */
        protected string $menu_slug;

        /**
         * Holds the submenu items
         * @var array
         */
        protected array $submenus = [];

        /**
         * BaseMenu constructor
         */
        public function __construct()
        {
            add_action('admin_menu', [$this, 'register_menus']);
        }

        /**
         * Register the main menu in WordPress
         */
        public function register_menus(): void
        {
            add_menu_page(
                $this->get_page_title(),
                $this->get_menu_title(),
                'manage_options',
                $this->menu_slug,
                [$this, 'render_page'],
                $this->get_menu_icon(),
                $this->get_menu_position()
            );

            $this->register_submenus();
        }

        /**
         * Registers submenus dynamically
         */
        protected function register_submenus(): void
        {
            foreach ($this->submenus as $submenu) {
                add_submenu_page(
                    $this->menu_slug,
                    $submenu['page_title'],
                    $submenu['menu_title'],
                    'manage_options',
                    $submenu['slug'],
                    $submenu['callback']
                );
            }
        }

        /**
         * Adds a submenu
         */
        public function add_submenu(string $page_title, string $menu_title, string $slug, callable $callback): void
        {
            $this->submenus[] = [
                'page_title' => $page_title,
                'menu_title' => $menu_title,
                'slug'       => $slug,
                'callback'   => $callback
            ];
        }

        /**
         * Renders the main menu page
         */
        abstract public function render_page(): void;

        /**
         * Get the page title
         */
        abstract protected function get_page_title(): string;

        /**
         * Get the menu title
         */
        abstract protected function get_menu_title(): string;

        /**
         * Get the menu icon
         */
        protected function get_menu_icon(): string
        {
            return 'dashicons-admin-generic';
        }

        /**
         * Get the menu position
         */
        protected function get_menu_position(): int
        {
            return 60;
        }
    }

}
	
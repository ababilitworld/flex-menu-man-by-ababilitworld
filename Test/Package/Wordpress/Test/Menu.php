<?php
namespace Ababilitworld\FlexMenuManByAbabilitworld\Package\Wordpress\Menu\Test;

use PHPUnit\Framework\TestCase;
use Ababilitworld\{
    FlexMenuManByAbabilitworld\Package\Wordpress\Base\Menu as AbstractMenu,
    FlexMenuManByAbabilitworld\Package\Wordpress\Concrete\Menu as ThemeSettingsMenu
};

/**
 * Class MenuTest
 * Unit tests for AbstractMenu & ThemeSettingsMenu
 */
class Menu extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Mocking WordPress functions
        if (!function_exists('add_menu_page')) {
            function add_menu_page($page_title, $menu_title, $capability, $menu_slug, $callback = '', $icon_url = '', $position = null) {
                return compact('page_title', 'menu_title', 'capability', 'menu_slug', 'callback', 'icon_url', 'position');
            }
        }

        if (!function_exists('add_submenu_page')) {
            function add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback = '') {
                return compact('parent_slug', 'page_title', 'menu_title', 'capability', 'menu_slug', 'callback');
            }
        }
    }

    /**
     * Test if ThemeSettingsMenu instance is created properly
     */
    public function testInstance()
    {
        $menu = new ThemeSettingsMenu();
        $this->assertInstanceOf(ThemeSettingsMenu::class, $menu);
    }

    /**
     * Data provider for menu titles
     */
    public function menuTitleProvider()
    {
        return [
            ['Theme Settings', 'Theme Settings'],
            ['Color Schemes', 'Color Schemes'],
            ['Active Color Scheme', 'Active Color Scheme']
        ];
    }

    /**
     * Test get_menu_title() with different inputs
     * @dataProvider menuTitleProvider
     */
    public function testGetMenuTitle($expected, $actual)
    {
        $menu = new ThemeSettingsMenu();
        $this->assertSame($expected, $this->invokeMethod($menu, 'get_menu_title'));
    }

    /**
     * Test if register_menus() calls add_menu_page()
     */
    public function testRegisterMenus()
    {
        $menu = new ThemeSettingsMenu();
        ob_start();
        $menu->register_menus();
        $output = ob_get_clean();
        $this->assertStringContainsString('Theme Settings', $output);
    }

    /**
     * Test menu icon & position values
     */
    public function testMenuIconAndPosition()
    {
        $menu = new ThemeSettingsMenu();
        $this->assertSame('dashicons-admin-generic', $this->invokeMethod($menu, 'get_menu_icon'));
        $this->assertSame(60, $this->invokeMethod($menu, 'get_menu_position'));
    }

    /**
     * Test submenu registration
     */
    public function testSubmenuRegistration()
    {
        $menu = new ThemeSettingsMenu();
        ob_start();
        $menu->register_submenus();
        $output = ob_get_clean();
        
        $this->assertStringContainsString('Color Schemes', $output);
        $this->assertStringContainsString('Active Color Scheme', $output);
    }

    /**
     * Test if an exception is thrown for invalid input
     */
    public function testInvalidMenuSlug()
    {
        $this->expectException(\InvalidArgumentException::class);
        new class extends AbstractMenu {
            protected string $menu_slug = '';
            public function render_page(): void {}
            protected function get_page_title(): string { return ''; }
            protected function get_menu_title(): string { return ''; }
        };
    }

    /**
     * Helper method to invoke protected/private methods
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}

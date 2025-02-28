<?php
namespace Ababilitworld\FlexMenuManByAbabilitworld\Package\Wordpress\Test;

use PHPUnit\Framework\TestCase;
use Ababilitworld\{
    FlexMenuManByAbabilitworld\Package\Wordpress\Base\Menu as AbstractMenu,
    FlexMenuManByAbabilitworld\Package\Wordpress\Concrete\Menu as ThemeSettingsMenu
};
/**
 * Class MenuTest
 * Unit tests for AbstractMenu & ThemeSettingsMenu
 */
class MenuTest extends TestCase
{
    /**
     * Test if ThemeSettingsMenu instance is created properly
     * @test
     */
    public function testInstance()
    {
        $menu = new ThemeSettingsMenu();
        $this->assertInstanceOf(ThemeSettingsMenu::class, $menu);
    }

    /**
     * Data provider for menu titles
     */
    public static function menuTitleProvider()
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
    public function testGetMenuTitle($expected)
    {
        $menu = new ThemeSettingsMenu();
        $this->assertSame($expected, $menu->get_menu_title());
    }


    /**
     * Test if register_menus() calls add_menu_page()
     */
    public function testRegisterMenus()
    {
        $menu = new ThemeSettingsMenu();
        
        $this->expectOutputRegex('/Theme Settings/');
        $menu->register_menus();
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
        
        $this->expectOutputRegex('/Color Schemes/');
        $this->expectOutputRegex('/Active Color Scheme/');
        
        $menu->register_submenus();
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

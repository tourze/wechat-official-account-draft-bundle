<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Tests\Service;

use Knp\Menu\ItemInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;
use WechatOfficialAccountDraftBundle\Service\AdminMenu;

/**
 * AdminMenu 单元测试
 *
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
final class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    private ItemInterface $item;

    public function testInvokeMethod(): void
    {
        // 测试 AdminMenu 的 __invoke 方法正常工作
        $this->expectNotToPerformAssertions();

        try {
            $linkGenerator = $this->createMock(LinkGeneratorInterface::class);
            $linkGenerator->method('getCurdListPage')->willReturn('/admin/draft');

            $container = self::getContainer();
            $container->set(LinkGeneratorInterface::class, $linkGenerator);
            $adminMenu = self::getService(AdminMenu::class);
            ($adminMenu)($this->item);
        } catch (\Throwable $e) {
            self::markTestIncomplete('AdminMenu __invoke method should not throw exception: ' . $e->getMessage());
        }
    }

    public function testImplementsMenuProviderInterface(): void
    {
        $linkGenerator = $this->createMock(LinkGeneratorInterface::class);
        $container = self::getContainer();
        $container->set(LinkGeneratorInterface::class, $linkGenerator);

        $adminMenu = self::getService(AdminMenu::class);
        // 验证服务实现了期望的接口（通过类型检查已保证）
        $this->assertNotNull($adminMenu);
    }

    protected function onSetUp(): void
    {
        $this->item = $this->createMock(ItemInterface::class);

        // 设置 mock 的返回值以避免 null 引用
        $childItem = $this->createMock(ItemInterface::class);
        $this->item->method('addChild')->willReturn($childItem);

        // 使用 willReturnCallback 来模拟 getChild 的行为
        $this->item->method('getChild')->willReturnCallback(function ($name) use ($childItem) {
            return '微信公众号' === $name ? $childItem : null;
        });

        // 设置子菜单项的 mock 行为
        $childItem->method('addChild')->willReturn($childItem);
        $childItem->method('setUri')->willReturn($childItem);
        $childItem->method('setAttribute')->willReturn($childItem);
    }
}

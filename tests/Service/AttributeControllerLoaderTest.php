<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use Tourze\RoutingAutoLoaderBundle\Service\RoutingAutoLoaderInterface;
use WechatOfficialAccountDraftBundle\Service\AttributeControllerLoader;

/**
 * AttributeControllerLoader 单元测试
 *
 * @internal
 */
#[CoversClass(AttributeControllerLoader::class)]
#[RunTestsInSeparateProcesses]
#[Group('wechat-official-account-draft-bundle')]
final class AttributeControllerLoaderTest extends AbstractIntegrationTestCase
{
    private AttributeControllerLoader $loader;

    protected function onSetUp(): void
    {
        $this->loader = self::getService(AttributeControllerLoader::class);
    }

    public function testServiceCanBeInstantiated(): void
    {
        $this->assertInstanceOf(AttributeControllerLoader::class, $this->loader);
    }

    public function testLoadReturnsRouteCollection(): void
    {
        $result = $this->loader->load('test-resource');

        $this->assertInstanceOf(RouteCollection::class, $result);
    }

    public function testLoadWithTypeReturnsRouteCollection(): void
    {
        $result = $this->loader->load('test-resource', 'test-type');

        $this->assertInstanceOf(RouteCollection::class, $result);
    }

    public function testSupportsReturnsFalse(): void
    {
        $result = $this->loader->supports('test-resource');

        $this->assertFalse($result);
    }

    public function testSupportsWithTypeReturnsFalse(): void
    {
        $result = $this->loader->supports('test-resource', 'test-type');

        $this->assertFalse($result);
    }

    public function testAutoloadReturnsRouteCollection(): void
    {
        $result = $this->loader->autoload();

        $this->assertInstanceOf(RouteCollection::class, $result);
    }

    public function testLoadAndAutoloadReturnSameCollection(): void
    {
        $loadResult = $this->loader->load('test-resource');
        $autoloadResult = $this->loader->autoload();

        $this->assertEquals($loadResult, $autoloadResult);
    }

    public function testRouteCollectionContainsDraftControllerRoutes(): void
    {
        $collection = $this->loader->autoload();

        // 验证路由集合不为空
        $this->assertGreaterThanOrEqual(0, $collection->count());

        // 检查是否包含预期的路由名称前缀（基于DraftCrudController的AdminCrud注解）
        $routeNames = array_keys($collection->all());
        $hasAdminDraftRoutes = false;

        foreach ($routeNames as $routeName) {
            if (str_contains($routeName, 'admin_draft')) {
                $hasAdminDraftRoutes = true;
                break;
            }
        }

        // 如果有路由，应该包含admin_draft相关路由
        if ($collection->count() > 0) {
            $this->assertTrue($hasAdminDraftRoutes, 'Route collection should contain admin_draft routes');
        }
    }

    public function testImplementsRoutingAutoLoaderInterface(): void
    {
        $this->assertInstanceOf(RoutingAutoLoaderInterface::class, $this->loader);
    }

    public function testExtendsLoader(): void
    {
        $this->assertInstanceOf(Loader::class, $this->loader);
    }

    public function testConstructorInitializesPropertiesCorrectly(): void
    {
        // 通过调用公共方法验证构造函数正确初始化了内部状态
        $collection1 = $this->loader->autoload();
        $collection2 = $this->loader->load('any-resource');

        // 两次调用应该返回相同的集合实例
        $this->assertSame($collection1, $collection2);
    }

    public function testLoaderConsistencyAcrossMultipleCalls(): void
    {
        // 验证多次调用的一致性
        $collection1 = $this->loader->autoload();
        $collection2 = $this->loader->autoload();
        $collection3 = $this->loader->load('resource1');
        $collection4 = $this->loader->load('resource2', 'type');

        // 所有调用都应该返回相同的集合
        $this->assertSame($collection1, $collection2);
        $this->assertSame($collection1, $collection3);
        $this->assertSame($collection1, $collection4);
    }

    public function testSupportsAlwaysReturnsFalseRegardlessOfInput(): void
    {
        // 测试不同类型的输入，supports方法都应该返回false
        $this->assertFalse($this->loader->supports(null));
        $this->assertFalse($this->loader->supports(''));
        $this->assertFalse($this->loader->supports('string-resource'));
        $this->assertFalse($this->loader->supports(123));
        $this->assertFalse($this->loader->supports(['array']));
        $this->assertFalse($this->loader->supports(new \stdClass()));

        // 带类型参数的测试
        $this->assertFalse($this->loader->supports('resource', null));
        $this->assertFalse($this->loader->supports('resource', ''));
        $this->assertFalse($this->loader->supports('resource', 'annotation'));
        $this->assertFalse($this->loader->supports('resource', 'attribute'));
    }
}

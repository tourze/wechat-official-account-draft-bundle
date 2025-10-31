<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use WechatOfficialAccountDraftBundle\DependencyInjection\WechatOfficialAccountDraftExtension;

/**
 * @internal
 */
#[CoversClass(WechatOfficialAccountDraftExtension::class)]
final class WechatOfficialAccountDraftExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new ContainerBuilder();
        $this->container->setParameter('kernel.environment', 'test');
    }

    private function createExtension(): WechatOfficialAccountDraftExtension
    {
        return new WechatOfficialAccountDraftExtension();
    }

    public function testLoadDoesNotThrowException(): void
    {
        $this->expectNotToPerformAssertions();

        // 如果加载过程中有任何问题，会抛出异常
        $extension = $this->createExtension();
        $extension->load([], $this->container);
    }
}

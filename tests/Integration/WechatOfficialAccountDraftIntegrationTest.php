<?php

namespace WechatOfficialAccountDraftBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountDraftBundle\WechatOfficialAccountDraftBundle;

class WechatOfficialAccountDraftIntegrationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }
    
    protected static function createKernel(array $options = []): IntegrationTestKernel
    {
        return new IntegrationTestKernel($options);
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        
        // 创建模拟服务        $officialAccountClientMock = $this->createMock(OfficialAccountClient::class);
        
        // 设置合成服务
        $container = self::getContainer();
        $container->set(OfficialAccountClient::class, $officialAccountClientMock);
    }

    public function testKernelBoot(): void
    {
        $kernel = self::$kernel;
        $this->assertNotNull($kernel, 'Kernel should be available');
        
        // 检查我们的 Bundle 是否已注册
        $bundles = $kernel->getBundles();
        $bundleFound = false;
        foreach ($bundles as $bundle) {
            if ($bundle instanceof WechatOfficialAccountDraftBundle) {
                $bundleFound = true;
                break;
            }
        }
        $this->assertTrue($bundleFound, 'WechatOfficialAccountDraftBundle should be registered');
    }
} 
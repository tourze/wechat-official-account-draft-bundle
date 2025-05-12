<?php

namespace WechatOfficialAccountDraftBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WechatOfficialAccountDraftBundle\DependencyInjection\WechatOfficialAccountDraftExtension;

class WechatOfficialAccountDraftExtensionTest extends TestCase
{
    private ContainerBuilder $container;
    private WechatOfficialAccountDraftExtension $extension;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new ContainerBuilder();
        $this->extension = new WechatOfficialAccountDraftExtension();
    }

    public function testLoad_doesNotThrowException(): void
    {
        $this->expectNotToPerformAssertions();
        
        // 如果加载过程中有任何问题，会抛出异常
        $this->extension->load([], $this->container);
    }
} 
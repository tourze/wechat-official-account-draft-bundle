<?php

namespace WechatOfficialAccountDraftBundle\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;
use WechatOfficialAccountDraftBundle\WechatOfficialAccountDraftBundle;

class WechatOfficialAccountDraftBundleTest extends TestCase
{
    public function testInstance_isBundle(): void
    {
        $bundle = new WechatOfficialAccountDraftBundle();
        
        $this->assertInstanceOf(Bundle::class, $bundle);
    }

    public function testClass_hasCorrectPermissionAttribute(): void
    {
        $reflectionClass = new ReflectionClass(WechatOfficialAccountDraftBundle::class);
        $attributes = $reflectionClass->getAttributes(AsPermission::class);
        
        $this->assertCount(1, $attributes, 'Should have exactly one AsPermission attribute');
        
        $attribute = $attributes[0]->newInstance();
        $this->assertSame('公众号草稿箱', $attribute->title);
    }
} 
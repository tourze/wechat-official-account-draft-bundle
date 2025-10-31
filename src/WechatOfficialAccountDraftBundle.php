<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;
use WechatOfficialAccountBundle\WechatOfficialAccountBundle;

#[AsPermission(title: '公众号草稿箱')]
class WechatOfficialAccountDraftBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            DoctrineBundle::class => [
                'all' => true,
            ],
            WechatOfficialAccountBundle::class => ['all' => true],
        ];
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        // 在测试环境手动注册 DataFixtures 服务
        if ($container->hasParameter('kernel.environment') && 'test' === $container->getParameter('kernel.environment')) {
            $container->register('wechat_official_account_draft_bundle.data_fixtures.draft_fixtures', 'WechatOfficialAccountDraftBundle\DataFixtures\DraftFixtures')
                ->addTag('doctrine.fixture.orm')
                ->setAutowired(true)
                ->setAutoconfigured(true)
            ;
        }
    }
}

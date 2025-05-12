<?php

namespace WechatOfficialAccountDraftBundle\Tests\Integration;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Kernel;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountDraftBundle\WechatOfficialAccountDraftBundle;

class IntegrationTestKernel extends Kernel
{
    private array $configs = [];

    public function __construct(array $configs = [])
    {
        parent::__construct('test', true);
        $this->configs = $configs;
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new WechatOfficialAccountDraftBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('framework', [
                'test' => true,
                'secret' => 'test',
                'http_method_override' => false,
                'handle_all_throwables' => true,
                'php_errors' => [
                    'log' => true,
                ],
                'uid' => [
                    'default_uuid_version' => 7,
                    'time_based_uuid_version' => 7,
                ],
                'validation' => [
                    'email_validation_mode' => 'html5',
                ],
            ]);
            
            $container->loadFromExtension('doctrine', [
                'dbal' => [
                    'driver' => 'pdo_sqlite',
                    'path' => '%kernel.cache_dir%/test.db',
                    'memory' => true,
                ],
                'orm' => [
                    'auto_generate_proxy_classes' => true,
                    'auto_mapping' => true,
                    'controller_resolver' => [
                        'auto_mapping' => true,
                    ],
                ],
            ]);

            // 注册模拟服务
            $this->registerMockServices($container);

            foreach ($this->configs as $extension => $config) {
                $container->loadFromExtension($extension, $config);
            }

            $container->prependExtensionConfig('framework', ['annotations' => false]);
        });
    }

    private function registerMockServices(ContainerBuilder $container): void
    {
        // 添加依赖服务的模拟
        $officialAccountClientDefinition = new Definition(OfficialAccountClient::class);
        $officialAccountClientDefinition->setPublic(true);
        $officialAccountClientDefinition->setSynthetic(true);
        $container->setDefinition(OfficialAccountClient::class, $officialAccountClientDefinition);
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/wechat_official_account_draft_bundle_tests/cache';
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/wechat_official_account_draft_bundle_tests/logs';
    }
} 
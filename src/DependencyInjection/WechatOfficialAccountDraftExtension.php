<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\DependencyInjection;

use Tourze\SymfonyDependencyServiceLoader\AutoExtension;

final class WechatOfficialAccountDraftExtension extends AutoExtension
{
    protected function getConfigDir(): string
    {
        return \dirname(__DIR__) . '/Resources/config';
    }
}

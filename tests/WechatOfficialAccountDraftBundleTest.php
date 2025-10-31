<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use WechatOfficialAccountDraftBundle\WechatOfficialAccountDraftBundle;

/**
 * @internal
 */
#[CoversClass(WechatOfficialAccountDraftBundle::class)]
#[RunTestsInSeparateProcesses]
final class WechatOfficialAccountDraftBundleTest extends AbstractBundleTestCase
{
}

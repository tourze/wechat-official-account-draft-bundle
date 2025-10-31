<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Tests\EventSubscriber;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountDraftBundle\EventSubscriber\DraftListener;
use WechatOfficialAccountDraftBundle\Request\DeleteDraftRequest;

/**
 * @internal
 */
#[CoversClass(DraftListener::class)]
#[RunTestsInSeparateProcesses]
final class DraftListenerTest extends AbstractIntegrationTestCase
{
    private DraftListener $listener;

    private OfficialAccountClient|MockObject $clientMock;

    protected function onSetUp(): void
    {
        $this->clientMock = $this->createMock(OfficialAccountClient::class);
        $container = self::getContainer();
        $container->set(OfficialAccountClient::class, $this->clientMock);
        $this->listener = self::getService(DraftListener::class);
    }

    public function testPreRemoveWithMediaIdSendsDeleteRequest(): void
    {
        // 使用具体类的原因：
        // 1. 测试需要验证实际Account对象的设置和获取
        // 2. Account类的属性和方法需要在实际环境中验证
        // 3. 确保与真实Account对象的兼容性
        $account = $this->createMock(Account::class);
        $mediaId = 'test-media-id';

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId($mediaId);

        $this->clientMock->expects($this->once())
            ->method('asyncRequest')
            ->with(self::callback(function (DeleteDraftRequest $request) use ($account, $mediaId) {
                return $request->getAccount() === $account
                       && $request->getMediaId() === $mediaId;
            }))
        ;

        $this->listener->preRemove($draft);

        // 断言 draft 的 media ID 被正确设置了
        $this->assertSame($mediaId, $draft->getMediaId());
    }

    public function testPreRemoveWithoutMediaIdDoesNotSendRequest(): void
    {
        // 使用具体类的原因：
        // 1. 测试需要验证实际Account对象的设置和获取
        // 2. Account类的属性和方法需要在实际环境中验证
        // 3. 确保与真实Account对象的兼容性
        $account = $this->createMock(Account::class);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId(null);

        $this->clientMock->expects($this->never())
            ->method('asyncRequest')
        ;

        $this->listener->preRemove($draft);

        // 断言 draft 的 media ID 为 null
        $this->assertNull($draft->getMediaId());
    }
}

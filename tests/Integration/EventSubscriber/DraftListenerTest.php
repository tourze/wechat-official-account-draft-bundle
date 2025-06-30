<?php

namespace WechatOfficialAccountDraftBundle\Tests\Integration\EventSubscriber;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountDraftBundle\EventSubscriber\DraftListener;
use WechatOfficialAccountDraftBundle\Request\DeleteDraftRequest;

class DraftListenerTest extends TestCase
{
    private DraftListener $listener;
    private OfficialAccountClient|MockObject $clientMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientMock = $this->createMock(OfficialAccountClient::class);
        $this->listener = new DraftListener($this->clientMock);
    }

    public function testPreRemove_withMediaId_sendsDeleteRequest(): void
    {
        $account = $this->createMock(Account::class);
        $mediaId = 'test-media-id';
        
        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId($mediaId);

        $this->clientMock->expects($this->once())
            ->method('asyncRequest')
            ->with($this->callback(function (DeleteDraftRequest $request) use ($account, $mediaId) {
                return $request->getAccount() === $account && 
                       $request->getMediaId() === $mediaId;
            }));

        $this->listener->preRemove($draft);
    }

    public function testPreRemove_withoutMediaId_doesNotSendRequest(): void
    {
        $account = $this->createMock(Account::class);
        
        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId(null);

        $this->clientMock->expects($this->never())
            ->method('asyncRequest');

        $this->listener->preRemove($draft);
    }
}
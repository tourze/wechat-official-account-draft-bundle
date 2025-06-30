<?php

namespace WechatOfficialAccountDraftBundle\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Request\DeleteDraftRequest;

class DeleteDraftRequestTest extends TestCase
{
    private DeleteDraftRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new DeleteDraftRequest();
    }

    public function testGetRequestPath_returnsCorrectUrl(): void
    {
        $expectedPath = 'https://api.weixin.qq.com/cgi-bin/draft/delete';
        $this->assertSame($expectedPath, $this->request->getRequestPath());
    }

    public function testSetMediaId_setsMediaIdCorrectly(): void
    {
        $mediaId = 'test-media-id';
        $this->request->setMediaId($mediaId);
        
        $this->assertSame($mediaId, $this->request->getMediaId());
    }

    public function testGetRequestOptions_returnsCorrectOptionsArray(): void
    {
        $mediaId = 'test-media-id';
        $this->request->setMediaId($mediaId);
        
        $options = $this->request->getRequestOptions();
        
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertIsArray($options['json']);
        $this->assertArrayHasKey('media_id', $options['json']);
        $this->assertSame($mediaId, $options['json']['media_id']);
    }

    public function testInheritance_extendsWithAccountRequest(): void
    {
        $this->assertInstanceOf(\WechatOfficialAccountBundle\Request\WithAccountRequest::class, $this->request);
    }

    public function testSetAccount_worksProperly(): void
    {
        $account = $this->createMock(Account::class);
        $this->request->setAccount($account);
        
        $this->assertSame($account, $this->request->getAccount());
    }
}
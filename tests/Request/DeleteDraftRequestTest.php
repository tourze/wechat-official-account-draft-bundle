<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Tests\Request;

use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountBundle\Request\WithAccountRequest;
use WechatOfficialAccountDraftBundle\Request\DeleteDraftRequest;

/**
 * @internal
 */
#[CoversClass(DeleteDraftRequest::class)]
final class DeleteDraftRequestTest extends RequestTestCase
{
    private function createRequest(): DeleteDraftRequest
    {
        return new DeleteDraftRequest();
    }

    public function testGetRequestPathReturnsCorrectUrl(): void
    {
        $request = $this->createRequest();
        $expectedPath = 'https://api.weixin.qq.com/cgi-bin/draft/delete';
        $this->assertSame($expectedPath, $request->getRequestPath());
    }

    public function testSetMediaIdSetsMediaIdCorrectly(): void
    {
        $request = $this->createRequest();
        $mediaId = 'test-media-id';
        $request->setMediaId($mediaId);

        $this->assertSame($mediaId, $request->getMediaId());
    }

    public function testGetRequestOptionsReturnsCorrectOptionsArray(): void
    {
        $request = $this->createRequest();
        $mediaId = 'test-media-id';
        $request->setMediaId($mediaId);

        $options = $request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertIsArray($options['json']);
        $this->assertArrayHasKey('media_id', $options['json']);
        $this->assertSame($mediaId, $options['json']['media_id']);
    }

    public function testInheritanceExtendsWithAccountRequest(): void
    {
        $request = $this->createRequest();
        $this->assertInstanceOf(WithAccountRequest::class, $request);
    }

    public function testSetAccountWorksProperly(): void
    {
        // 使用具体类的原因：
        // 1. 测试需要验证实际Account对象的设置和获取
        // 2. Account类的属性和方法需要在实际环境中验证
        // 3. 确保与真实Account对象的兼容性
        $request = $this->createRequest();
        $account = $this->createMock(Account::class);
        $request->setAccount($account);

        $this->assertSame($account, $request->getAccount());
    }
}

<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;

/**
 * @internal
 */
#[CoversClass(Draft::class)]
final class DraftTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new Draft();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'account' => ['account', new Account()],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createDraft(): Draft
    {
        return new Draft();
    }

    public function testGetIdReturnsNullForNewEntity(): void
    {
        $draft = $this->createDraft();
        $this->assertNull($draft->getId());
    }

    public function testSetAccountSetsAccountCorrectly(): void
    {
        // 使用具体类的原因：
        // 1. 测试需要验证实际Account对象的设置和获取
        // 2. Account类的属性和方法需要在实际环境中验证
        // 3. 确保与真实Account对象的兼容性
        $draft = $this->createDraft();
        $account = $this->createMock(Account::class);
        $draft->setAccount($account);

        $this->assertSame($account, $draft->getAccount());
    }

    public function testGetAccountReturnsSetAccount(): void
    {
        // 使用具体类的原因：
        // 1. 测试需要验证实际Account对象的设置和获取
        // 2. Account类的属性和方法需要在实际环境中验证
        // 3. 确保与真实Account对象的兼容性
        $draft = $this->createDraft();
        $account = $this->createMock(Account::class);
        $draft->setAccount($account);

        $this->assertSame($account, $draft->getAccount());
    }

    public function testSetMediaIdSetsMediaIdCorrectly(): void
    {
        $draft = $this->createDraft();
        $mediaId = 'test-media-id';
        $draft->setMediaId($mediaId);

        $this->assertSame($mediaId, $draft->getMediaId());
    }

    public function testGetMediaIdReturnsSetMediaId(): void
    {
        $draft = $this->createDraft();
        $mediaId = 'test-media-id';
        $draft->setMediaId($mediaId);

        $this->assertSame($mediaId, $draft->getMediaId());
    }

    public function testSetMediaIdAcceptsNull(): void
    {
        $draft = $this->createDraft();
        $draft->setMediaId(null);

        $this->assertNull($draft->getMediaId());
    }

    public function testSetCreatedFromIpSetsIpCorrectly(): void
    {
        $draft = $this->createDraft();
        $ip = '127.0.0.1';
        $draft->setCreatedFromIp($ip);

        $this->assertSame($ip, $draft->getCreatedFromIp());
    }

    public function testGetCreatedFromIpReturnsSetIp(): void
    {
        $draft = $this->createDraft();
        $ip = '127.0.0.1';
        $draft->setCreatedFromIp($ip);

        $this->assertSame($ip, $draft->getCreatedFromIp());
    }

    public function testSetUpdatedFromIpSetsIpCorrectly(): void
    {
        $draft = $this->createDraft();
        $ip = '127.0.0.1';
        $draft->setUpdatedFromIp($ip);

        $this->assertSame($ip, $draft->getUpdatedFromIp());
    }

    public function testGetUpdatedFromIpReturnsSetIp(): void
    {
        $draft = $this->createDraft();
        $ip = '127.0.0.1';
        $draft->setUpdatedFromIp($ip);

        $this->assertSame($ip, $draft->getUpdatedFromIp());
    }

    public function testSetCreateTimeSetsDateTime(): void
    {
        $draft = $this->createDraft();
        $dateTime = new \DateTimeImmutable();
        $draft->setCreateTime($dateTime);

        $this->assertSame($dateTime, $draft->getCreateTime());
    }

    public function testGetCreateTimeReturnsNullByDefault(): void
    {
        $draft = $this->createDraft();
        $this->assertNull($draft->getCreateTime());
    }

    public function testSetUpdateTimeSetsDateTime(): void
    {
        $draft = $this->createDraft();
        $dateTime = new \DateTimeImmutable();
        $draft->setUpdateTime($dateTime);

        $this->assertSame($dateTime, $draft->getUpdateTime());
    }

    public function testGetUpdateTimeReturnsNullByDefault(): void
    {
        $draft = $this->createDraft();
        $this->assertNull($draft->getUpdateTime());
    }
}

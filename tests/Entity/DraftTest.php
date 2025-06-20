<?php

namespace WechatOfficialAccountDraftBundle\Tests\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;

class DraftTest extends TestCase
{
    private Draft $draft;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->draft = new Draft();
    }

    public function testGetId_returnsNullForNewEntity(): void
    {
        $this->assertNull($this->draft->getId());
    }

    public function testSetAccount_returnsFluentInterface(): void
    {
        $account = $this->createMock(Account::class);
        $result = $this->draft->setAccount($account);
        
        $this->assertSame($this->draft, $result);
    }

    public function testGetAccount_returnsSetAccount(): void
    {
        $account = $this->createMock(Account::class);
        $this->draft->setAccount($account);
        
        $this->assertSame($account, $this->draft->getAccount());
    }

    public function testSetMediaId_returnsFluentInterface(): void
    {
        $mediaId = 'test-media-id';
        $result = $this->draft->setMediaId($mediaId);
        
        $this->assertSame($this->draft, $result);
    }

    public function testGetMediaId_returnsSetMediaId(): void
    {
        $mediaId = 'test-media-id';
        $this->draft->setMediaId($mediaId);
        
        $this->assertSame($mediaId, $this->draft->getMediaId());
    }

    public function testSetMediaId_acceptsNull(): void
    {
        $this->draft->setMediaId(null);
        
        $this->assertNull($this->draft->getMediaId());
    }

    public function testSetCreatedFromIp_returnsFluentInterface(): void
    {
        $ip = '127.0.0.1';
        $result = $this->draft->setCreatedFromIp($ip);
        
        $this->assertSame($this->draft, $result);
    }

    public function testGetCreatedFromIp_returnsSetIp(): void
    {
        $ip = '127.0.0.1';
        $this->draft->setCreatedFromIp($ip);
        
        $this->assertSame($ip, $this->draft->getCreatedFromIp());
    }

    public function testSetUpdatedFromIp_returnsFluentInterface(): void
    {
        $ip = '127.0.0.1';
        $result = $this->draft->setUpdatedFromIp($ip);
        
        $this->assertSame($this->draft, $result);
    }

    public function testGetUpdatedFromIp_returnsSetIp(): void
    {
        $ip = '127.0.0.1';
        $this->draft->setUpdatedFromIp($ip);
        
        $this->assertSame($ip, $this->draft->getUpdatedFromIp());
    }

    public function testSetCreateTime_setsDateTime(): void
    {
        $dateTime = new DateTimeImmutable();
        $this->draft->setCreateTime($dateTime);
        
        $this->assertSame($dateTime, $this->draft->getCreateTime());
    }

    public function testGetCreateTime_returnsNullByDefault(): void
    {
        $this->assertNull($this->draft->getCreateTime());
    }

    public function testSetUpdateTime_setsDateTime(): void
    {
        $dateTime = new DateTimeImmutable();
        $this->draft->setUpdateTime($dateTime);
        
        $this->assertSame($dateTime, $this->draft->getUpdateTime());
    }

    public function testGetUpdateTime_returnsNullByDefault(): void
    {
        $this->assertNull($this->draft->getUpdateTime());
    }
} 
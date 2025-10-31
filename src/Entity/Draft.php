<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineIpBundle\Traits\IpTraceableAware;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Repository\DraftRepository;

#[ORM\Entity(repositoryClass: DraftRepository::class)]
#[ORM\Table(name: 'wechat_official_account_draft', options: ['comment' => '草稿'])]
class Draft implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;
    use IpTraceableAware;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Account $account;

    #[ORM\Column(length: 120, nullable: true, options: ['comment' => '媒体ID'])]
    #[Assert\Length(max: 120)]
    private ?string $mediaId = null;

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    public function getMediaId(): ?string
    {
        return $this->mediaId;
    }

    public function setMediaId(?string $mediaId): void
    {
        $this->mediaId = $mediaId;
    }

    public function __toString(): string
    {
        return $this->mediaId ?? 'New Draft';
    }
}

<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Service;

use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use WechatOfficialAccountDraftBundle\Entity\Draft;

/**
 * @internal
 */
#[Autoconfigure(public: true)]
readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(private LinkGeneratorInterface $linkGenerator)
    {
    }

    public function __invoke(ItemInterface $item): void
    {
        if (null === $item->getChild('微信公众号')) {
            $item->addChild('微信公众号')
                ->setAttribute('icon', 'fas fa-comments')
            ;
        }

        $wechatItem = $item->getChild('微信公众号');
        if (null !== $wechatItem) {
            $wechatItem
                ->addChild('草稿管理')
                ->setUri($this->linkGenerator->getCurdListPage(Draft::class))
                ->setAttribute('icon', 'fas fa-file-text')
                ->setAttribute('help', '管理微信公众号草稿内容')
            ;
        }
    }
}

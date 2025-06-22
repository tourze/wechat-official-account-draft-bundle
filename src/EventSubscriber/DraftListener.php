<?php

namespace WechatOfficialAccountDraftBundle\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountDraftBundle\Request\DeleteDraftRequest;

/**
 * @see https://developers.weixin.qq.com/doc/offiaccount/Draft_Box/Add_draft.html
 * @see https://developers.weixin.qq.com/doc/offiaccount/Draft_Box/Get_draft.html
 * @see https://developers.weixin.qq.com/doc/offiaccount/Draft_Box/Update_draft.html
 * @see https://developers.weixin.qq.com/doc/offiaccount/Draft_Box/Delete_draft.html
 * @see https://developers.weixin.qq.com/doc/offiaccount/Draft_Box/Get_draft_list.html
 */
#[AsEntityListener(event: Events::preRemove, method: 'preRemove', entity: Draft::class)]
class DraftListener
{
    public function __construct(private readonly OfficialAccountClient $client)
    {
    }

    public function preRemove(Draft $object): void
    {
        if ($object->getMediaId() === null) {
            return;
        }

        $request = new DeleteDraftRequest();
        $request->setAccount($object->getAccount());
        $request->setMediaId($object->getMediaId());
        $this->client->asyncRequest($request);
    }
}

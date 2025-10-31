<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Request;

use WechatOfficialAccountBundle\Request\WithAccountRequest;

/**
 * 删除草稿
 *
 * @see https://developers.weixin.qq.com/doc/offiaccount/Draft_Box/Delete_draft.html
 */
class DeleteDraftRequest extends WithAccountRequest
{
    /**
     * @var string 要删除的素材的media_id
     */
    private string $mediaId;

    public function getRequestPath(): string
    {
        return 'https://api.weixin.qq.com/cgi-bin/draft/delete';
    }

    public function getRequestOptions(): ?array
    {
        $json = [
            'media_id' => $this->getMediaId(),
        ];

        return [
            'json' => $json,
        ];
    }

    public function getMediaId(): string
    {
        return $this->mediaId;
    }

    public function setMediaId(string $mediaId): void
    {
        $this->mediaId = $mediaId;
    }
}

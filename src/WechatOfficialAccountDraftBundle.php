<?php

namespace WechatOfficialAccountDraftBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;

#[AsPermission(title: '公众号草稿箱')]
class WechatOfficialAccountDraftBundle extends Bundle
{
}

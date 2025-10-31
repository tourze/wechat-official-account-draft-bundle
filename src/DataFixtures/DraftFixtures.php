<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;

#[When(env: 'test')]
#[When(env: 'dev')]
class DraftFixtures extends Fixture
{
    public const DRAFT_1_REFERENCE = 'draft-1';
    public const DRAFT_2_REFERENCE = 'draft-2';
    public const DRAFT_3_REFERENCE = 'draft-3';

    public function load(ObjectManager $manager): void
    {
        // 直接创建 Account 而不是依赖引用，避免依赖问题
        $account = new Account();
        $account->setName('Draft Test Account');
        $account->setAppId('draft_test_app_id_' . uniqid());
        $account->setAppSecret('draft_test_secret');
        $account->setValid(true);
        $manager->persist($account);
        $manager->flush();

        $draft1 = new Draft();
        $draft1->setAccount($account);
        $draft1->setMediaId('media_123456');
        $draft1->setCreatedFromIp('192.168.1.1');
        $draft1->setUpdatedFromIp('192.168.1.1');
        $manager->persist($draft1);

        $draft2 = new Draft();
        $draft2->setAccount($account);
        $draft2->setMediaId('media_789012');
        $draft2->setCreatedFromIp('192.168.1.2');
        $draft2->setUpdatedFromIp('192.168.1.2');
        $manager->persist($draft2);

        $draft3 = new Draft();
        $draft3->setAccount($account);
        $draft3->setMediaId('media_345678');
        $draft3->setCreatedFromIp('192.168.1.3');
        $draft3->setUpdatedFromIp('192.168.1.3');
        $manager->persist($draft3);

        $manager->flush();

        $this->addReference(self::DRAFT_1_REFERENCE, $draft1);
        $this->addReference(self::DRAFT_2_REFERENCE, $draft2);
        $this->addReference(self::DRAFT_3_REFERENCE, $draft3);
    }

    /**
     * @return array<class-string>
     */
    public function getDependencies(): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountDraftBundle\Repository\DraftRepository;

/**
 * @internal
 */
#[CoversClass(DraftRepository::class)]
#[RunTestsInSeparateProcesses]
final class DraftRepositoryTest extends AbstractRepositoryTestCase
{
    private DraftRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(DraftRepository::class);
    }

    public function testFindByWithNullValueQuery(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId(null);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $result = $this->repository->findBy(['mediaId' => null]);

        $this->assertCount(1, $result);
        /** @var Draft $firstResult */
        $firstResult = $result[0];
        $this->assertNull($firstResult->getMediaId());
    }

    public function testCountWithNullValueQuery(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId(null);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $count = $this->repository->count(['mediaId' => null]);

        $this->assertSame(1, $count);
    }

    public function testFindByWithAccountAssociation(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media');
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $result = $this->repository->findBy(['account' => $account]);

        $this->assertCount(1, $result);
        /** @var Draft $firstResult */
        $firstResult = $result[0];
        $this->assertSame($account, $firstResult->getAccount());
    }

    public function testCountWithAccountAssociation(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media');
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $count = $this->repository->count(['account' => $account]);

        $this->assertSame(1, $count);
    }

    public function testSaveShouldPersistEntity(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media_id');

        $this->repository->save($draft);

        $this->assertNotNull($draft->getId());
        $saved = $this->repository->find($draft->getId());
        $this->assertInstanceOf(Draft::class, $saved);
        $this->assertSame('test_media_id', $saved->getMediaId());
    }

    public function testSaveWithoutFlushShouldNotCommitToDatabase(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media_id');

        $this->repository->save($draft, false);

        self::getEntityManager()->clear();
        $count = $this->repository->count(['mediaId' => 'test_media_id']);
        $this->assertSame(0, $count);
    }

    public function testFindOneByShouldRespectOrderByClause(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft1 = new Draft();
        $draft1->setAccount($account);
        $draft1->setMediaId('z_media');
        self::getEntityManager()->persist($draft1);

        $draft2 = new Draft();
        $draft2->setAccount($account);
        $draft2->setMediaId('a_media');
        self::getEntityManager()->persist($draft2);

        self::getEntityManager()->flush();

        $result = $this->repository->findOneBy(['account' => $account], ['mediaId' => 'ASC']);

        $this->assertInstanceOf(Draft::class, $result);
        $this->assertSame('a_media', $result->getMediaId());
    }

    public function testRemove(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId(null);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $draftId = $draft->getId();
        $this->repository->remove($draft);

        $result = $this->repository->find($draftId);
        $this->assertNull($result);
    }

    public function testFindByWithCreatedFromIpIsNull(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media');
        $draft->setCreatedFromIp(null);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $result = $this->repository->findBy(['createdFromIp' => null]);

        $this->assertCount(1, $result);
        /** @var Draft $firstResult */
        $firstResult = $result[0];
        $this->assertNull($firstResult->getCreatedFromIp());
    }

    public function testCountWithCreatedFromIpIsNull(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media');
        $draft->setCreatedFromIp(null);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $count = $this->repository->count(['createdFromIp' => null]);

        $this->assertSame(1, $count);
    }

    public function testFindByWithUpdatedFromIpIsNull(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media');
        $draft->setUpdatedFromIp(null);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $result = $this->repository->findBy(['updatedFromIp' => null]);

        $this->assertCount(1, $result);
        /** @var Draft $firstResult */
        $firstResult = $result[0];
        $this->assertNull($firstResult->getUpdatedFromIp());
    }

    public function testCountWithUpdatedFromIpIsNull(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media');
        $draft->setUpdatedFromIp(null);
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $count = $this->repository->count(['updatedFromIp' => null]);

        $this->assertSame(1, $count);
    }

    public function testFindByWithCreateTimeIsNull(): void
    {
        $result = $this->repository->findBy(['createTime' => null]);

        $this->assertIsArray($result);
    }

    public function testCountWithCreateTimeIsNull(): void
    {
        $count = $this->repository->count(['createTime' => null]);

        $this->assertIsInt($count);
    }

    public function testFindByWithUpdateTimeIsNull(): void
    {
        $result = $this->repository->findBy(['updateTime' => null]);

        $this->assertIsArray($result);
    }

    public function testCountWithUpdateTimeIsNull(): void
    {
        $count = $this->repository->count(['updateTime' => null]);

        $this->assertIsInt($count);
    }

    public function testFindOneByWithAccountAssociation(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media');
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $result = $this->repository->findOneBy(['account' => $account]);

        $this->assertInstanceOf(Draft::class, $result);
        $this->assertSame($account, $result->getAccount());
    }

    public function testFindByWithAccountOrderBy(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft1 = new Draft();
        $draft1->setAccount($account);
        $draft1->setMediaId('z_media');
        self::getEntityManager()->persist($draft1);

        $draft2 = new Draft();
        $draft2->setAccount($account);
        $draft2->setMediaId('a_media');
        self::getEntityManager()->persist($draft2);

        self::getEntityManager()->flush();

        $result = $this->repository->findBy(['account' => $account], ['mediaId' => 'ASC']);

        $this->assertCount(2, $result);
        /** @var Draft $firstResult */
        $firstResult = $result[0];
        /** @var Draft $secondResult */
        $secondResult = $result[1];
        $this->assertSame('a_media', $firstResult->getMediaId());
        $this->assertSame('z_media', $secondResult->getMediaId());
    }

    public function testFindOneByWithAccountOrderBy(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft1 = new Draft();
        $draft1->setAccount($account);
        $draft1->setMediaId('z_media');
        self::getEntityManager()->persist($draft1);

        $draft2 = new Draft();
        $draft2->setAccount($account);
        $draft2->setMediaId('a_media');
        self::getEntityManager()->persist($draft2);

        self::getEntityManager()->flush();

        $result = $this->repository->findOneBy(['account' => $account], ['mediaId' => 'ASC']);

        $this->assertInstanceOf(Draft::class, $result);
        $this->assertSame('a_media', $result->getMediaId());
    }

    public function testFindOneByAssociationAccountShouldReturnMatchingEntity(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft = new Draft();
        $draft->setAccount($account);
        $draft->setMediaId('test_media');
        self::getEntityManager()->persist($draft);
        self::getEntityManager()->flush();

        $result = $this->repository->findOneBy(['account' => $account]);

        $this->assertInstanceOf(Draft::class, $result);
        $this->assertSame($account, $result->getAccount());
    }

    public function testCountByAssociationAccountShouldReturnCorrectNumber(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);

        $draft1 = new Draft();
        $draft1->setAccount($account);
        $draft1->setMediaId('test_media_1');
        self::getEntityManager()->persist($draft1);

        $draft2 = new Draft();
        $draft2->setAccount($account);
        $draft2->setMediaId('test_media_2');
        self::getEntityManager()->persist($draft2);

        self::getEntityManager()->flush();

        $count = $this->repository->count(['account' => $account]);

        $this->assertSame(2, $count);
    }

    protected function createNewEntity(): object
    {
        $account = new Account();
        $account->setName('Test Account for Draft');
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret');
        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $entity = new Draft();
        $entity->setAccount($account);
        $entity->setMediaId('test_media_' . uniqid());

        return $entity;
    }

    protected function getRepository(): DraftRepository
    {
        return $this->repository;
    }
}

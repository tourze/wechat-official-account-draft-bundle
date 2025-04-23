<?php

namespace WechatOfficialAccountDraftBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use WechatOfficialAccountDraftBundle\Entity\Draft;

/**
 * @method Draft|null find($id, $lockMode = null, $lockVersion = null)
 * @method Draft|null findOneBy(array $criteria, array $orderBy = null)
 * @method Draft[]    findAll()
 * @method Draft[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DraftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Draft::class);
    }
}

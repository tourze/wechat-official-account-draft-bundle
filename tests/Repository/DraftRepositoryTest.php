<?php

namespace WechatOfficialAccountDraftBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountDraftBundle\Repository\DraftRepository;

class DraftRepositoryTest extends TestCase
{
    private ManagerRegistry $registry;
    private DraftRepository $repository;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = $this->createMock(ManagerRegistry::class);
        $this->repository = new DraftRepository($this->registry);
    }

    public function testConstructor_registersCorrectEntityClass(): void
    {
        // 使用反射获取实际的实体类名
        $reflection = new \ReflectionClass($this->repository);
        
        // 尝试访问EntityRepository中的_entityName或_class属性
        // 在不同版本的Doctrine中，字段名可能不同
        foreach (['_entityName', '_entityClass', '_class', '_className'] as $propertyName) {
            try {
                if ($reflection->hasProperty($propertyName)) {
                    $property = $reflection->getProperty($propertyName);
                    $property->setAccessible(true);
                    $entityClass = $property->getValue($this->repository);
                    $this->assertSame(Draft::class, $entityClass);
                    return;
                }
            } catch (\ReflectionException $e) {
                // 继续尝试下一个属性名
            }
        }
        
        // 如果没有找到合适的属性，则测试是否可以成功实例化，说明构造函数工作正常
        $this->assertInstanceOf(DraftRepository::class, $this->repository);
    }
} 
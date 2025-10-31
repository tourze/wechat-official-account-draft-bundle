<?php

declare(strict_types=1);

namespace WechatOfficialAccountDraftBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use WechatOfficialAccountDraftBundle\Entity\Draft;

/**
 * @internal
 */
#[AdminCrud(routePath: '/wechat-official-account-draft/draft', routeName: 'wechat_official_account_draft_draft')]
final class DraftCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Draft::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('草稿')
            ->setEntityLabelInPlural('草稿')
            ->setPageTitle(Crud::PAGE_INDEX, '微信公众号草稿管理')
            ->setPageTitle(Crud::PAGE_NEW, '创建草稿')
            ->setPageTitle(Crud::PAGE_EDIT, '编辑草稿')
            ->setPageTitle(Crud::PAGE_DETAIL, '草稿详情')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->onlyOnIndex()
        ;

        yield AssociationField::new('account', '微信账号')
            ->setRequired(true)
            ->setHelp('选择对应的微信公众号账号')
        ;

        yield TextField::new('mediaId', '媒体ID')
            ->setMaxLength(120)
            ->setHelp('微信公众号草稿的媒体ID，最大长度120字符')
        ;

        yield DateTimeField::new('createTime', '创建时间')
            ->onlyOnIndex()
            ->setFormat('yyyy-MM-dd HH:mm:ss')
        ;

        yield DateTimeField::new('updateTime', '更新时间')
            ->onlyOnDetail()
            ->setFormat('yyyy-MM-dd HH:mm:ss')
        ;

        yield TextField::new('createIp', '创建IP')
            ->onlyOnDetail()
            ->setHelp('创建记录时的IP地址')
        ;

        yield TextField::new('updateIp', '更新IP')
            ->onlyOnDetail()
            ->setHelp('最后更新记录时的IP地址')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('account')
            ->add('mediaId')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}

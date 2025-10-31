# 微信公众号草稿箱 Bundle

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://www.php.net/releases/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](#)
[![Code Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg)](#)

[English](README.md) | [中文](README.zh-CN.md)

用于管理微信公众号草稿文章的 Symfony Bundle。

## 目录

- [功能特性](#功能特性)
- [依赖关系](#依赖关系)
- [安装](#安装)
- [配置](#配置)
- [快速开始](#快速开始)
- [高级用法](#高级用法)
- [API 参考](#api-参考)
- [安全性](#安全性)
- [许可证](#许可证)

## 功能特性

- 基于 Doctrine ORM 的草稿实体管理
- 草稿删除功能
- 支持微信公众号 API 集成
- 内置草稿操作仓储
- 事件驱动架构和监听器

## 依赖关系

此 Bundle 需要以下包：

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- Doctrine ORM 3.0 或更高版本
- tourze/wechat-official-account-bundle

## 安装

```bash
composer require tourze/wechat-official-account-draft-bundle
```

## 配置

此 Bundle 与微信公众号 Bundle 集成，需要正确配置微信 API 凭据。在使用此草稿扩展之前，请确保已配置主微信 Bundle。

## 快速开始

### 1. 配置 Bundle

在 `config/bundles.php` 中添加 Bundle：

```php
return [
    // ... 其他 bundles
    WechatOfficialAccountDraftBundle\WechatOfficialAccountDraftBundle::class => ['all' => true],
];
```

### 2. 创建数据库表

运行 Doctrine 迁移来创建必要的数据表：

```bash
php bin/console doctrine:migrations:migrate
```

### 3. 基本使用

```php
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountDraftBundle\Request\DeleteDraftRequest;

// 创建草稿
$draft = new Draft();
$draft->setAccount($account);
$draft->setMediaId('来自微信的媒体ID');

// 删除草稿
$deleteRequest = new DeleteDraftRequest();
$deleteRequest->setAccount($account);
$deleteRequest->setMediaId('要删除的媒体ID');
```

## 高级用法

### 使用草稿仓储

```php
use WechatOfficialAccountDraftBundle\Repository\DraftRepository;

// 注入仓储
public function __construct(private DraftRepository $draftRepository)
{
}

// 按账号查找草稿
$drafts = $this->draftRepository->findBy(['account' => $account]);

// 按媒体ID查找草稿
$draft = $this->draftRepository->findOneBy(['mediaId' => $mediaId]);
```

### 事件处理

Bundle 提供事件驱动架构来处理草稿操作。您可以监听草稿相关事件来实现自定义业务逻辑。

## API 参考

### 实体

- `Draft`: 用于管理草稿文章的主要实体
  - `account`: 关联的微信账号
  - `mediaId`: 草稿的微信媒体ID

### 请求

- `DeleteDraftRequest`: 通过微信 API 删除草稿的请求处理器

### 仓储

- `DraftRepository`: 草稿数据库操作仓储

## 安全性

此 Bundle 遵循安全最佳实践：

- 所有输入验证通过 Symfony 约束处理
- 媒体ID长度限制以防止数据库溢出
- 账号关联使用外键约束和级联删除

如果您发现任何安全漏洞，请负责任地报告。

## 许可证

此 Bundle 在 MIT 许可证下发布。详细信息请参阅 [LICENSE](LICENSE) 文件。
# WeChat Official Account Draft Bundle

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://www.php.net/releases/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](#)
[![Code Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg)](#)

[English](README.md) | [中文](README.zh-CN.md)

A Symfony bundle for managing WeChat Official Account draft articles.

## Table of Contents

- [Features](#features)
- [Dependencies](#dependencies)
- [Installation](#installation)
- [Configuration](#configuration)
- [Quick Start](#quick-start)
- [Advanced Usage](#advanced-usage)
- [API Reference](#api-reference)
- [Security](#security)
- [License](#license)

## Features

- Draft entity management with Doctrine ORM
- Draft deletion functionality
- Support for WeChat Official Account API integration
- Built-in repository for draft operations
- Event-driven architecture with listeners

## Dependencies

This bundle requires the following packages:

- PHP 8.1 or higher
- Symfony 6.4 or higher
- Doctrine ORM 3.0 or higher
- tourze/wechat-official-account-bundle

## Installation

```bash
composer require tourze/wechat-official-account-draft-bundle
```

## Configuration

The bundle integrates with the WeChat Official Account Bundle and requires proper configuration of the WeChat API credentials. Ensure you have configured the main WeChat bundle before using this draft extension.

## Quick Start

### 1. Configure the bundle

Add the bundle to your `config/bundles.php`:

```php
return [
    // ... other bundles
    WechatOfficialAccountDraftBundle\WechatOfficialAccountDraftBundle::class => ['all' => true],
];
```

### 2. Create database tables

Run the Doctrine migrations to create the necessary tables:

```bash
php bin/console doctrine:migrations:migrate
```

### 3. Basic Usage

```php
use WechatOfficialAccountDraftBundle\Entity\Draft;
use WechatOfficialAccountDraftBundle\Request\DeleteDraftRequest;

// Create a draft
$draft = new Draft();
$draft->setAccount($account);
$draft->setMediaId('media_id_from_wechat');

// Delete a draft
$deleteRequest = new DeleteDraftRequest();
$deleteRequest->setAccount($account);
$deleteRequest->setMediaId('media_id_to_delete');
```

## Advanced Usage

### Working with Draft Repository

```php
use WechatOfficialAccountDraftBundle\Repository\DraftRepository;

// Inject the repository
public function __construct(private DraftRepository $draftRepository)
{
}

// Find drafts by account
$drafts = $this->draftRepository->findBy(['account' => $account]);

// Find draft by media ID
$draft = $this->draftRepository->findOneBy(['mediaId' => $mediaId]);
```

### Event Handling

The bundle provides event-driven architecture for handling draft operations. You can listen to draft-related events to implement custom business logic.

## API Reference

### Entities

- `Draft`: Main entity for managing draft articles
  - `account`: Associated WeChat account
  - `mediaId`: WeChat media ID for the draft

### Requests

- `DeleteDraftRequest`: Request handler for deleting drafts via WeChat API

### Repository

- `DraftRepository`: Repository for draft database operations

## Security

This bundle follows security best practices:

- All input validation is handled through Symfony constraints
- Media ID length is limited to prevent database overflow
- Account associations use foreign key constraints with cascade deletion

If you discover any security vulnerabilities, please report them responsibly.

## License

This bundle is released under the MIT License. See the [LICENSE](LICENSE) file for details.
<?php

namespace Penwork\Tests;

use Penwork\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    public function testGetInstance(): void
    {
        $firstInstance = Config::getInstance();
        $secondInstance = Config::getInstance();

        self::assertEquals($firstInstance, $secondInstance);
    }

    public function testGetParams(): void
    {
        $config = Config::getInstance();

        $params = ['fake' => 'params'];
        $config->setParams($params);

        self::assertEquals($params, $config->getParams());
    }

    public function testGetParamsWithKeys(): void
    {
        $config = Config::getInstance();

        $params = ['fake' => ['params' => 'key']];
        $config->setParams($params);

        self::assertEquals('key', $config->getParams('fake', 'params'));
    }

    public function testGetUnknownParams(): void
    {
        $config = Config::getInstance();

        $params = ['fake' => ['params' => 'key']];
        $config->setParams($params);

        self::assertNull($config->getParams('another', 'fake', 'params'));
    }

    public function testMergeParams(): void
    {
        $config = Config::getInstance();

        $params = [
            'fake' => ['params' => 'key']
        ];
        $config->setParams($params);

        $paramsToMerge = [
            'fake' => ['params' => ['new' => 'value']]
        ];
        $config->mergeParams($paramsToMerge);

        self::assertEquals(['new' => 'value'], $config->getParams('fake', 'params'));
    }
}

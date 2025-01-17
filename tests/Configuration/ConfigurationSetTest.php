<?php

namespace EquipTests\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\ConfigurationSet;
use Equip\Exception\ConfigurationException;
use PHPUnit\Framework\TestCase;

class ConfigurationSetTest extends TestCase
{
    public function testSet()
    {
        $config = $this->createMock(ConfigurationInterface::class);
        $injector = $this->createMock(Injector::class);

        $injector
            ->expects($this->once())
            ->method('make')
            ->with(get_class($config))
            ->willReturn($config);

        $config
            ->expects($this->once())
            ->method('apply')
            ->with($injector);

        $set = new ConfigurationSet([
            get_class($config),
        ]);

        $set->apply($injector);
    }

    public function testSetObject()
    {
        $config = $this->createMock(ConfigurationInterface::class);
        $injector = $this->createMock(Injector::class);

        $config
            ->expects($this->once())
            ->method('apply')
            ->with($injector);

        $set = new ConfigurationSet([
            $config,
        ]);

        $set->apply($injector);
    }

    public function testInvalidClass()
    {
        $this->expectException(ConfigurationException::class);
        $set = new ConfigurationSet;
        $set->withValue('\stdClass');
    }
}

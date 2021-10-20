<?php

declare(strict_types=1);

namespace StsGamingGroup\KafkaBundle\Tests\Unit\Configuration\Type;

use StsGamingGroup\KafkaBundle\Configuration\Contract\ConfigurationInterface;
use StsGamingGroup\KafkaBundle\Configuration\Type\EnableAutoCommit;

class EnableAutoCommitTest extends AbstractBooleanConfigurationTest
{
    protected function getConfiguration(): ConfigurationInterface
    {
        return new EnableAutoCommit();
    }
}

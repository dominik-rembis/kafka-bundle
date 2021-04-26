<?php

declare(strict_types=1);

namespace Sts\KafkaBundle\Configuration\Type;

use Sts\KafkaBundle\Configuration\Contract\CastValueInterface;
use Sts\KafkaBundle\Configuration\Contract\ConsumerConfigurationInterface;
use Symfony\Component\Console\Input\InputOption;

class MaxRetries implements ConsumerConfigurationInterface, CastValueInterface
{
    public const NAME = 'max_retries';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getMode(): int
    {
        return InputOption::VALUE_REQUIRED;
    }

    public function getDescription(): string
    {
        return sprintf(
            'How many times message should be consumed if exception is thrown. Defaults to %s',
            self::getDefaultValue()
        );
    }

    public function isValueValid($value): bool
    {
        return is_numeric($value) && $value >= 0;
    }

    public static function getDefaultValue(): int
    {
        return 0;
    }

    public function cast($validatedValue): int
    {
        return (int) $validatedValue;
    }
}

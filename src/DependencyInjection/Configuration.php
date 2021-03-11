<?php

declare(strict_types=1);

namespace Sts\KafkaBundle\DependencyInjection;

use Sts\KafkaBundle\Configuration\Type\AutoCommitIntervalMs;
use Sts\KafkaBundle\Configuration\Type\AutoOffsetReset;
use Sts\KafkaBundle\Configuration\Type\Brokers;
use Sts\KafkaBundle\Configuration\Type\Decoder;
use Sts\KafkaBundle\Configuration\Type\EnableAutoCommit;
use Sts\KafkaBundle\Configuration\Type\EnableAutoOffsetStore;
use Sts\KafkaBundle\Configuration\Type\GroupId;
use Sts\KafkaBundle\Configuration\Type\LogLevel;
use Sts\KafkaBundle\Configuration\Type\Offset;
use Sts\KafkaBundle\Configuration\Type\OffsetStoreMethod;
use Sts\KafkaBundle\Configuration\Type\Partition;
use Sts\KafkaBundle\Configuration\Type\RegisterMissingSchemas;
use Sts\KafkaBundle\Configuration\Type\RegisterMissingSubjects;
use Sts\KafkaBundle\Configuration\Type\SchemaRegistry;
use Sts\KafkaBundle\Configuration\Type\Timeout;
use Sts\KafkaBundle\Configuration\Type\Topics;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sts_kafka');
        $rootNode = $treeBuilder->getRootNode();

        $builder = $rootNode->children();
        $this->addConfigurations($builder);
        $builder->append($this->addConsumersSection())
            ->append($this->addProducersSection());

        return $treeBuilder;
    }

    /**
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function addConsumersSection()
    {
        $treeBuilder = new TreeBuilder('consumers');

        $node = $treeBuilder->getRootNode();
        $builder = $node->arrayPrototype()->children();
        $this->addConfigurations($builder);
        $builder->end();

        return $node;
    }

    /**
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function addProducersSection()
    {
        $treeBuilder = new TreeBuilder('producers');

        $node = $treeBuilder->getRootNode();
        $builder = $node->arrayPrototype()->children();
        $this->addConfigurations($builder);
        $builder->end();

        return $node;
    }

    /**
     * @param NodeBuilder $builder
     * @return mixed
     */
    private function addConfigurations(NodeBuilder $builder)
    {
        return
            $builder
                ->scalarNode(AutoCommitIntervalMs::NAME)
                    ->defaultValue(AutoCommitIntervalMs::getDefaultValue())
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(AutoOffsetReset::NAME)
                    ->defaultValue(AutoOffsetReset::getDefaultValue())
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode(Brokers::NAME)
                    ->defaultValue(Brokers::getDefaultValue())
                    ->cannotBeEmpty()
                    ->scalarPrototype()
                        ->cannotBeEmpty()
                    ->end()
                ->end()
                ->scalarNode(Decoder::NAME)
                    ->defaultValue(Decoder::getDefaultValue())
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(GroupId::NAME)
                    ->defaultValue(GroupId::getDefaultValue())
                    ->cannotBeEmpty()
                ->end()
                ->integerNode(Offset::NAME)
                    ->defaultValue(Offset::getDefaultValue())
                ->end()
                ->scalarNode(OffsetStoreMethod::NAME)
                    ->defaultValue(OffsetStoreMethod::getDefaultValue())
                    ->cannotBeEmpty()
                ->end()
                ->integerNode(Partition::NAME)
                    ->defaultValue(Partition::getDefaultValue())
                ->end()
                ->scalarNode(SchemaRegistry::NAME)
                    ->defaultValue(SchemaRegistry::getDefaultValue())
                    ->cannotBeEmpty()
                ->end()
                ->integerNode(Timeout::NAME)
                    ->defaultValue(Timeout::getDefaultValue())
                ->end()
                ->arrayNode(Topics::NAME)
                    ->defaultValue(Topics::getDefaultValue())
                    ->cannotBeEmpty()
                    ->scalarPrototype()
                        ->cannotBeEmpty()
                    ->end()
                ->end()
                ->scalarNode(EnableAutoOffsetStore::NAME)
                    ->defaultValue(EnableAutoOffsetStore::getDefaultValue())
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(EnableAutoCommit::NAME)
                    ->defaultValue(EnableAutoCommit::getDefaultValue())
                    ->cannotBeEmpty()
                ->end()
                ->integerNode(LogLevel::NAME)
                    ->defaultValue(LogLevel::getDefaultValue())
                ->end()
                ->booleanNode(RegisterMissingSchemas::NAME)
                    ->defaultValue(RegisterMissingSchemas::getDefaultValue())
                ->end()
                ->booleanNode(RegisterMissingSubjects::NAME)
                    ->defaultValue(RegisterMissingSubjects::getDefaultValue())
                ->end()
            ->end();
    }
}

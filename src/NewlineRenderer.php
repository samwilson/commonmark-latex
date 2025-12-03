<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex;

use League\CommonMark\Node\Inline\Newline;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Xml\XmlNodeRendererInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

class NewlineRenderer implements NodeRendererInterface, XmlNodeRendererInterface, ConfigurationAwareInterface
{
    private ConfigurationInterface $config;

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }

    /**
     * @param Newline $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        Newline::assertInstanceOf($node);

        if ($node->getType() === Newline::HARDBREAK) {
            return "\\\\\n";
        }

        return $this->config->get('renderer/soft_break');
    }

    /**
     * @param Newline $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function getXmlTagName(Node $node): string
    {
        Newline::assertInstanceOf($node);

        return $node->getType() === Newline::SOFTBREAK ? 'softbreak' : 'linebreak';
    }

    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}

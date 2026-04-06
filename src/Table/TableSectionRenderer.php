<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\Table;

use League\CommonMark\Extension\Table\TableSection;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class TableSectionRenderer implements NodeRendererInterface
{
    /**
     * @param TableSection $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        TableSection::assertInstanceOf($node);

        if (! $node->hasChildren()) {
            return '';
        }

        $section = "\hline\n"
            . \trim($childRenderer->renderNodes($node->children()));
        if ($node->getType() === TableSection::TYPE_BODY) {
            $section .= "\n\hline";
        }

        return $section;
    }
}

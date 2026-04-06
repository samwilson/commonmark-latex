<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\Table;

use League\CommonMark\Extension\Table\TableCell;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class TableCellRenderer implements NodeRendererInterface
{
    /**
     * @param TableCell $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        TableCell::assertInstanceOf($node);

        return \trim($childRenderer->renderNodes($node->children()));
    }
}

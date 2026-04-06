<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\Table;

use League\CommonMark\Extension\Table\TableRow;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class TableRowRenderer implements NodeRendererInterface
{
    /**
     * @param TableRow $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        TableRow::assertInstanceOf($node);

        $row = '';
        foreach ($node->children() as $child) {
            $separator = $child->next() ? ' & ' : " \\\\\n";
            $row      .= \trim($childRenderer->renderNodes([$child])) . $separator;
        }

        return \trim($row);
    }
}

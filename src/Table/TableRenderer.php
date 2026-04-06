<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\Table;

use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Extension\Table\TableCell;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class TableRenderer implements NodeRendererInterface
{
    /**
     * @param Table $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        Table::assertInstanceOf($node);

        $alignments = [];
        foreach ($node->children() as $section) {
            foreach ($section->children() as $row) {
                foreach ($row->children() as $cell) {
                    if (! $cell instanceof TableCell) {
                        continue;
                    }

                    $align = $cell->getAlign();
                    if ($align === TableCell::ALIGN_RIGHT) {
                        $alignments[] = 'r';
                    } elseif ($align === TableCell::ALIGN_CENTER) {
                        $alignments[] = 'c';
                    } else {
                        $alignments[] = 'l';
                    }
                }

                break 2;
            }
        }

        return '\begin{tabular}{ ' . \implode(' ', $alignments) . ' }' . "\n"
            . \trim($childRenderer->renderNodes($node->children())) . "\n"
            . '\end{tabular}';
    }
}

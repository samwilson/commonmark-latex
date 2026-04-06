<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex;

use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class ListBlockRenderer implements NodeRendererInterface
{
    /**
     * {@inheritDoc}
     *
     * @param ListBlock $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        ListBlock::assertInstanceOf($node);

        $listType = $node->getListData()->type === ListBlock::TYPE_BULLET ? 'itemize' : 'enumerate';

        return '\\begin{' . $listType . '}' . "\n"
            . $childRenderer->renderNodes($node->children()) . "\n"
            . '\\end{' . $listType . '}' . "\n";
    }
}

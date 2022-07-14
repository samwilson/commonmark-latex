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
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        ListBlock::assertInstanceOf($node);

        $listData = $node->getListData();

        $listType = $listData->type === ListBlock::TYPE_BULLET ? 'itemize' : 'enumerate';

        $attrs = $node->data->get('attributes');

        // if ($listData->start !== null && $listData->start !== 1) {
        //     $attrs['start'] = (string) $listData->start;
        // }

        $innerSeparator = $childRenderer->getInnerSeparator();

        // return new HtmlElement($tag, $attrs, $innerSeparator . $childRenderer->renderNodes($node->children()) . $innerSeparator);

        return '\\begin{' . $listType . '}' . "\n"
            . $innerSeparator . $childRenderer->renderNodes($node->children()) . $innerSeparator
            . '\\end{' . $listType . '}';
    }
}

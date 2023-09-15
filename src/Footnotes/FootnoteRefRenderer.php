<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\Footnotes;

use League\CommonMark\Extension\Footnote\Node\FootnoteRef;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class FootnoteRefRenderer implements NodeRendererInterface
{
    /**
     * {@inheritDoc}
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        FootnoteRef::assertInstanceOf($node);

        $footnote = GatherFootnotesListener::$footnotes[$node->getReference()->getTitle()];

        return '\\footnote{' . $childRenderer->renderNodes($footnote->children()) . '}';
    }
}

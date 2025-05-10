<?php

/**
 * This file is entirely duplicated from the CommonMark core package.
 */

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\SmartPunct;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Node\Inline\AdjacentTextMerger;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Node\Query;

/**
 * Identifies any lingering Quote nodes that were missing pairs and converts them into Text nodes
 */
final class ReplaceUnpairedQuotesListener
{
    public function __invoke(DocumentParsedEvent $event): void
    {
        $query = (new Query())->where(Query::type(Quote::class));
        foreach ($query->findAll($event->getDocument()) as $quote) {
            \assert($quote instanceof Quote);

            $literal = $quote->getLiteral();
            if ($literal === Quote::SINGLE_QUOTE) {
                $literal = Quote::SINGLE_QUOTE_CLOSER;
            } elseif ($literal === Quote::DOUBLE_QUOTE) {
                $literal = Quote::DOUBLE_QUOTE_OPENER;
            }

            $quote->replaceWith($new = new Text($literal));
            AdjacentTextMerger::mergeWithDirectlyAdjacentNodes($new);
        }
    }
}

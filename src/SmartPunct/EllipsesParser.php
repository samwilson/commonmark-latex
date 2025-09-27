<?php

/**
 * This file is almost entirely duplicated from the CommonMark core package.
 */

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\SmartPunct;

use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

final class EllipsesParser implements InlineParserInterface
{
    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::oneOf('...', '. . .');
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $cursor->advanceBy($inlineContext->getFullMatchLength());
        $text = '\dots';
        if ($cursor->getCurrentCharacter() === ' ') {
            // Force a space afterwards if there is one in the Markdown.
            $text .= '\\';
        } elseif ($cursor->getCurrentCharacter() !== null) {
            // Otherwise, if not the end of the line, add a space to separate the dots from what follows.
            $text .= ' ';
        }

        $inlineContext->getContainer()->appendChild(new Text($text));

        return true;
    }
}

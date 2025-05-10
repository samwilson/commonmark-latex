<?php

/**
 * This file is entirely duplicated from the CommonMark core package.
 */

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\SmartPunct;

use League\CommonMark\Delimiter\Delimiter;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;
use League\CommonMark\Util\RegexHelper;

final class QuoteParser implements InlineParserInterface
{
    /**
     * @deprecated This constant is no longer used and will be removed in a future major release
     */
    public const DOUBLE_QUOTES = [Quote::DOUBLE_QUOTE, Quote::DOUBLE_QUOTE_OPENER, Quote::DOUBLE_QUOTE_CLOSER];

    /**
     * @deprecated This constant is no longer used and will be removed in a future major release
     */
    public const SINGLE_QUOTES = [Quote::SINGLE_QUOTE, Quote::SINGLE_QUOTE_OPENER, Quote::SINGLE_QUOTE_CLOSER];

    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::oneOf(Quote::SINGLE_QUOTE, Quote::DOUBLE_QUOTE);
    }

    /**
     * Normalizes any quote characters found and manually adds them to the delimiter stack
     */
    public function parse(InlineParserContext $inlineContext): bool
    {
        $char   = $inlineContext->getFullMatch();
        $cursor = $inlineContext->getCursor();
        $index  = $cursor->getPosition();

        $charBefore = $cursor->peek(-1);
        if ($charBefore === null) {
            $charBefore = "\n";
        }

        $cursor->advance();

        $charAfter = $cursor->getCurrentCharacter();
        if ($charAfter === null) {
            $charAfter = "\n";
        }

        [$leftFlanking, $rightFlanking] = $this->determineFlanking($charBefore, $charAfter);
        $canOpen                        = $leftFlanking && ! $rightFlanking;
        $canClose                       = $rightFlanking;

        $node = new Quote($char, ['delim' => true]);
        $inlineContext->getContainer()->appendChild($node);

        // Add entry to stack to this opener
        $inlineContext->getDelimiterStack()->push(new Delimiter($char, 1, $node, $canOpen, $canClose, $index));

        return true;
    }

    /**
     * @return bool[]
     */
    private function determineFlanking(string $charBefore, string $charAfter): array
    {
        $afterIsWhitespace   = \preg_match('/\pZ|\s/u', $charAfter);
        $afterIsPunctuation  = \preg_match(RegexHelper::REGEX_PUNCTUATION, $charAfter);
        $beforeIsWhitespace  = \preg_match('/\pZ|\s/u', $charBefore);
        $beforeIsPunctuation = \preg_match(RegexHelper::REGEX_PUNCTUATION, $charBefore);

        $leftFlanking = ! $afterIsWhitespace &&
            ! ($afterIsPunctuation &&
                ! $beforeIsWhitespace &&
                ! $beforeIsPunctuation);

        $rightFlanking = ! $beforeIsWhitespace &&
            ! ($beforeIsPunctuation &&
                ! $afterIsWhitespace &&
                ! $afterIsPunctuation);
        //echo "$charAfter, right = $rightFlanking, left = $leftFlanking\n";

        return [$leftFlanking, $rightFlanking];
    }
}

<?php

/**
 * This file is entirely duplicated from the CommonMark core package.
 */

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\SmartPunct;

use League\CommonMark\Delimiter\DelimiterInterface;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use League\CommonMark\Node\Inline\AbstractStringContainer;

final class QuoteProcessor implements DelimiterProcessorInterface
{
    /** @psalm-readonly */
    private string $normalizedCharacter;

    /** @psalm-readonly */
    private string $openerCharacter;

    /** @psalm-readonly */
    private string $closerCharacter;

    private function __construct(string $char, string $opener, string $closer)
    {
        $this->normalizedCharacter = $char;
        $this->openerCharacter     = $opener;
        $this->closerCharacter     = $closer;
    }

    public function getOpeningCharacter(): string
    {
        return $this->normalizedCharacter;
    }

    public function getClosingCharacter(): string
    {
        return $this->normalizedCharacter;
    }

    public function getMinLength(): int
    {
        return 1;
    }

    public function getDelimiterUse(DelimiterInterface $opener, DelimiterInterface $closer): int
    {
        return 1;
    }

    public function process(AbstractStringContainer $opener, AbstractStringContainer $closer, int $delimiterUse): void
    {
        $opener->insertAfter(new Quote($this->openerCharacter));
        $closer->insertBefore(new Quote($this->closerCharacter));
    }

    /**
     * Create a double-quote processor
     */
    public static function createDoubleQuoteProcessor(string $opener = Quote::DOUBLE_QUOTE_OPENER, string $closer = Quote::DOUBLE_QUOTE_CLOSER): self
    {
        return new self(Quote::DOUBLE_QUOTE, $opener, $closer);
    }

    /**
     * Create a single-quote processor
     */
    public static function createSingleQuoteProcessor(string $opener = Quote::SINGLE_QUOTE_OPENER, string $closer = Quote::SINGLE_QUOTE_CLOSER): self
    {
        return new self(Quote::SINGLE_QUOTE, $opener, $closer);
    }
}

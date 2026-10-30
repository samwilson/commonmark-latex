<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex;

use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;
use League\CommonMark\Util\RegexHelper;

/**
 * Handle backslashes separately to other special characters (they're in LatexSpecialCharsParser).
 */
final class BackslashParser implements InlineParserInterface
{
    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::string('\\');
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $next   = $cursor->peek();

        if ($next === "\n") {
            return false;
        }

        // Check if this backslash is followed by a special character (i.e. already added by LatexSpecialCharsParser).
        if ($next !== null && RegexHelper::isEscapable($next)) {
            $cursor->advanceBy(2);
            $map = [
                '\\' => '\\textbackslash{}',
                '~' => '\\textasciitilde{}',
                '^' => '\\textasciicircum{}',
                '&' => '\\&',
                '%' => '\\%',
                '$' => '\\$',
                '#' => '\\#',
                '_' => '\\_',
                '{' => '\\{',
                '}' => '\\}',
            ];
            $inlineContext->getContainer()->appendChild(new Text($map[$next] ?? $next));

            return true;
        }

        // All other backslashes should be output as actual backslahes.
        $cursor->advanceBy(1);
        $inlineContext->getContainer()->appendChild(new Text('\\textbackslash{}'));

        return true;
    }
}

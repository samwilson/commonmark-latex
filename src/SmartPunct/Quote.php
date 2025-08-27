<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\SmartPunct;

use League\CommonMark\Node\Inline\AbstractStringContainer;

final class Quote extends AbstractStringContainer
{
    public const DOUBLE_QUOTE        = '"';
    public const DOUBLE_QUOTE_OPENER = '``';
    public const DOUBLE_QUOTE_CLOSER = "''";

    public const SINGLE_QUOTE        = "'";
    public const SINGLE_QUOTE_OPENER = '`';
    public const SINGLE_QUOTE_CLOSER = "'";
}

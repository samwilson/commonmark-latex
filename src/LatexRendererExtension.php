<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Inline\Text;

final class LatexRendererExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new LatexSpecialCharsParser(), 10)

            ->addRenderer(Paragraph::class, new ParagraphRenderer(), 10)
            ->addRenderer(Text::class, new TextRenderer(), 10)

            ->addRenderer(BlockQuote::class, new BlockQuoteRenderer(), 10)
            ->addRenderer(FencedCode::class, new FencedCodeRenderer(), 10)
            ->addRenderer(Heading::class, new HeadingRenderer(), 10)
            ->addRenderer(IndentedCode::class, new IndentedCodeRenderer(), 10)
            ->addRenderer(ListBlock::class, new ListBlockRenderer(), 10)
            ->addRenderer(ListItem::class, new ListItemRenderer(), 10)
            ->addRenderer(ThematicBreak::class, new ThematicBreakRenderer(), 10)

            ->addRenderer(Code::class, new CodeRenderer(), 10)
            ->addRenderer(Emphasis::class, new EmphasisRenderer(), 10)
            ->addRenderer(Image::class, new ImageRenderer(), 10)
            ->addRenderer(Link::class, new LinkRenderer(), 10)
            ->addRenderer(Strong::class, new StrongRenderer(), 10);
    }
}

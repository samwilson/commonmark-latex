<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
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
            ->addRenderer(BlockQuote::class, new BlockQuoteRenderer(), 10)
            // @todo ->addRenderer(CoreNode\Block\Document::class,  new CoreRenderer\Block\DocumentRenderer(),  10)
            // @todo ->addRenderer(Node\Block\FencedCode::class,    new Renderer\Block\FencedCodeRenderer(),    10)
            ->addRenderer(Heading::class, new HeadingRenderer(), 10)
            // @todo ->addRenderer(Node\Block\HtmlBlock::class,     new Renderer\Block\HtmlBlockRenderer(),     10)
            // @todo ->addRenderer(Node\Block\IndentedCode::class,  new Renderer\Block\IndentedCodeRenderer(),  10)
            // @todo ->addRenderer(Node\Block\ListBlock::class,     new Renderer\Block\ListBlockRenderer(),     10)
            // @todo ->addRenderer(Node\Block\ListItem::class,      new Renderer\Block\ListItemRenderer(),      10)
            ->addRenderer(Paragraph::class, new ParagraphRenderer(), 10)
            // @todo ->addRenderer(Node\Block\ThematicBreak::class, new Renderer\Block\ThematicBreakRenderer(), 10)

            // @todo ->addRenderer(Node\Inline\Code::class,        new Renderer\Inline\CodeRenderer(),        10)
            ->addRenderer(Emphasis::class, new EmphasisRenderer(), 10)
            // @todo ->addRenderer(Node\Inline\HtmlInline::class,  new Renderer\Inline\HtmlInlineRenderer(),  10)
            // @todo ->addRenderer(Node\Inline\Image::class,       new Renderer\Inline\ImageRenderer(),       10)
            // @todo ->addRenderer(Node\Inline\Link::class,        new Renderer\Inline\LinkRenderer(),        10)
            // @todo ->addRenderer(CoreNode\Inline\Newline::class, new CoreRenderer\Inline\NewlineRenderer(), 10)
            ->addRenderer(Strong::class, new StrongRenderer(), 10)
            ->addRenderer(Text::class, new TextRenderer(), 10);
    }
}

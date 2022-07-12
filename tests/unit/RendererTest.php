<?php

declare(strict_types=1);

namespace Samwilson\CommonMarkLatex\Test\Unit;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Samwilson\CommonMarkLatex\LatexRendererExtension;

class RendererTest extends TestCase
{
    /**
     * @dataProvider provideRendering
     */
    public function testRendering(string $inputMarkdown, string $expectedLatex): void
    {
        $environment = new Environment(['html_input' => 'allow']);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new LatexRendererExtension());
        $converter = new MarkdownConverter($environment);
        $this->assertSame($expectedLatex, $converter->convert($inputMarkdown)->getContent());
    }

    /**
     * @return string[][]
     */
    public function provideRendering(): array
    {
        return [
            [
                'Lorem **strong** percent-10% dollar-$20 hash-#3 under_score {braces} tilde~ caret^.',
                "Lorem \\textbf{strong} percent-10\\% dollar-\\$20 hash-\\#3 under\\_score \\{braces\\} tilde\\textasciitilde caret\\textasciicircum.\n\n",
            ],
            [
                "Lorem\n\nIpsum",
                "Lorem\n\nIpsum\n\n",
            ],
            [
                '# Lorem *ipsum*',
                "\section{Lorem \\emph{ipsum}}\n",
            ],
            'ampersand' => [
                'Lorem & ipsum',
                "Lorem \\& ipsum\n\n",
            ],
        ];
    }
}

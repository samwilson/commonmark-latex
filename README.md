Samwilson/CommonMarkLatex
=========================

An extension to [League/CommonMark](https://commonmark.thephpleague.com)
for rendering Markdown to LaTeX.

[![CI](https://github.com/samwilson/commonmark-latex/workflows/CI/badge.svg)](https://github.com/samwilson/commonmark-latex/actions/workflows/ci.yml)

## Installation

```
$ composer install samwilson/commonmark-latex
```

## Usage

```php
<?php
$environment = new \League\CommonMark\Environment\Environment(['html_input' => 'allow']);
$environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension\CommonMarkCoreExtension());
$environment->addExtension(new \Samwilson\CommonMarkLatex\LatexRendererExtension());
$converter = new \League\CommonMark\MarkdownConverter($environment);
$latex = $converter->convert('*Markdown* content goes here!')->getContent());
```

## License

This program is free software: you can redistribute it and/or modify it under the terms of
the GNU General Public License as published by the Free Software Foundation,
either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.
If not, see <https://www.gnu.org/licenses/>.

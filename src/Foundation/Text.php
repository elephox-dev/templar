<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;
use Elephox\Templar\RenderWidget;

class Text extends RenderWidget {
	public function __construct(
		private readonly string $text,
	) {}

	public function render(RenderContext $context): string {
		return <<<HTML
<span style="{$this->renderStyle($context)}">
	$this->text
</span>
HTML;
	}

	private function renderStyle(RenderContext $context): string {
		$textStyle = $context->textStyle;

		return "font-size: $textStyle->size; font-weight: $textStyle->weight; font-family: $textStyle->font;";
	}
}

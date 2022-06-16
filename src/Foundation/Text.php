<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasRenderedStyle;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Text extends HtmlRenderWidget {
	use HasRenderedStyle;

	public function __construct(
		private readonly string $text,
	) {}

	private function renderStyle(RenderContext $context): string {
		$textStyle = $context->textStyle;

		return "font-size: $textStyle->size; font-weight: $textStyle->weight; font-family: $textStyle->font;";
	}

	protected function renderChild(RenderContext $context): string {
		return $this->text;
	}
}

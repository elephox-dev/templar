<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Text extends HtmlRenderWidget {
	public function __construct(
		private readonly string $text,
	) {}

	protected function renderStyleContent(RenderContext $context): string {
		$textStyle = $context->textStyle;

		return "font-size: $textStyle->size; font-weight: $textStyle->weight; font-family: $textStyle->font;";
	}

	protected function renderChild(RenderContext $context): string {
		return $this->text;
	}

	protected function getTag(): string {
		return 'span';
	}

	public function getHashCode(): int {
		return hexdec(
			substr(
				md5($this->text),
				0,
				8,
			)
		);
	}
}

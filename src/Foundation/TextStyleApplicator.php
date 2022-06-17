<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class TextStyleApplicator extends HtmlRenderWidget {
	use HasSingleRenderChild;

	public function __construct(
		protected readonly ?Widget $child,
		protected readonly ?TextStyle $textStyle = null,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = "width: 100%;height: 100%;";

		$textStyle = $context->textStyle?->overwriteFrom($this->textStyle) ?? $this->textStyle;

		if ($textStyle === null) {
			return $style;
		}

		if ($textStyle->font !== null) {
			$style .= "font-family: $textStyle->font;";
		}

		if ($textStyle->weight !== null) {
			$style .= "font-weight: $textStyle->weight;";
		}

		if ($textStyle->size !== null) {
			$style .= "font-size: $textStyle->size;";
		}

		if ($textStyle->align !== null) {
			$style .= "text-align: {$textStyle->align->value};";
		}

		return $style;
	}
}
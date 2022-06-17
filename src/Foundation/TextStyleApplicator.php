<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersTextStyle;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class TextStyleApplicator extends HtmlRenderWidget {
	use HasSingleRenderChild;
	use RendersTextStyle;

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

		return $this->renderTextStyle($textStyle) . $style;
	}
}
<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Color;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersTextStyle;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class Body extends HtmlRenderWidget {
	use HasSingleRenderChild;
	use RendersTextStyle;

	public function __construct(
		protected readonly ?Widget $child,
		protected readonly ?TextStyle $textStyle = null,
		protected null|Color $color = null,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}
	}

	protected function getTag(): string {
		return 'body';
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = '';

		$backgroundColor = $this->color ?? $context->colorScheme->background;
		if ($backgroundColor !== null) {
			$style .= "background-color: $backgroundColor; transition: background-color 0.3s ease;";
		}

		$style .= $this->renderTextStyle(
			$this->textStyle ?? $context->textStyle ?? new TextStyle(),
			$context
		);

		return $style;
	}
}

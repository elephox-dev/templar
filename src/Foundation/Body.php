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

	public function render(RenderContext $context): string {
		$tag = $this->getTag();
		$attributes =
			$this->renderAttributes(
				$context,
				false
			);
		$content = $this->renderContent($context);

		return $this->renderHtml(
			$tag,
			$attributes,
			$content
		);
	}

	public function getStyleClassName(): string {
		return $this->getTag();
	}

	public function renderCss(string $className, string $content): string {
		return "$className { $content }";
	}

	protected function getTag(): string {
		return 'body';
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = '';

		$backgroundColor = $this->color ?? $context->colorScheme->background;
		if ($backgroundColor !== null) {
			$style .= "background-color: $backgroundColor;";
		}

		$style .= $this->renderTextStyle(
			$this->textStyle ?? $context->textStyle ?? new TextStyle(),
			$context
		);

		return $style;
	}
}

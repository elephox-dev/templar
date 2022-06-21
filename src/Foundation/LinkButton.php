<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\Angle;
use Elephox\Templar\Border;
use Elephox\Templar\BorderRadius;
use Elephox\Templar\BoxShadow;
use Elephox\Templar\Color;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Gradient;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\LinearGradient;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersBoxShadows;
use Elephox\Templar\RendersPadding;
use Elephox\Templar\RendersTextStyle;
use Elephox\Templar\TextAlign;
use Elephox\Templar\TextDecoration;
use Elephox\Templar\TextDecorationPosition;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class LinkButton extends HtmlRenderWidget {
	use RendersTextStyle;
	use RendersBoxShadows;
	use RendersPadding;

	protected readonly Closure $linkRenderer;

	/**
	 * @param string|callable(RenderContext): string $link
	 */
	public function __construct(
		protected readonly ?Widget $child,
		string|callable $link,
		protected readonly bool $newWindow = false,
		protected readonly null|Gradient|Color $background = null,
		protected readonly ?TextStyle $textStyle = null,
		protected readonly ?EdgeInsets $padding = null,
		protected readonly ?Border $border = null,
		protected readonly ?BorderRadius $borderRadius = null,
	) {
		$this->linkRenderer = $link instanceof Closure
			? $link
			: static fn() => $link;
	}

	use HasSingleRenderChild;

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context) + [
				'href' => ($this->linkRenderer)($context),
			];

		if ($this->newWindow) {
			$attributes['target'] = '_blank';
		}

		return $attributes;
	}

	protected function getTag(): string {
		return 'a';
	}

	public function renderStyle(RenderContext $context): string {
		$className = $this->getStyleClassName();
		if (in_array(
			$className,
			$context->renderedClasses,
			true
		)) {
			return '';
		}

		$context->renderedClasses[] = $className;
		$style = ".$className {" . $this->renderDefaultStyleContent($context) . "}";
		$style .= ".$className:hover {" . $this->renderHoverStyleContent($context) . "}";
		$style .= ".$className:focus {" . $this->renderFocusStyleContent($context) . "}";
		$style .= ".$className:active {" . $this->renderActiveStyleContent($context) . "}";
		return $style;
	}

	protected function renderDefaultStyleContent(RenderContext $context): string {
		$style = $this->renderStyleContent($context);

		$style .= "transition: background 0.2s ease-out, box-shadow 0.2s ease-out;";

		$background = $this->background ?? $context->colorScheme->primary;
		$style .= "background: $background;";

		$padding = $this->padding ?? EdgeInsets::symmetric(16, 8);
		$style .= $this->renderPadding($padding);
		$style .= $this->renderBoxShadows(BoxShadow::fromElevation(4)->withAmbient());

		$textStyle = $this->textStyle ?? $context->textStyle ?? new TextStyle();
		$textStyle = $textStyle->withFallback(
			size: Length::inRem(0.9),
			align: TextAlign::Center,
			color: $context->colorScheme->onPrimary,
			decoration: new TextDecoration(),
		);
		$style .= $this->renderTextStyle(
			$textStyle->with(
				decoration: $textStyle->decoration->withFallback(
					positions: [TextDecorationPosition::None]
				)
			),
			$context,
		);

		if ($this->border !== null) {
			$style .= $this->border->toEmittable();
		}

		$borderRadius = $this->borderRadius ?? BorderRadius::all(4);
		$style .= $borderRadius->toEmittable();

		return $style;
	}

	protected function renderHoverStyleContent(RenderContext $context): string {
		$style = "";

		$background = ($this->background ?? $context->colorScheme->primary)->darken(0.1);
		$style .= "background: $background;";
		$style .= $this->renderBoxShadows(BoxShadow::fromElevation(6)->withAmbient());

		return $style;
	}

	protected function renderActiveStyleContent(RenderContext $context): string {
		$style = "";

		$background = ($this->background ?? $context->colorScheme->primary)->darken(0.3);
		$style .= "background: $background;";
		$style .= $this->renderBoxShadows(BoxShadow::fromElevation(2)->withAmbient());

		return $style;
	}

	protected function renderFocusStyleContent(RenderContext $context): string {
		$style = $this->renderHoverStyleContent($context);

		$style .= "outline: none;";

		return $style;
	}
}
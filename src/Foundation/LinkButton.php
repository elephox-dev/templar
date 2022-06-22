<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\BackgroundValue;
use Elephox\Templar\Border;
use Elephox\Templar\BorderRadius;
use Elephox\Templar\BorderSide;
use Elephox\Templar\BoxShadow;
use Elephox\Templar\Color;
use Elephox\Templar\ColorRank;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
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
	use HasSingleRenderChild;

	protected readonly Closure $linkRenderer;

	/**
	 * @param string|callable(RenderContext): string $link
	 */
	public function __construct(
		protected readonly ?Widget $child,
		string|callable $link,
		protected readonly ?bool $newWindow = null,
		protected readonly null|BackgroundValue $background = null,
		protected readonly ?TextStyle $textStyle = null,
		protected readonly ?EdgeInsets $padding = null,
		protected readonly ?BorderRadius $borderRadius = null,
		protected readonly ColorRank $rank = ColorRank::Primary,
	) {
		if ($this->child !== null) {
			$this->child->renderParent = $this;
		}

		$this->linkRenderer = $link instanceof Closure
			? $link
			: static fn() => $link;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->child,
			$this->background,
			$this->textStyle,
			$this->padding,
			$this->borderRadius,
			$this->rank,
		);
	}

	protected function getAttributes(RenderContext $context): array {
		$href = ($this->linkRenderer)($context);
		$attributes = parent::getAttributes($context) + [
				'href' => $href,
			];

		// TODO: parse href to determine if it is a relative or absolute URL and open absolute on other domains in new windows by default ($newWindow === null)
		if ($this->newWindow === true) {
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

		$style .= "transition: background 0.2s ease-out, box-shadow 0.2s ease-out, border 0.2s ease-out;";

		$background = $this->getBackground($context);
		$style .= "background: {$background->toEmittable()};";

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
				color: $this->background !== null
					? $context->textStyle->color
					: match ($this->rank) {
						ColorRank::Primary => $context->colorScheme->onPrimary,
						ColorRank::Secondary => $context->colorScheme->onSecondary,
						ColorRank::Tertiary => $context->colorScheme->onTertiary,
					},
				decoration: $textStyle->decoration->withFallback(
					positions: [TextDecorationPosition::None]
				),
			),
			$context,
		);

		$border = Border::all(BorderSide::solid(2, Colors::Transparent()));
		$style .= $border->toEmittable();

		$borderRadius = $this->borderRadius ?? BorderRadius::all(4);
		$style .= $borderRadius->toEmittable();

		return $style;
	}

	protected function renderHoverStyleContent(RenderContext $context): string {
		$style = "";

		$background = $this->getBackground($context);
		if ($background instanceof Color) {
			$background = $background->darken(0.1);
		}
		$style .= "background: $background;";
		$style .= $this->renderBoxShadows(BoxShadow::fromElevation(6)->withAmbient());

		return $style;
	}

	protected function renderActiveStyleContent(RenderContext $context): string {
		$style = "";

		$background = $this->getBackground($context);
		if ($background instanceof Color) {
			$background = $background->darken(0.3);
		}
		$style .= "background: $background;";
		$style .= $this->renderBoxShadows(BoxShadow::fromElevation(2)->withAmbient());

		return $style;
	}

	protected function renderFocusStyleContent(RenderContext $context): string {
		$style = $this->renderHoverStyleContent($context);

		$style .= "outline: none;";

		return $style;
	}

	protected function getBackground(RenderContext $context): BackgroundValue {
		return $this->background ?? match ($this->rank) {
				ColorRank::Secondary => $context->colorScheme->secondary,
				ColorRank::Tertiary => $context->colorScheme->tertiary,
				default => $context->colorScheme->primary,
			};
	}
}
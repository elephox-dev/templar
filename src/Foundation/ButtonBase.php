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
use Elephox\Templar\Offset;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersBoxShadows;
use Elephox\Templar\RendersPadding;
use Elephox\Templar\RendersTextStyle;
use Elephox\Templar\TextAlign;
use Elephox\Templar\TextDecoration;
use Elephox\Templar\TextDecorationPosition;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

abstract class ButtonBase extends HtmlRenderWidget {
	use RendersTextStyle;
	use RendersBoxShadows;
	use RendersPadding;
	use HasSingleRenderChild;

	public function __construct(
		protected readonly ?Widget $child,
		protected readonly null|BackgroundValue $background,
		protected readonly ?TextStyle $textStyle,
		protected readonly ?EdgeInsets $padding,
		protected readonly ?BorderRadius $borderRadius,
		protected readonly ColorRank $rank,
	) {}

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

	protected function getTag(): string {
		return 'button';
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

		$style .= "cursor: pointer;";

		$background = $this->getBackground($context);
		$style .= "background: {$background->toEmittable()};";

		$padding =
			$this->padding
			??
			EdgeInsets::symmetric(
				16,
				8
			);
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

		$border =
			Border::all(
				BorderSide::solid(
					0,
					Colors::Transparent()
				)
			);
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
			$background = $background->darken(0.2);
		}
		$style .= "background: $background;";
		$style .= $this->renderBoxShadows(
			[
				...BoxShadow::fromElevation(2)->withAmbient(),
				new BoxShadow(
					offset: Offset::both(2),
					blurRadius: 6,
					color: Colors::Black()->withOpacity(0.2),
					inset: true
				),
			]
		);

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
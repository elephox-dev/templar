<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BackgroundValue;
use Elephox\Templar\Border;
use Elephox\Templar\BorderRadius;
use Elephox\Templar\BorderSide;
use Elephox\Templar\Color;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\EmittableLength;
use Elephox\Templar\Gradient;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\Positionable;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersBoxShadows;
use Elephox\Templar\RendersMargin;
use Elephox\Templar\RendersPadding;
use Elephox\Templar\Widget;

class Container extends HtmlRenderWidget implements Positionable {
	use HasSingleRenderChild;
	use RendersPadding;
	use RendersMargin;
	use RendersBoxShadows;

	protected readonly ?EmittableLength $width;
	protected readonly ?EmittableLength $height;
	protected readonly ?EmittableLength $minWidth;
	protected readonly ?EmittableLength $minHeight;
	protected readonly ?EmittableLength $maxWidth;
	protected readonly ?EmittableLength $maxHeight;
	protected readonly ?EmittableLength $top;
	protected readonly ?EmittableLength $left;
	protected readonly ?EmittableLength $bottom;
	protected readonly ?EmittableLength $right;

	public function __construct(
		protected readonly ?Widget $child = null,
		protected readonly null|BackgroundValue $background = null,
		protected readonly array $shadows = [],
		protected readonly null|EdgeInsets $padding = null,
		protected readonly null|EdgeInsets $margin = null,
		protected readonly ?Border $border = null,
		protected readonly ?BorderRadius $borderRadius = null,
		protected ?PositionContext $position = null,
		null|int|float|EmittableLength $width = null,
		null|int|float|EmittableLength $height = null,
		null|int|float|EmittableLength $minWidth = null,
		null|int|float|EmittableLength $minHeight = null,
		null|int|float|EmittableLength $maxWidth = null,
		null|int|float|EmittableLength $maxHeight = null,
		null|int|float|EmittableLength $top = null,
		null|int|float|EmittableLength $left = null,
		null|int|float|EmittableLength $bottom = null,
		null|int|float|EmittableLength $right = null,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}

		$this->width = $width === null ? null : Length::wrap($width);
		$this->height = $height === null ? null : Length::wrap($height);
		$this->minWidth = $minWidth === null ? null : Length::wrap($minWidth);
		$this->minHeight = $minHeight === null ? null : Length::wrap($minHeight);
		$this->maxWidth = $maxWidth === null ? null : Length::wrap($maxWidth);
		$this->maxHeight = $maxHeight === null ? null : Length::wrap($maxHeight);
		$this->top = $top === null ? null : Length::wrap($top);
		$this->left = $left === null ? null : Length::wrap($left);
		$this->bottom = $bottom === null ? null : Length::wrap($bottom);
		$this->right = $right === null ? null : Length::wrap($right);
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = '';

		if ($this->background !== null) {
			if ($this->background instanceof Color) {
				$property = "background-color";
			} else {
				$property = "background-image";
			}

			$style .= "$property: {$this->background->toEmittable()};";
		}

		if ($this->padding !== null) {
			$style .= $this->renderPadding($this->padding);
		}

		if ($this->margin !== null) {
			$style .= $this->renderMargin($this->margin);
		}

		if (!empty($this->shadows)) {
			$style .= $this->renderBoxShadows($this->shadows);
		}

		$border = $this->border;

		if ($this->borderRadius !== null) {
			if ($border === null) {
				$border =
					Border::all(
						BorderSide::solid(
							0,
							Colors::Transparent()
						)
					);
			}

			$style .= $this->borderRadius->toEmittable();
		}

		if ($border !== null) {
			$style .= $this->border->toEmittable();
		}

		if ($this->position !== null) {
			$style .= "position: {$this->position->value};";
		}

		if ($this->top !== null) {
			$style .= "top: {$this->top->toEmittable()};";
		}

		if ($this->left !== null) {
			$style .= "left: {$this->left->toEmittable()};";
		}

		if ($this->bottom !== null) {
			$style .= "bottom: {$this->bottom->toEmittable()};";
		}

		if ($this->right !== null) {
			$style .= "right: {$this->right->toEmittable()};";
		}

		if ($this->width !== null) {
			$style .= "width: {$this->width->toEmittable()};";
		}

		if ($this->height !== null) {
			$style .= "height: {$this->height->toEmittable()};";
		}

		if ($this->minWidth !== null) {
			$style .= "min-width: {$this->minWidth->toEmittable()};";
		}

		if ($this->minHeight !== null) {
			$style .= "min-height: {$this->minHeight->toEmittable()};";
		}

		if ($this->maxWidth !== null) {
			$style .= "max-width: {$this->maxWidth->toEmittable()};";
		}

		if ($this->maxHeight !== null) {
			$style .= "max-height: {$this->maxHeight->toEmittable()};";
		}

		return $style;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->child,
			$this->padding,
			$this->margin,
			$this->position,
			$this->border,
			$this->borderRadius,
			$this->width,
			$this->height,
			$this->minWidth,
			$this->minHeight,
			$this->maxWidth,
			$this->maxHeight,
			...
			$this->shadows,
		);
	}

	public function getContext(): PositionContext {
		return $this->position ?? PositionContext::Static;
	}

	public function getTop(): ?EmittableLength {
		return $this->top;
	}

	public function getLeft(): ?EmittableLength {
		return $this->left;
	}

	public function getRight(): ?EmittableLength {
		return $this->right;
	}

	public function getBottom(): ?EmittableLength {
		return $this->bottom;
	}

	public function maybeSetContext(PositionContext $context): void {
		$this->position ??= $context;
	}
}

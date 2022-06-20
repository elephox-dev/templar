<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Color;
use Elephox\Templar\CompoundLength;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Gradient;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\MathOperator;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersBoxShadows;
use Elephox\Templar\RendersMargin;
use Elephox\Templar\RendersPadding;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

class Container extends HtmlRenderWidget {
	use HasSingleRenderChild;
	use RendersPadding;
	use RendersMargin;
	use RendersBoxShadows;

	protected readonly ?Length $width;
	protected readonly ?Length $height;
	protected readonly ?Length $minWidth;
	protected readonly ?Length $minHeight;
	protected readonly ?Length $maxWidth;
	protected readonly ?Length $maxHeight;

	public function __construct(
		protected readonly ?Widget $child = null,
		protected readonly null|Gradient|Color $color = null,
		protected readonly array $shadows = [],
		protected readonly null|EdgeInsets $padding = null,
		protected readonly null|EdgeInsets $margin = null,
		protected readonly ?PositionContext $position = null,
		null|int|float|Length $width = null,
		null|int|float|Length $height = null,
		null|int|float|Length $minWidth = null,
		null|int|float|Length $minHeight = null,
		null|int|float|Length $maxWidth = null,
		null|int|float|Length $maxHeight = null,
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
	}

	protected function renderStyleContent(RenderContext $context): string {
		$width = new CompoundLength([$this->width ?? Length::inPercent(100)], MathOperator::Minus);
		$height =
			new CompoundLength([$this->height ?? Length::inPercent(100)], MathOperator::Minus);

		$style = '';

		if ($this->color !== null) {
			if ($this->color instanceof Gradient) {
				$property = "background-image";
			} else {
				$property = "background-color";
			}

			$style .= "$property: $this->color;";
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

		if ($this->position !== null) {
			$style .= "position: {$this->position->value};";
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

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->child,
			$this->padding,
			$this->margin,
			$this->position,
			$this->width,
			$this->height,
			$this->minWidth,
			$this->minHeight,
			$this->maxWidth,
			$this->maxHeight,
			...$this->shadows,
		);
	}
}

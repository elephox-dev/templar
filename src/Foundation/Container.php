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

	public function __construct(
		protected readonly ?Widget $child = null,
		protected readonly null|Gradient|Color $color = null,
		protected readonly array $shadows = [],
		protected readonly null|EdgeInsets $padding = null,
		protected readonly null|EdgeInsets $margin = null,
		null|int|float|Length $width = null,
		null|int|float|Length $height = null,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}

		$this->width = $width === null ? null : Length::wrap($width);
		$this->height = $height === null ? null : Length::wrap($height);
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

		$style .= "width: {$width->toEmittable()}; height: {$height->toEmittable()};";

		return $style;
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->child?->getHashCode(),
			$this->color?->getHashCode(),
		);
	}
}

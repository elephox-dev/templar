<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\CompoundLength;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\MathOperator;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersPadding;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

class Padding extends HtmlRenderWidget {
	use HasSingleRenderChild;
	use RendersPadding;

	public function __construct(
		protected readonly ?Widget $child,
		protected readonly EdgeInsets $padding,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}
	}

	protected function renderStyleContent(RenderContext $context): string {
		$width = new CompoundLength([Length::inPercent(100)], MathOperator::Minus);
		$height = new CompoundLength([Length::inPercent(100)], MathOperator::Minus);
		$padding = $this->renderPadding($this->padding, $width, $height);

		return "{$padding}width: {$width->toEmittable()}; height: {$height->toEmittable()};";
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->child?->getHashCode(),
			$this->padding->getHashCode(),
		);
	}
}
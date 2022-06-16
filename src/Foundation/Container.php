<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Color;
use Elephox\Templar\Gradient;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

class Container extends HtmlRenderWidget {
	use HasSingleRenderChild;

	public function __construct(
		protected readonly Widget $child,
		protected readonly null|Gradient|Color $color = null,
	) {}

	protected function renderStyleContent(RenderContext $context): string {
		$style = 'width: 100%; height: 100%;';

		if ($this->color !== null) {
			if ($this->color instanceof Gradient) {
				$property = "background-image";
			} else {
				$property = "background-color";
			}

			$style .= "$property: $this->color;";
		}

		return $style;
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->child->getHashCode(),
			$this->color?->getHashCode(),
		);
	}
}

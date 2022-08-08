<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Color;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;

class Separator extends HtmlRenderWidget {
	public function __construct(
		protected readonly ?Color $color = null,
		protected readonly ?Length $size = null,
		protected readonly bool $horizontal = true,
	) {}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->color,
			$this->size,
			$this->horizontal,
		);
	}

	protected function renderContent(RenderContext $context): string {
		return "";
	}

	protected function getTag(): string {
		return "hr";
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = '';

		$color = $this->color ?? $context->colorScheme->divider;
		if ($color !== null) {
			$style .= 'background: ' . $color->toEmittable() . ';';
		}

		if ($this->size !== null) {
			$style .= ($this->horizontal ? 'height' : 'width') .
				': ' .
				$this->size->toEmittable() .
				';';
		}

		if (!$this->horizontal) {
			$style .= 'height: 100%;';
		}

		return $style;
	}
}
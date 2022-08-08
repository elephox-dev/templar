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
		protected readonly ?Length $thickness = null,
		protected readonly ?Length $length = null,
		protected readonly bool $horizontal = true,
	) {}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->color,
			$this->thickness,
			$this->length,
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
		$style = parent::renderStyleContent($context);

		$border = $this->horizontal ? "border-top" : "border-left";

		$color = $this->color ?? $context->colorScheme->divider;
		if ($color !== null) {
			$style .= $border . '-color: ' . $color->toEmittable() . ';';
		}

		$thickness = $this->thickness?->toEmittable() ?? 'thin';
		$style .= $border . '-width: ' . $thickness . ';';

		$length = $this->length ?? Length::inPercent(100);
		if ($this->horizontal) {
			$style .= 'height: 0; width: ' . $length->toEmittable() . ';';
		} else {
			$style .= 'height: ' . $length->toEmittable() . '; width: 0;';
		}

		return $style;
	}
}
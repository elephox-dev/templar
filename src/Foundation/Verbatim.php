<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;
use Elephox\Templar\RenderWidget;

class Verbatim extends RenderWidget {
	public function __construct(
		protected readonly string $content,
		protected readonly string $style = "",
	) {}

	public function getHashCode(): float {
		return 0.0;
	}

	public function render(RenderContext $context): string {
		return $this->content;
	}

	public function renderStyle(RenderContext $context): string {
		return $this->style;
	}
}
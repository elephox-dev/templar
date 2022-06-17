<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class Positioned extends HtmlRenderWidget {
	use HasSingleRenderChild;

	public function __construct(
		protected readonly ?Widget $child,
		protected readonly PositionContext $position,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}
	}

	protected function renderStyleContent(RenderContext $context): string {
		return "position: {$this->position->value};width: 100%; height: 100%;";
	}
}
<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class GridCell extends HtmlRenderWidget {
	use HasSingleRenderChild;

	public function __construct(
		protected readonly ?Widget $child,
		protected readonly string $area,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}
	}

	public function renderStyleContent(RenderContext $context): string {
		return parent::renderStyleContent($context) . "grid-area: $this->area;";
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->child,
			$this->area,
		);
	}
}
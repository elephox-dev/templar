<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class SizedBox extends HtmlRenderWidget {
	use HasSingleRenderChild;

	public function __construct(
		protected readonly ?Widget $child,
		protected readonly ?Length $width = null,
		protected readonly ?Length $height = null,
	) {
		if ($this->child !== null) {
			$this->child->renderParent = $this;
		}
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->child->getHashCode(),
			$this->width?->getHashCode(),
			$this->height?->getHashCode(),
		);
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = '';

		if ($this->width !== null) {
			$style .= "width: $this->width;";
		}

		if ($this->height !== null) {
			$style .= "height: $this->height;";
		}

		return $style;
	}
}

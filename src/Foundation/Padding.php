<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\EdgeInsets;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RendersPadding;
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
		return $this->renderPadding($this->padding);
	}

	public function getHashCode(): int {
		return HashBuilder::buildHash(
			$this->child?->getHashCode(),
			$this->padding->getHashCode(),
		);
	}
}
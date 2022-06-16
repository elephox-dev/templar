<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait HasSingleRenderChild {
	public function __construct(
		private readonly Widget $child,
	) {}

	protected function renderChild(RenderContext $context): string {
		return $this->child->render($context);
	}
}

<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait HasSingleRenderChild {
	public function __construct(
		protected readonly Widget $child,
	) {}

	protected function renderChild(RenderContext $context): string {
		return $this->child->render($context);
	}

	public function renderStyle(RenderContext $context): string
	{
		$myStyle = parent::renderStyle($context);
		$childStyle = $this->child->renderStyle($context);
		return <<<CSS
$myStyle
$childStyle
CSS;
	}

	protected function renderStyleContent(RenderContext $context): string {
		return '';
	}

	public function getHashCode(): int {
		return $this->child->getHashCode();
	}
}

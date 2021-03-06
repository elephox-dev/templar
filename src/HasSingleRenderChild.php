<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait HasSingleRenderChild {
	public function __construct(
		protected readonly ?Widget $child,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}
	}

	protected function renderContent(RenderContext $context): string {
		return $this->child?->render($context) ?? '';
	}

	public function renderStyle(RenderContext $context): string {
		$myStyle = parent::renderStyle($context);
		$childStyle = $this->child?->renderStyle($context) ?? '';

		return $myStyle . $childStyle;
	}

	public function getHashCode(): float {
		return $this->child?->getHashCode() ?? 0.0;
	}
}

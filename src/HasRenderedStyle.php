<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait HasRenderedStyle {
	protected function getAttributes(RenderContext $context): array {
		return parent::getAttributes($context) + [
				'style' => $this->renderStyle($context),
			];
	}

	protected function renderStyle(RenderContext $context): string {
		return '';
	}
}

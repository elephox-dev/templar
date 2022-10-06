<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

class CodeSpan extends TextSpan {
	protected function getTag(): string {
		return 'code';
	}

	protected function shouldFlattenRender(): bool {
		return $this->renderParent instanceof self && parent::shouldFlattenRender();
	}
}
<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class BuildWidget extends Widget
{
	public function render(RenderContext $context): string {
		return $this->build()->render($context);
	}

	public function renderStyle(RenderContext $context): string {
		return $this->build()->renderStyle($context);
	}

	public function getHashCode(): int {
		return hexdec(substr(spl_object_hash($this), 0, 8));
	}
}

<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class RenderWidget extends Widget {
	protected function build(): Widget {
		return $this;
	}

	abstract public function render(RenderContext $context): string;
}

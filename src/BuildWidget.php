<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class BuildWidget extends Widget
{
	abstract protected function build(): Widget;

	public function render(RenderContext $context): string {
		return $this->build()->render($context);
	}
}

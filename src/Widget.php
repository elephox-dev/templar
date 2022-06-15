<?php

namespace Elephox\Templar;

abstract class Widget {
	abstract protected function build(): Widget;

	abstract public function render(RenderContext $context): string;
}

<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class RenderWidget extends Widget {
	protected function build(RenderContext $context): Widget {
		return $this;
	}
}

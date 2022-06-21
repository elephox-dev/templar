<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class RenderWidget extends Widget {
	protected function build(RenderContext $context): Widget {
		assert(
			isset($this->renderParent),
			"No render parent set for widget: " . get_debug_type($this)
		);

		return $this;
	}
}

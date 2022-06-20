<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Throwable;

abstract class BuildWidget extends Widget {
	public function safeBuild(RenderContext $context): Widget {
		try {
			return $this->build($context);
		} catch (Throwable $e) {
			return new ThrowableWidget($e);
		}
	}

	public function render(RenderContext $context): string {
		return $this->safeBuild($context)->render($context);
	}

	public function renderStyle(RenderContext $context): string {
		return $this->safeBuild($context)->renderStyle($context);
	}

	public function getHashCode(): int {
		return 0;
	}
}

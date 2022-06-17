<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Throwable;

abstract class BuildWidget extends Widget {
	public function render(RenderContext $context): string {
		try {
			return $this->build()->render($context);
		} catch (Throwable $e) {
			return (new ThrowableWidget($e))->render($context);
		}
	}

	public function renderStyle(RenderContext $context): string {
		try {
			return $this->build()->renderStyle($context);
		} catch (Throwable $e) {
			return (new ThrowableWidget($e))->renderStyle($context);
		}
	}

	public function getHashCode(): int {
		return hexdec(substr(spl_object_hash($this), 0, 8));
	}
}

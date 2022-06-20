<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class LateWidget extends BuildWidget {
	/**
	 * @param Closure(Widget, RenderContext): Widget $buildCallback
	 */
	public function __construct(
		protected readonly Closure $buildCallback,
	) {}

	protected function build(RenderContext $context): Widget {
		return ($this->buildCallback)($this, $context);
	}
}
<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\Widget;

class LateWidget extends BuildWidget {
	/**
	 * @param Closure(): Widget $buildCallback
	 */
	public function __construct(
		protected readonly Closure $buildCallback,
	) {}

	protected function build(): Widget {
		return ($this->buildCallback)();
	}
}
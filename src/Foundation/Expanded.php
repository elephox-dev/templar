<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\Widget;

class Expanded extends BuildWidget {
	public function __construct(
		private readonly Widget $child,
	) {}

	protected function build(): Widget {
		return new FlexChild(
			$this->child,
			grow: 1,
		);
	}
}

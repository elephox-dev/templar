<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class Expanded extends BuildWidget {
	public function __construct(
		protected readonly Widget $child,
	) {}

	protected function build(RenderContext $context): Widget {
		return new FlexChild(
			$this->child,
			grow: 1,
		);
	}

	public function getHashCode(): float {
		return $this->child->getHashCode();
	}
}

<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Widget;

class Center extends Widget {
	public function __construct(
		private readonly Widget $child,
	) {}

	public function render(): string {
		return (new Flex(
			children: [
				$this->child,
			],
		))->render();
	}
}

<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class SingleChildRenderWidget extends RenderWidget {
	public function __construct(
		protected readonly Widget $child,
	) {}
}

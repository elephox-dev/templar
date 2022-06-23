<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class LateWidget extends BuildWidget {
	public function __construct(
		protected readonly Closure $buildCallback,
	) {}

	protected function build(RenderContext $context): Widget {
		$result =
			($this->buildCallback)(
				$context,
				$this
			);

		assert(
			$result instanceof Widget,
			'LateWidget build callback must return a Widget'
		);

		$result->renderParent = $this->renderParent;

		return $result;
	}
}
<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;
use Elephox\Templar\RenderWidget;
use Elephox\Templar\Widget;

class Body extends RenderWidget {
	public function __construct(
		private readonly Widget $child,
	) {}

	public function render(RenderContext $context): string {
		return <<<HTML
<body>
	{$this->child->render($context)}
</body>
HTML;
	}
}

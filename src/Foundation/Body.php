<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;

class Body extends HtmlRenderWidget {
	use HasSingleRenderChild;

	protected function getTag(): string {
		return 'body';
	}
}

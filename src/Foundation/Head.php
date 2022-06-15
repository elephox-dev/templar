<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;
use Elephox\Templar\RenderWidget;

class Head extends RenderWidget {
	public function __construct(
		private readonly ?string $title = null,
	) {}

	public function render(RenderContext $context): string {
		$title = $this->title ?? $context->documentMeta?->title;

		return <<<HTML
<head>
	<title>$title</title>
	
	<style>
		{$this->renderStyle($context)}
	</style>
</head>
HTML;
	}

	private function renderStyle(RenderContext $context): string {
		$colors = $context->colorScheme;
		$style = <<<CSS
html, body {
	height: 100%;
	margin: 0;
}

body {
	background-color: $colors->background;
	color: $colors->foreground;
}
CSS;

		if ($context->darkColorScheme !== null) {
			$darkColors = $context->darkColorScheme;
			$style .= <<<CSS
@media (prefers-color-scheme: dark) {
	body {
		background-color: $darkColors->background;
		color: $darkColors->foreground;
	}
}
CSS;
		}

		return $style;
	}
}

<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;
use Elephox\Templar\RenderWidget;

class Document extends RenderWidget {
	public function __construct(
		private readonly Head $head,
		private readonly Body $body,
	) {}

	public function render(RenderContext $context): string {
		$context->documentMeta ??= new DocumentMeta();

		$body = $this->body->render($context);

		// render head after context, so scripts can be injected from body widgets
		$head = $this->head->render($context);

		return <<<HTML
<!DOCTYPE html>
<html lang="{$context->documentMeta->language}">
	$head
	$body
</html>
HTML;
	}
}

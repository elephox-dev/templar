<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

abstract class HeadWidget extends HtmlRenderWidget {
	public function render(RenderContext $context): string {
		$tag = $this->getTag();
		if (!in_array(
			$tag,
			['base', 'meta', 'link', 'style', 'script', 'title'],
			true
		)) {
			throw new \InvalidArgumentException(
				"Tag '$tag' is not allowed in the head"
			);
		}

		$attributes =
			$this->renderAttributes(
				$context,
				false
			);
		$content = $this->renderContent($context);

		return $this->renderHtml(
			$tag,
			$attributes,
			$content
		);
	}

	protected function renderContent(RenderContext $context): string {
		return '';
	}

	public function getHashCode(): float {
		return 0.0;
	}
}

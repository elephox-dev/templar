<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class HtmlRenderWidget extends RenderWidget {
	public function render(RenderContext $context): string {
		$previousParent = $context->parent;
		$context->parent = $this;

		$tag = $this->getTag();
		$attributes = $this->renderAttributes($context);
		$child = $this->renderChild($context);

		$context->parent = $previousParent;

		return <<<HTML
<$tag $attributes>
	$child
</$tag>
HTML;
	}

	abstract protected function renderChild(RenderContext $context): string;

	protected function renderAttributes(RenderContext $context): string {
		$attributes = [];

		foreach ($this->getAttributes($context) as $name => $value) {
			$attributes[] = "$name=\"$value\"";
		}

		return implode(' ', $attributes);
	}

	protected function getAttributes(RenderContext $context): array {
		return [];
	}

	protected function getTag(): string {
		return 'div';
	}
}

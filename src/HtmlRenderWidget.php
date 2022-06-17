<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class HtmlRenderWidget extends RenderWidget {
	public function render(RenderContext $context): string {
		$tag = $this->getTag();
		$attributes = $this->renderAttributes($context);
		$child = $this->renderChild($context);

		return <<<HTML
<$tag $attributes>
	$child
</$tag>
HTML;
	}

	abstract protected function renderChild(RenderContext $context): string;

	protected function renderAttributes(RenderContext $context): string {
		$attributes = $this->getAttributes($context);

		if (isset($attributes['class'])) {
			$attributes['class'] .= ' ' . $this->getStyleClassName();
		}
		else {
			$attributes['class'] = $this->getStyleClassName();
		}

		foreach ($attributes as $name => $value) {
			if ($name === 'style') {
				trigger_error(
					'Style attributes should not be inline. Use HtmlRenderWidget::renderStyle instead',
					E_USER_NOTICE,
				);
			}

			$rendered[] = "$name=\"$value\"";
		}

		return implode(
			' ',
			$rendered,
		);
	}

	public function renderStyle(RenderContext $context): string {
		if (in_array(
			$this->getStyleClassName(),
			$context->renderedClasses,
			true
		)) {
			return '';
		}

		$context->renderedClasses[] = $this->getStyleClassName();

		return <<<CSS
.{$this->getStyleClassName()} {
	{$this->renderStyleContent($context)}
}
CSS;
	}

	abstract protected function renderStyleContent(RenderContext $context): string;

	protected function getAttributes(RenderContext $context): array {
		return [];
	}

	protected function getTag(): string {
		return 'div';
	}
}

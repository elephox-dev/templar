<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class HtmlRenderWidget extends RenderWidget {
	public function render(RenderContext $context): string {
		$tag = $this->getTag();
		$attributes = $this->renderAttributes($context);
		$content = $this->renderContent($context);

		return $this->renderHtml(
			$tag,
			$attributes,
			$content
		);
	}

	protected function renderHtml(string $tag, string $attributes, string $content): string {
		// TODO: check which tags can/must be closed
		if ($content === '' &&
			!in_array(
				$tag,
				['div', 'script'],
				true
			)) {
			return "<$tag $attributes/>";
		}

		return "<$tag $attributes>$content</$tag>";
	}

	abstract protected function renderContent(RenderContext $context): string;

	protected function renderAttributes(
		RenderContext $context,
		bool $includeStyleClassname = true
	): string {
		$attributes = $this->getAttributes($context);

		if ($includeStyleClassname) {
			if (isset($attributes['class'])) {
				$attributes['class'] .= ' ' . $this->getStyleClassName();
			} else {
				$attributes['class'] = $this->getStyleClassName();
			}
		}

		$rendered = [];
		foreach ($attributes as $name => $value) {
			if ($name === 'style') {
				trigger_error(
					'Style attributes should not be inline. Use HtmlRenderWidget::renderStyle instead'
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
		$className = $this->getStyleClassName();
		if (in_array(
			$className,
			$context->renderedClasses,
			true
		)) {
			return '';
		}

		$context->renderedClasses[] = $className;
		$content = $this->renderStyleContent($context);
		if ($content === '') {
			return '';
		}

		return $this->renderCss(
			$className,
			$content
		);
	}

	public function renderCss(string $className, string $content): string {
		return "." . $className . " {" . $content . "}";
	}

	protected function renderStyleContent(RenderContext $context): string {
		return '';
	}

	protected function getAttributes(RenderContext $context): array {
		return [];
	}

	protected function getTag(): string {
		return 'div';
	}
}

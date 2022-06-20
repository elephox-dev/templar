<?php

namespace Elephox\Templar;

abstract class Widget implements Hashable {
	public ?RenderWidget $renderParent;

	abstract protected function build(RenderContext $context): Widget;

	abstract public function render(RenderContext $context): string;

	public function getStyleClassName(): string {
		return sprintf(
			'%s-%.0f',
			strtolower(str_replace('\\', '-', $this::class)),
			$this->getHashCode()
		);
	}

	abstract public function renderStyle(RenderContext $context): string;
}

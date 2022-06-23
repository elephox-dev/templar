<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\ContentAlignment;
use Elephox\Templar\CrossAxisAlignment;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\Length;
use Elephox\Templar\MainAxisAlignment;
use Elephox\Templar\RenderContext;

class Form extends Flex {
	protected array $children;

	public function __construct(
		iterable $children,
		?MainAxisAlignment $mainAxisAlignment = null,
		?CrossAxisAlignment $crossAxisAlignment = null,
		?ContentAlignment $contentAlignment = null,
		?FlexDirection $direction = null,
		?FlexWrap $wrap = null,
		?Length $rowGap = null,
		?Length $columnGap = null,
		?Length $width = null,
		?Length $height = null,
		protected readonly ?string $method = null,
		protected readonly ?string $action = null,
		protected readonly ?string $enctype = null,
	) {
		parent::__construct(
			$children,
			$mainAxisAlignment,
			$crossAxisAlignment,
			$contentAlignment,
			$direction,
			$wrap,
			$rowGap,
			$columnGap,
			$width,
			$height,
		);
	}

	protected function getTag(): string {
		return 'form';
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);

		if ($this->method !== null) {
			$attributes['method'] = $this->method;
		}

		if ($this->action !== null) {
			$attributes['action'] = $this->action;
		}

		if ($this->enctype !== null) {
			$attributes['enctype'] = $this->enctype;
		}

		return $attributes;
	}
}
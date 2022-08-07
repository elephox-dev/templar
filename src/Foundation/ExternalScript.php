<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;

class ExternalScript extends HeadWidget {
	// TODO add enums for crossorigin and referrerpolicy
	public function __construct(
		protected readonly string $src,
		protected readonly string $type = 'text/javascript',
		protected readonly bool $async = false,
		protected readonly bool $defer = false,
		protected readonly ?string $crossorigin = null,
		protected readonly ?string $integrity = null,
		protected readonly ?bool $nomodule = null,
		protected readonly ?string $referrerpolicy = null,
	) {}

	protected function getTag(): string {
		return 'script';
	}

	protected function getAttributes(RenderContext $context): array {
		$attrs = [
			'src' => $this->src,
			'type' => $this->type,
		];

		if ($this->async) {
			$attrs['async'] = 'async';
		}

		if ($this->defer) {
			$attrs['defer'] = 'defer';
		}

		if ($this->crossorigin) {
			$attrs['crossorigin'] = $this->crossorigin;
		}

		if ($this->integrity) {
			$attrs['integrity'] = $this->integrity;
		}

		if ($this->nomodule !== null) {
			$attrs['nomodule'] = $this->nomodule ? 'True' : 'False';
		}

		if ($this->referrerpolicy) {
			$attrs['referrerpolicy'] = $this->referrerpolicy;
		}

		return array_merge(
			parent::getAttributes($context),
			$attrs,
		);
	}
}
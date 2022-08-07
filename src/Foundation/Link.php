<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;

class Link extends HeadWidget {
	// TODO add enum for crossorigin, referrerpolicy and rel
	public function __construct(
		protected readonly string $href,
		protected readonly string $rel = 'stylesheet',
		protected readonly ?string $hreflang = null,
		protected readonly ?string $type = null,
		protected readonly ?string $media = null,
		protected readonly ?string $sizes = null,
		protected readonly ?string $referrerpolicy = null,
		protected readonly ?string $crossorigin = null,
		protected readonly ?string $title = null,
	) {}

	protected function getTag(): string {
		return 'link';
	}

	protected function getAttributes(RenderContext $context): array {
		$attrs = [
			'href' => $this->href,
			'rel' => $this->rel,
		];

		if ($this->hreflang) {
			$attrs['hreflang'] = $this->hreflang;
		}

		if ($this->type) {
			$attrs['type'] = $this->type;
		}

		if ($this->media) {
			$attrs['media'] = $this->media;
		}

		if ($this->sizes) {
			$attrs['sizes'] = $this->sizes;
		}

		if ($this->crossorigin) {
			$attrs['crossorigin'] = $this->crossorigin;
		}

		if ($this->referrerpolicy) {
			$attrs['referrerpolicy'] = $this->referrerpolicy;
		}

		if ($this->title) {
			$attrs['title'] = $this->title;
		}

		return array_merge(
			parent::getAttributes($context),
			$attrs,
		);
	}
}
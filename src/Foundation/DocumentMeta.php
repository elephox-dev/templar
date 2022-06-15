<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

class DocumentMeta {
	public function __construct(
		public ?string $title = null,
		public string $language = 'en',
	) {}
}

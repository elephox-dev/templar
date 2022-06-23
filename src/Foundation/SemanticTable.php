<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Border;

class SemanticTable extends Table {
	public function __construct(
		?TableHead $head = null,
		?TableBody $body = null,
		?TableFoot $foot = null,
		?Border $border = null,
	) {
		parent::__construct([], $border);

		if ($head !== null) {
			$head->renderParent = $this;
			$this->rows[] = $head;
		}

		if ($body !== null) {
			$body->renderParent = $this;
			$this->rows[] = $body;
		}

		if ($foot !== null) {
			$foot->renderParent = $this;
			$this->rows[] = $foot;
		}
	}
}
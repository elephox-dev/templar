<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum HyperlinkRel: string {
	use HasEnumHashCode;

	case Alternate = 'alternate';
	case Author = 'author';
	case Bookmark = 'bookmark';
	case External = 'external';
	case Help = 'help';
	case License = 'license';
	case Next = 'next';
	case NoFollow = 'nofollow';
	case NoReferrer = 'noreferrer';
	case NoOpener = 'noopener';
	case Prev = 'prev';
	case Search = 'search';
	case Tag = 'tag';
}
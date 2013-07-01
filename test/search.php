<?php

class Search {
	public function to($build) {
		print $build . ' -s' . PHP_EOL;
	}
	public function from($build) {
		foreach ($build->matches as $m) {
			print 'posts sent from account "' . $m->name . '"' . PHP_EOL;
		}
	}
	public function user($build) {
		foreach ($build->matches as $m) {
			print 'posts mentioning account "' . $m->name . '"' . PHP_EOL;
		}
	}
	public function hashtag($build) {
		foreach ($build->matches as $m) {
			print 'posts containing the hashtag "' . $m->name . '"' . PHP_EOL;
		}
	}
}
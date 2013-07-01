<?php

class Glasses {
	protected $rules = array(), $wildcards = array(
		':any' => '[0-9a-zA-Z~%\.:_\\-]+'
	), $method = 'to';
	public function set_method($method = 'to') {
		$this->method = $method;
	}
	public function rule($name, $test, $class) {
		$name = strtolower($name);
		$this->rules[$name] = compact('test', 'class');
	}
	public function parse($str) {
		$str = trim($str);
		$method = $this->method;
		foreach ($this->rules as $r) {
			if (($give = $this->_check($r, $str))) {
				$u = null;
				$class = '';

				if (is_array($r['class'])) { $class = $r['class'][0]; $method = $r['class'][1]; }
				else { $class = $r['class']; }

				if (class_exists($class)) {
					$u = new $class;
					if (method_exists($u, $method)) {
						$u->{$method}($give);
					}
				}
			}
		}
	}
	protected function _check($rule, $str) {
		$search = array();
		$replace = array();
		foreach ($this->wildcards as $s => $r) { $search[] = $s; $replace[] = $r; }
		$build = new stdClass;
		$build->str = $str;
		$build->regex = '/' . str_replace($search, $replace, $rule['test']) . '/';
		$build->matches = array();
		if (preg_match_all($build->regex, $build->str, $matches)) {
			$full = array_shift($matches);
			$small = array_shift($matches);
			foreach ($full as $i => $a) {
				$x = new stdClass;
				$x->name = $small[$i];
				$x->text = $a;
				$build->matches[] = $x;
			}
			return $build;
		}
		return false;
	}
}
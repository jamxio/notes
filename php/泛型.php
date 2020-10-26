<?php

/**
 * 假泛型
 * Class Generics
 */
class Generics extends ArrayObject
{
	protected $baseTypes = [
		'boolean', 'integer', 'float', 'string', 'array', 'NULL', 'resource',
	];
	/** @var string $type */
	protected $type;

	public function __construct($T, $input = array(), $flags = 0, $iterator_class = "ArrayIterator")
	{
		$this->type = $T;
		if (!in_array($T, $this->baseTypes) && !class_exists($T)) {
			throw new Exception('未定义类：' . $T);
		}

		foreach ($input as $index => $value) {
			$this->validateValType($value, $index);
		}
		parent::__construct($input, $flags, $iterator_class);
	}

	public function offsetSet($index, $newval)
	{
		$this->validateValType($newval, $index);
		return parent::offsetSet($index, $newval);
	}

	/**
	 * 验证元素必须符合要求
	 * @param $val
	 * @param $index
	 */
	protected function validateValType($val, $index)
	{
		$type = gettype($val);
		if ($type != $this->type) { //不是当前类型
			if (in_array($type, $this->baseTypes)) {//是基础类型
				throw new InvalidArgumentException('[' . $index . ']元素不符合类型' . $this->type);
			} else {
				$class = get_class($val);
				if ($class != $this->type)
					throw new InvalidArgumentException('[' . $index . ']元素不是' . $this->type . '的对象');
			}
		}
	}
}

$a = new Generics('string', ['3', '4']);
$resource = new Generics('resource', [fopen('scratch.php', 'r+')]);
//$resource->append(3);

$b = new class('boolean') extends Generics {
};
$b['sdf'] = true;

//$b['false'] = 0;

class StringArray extends Generics
{
	public function __construct($input = array(), $flags = 0, $iterator_class = "ArrayIterator")
	{
		parent::__construct('string', $input, $flags, $iterator_class);
	}
}

$a = new StringArray();
$a[] = 3;


print_r(date("Y-m-d TZ"));


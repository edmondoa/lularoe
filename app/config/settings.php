<?php

# app/config/settings.php

class DBconfiguratorObject implements ArrayAccess, Serializable {
	protected $config = array();
	protected $table = null;
	protected $tableName = null;

	private static $_instance = null;

	public static function instance($tableName = 'site_configs'){
		if(self::$_instance === null){
			self::$_instance = new self($tableName);
		}
		return self::$_instance;
	}

	private function __construct($tableName = 'site_configs')
	{
		$this->tableName = $tableName;

		// Query the database and cache it forever
		$this->table = DB::table($tableName)->rememberForever('site_configs');

		// Set the config array like a typical config file is structured
		$this->config = $this->table->lists('value', 'key');
	}

	public function offsetGet($key){
		return $this->config[$key];
	}

	public function offsetSet($key, $value){
		if($this->offsetExists($key)){
			$this->table->where('key', $key)->update(array(
				'value' => $value
			));
		} else {
			$this->table->insert(array(
				'key' => $key,
				'value' => $value
			));
		}
		$this->config[$key] = $value;

		// Clear the database cache
		Cache::forget($this->tableName);
	}

	public function offsetExists($key){
		return isset($this->config[$key]);
	}

	public function offsetUnset($key){
		unset($this->config[$key]);
		$this->table->where('key', $key)->delete();

		// Clear the database cache
		Cache::forget($this->tableName);
	}

	public function serialize(){
		return serialize($this->config);
	}

	public function unserialize($serialized){
		$config = unserialize($serialized);
		foreach($config as $key => $value){
			$this[$key] = $value;
		}
	}

	public function toJson(){
		return json_encode($this->config);
	}
}

return DBconfiguratorObject::instance();
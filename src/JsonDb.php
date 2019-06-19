<?php
/**
 * Created by PhpStorm.
 * User: Andrey Mistulov
 * Company: Aristos
 * Date: 14.03.2017
 * Time: 15:25
 */

namespace Prowebcraft;

/**
 * Class Data
 * @package Aristos
 */
class JsonDb extends \Prowebcraft\Dot
{
    protected $db = '';
    protected $data = null;
    protected $config = [];

    public function __construct($config = [])
    {
        $this->config = array_merge([
            'name' => 'data.json',
            'backup' => 5,
            'dir' => getcwd(),
            'template' => getcwd() . DIRECTORY_SEPARATOR . 'data.template.json'
        ], $config);
        $this->loadData();
        parent::__construct();
    }

    /**
     * Set value or array of values to path
     *
     * @param mixed      $key   Path or array of paths and values
     * @param mixed|null $value Value to set if path is not an array
     * @param bool $save Сохранить данные в базу
     * @return $this
     */
    public function set($key, $value = null, $save = true)
    {
        parent::set($key, $value);
        if ($save) $this->save();
        return $this;
    }

    /**
     * Add value or array of values to path
     *
     * @param mixed $key Path or array of paths and values
     * @param mixed|null $value Value to set if path is not an array
     * @param boolean $pop Helper to pop out last key if value is an array
     * @param bool $save Сохранить данные в базу
     * @return $this
     */
    public function add($key, $value = null, $pop = false, $save = true)
    {
        parent::add($key, $value, $pop);
        if ($save) $this->save();
        return $this;
    }

    /**
     * Delete path or array of paths
     *
     * @param mixed $key Path or array of paths to delete
     * @param bool $save Сохранить данные в базу
     * @return $this
     */
    public function delete($key, $save = true)
    {
        parent::delete($key);
        if ($save) $this->save();
        return $this;
    }

    /**
     * Delete all data, data from path or array of paths and
     * optionally format path if it doesn't exist
     *
     * @param mixed|null $key Path or array of paths to clean
     * @param boolean $format Format option
     * @param bool $save Сохранить данные в базу
     * @return $this
     */
    public function clear($key = null, $format = false, $save = true)
    {
        parent::clear($key, $format);
        if ($save) $this->save();
        return $this;
    }


    /**
     * Загрузка локальной базы данных
     * @param bool $reload
     * Перезагрузить данные?
     * @return array|mixed|null
     */
    protected function loadData($reload = false) {
        if ($this->data === null || $reload) {
            $this->db = $this->config['dir'] . DIRECTORY_SEPARATOR . $this->config['name'];
            if (!file_exists($this->db)) {
                $templateFile = $this->config['template'];
                if (file_exists($templateFile)) {
                    copy($templateFile, $this->db);
                } else {
                    file_put_contents($this->db, '{}');
                }
            } else {
                if ($this->config['backup']) {
                   try {
                       //todo make backup of database
                   } catch (\Exception $e) {

                   }
                }
            }
            $this->data = json_decode(file_get_contents($this->db), true);
            if (!$this->data === null) {
                throw new \InvalidArgumentException('Database file ' . $this->db
                    . ' contains invalid json object. Please validate or remove file');
            }
        }
        return $this->data;
    }

    /**
     * Сохранение в локальную базу
     */
    public function save() {
        file_put_contents($this->db, json_encode($this->data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }


}

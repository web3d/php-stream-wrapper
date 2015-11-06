<?php

require_once dirname(__FILE__) . '/Base.php';

/**
 * 实现基于DB的 stream wrapper
 * wrapper标识为 tcdb
 * 默认只实现了MySQL引擎
 * 
 * @usage
 * 前缀: tcmysqlfs://testuser@localhost/testdb
 * 其他路径格式照旧: 如 /data/page/1/hello_world.txt
 * 
 * $fr = fopen('tcmysqlfs://testuser@localhost/testdb', 'r');
 * $fw = fopen('tcmysqlfs://testuser:testpassword@localhost/testdb', 'w');
 */
class TimeCheer_StreamWrapper_MySQL extends TimeCheer_StreamWrapper_Base {

    /**
     *
     * @var PDO db对象 
     */
    protected $pdo;

    /**
     *
     * @var PDOStatement 
     */
    protected $ps;

    /**
     *
     * @var int 当前记录id
     */
    protected $rowId = 0;
    
    /**
     * path参数中传递过来的db配置部分
     * @var array 
     */
    protected $dbConf = array();
    /**
     * path参数中路径部分
     * @var string 
     */
    protected $dir;
    /**
     * path参数中文件名部分
     * @var string 
     */
    protected $file;
    
    /**
     *
     * @var array 当前文件的元信息
     */
    protected $stat;
    
    protected $dir_mode = 16895 ; //040000 + 0222;
    protected $file_mode = 33279 ; //0100000 + 0777;

    protected $tablePrefix = 'tcmysqlfs_';
    protected $defaultTableDir = 'dir';
    protected $defaultTableFile = 'file';
    
    protected $tableDir;
    protected $tableFile;
    
    
    public function __construct() {
        $this->tableDir = $this->tablePrefix . $this->defaultTableDir;
        $this->tableFile = $this->tablePrefix . $this->defaultTableFile;
    }

    public function dir_closedir() {
        
    }

    public function dir_opendir($path, $options) {
        
    }

    public function dir_readdir() {
        
    }

    public function dir_rewinddir() {
        
    }

    public function mkdir($path, $mode, $options) {
        if (!$this->parsePath($path, false) || !$this->dir) {
            return false;
        }
        $this->initDb();
        
        if ($this->fetchDir($this->dir))
            return false;
        
        $ps = $this->pdo->prepare("INSERT INTO {$this->tableDir}(name, created_time) VALUES(?, ?)");
        $ret = $ps->execute(array($this->dir, time()));
        if (!$ret) {
            return false;
        }
        
        return $this->pdo->lastInsertId();
    }

    /**
     * 未知其使用场景\待测
     * @param type $path_from
     * @param type $path_to
     * @return boolean
     */
    public function rename($path_from, $path_to) {
        if (!$this->parsePath($path_from, false) || !$this->dir) {
            return false;
        }
        $this->initDb();
        
        $row = $this->fetchDir($this->dir);
        if (!$row)
            return false;
        
        $ps = $this->pdo->prepare("UPDATE {$this->tableDir} SET name = ? WHERE id = ?");
        $ret = $ps->execute(array($path_to, $row['id']));
        
        return $ret;
    }

    public function rmdir($path, $options) {
        if (!$this->parsePath($path, false) || !$this->dir) {
            return false;
        }
        $this->initDb();
        
        if (!$row = $this->fetchDir($this->dir) 
                || $this->countFileByDir($row['id'])) {//目录下有文件不能删除
            return false;
        }
        
        $ps = $this->pdo->prepare("DELETE FROM {$this->tableDir} WHERE name = ?");
        
        return $ps->execute(array($this->dir));
    }

    public function stream_cast($cast_as) {
        
    }

    public function stream_close() {
        
    }

    public function stream_eof() {
        $this->ps->execute(array($this->rowId));
        
        return (bool) $this->ps->rowCount();
    }

    public function stream_flush() {
        
    }

    public function stream_lock($operation) {
        
    }

    public function stream_metadata($path, $option, $value) {
        
    }

    /**
     * 
     * Opens file or URL
     * @param string $path
     * @param string $mode
     * @param int $options
     * @param string $opened_path
     */
    public function stream_open($path, $mode, $options, &$opened_path) {
        if (!$this->parsePath($path) || !$this->dir || !$this->file) {
            return false;
        }
        $this->initDb();
        
        $dir_row = $this->fetchDir($this->dir);
        if (!$dir_row)
            return false;
        
        $file_row = $this->fetchFile($this->file, $dir_row['id'], 'id, meta');
        $time = time();

        switch ($mode) {
            case 'w' :
                //如果已经存在,则更新
                if ($file_row) {
                    $this->stat = unserialize($file_row['meta']);
                    if (!$this->stat) {
                        $this->initStatInfo();
                    }
                    $this->stat['ctime'] = $this->stat[10] = time();
                    
                    $sql = "UPDATE {$this->tableFile} SET data = ?, updated_time = {$time}, meta='" . serialize($this->stat) . "' WHERE id={$file_row['id']}";
                    
                } else {
                    $this->initStatInfo();
                    $this->stat['ctime'] = $this->stat[10] = time();
                    
                    $sql = "INSERT INTO {$this->tableFile}(name, data, dir_id, created_time, meta) VALUES('{$this->file}', ?, {$dir_row['id']}, $time, '" . serialize($this->stat) . "')";
                    
                }
                $this->ps = $this->pdo->prepare($sql);
                break;
            case 'r' :
                $this->initStatInfo();
                $this->stat['mode'] = $this->stat[2] = $this->file_mode;
                $this->ps = $this->pdo->prepare("SELECT * FROM {$this->tableFile} WHERE name = '{$this->file}' AND dir_id = {$dir_row['id']} LIMIT 1");
                break;
            case 'a':
                //如果已经存在,则追加 暂不考虑性能问题
                if ($file_row) {
                    $this->stat = unserialize($file_row['meta']);
                    if (!$this->stat) {
                        $this->stat = $this->initStatInfo();
                    }
                    $this->stat['ctime'] = $this->stat[10] = time();
                    
                    $sql = "UPDATE {$this->tableFile} SET data = CONCAT(data,?), updated_time = $time, meta='" . serialize($this->stat) . "' WHERE id={$file_row['id']}";
                } else {
                    $this->initStatInfo();
                    $this->stat['ctime'] = $this->stat[10] = time();
                    
                    $sql = "INSERT INTO {$this->tableFile}(name, data, dir_id, created_time, meta) VALUES('{$this->file}', ?, {$dir_row['id']}, $time '" . serialize($this->stat) . "')";
                }
                $this->ps = $this->pdo->prepare($sql);
                break;
            default : return false;
        }
        
        return true;
    }

    public function stream_read($count) {
        $this->ps->execute();
        if ($this->ps->rowCount() == 0)
            return false;
        
        $this->ps->bindcolumn('id', $this->rowId);
        $this->ps->bindcolumn('data', $ret);
        $this->ps->fetch(PDO::FETCH_ASSOC);
        
        return $ret;
    }

    public function stream_seek($offset, $whence = SEEK_SET) {
        
    }

    public function stream_set_option($option, $arg1, $arg2) {
        
    }

    public function stream_stat() {
        return $this->stat;
    }

    public function stream_tell() {
        return $this->rowId;
    }

    public function stream_truncate($new_size) {
        
    }

    public function stream_write($data) {
        $this->ps->execute(array($data));
        return strlen($data);
    }

    public function unlink($path) {
        
    }

    public function url_stat($path, $flags) {
        if (!$this->parsePath($path) || !$this->dir || !$this->file) {
            return false;
        }
        $this->initDb();
        
        return $this->getFileMeta($this->dir, $this->file);
    }
    
    /**
     * 将外部传人的路径参数解析出来放到dbConf属性中
     * @param string $path tcmysqlfs://testuser@localhost/testdb/data/page/1/hello_world.txt
     * @param bool $with_file 明确指定path中是否包含文件名部分
     */
    protected function parsePath($path, $with_file = true) {
        $this->dbConf = parse_url($path);
        
        $_path = explode('/', trim($this->dbConf['path'], '/'), 2);
        $this->dbConf['path'] = $_path[0];
        
        if (!isset($_path[1]) || !$_path[1]) {
            return false;
        }
        
        $_path[1] = '/' . $_path[1];
        
        if (!$with_file) {
            $this->dir = $_path[1];
            return true;
        }
        
        $this->file = basename($_path[1]);
        $this->dir = dirname($_path[1]);
        
        return true;
    }
    
    /**
     * 初始化db对象
     * @return boolean
     */
    protected function initDb() {
        if ($this->pdo instanceof PDO) {//???是否会限制使用场景
            return true;
        }
        
        try {
            $this->pdo = new PDO("mysql:host={$this->dbConf['host']};dbname={$this->dbConf['path']}", $this->dbConf['user'], isset($this->dbConf['pass']) ? $this->dbConf['pass'] : '', array());
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * 根据目录名从db中取一条dir记录
     * @param string $dir
     * @return array
     */
    protected function fetchDir($dir, $field = '*') {
        $ps = $this->pdo->prepare("SELECT {$field} FROM {$this->tableDir} WHERE name= ? LIMIT 1");
        $ps->execute(array($dir));
        
        return $ps->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * 根据条件从db中取出一条file记录
     * @param string $name
     * @param int $dir_id
     * @param string $field
     */
    protected function fetchFile($name, $dir_id, $field = '*') {
        $ps = $this->pdo->prepare("SELECT {$field} FROM {$this->tableFile} WHERE name= ?  AND dir_id = ? LIMIT 1");
        $ps->execute(array($name, $dir_id));
        
        return $ps->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * 根据目录名和文件名取file
     * @param string $dir
     * @param sting $name
     * @param string $field
     * @return mixed
     */
    public function getFile($dir, $name, $field = '*') {
        $dir_row = $this->fetchDir($dir);
        if (!$dir_row)
            return false;
        
        return $this->fetchFile($name, $dir_row['id'], $field);
    }
    
    /**
     * 统计db中文件夹下文件的数量
     * @param int $dir_id
     * @return int
     */
    protected function countFileByDir($dir_id) {
        $ps = $this->pdo->prepare("SELECT id FROM {$this->tableFile} WHERE dir_id = ? LIMIT 1");
        $ps->execute(array($dir_id));
        
        return $ps->rowCount();
    }

    /**
     * 查询目录/文件元属性信息
     * @param string $dir 目录
     * @param string $fileName 文件名
     */
    protected function getFileMeta($dir, $fileName) {
        if (!$dir || !$fileName) {
            return false;
        }
        
        echo $dir .'/'. $fileName;
        
        $file_row = $this->getFile($dir, $fileName, 'id, meta');
        if (!$file_row) {
            return false;
        }
            
        if (empty($file_row['meta'])) {
            $this->initStatInfo();
        } else {
            return $this->stat = unserialize($file_row['meta']);
        }
    }

    /**
     * 构建初始化目录/文件属性信息
     * @param bool $is_file 区别文件还是目录
     */
    public function initStatInfo($is_file = true) {
        $this->stat['dev'] = $this->stat[0] = 0;
        $this->stat['ino'] = $this->stat[1] = 0;

        if ($is_file)
            $this->stat['mode'] = $this->stat[2] = $this->file_mode;
        else
            $this->stat['mode'] = $this->stat[2] = $this->dir_mode;

        $this->stat['nlink'] = $this->stat[3] = 0;
        $this->stat['uid'] = $this->stat[4] = 0;
        $this->stat['gid'] = $this->stat[5] = 0;
        $this->stat['rdev'] = $this->stat[6] = 0;
        $this->stat['size'] = $this->stat[7] = 0;
        $this->stat['atime'] = $this->stat[8] = 0;
        $this->stat['mtime'] = $this->stat[9] = 0;
        $this->stat['ctime'] = $this->stat[10] = 0;
        $this->stat['blksize'] = $this->stat[11] = 0;
        $this->stat['blocks'] = $this->stat[12] = 0;
    }

}

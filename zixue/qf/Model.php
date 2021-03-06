<?php
$config = [
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PWD'  => 'liuliliuli',
    'DB_NAME' => 'blog',
    'DB_CHARSET' => 'UTF8',
    'DB_PREFIX' => ''
];
$m = new Model($config);
// $a = $m->limit('0,5')->table('user')->order('id desc')->where('id>10')->select();
// var_dump($a);
// var_dump($m->sql);
$data = [
    'username' =>'shabi',
    'password' => md5(123),
    'name' => 'hehanxun'
];
// var_dump($m->insert($data));
var_dump($m->table('user')->where('id=26')->update($data));
class Model{
    //主机名
    protected $host;
    //用户名
    protected $user;
    //密码
    protected $pwd;
    //数据库名
    protected $dbname;
    //字符集
    protected $charset;
    //数据表前缀
    protected $prefix;
    //数据库连接资源
    protected $link;
    //数据表名  这里可以自己指定表名
    protected $tableName;
    //sql语句
    protected $sql;
    //操作数组  存放的就是所有的查询条件
    protected $options;
    //构造方法，对成员变量进行初始化
    public function __construct(array $config)
    {
        //对成员变量一一进行初始化
        $this->host = $config['DB_HOST'] ?  $config['DB_HOST'] : 'localhost';
        $this->user = $config['DB_USER'] ? $config['DB_USER'] : 'root';
        $this->pwd = $config['DB_PWD'] ? $config['DB_PWD'] : '123456';
        $this->dbname = $config['DB_NAME'] ? $config['DB_NAME'] : 'root';
        $this->charset = $config['DB_CHARSET'] ? $config['DB_CHARSET'] : 'utf8';
        $this->prefix = $config['DB_PREFIX'] ? $config['DB_PREFIX'] : '';
        //连接数据库
        $this->link = $this->connect();
        //得到数据表名  user ===》userModel
        $this->tableName = $this->getTableName();

        //初始化options数组
        $this->initOptions();
    }

    protected function getTableName(){
        //第一种，如果设置了成员变量，那么通过成员变量来得到表名
        if(!empty($this->tableName)){
            return $this->prefix . $this->tableName;
        }

        //第二种，如果没有设置成员变量，那么通过雷鸣来得到表名
        //得到类名字符串 例子：UserModel
        $className = get_class($this);
        //如果类名中有Model需要去掉
        if(strstr($className, 'Model') == 'Model'){
            $table = strtolower(substr($className, 0, -5));
        }
        $table = strtolower($className);      
        return $this->prefix . $table;
    }

    //连接数据库
    protected function connect(){
        $link = mysqli_connect($this->host, $this->user, $this->pwd);
        if(!$link){
            die('数据库连接失败');
        }
        mysqli_select_db($link, $this->dbname);
        mysqli_set_charset($link, $this->charset);
        return $link;

    }

    protected function initOptions(){
        $arr = ['where', 'table', 'field', 'order', 'group', 'having', 'limit'];
        foreach($arr as $value){
            //将options数组中这些建对应的值全部清空
            $this->options[$value] = '';
            //将table默认设置为tablename
            if($value == 'table'){
                $this->options[$value] = $this->tableName;
            }
            if($value == 'field'){
                $this->options[$value] = '*';
            }
        }
    }
    //filed方法
    public function field($field){
        //如果不为空在进行处理
        if(!empty($field)){
            if(is_string($field)){
                $this->options['field'] = $field;
            }elseif (is_array($field)) {
                $this->options['field'] = join(',', $field);
            }
        }
        return $this;
    }
    //table方法
    public function table($table){
        if(!empty($table)){
            $this->options['table'] = $table;
        }
        return $this;
    }
    //where方法
    public function where($where){
        if(!empty($where)){
            $this->options['where'] = 'WHERE ' . $where;
        }
        return $this;
    }

    //group方法
    public function group($group){
        if(!empty($group)){
            $this->options['group'] = 'GROUP BY ' . $group;
        }
        return $this;
    }

    //having方法
    public function having($having){
        if(!empty($having)){
            $this->options['having'] = 'HAVING ' . $having;
        }
        return $this;
    }

    //order方法
    public function order($order){
        if(!empty($order)){
            $this->options['order'] = 'ORDER BY ' . $order;
        }
        return $this;
    }

    //limit方法
    public function limit($limit){
        if(!empty($limit)){
            if(is_string($limit)){
                $this->options['limit'] = 'LIMIT ' . $limit;
            }elseif (is_array($limit)) {
                $this->options['limit'] = 'LIMIT ' . join(',', $limit);
            }      
        }
        return $this;
    }

    //select方法
    public function select(){
        //先预写一个带有占位符的sql语句
        $sql = "SELECT %FIELD% FROM %TABLE% %WHERE% %GROUP% %HAVING% %ORDER% %LIMIT%";
        //将options中对应的值依次的替换上面的占位符
        $sql = str_replace(['%FIELD%', '%TABLE%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%'], [$this->options['field'], $this->options['table'], $this->options['where'], $this->options['group'], $this->options['having'], $this->options['order'], $this->options['limit']], $sql);
        //保存一份sql语句
        $this->sql = $sql;
        //执行sql语句
        return $this->query($sql);
    }

    //query方法
    public function query($sql){
        //清空options数组中的值
        $this->initOptions();
        //执行sql语句
        $result = mysqli_query($this->link, $sql);
        //提取结果集存放到数组中
        if($result && mysqli_affected_rows($this->link)){
            while($data = mysqli_fetch_assoc($result)){
                $newData[] = $data;
            }
        }
        return $newData;
    }
    
    //exec方法
    protected function exec($sql, $isInsert = false){
        //清空options数组中的值
        $this->initOptions();
        //执行sql语句
        $result = mysqli_query($this->link, $sql);
        if($result && mysqli_affected_rows($this->link)){
            //判断是否是插入语句
            if($isInsert){
                return mysqli_insert_id($this->link);
            }else{
                return mysqli_affected_rows($this->link);
            }
        }
        return false;
    }

    //获取sql语句
    public function __get($name)
    {
        if($name == 'sql'){
            return $this->sql;
        }
        return false;
    }

    //数据库插入语句
    /**
     * @access: public
     * @Descripttion: 这是一个文件
     * @test: insert into 表名（字段） value （值）
     * @param 参数为一个关联数组 建是字段名，值是字段值
     * @return: 返回值类型
     */
    public function insert(array $data){
        //处理值是字符串问题，两边需要添加单或双引号
        $data = $this->parseValue($data);
        //提取所有的字段
        $keys = array_keys($data);
        $values = array_values($data);
        //正价数据的sql语句
        $sql = "INSERT INTO %TABLE%(%FIELD%) VALUES (%VALUES%)";
        $sql = str_replace(['%TABLE%', '%FIELD%', '%VALUES%'], [$this->options['table'],join(',',$keys),join(',', $values)], $sql);
        $this->sql = $sql;
        return $this->exec($sql, true);
    }

    //传递进来一个数组，将数组中值为字符串的两边加上引号
    protected function parseValue($data){
        foreach($data as $key => $value){
            if(is_string($value)){
                $value = '"' . $value . '"';
            }
            $newData[$key] = $value;
        }
        return $newData;
    }

    //删除函数
    public function delete(){
        //拼接sql语句
        $sql = "DELETE FROM %TABLE% %WHERE%";
        $sql = str_replace(['%TABLE%', '%WHERE%'], [$this->options['table'], $this->options['where']] , $sql);
        //保存sql语句
        $this->sql = $sql;
        //执行sql语句
        return $this->exec($sql);
    }

    //更新函数
    //格式 update 表名  set 字段名=字段值 where id=1
    public function update($data){
        //处理$data数组中值为字段加引号的问题
        $data = $this->parseValue($data);
        //将关联数组凭借为固定的格式 建=值
        $value = $this->parseUpdate($data);
        //准备sql语句
        $sql = "UPDATE %TABLE% SET %VALUE% %WHERE%";
        $sql = str_replace(['%TABLE%', '%VALUE%', '%WHERE%'],[$this->options['table'], $value, $this->options['where']], $sql);
        $this->sql = $sql;
        return $this->exec($sql);
    }

    protected function parseUpdate($data){
        foreach($data as $key => $value){
            $newData[] = $key . '=' . $value;
        }
        return join(',', $newData);
    }

    //max函数
    public function max($field){
        //通过调用 自己的封装的方法进行查询
        $result = $this->fiele('max(' . $field . ') AS max')->select();
        return $result[0]['max'];
    }

    //关闭数据库资源
    public function __destruct()
    {
        mysqli_close($this->link);
    }

    //getBy字段名  字段名=函数参数  用作where条件
    public function __call($name, $arguments)
    {
        //获取前五个字符
        $str = substr($name, 0, 5);
        //获取后面的字段名
        $field = strtolower(substr($name, 5));
        //判断前五个字符是否是getBy
        if($str == 'getBy'){
            return $this->where($field . '="' . $arguments[0] . '"')->select();
        }
        return false;
    }
}
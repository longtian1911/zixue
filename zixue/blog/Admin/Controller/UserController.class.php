<?php
//声明命名空间
namespace Admin\Controller;
use Frame\Libs\BaseController;
use Admin\Model\UserModel;
use Frame\Vendor\Captcha;

final class UserController extends BaseController{
	//显示用户列表
	public function index(){
		//权限验证
		$this->denyAccess();
		//创建模型对象
		$modelObj = UserModel::getInstance();
		//获取多行数据
		$users = $modelObj->fetchAll();

		//向视图复制，并显示视图
		$this->smarty->assign('users',$users);
		$this->smarty->display('index.html');
	}

	//显示添加用户
	public function add(){
		//权限验证
		$this->denyAccess();
		$this->smarty->display('add.html');
	}

	//插入用户
	public function insert(){
		//权限验证
		$this->denyAccess();
		//获取表单数据
		$data['username'] = $_POST['username'];
		$data['password'] = md5(trim($_POST['password']));  
		$data['name'] = $_POST['name'];
		$data['tel'] = $_POST['tel'];
		$data['status'] = $_POST['status'];
		$data['role'] = $_POST['role'];
		$data['addate'] = time();
		//判断用户是否已经存在
		if(UserModel::getInstance()->rowCount("username='{$data['username']}'")){
			$this->jump("用户名:{$data['username']}已经存在，请重新输入","?c=User&a=add");
		}
		//判断两次密码是否一致
		if ($data['password'] != md5(trim($_POST['confirmpwd']))) {
			$this->jump("两次输入的密码不一致！","?c=User&a=add");
		}

		//判断记录是否插入成功
		if (UserModel::getInstance()->insert($data)) {
			$this->jump("用户注册成功","?c=User");
		}else{
			$this->jump("用户注册失败","?c=User");
		}
	}

	//删除记录
	public function delete(){
		//权限验证
		$this->denyAccess();
		//获取地址栏传递的id
		$id = $_GET['id'];
		//判断是否删除成功
		if (UserModel::getInstance()->delete($id)) {
			$this->jump("id={$id}的记录删除成功","?c=User");
		}else{
			$this->jump("id={$id}的记录删除失败","?c=User");
		}
	}

	//修改
	public function edit(){
		//权限验证
		$this->denyAccess();
		//获取地址栏传递过来的id
		$id = $_GET['id'];
		//获取制定id的用户视图
		$user = UserModel::getInstance()->fetchOne("id=$id");
		//向视图赋值
		$this->smarty->assign('user',$user);
		$this->smarty->display('edit.html');
	}

	//更新记录
	public function update(){
		//权限验证
		$this->denyAccess();
		//获取表单数据
		$id = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['tel'] = $_POST['tel'];
		$data['status'] = $_POST['status'];
		$data['role'] = $_POST['role'];
		//判断密码是否为空
		if (!empty($_POST['password']) && !empty($_POST['confirmpwd'])) {
			//判断两次密码是否一致
			if ($_POST['password'] == $_POST['confirmpwd']) {
				$data['password'] = md5(trim($_POST['password']));
			}
		}

		//判断是否更新成功
		if (UserModel::getInstance()->update($data,$id)) {
			$this->jump("用户名为：{$_POST['username']}修改成功",'?c=User');
		}else{
			$this->jump("用户名为：{$_POST['username']}修改失败",'?c=User');
		}
	}

	//后台登录页面
	public function login(){
		$this->smarty->display('login.html');
	}

	//后台登录验证
	public function loginCheck(){
		//获取表单提交至
		$username = $_POST['username'];
		$password = md5(trim($_POST['password']));
		$verify = $_POST['verify'];
		// //判断验证码与服务器保存是否一致
		if(strtolower($verify) != $_SESSION['captcha'])
		{
			$this->jump("验证码不一致！","?c=User&a=login");
		}
	

		//判断用户名与密码与数据库中的是否一致。
		$user = UserModel::getInstance()->fetchOne("username='$username' and password='$password'");
		if (!$user) {
			$this->jump('用户名或密码不正确，请重新登录！','?c=User&a=login');
		}

		//判断用户账号状态
		if (empty($user['status'])) {
			$this->jump('账号被停用请与管理员联系！','?c=User&a=login');
		}

		//更新数据库关于用户登录的数据:last_login_ip last_login_time  login_times
		$data['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['last_login_time'] = time();
		$data['login_times'] = $user['login_times'] + 1;
		if (!UserModel::getInstance()->update($data,$user['id'])) {
			$this->jump('登录失败！','?c=User&a=login');
		}

		//将用户的状态存入SESSION
		$_SESSION['uid'] = $user['id'];
		$_SESSION['username'] = $username;
		//跳转到后台首页
		header("location:./admin.php");
	}

	//显示验证码
	public function captcha(){
		//创建验证码类的对象
		$captcha = new Captcha();
		//将验证码字符串，保存到session中
		$_SESSION['captcha'] = $captcha->getCode();
	}

	//退出登录
	public function logout(){
		//删除SESSION数据
		unset($_SESSION['username']);
		unset($_SESSION['uid']);
		//删除SESSION文件
		session_destroy();
		//设置当前SESSIONID对应的COOKIE数据为过期时间
		setcookie(session_name(),false);
		//跳转到后台登录页面
		header("location:admin.php?c=User&a=login");
	}
}




















# ThinkPHP5 学习笔记

## 一、模型

### 新增数据--单条数据

1. 通过实例化模型对象的方式新增数据；在model层里新建一个类文件，如:User.php，引入命令空间；使用时只需在controller层实例化即可。

```php
<?php
namespace app\admin\controller;
use app\admin\model\User as UserModel;

class User {
	public function add(){
		$user = new UserModel;
		$user->name='张三';
		$user->age=19;
		$user->create_time=date('Y-m-d H:i:s');
		$user->save();
	}
}
```

2. 通过数组的方式新增数据；同样在model层新建一个User.php类文件，在controller层，通过如一方式新增数据：

```php
<?php
namespace app\admin\controller;
use app\admin\model\User as UserModel;
class User {
	public function add(){
		$user['name']='张三';
		$user['age']=18;
		$user['create_time']=date('Y-m-d H:i:s');
		UserModel::create($user);
	}
}
```

### 新增数据--批量

通过先准备好新增的数据（一个数组，多条数据），实例化模型，再调用saveAll()方法；

```php
namespace app\admin\controller;
use app\admin\model\User as UserModel;
class User {
	public function add(){
		$user = new User;
		$list=[
			['id'=>1,'name'=>'张三','age'=>18,'create_time'=>date('Y-m-d H:i:s')],
			['id'=>2,'name'=>'李四','age'=>18,'create_time'=>date('Y-m-d H:i:s')],
		];
		$user->saveAll($list);
	}
}
```


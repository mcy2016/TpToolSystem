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

### 数据查询--单条查询

通过调用模型的静态方法get(),getByName()来进行单条数据查询，

1. get()

```php
	namespace app\admin\controller;
	use app\admin\model\User as UserModel;
	class User {
		public function read() {
			$user = UserModel::get($id);//$id为主键,返回一个对象
			echo $user->id.'<br />';
			echo $user->name.'<br />';
			echo $user->age.'<br />';
		}
	}
```

2. getBy...();

```php
	namespace app\admin\controller;
	use app\admin\model\User as UserModel;
	class User {
		public fucntion read() {
			$user = UserModel::getByName($name);//通过传入的值进行相应的数据库字段查询
			if($user !=null){
				echo $user->id.'<br />';
				echo $user->name.'<br />';
				echo $user->age.'<br />';
			}else {
				echo 'no data ';
			}
		}
	}
```

> 还可以通过get(['name' => '张三','age'=>18])传入数组这样的形式进行查询

3. 通过where 子句进行查询，只需换成这句：$user = UserModel::where('age','>',3)->find(); 通过find()同样也是一条数据，如果把find()换成select()后查询出来的是一个二维数组，可以通过dump()方法把数据打印出来。

### 数据查询--多条查询

1. 查询所有的数据

```php
	public function read () {
		$list = UserModel::all();//查询所有的数据
		//通过foreach(){} 把查出来的每条数据打印出来
		foreach ($list as $user) {
			echo $user -> id.'<br />';
			echo $user -> name.'<br />';
			echo $user -> age.'<br />';
			echo $user -> sex.'<br />';
			echo '--------------------';
		}
	}
```
2. 查询带条件的数据，把男性的所有人信息查询出来

```php
	public function read () {
		$list = UserModel::all(['sex'=>'男']);//查询所有的数据
		//通过foreach(){} 把查出来的每条数据打印出来
		foreach ($list as $user) {
			echo $user -> id.'<br />';
			echo $user -> name.'<br />';
			echo $user -> age.'<br />';
			echo $user -> sex.'<br />';
			echo '--------------------';
		}
	}
```

3. 使用where子句，可加入更多的限制条件

```php
	public function read () {
		$list = UserModel::where('age','>',10)->select();//查询所有的数据
		//通过foreach(){} 把查出来的每条数据打印出来
		foreach ($list as $user) {
			echo $user -> id.'<br />';
			echo $user -> name.'<br />';
			echo $user -> age.'<br />';
			echo $user -> sex.'<br />';
			echo '--------------------';
		}
	}
```

### 数据的更新
> 1.通过先把要更新的数据查询出来，再对数据里的每个字段进行赋值，然后使用$user->save()方法对数据进行更新操作，1取，2赋，3存；

```php
public function update($id) {
	$user = UserModel::get($id);//$id为主键,返回一个对象
	$user->name='李四';
	$user->age=18;
	$result =$user->isUpdate(true)->save();//调用方法isUpdate(true)时，传入ture时调用save()方法，表示更新，传入false时，表示新增
	if($result){}else{

	}
}
```

> 2.也可以调用模型的静态方法：UseModel::update($user)进行更新操作，$user是一数组：$user['id']=(int)$id,数组的键是数据库字段；
```php
	public function update($id) {
		//先定义一个变量数组
		$user['id'] = (int)$id;//$id数据库中已存在的id值
		$user['name']='李四';
		$user['age']=18;
		$result =UserModel::update($user);
		if($result){

		}else{

	}
}
```

### 数据的删除
> 1.首先要拿到要删除的数据对象（以上讲的查询方法拿到数据对象），再调用模型的静态方法delete()或者直接使用UserModel::destroy($id); 会有一个返回值

### 读取器 

> 使用get+属性名的驼峰命名+Attr这样的方式,是在Model层使用，属性名对应数据库字段，是指查询出数据后在呈现给用户前做的一些格式上的转换，然后返回

```php
	<?php
	namespace app\admin\model;
	use think\Model;
	class User extends Model(){
		//create_time读取器
		protected fucntion getCreateTimeAttr($cerateTime) {
			return date('Y-m-d',$cerateTime)
		}
	}
```

### 修改器

> 使用set+属性名的驼峰命名+Attr,是指接收到一个数据后，通过修改器转换成数据库能接收的数据类型返回

```php
	class User extends Model
	{
		//$value 是一个字符串，通过create_time修改器后转换成一个时间戳
		protected function setCreateTimeAttr($valu){
			return strtotime($value);
		}		
	}
```

> *读取器与修改器的作用：*都是处于模型与数据库间的过滤系统，只针对于数据格式进行处理和转换，不涉及相关业务逻辑，这两者往往并行使用
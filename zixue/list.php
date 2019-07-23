<?php
	//包含数据库的公共文件
	require_once('./conn.php');
	//获取多行数据
	$sql = "SELECT * FROM user ORDER BY id DESC";
	$arrs = $db->fetchAll($sql); 
	//获取记录数
	$records = $db->rowCount($sql);
?>
<!DOCTYPE html>
<html>
<head>
	<title>学生信息管理中心</title>
	<meta charset="utf-8" />
</head>
<body>
	<div style="text-align: center;padding-bottom: 10px;">
		<h2>学生信息管理中心</h2>
		<a href="#">添加学生</a>
		共有<font color="red"><?php echo $records; ?></font>个学生
	</div>
	<table width="500" border="1" bordercolor='#ccc' rules="all" cellpadding="5" align="center">
		<tr bgcolor="#f0f0f0">
			<th>编号</th>
			<th>姓名</th>
			<th>性别</th>
			<th>年龄</th>
			<th>学历</th>
			<th>工资</th>
			<th>奖金</th>
			<th>籍贯</th>
			<th>操作选项</th>
		</tr>
		<?php 
			//循环二位数组
			foreach ($arrs as $arr) {
		?>
		<tr align="center">
			<td><?php echo $arr['id']; ?></td>
			<td><?php echo $arr['id']; ?></td>
			<td><?php echo $arr['id']; ?></td>
			<td><?php echo $arr['id']; ?></td>
			<td><?php echo $arr['id']; ?></td>
			<td><?php echo $arr['id']; ?></td>
			<td><?php echo $arr['id']; ?></td>
			<td><?php echo $arr['id']; ?></td>
			<td>
				<a href="./edit.php">修改</a>
				<a href="javascript:void(0)">删除</a>
			</td>
		</tr>
		<?php } ?>
	</table>
</body>
</html>
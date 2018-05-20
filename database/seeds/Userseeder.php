<?php

use Illuminate\Database\Seeder;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $owner = new \App\Role();
        $owner->name = 'owner';
        $owner->display_name = '超级管理员';
        $owner->description = '管理一切';
        $owner->save();

        $admin = new \App\Role();
        $admin->name = 'admin';
        $admin->display_name = '管理员';
        $admin->description = '管理大部分';
        $admin->save();

        $teacher = new \App\Role();
        $teacher->name = 'teacher';
        $teacher->display_name = '老师';
        $teacher->description = '管理下级学生';
        $teacher->save();

        $student = new \App\Role();
        $student->name = 'student';
        $student->display_name = '学生';
        $student->description = '普通用户';
        $student->save();


//        设定权限
        $createhome = new \App\Permission();
        $createhome->name = 'create-homework';
        $createhome->display_name = '创建作业';
        $createhome->description = '当然包括四大基本权限';
        $createhome->save();

        $editUser = new \App\Permission();
        $editUser->name = 'edit-user';
        $editUser->display_name = '管理学生';
        $editUser->description = '管理学生';
        $editUser->save();

        $managerUser = new \App\Permission();
        $managerUser->name = 'manager-user';
        $managerUser->display_name = '管理用户';
        $managerUser->description = '当然包括四大基本权限';
        $managerUser->save();

        $default = new \App\Permission();
        $default->name = 'default-user';
        $default->display_name = '基本权限';
        $default->description = '查看作业，申请休假，等等';
        $default->save();

        $owner->attachPermission($createhome,$default,$managerUser,$editUser);
//等价于 $owner->perms()->sync(array($createPost->id));

        $admin->attachPermissions(array($createhome, $editUser,$default,$managerUser));

        $teacher->attachPermission(array($editUser,$createhome,$default));

        $student->attachPermission(array($default));



    }
}

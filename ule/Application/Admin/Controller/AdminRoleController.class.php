<?php
namespace Admin\Controller;
use Think\Controller;

class AdminRoleController extends CommonController {
    /**
     * 权限列表
     */
    public function index(){
        $data=D('AuthRule')->getTreeData('tree','id','title');

        $assign=array(
            'data'=>$data
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加权限
     */
    public function add(){
        $id=I('get.id',0);
        if (IS_AJAX) {
            $data = I('post.');
            unset($data['id']);
            $result = D('AuthRule')->addData($data);
            if ($result) {
                $data['state']=1;
                $data['message']="添加成功！";
                $this->ajaxReturn($data);
            } else {
                $data['state']=0;
                $data['message']="添加失败！";
                $this->ajaxReturn($data);
            }
        }
        $this->assign('pid',$id);
        $this->display();
    }

    /**
     * 修改权限
     */
    public function edit(){
        $id=I('get.id',0);
        if (IS_AJAX) {
            $data = I('post.');
            $map = array(
                'id' => $data['id']
            );
            $result = D('AuthRule')->editData($map, $data);
            if ($result) {
                $data['state']=1;
                $data['message']="修改成功！";
                $this->ajaxReturn($data);
            } else {
                $data['state']=0;
                $data['message']="修改失败！";
                $this->ajaxReturn($data);
            }
        }
        $role_data = D('AuthRule')->where(array('id'=>$id))->find();
        $this->assign('role_data',$role_data);
        $this->display();
    }

    /**
     * 删除权限
     */
    public function delete(){
        $id=I('get.id');
        $map=array(
            'id'=>$id
        );
        $result=D('AuthRule')->deleteData($map);
        if($result){
            $this->success('删除成功',U('AdminRole/index'));
        }else{
            $this->error('请先删除子权限');
        }

    }
//*******************用户组**********************
    /**
     * 用户组列表
     */
    public function group(){
        $data=D('AuthGroup')->select();
        $assign=array(
            'data'=>$data
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加用户组
     */
    public function add_group(){
        if (IS_AJAX) {
            $data = I('post.');
            unset($data['id']);
            $result = D('AuthGroup')->addData($data);
            if ($result) {
                $data['state']=1;
                $data['message']="添加成功！";
                $this->ajaxReturn($data);
            } else {
                $data['state']=0;
                $data['message']="添加失败！";
                $this->ajaxReturn($data);
            }
        }
        $this->display();
    }

    /**
     * 修改用户组
     */
    public function edit_group(){
        if (IS_AJAX) {
            $data = I('post.');
            $map = array(
                'id' => $data['id']
            );
            $result = D('AuthGroup')->editData($map, $data);
            if ($result) {
                $data['state']=1;
                $data['message']="修改成功！";
                $this->ajaxReturn($data);
            } else {
                $data['state']=0;
                $data['message']="修改失败！";
                $this->ajaxReturn($data);
            }
        }
        $id=I('get.id');
        $group_data = D('AuthGroup')->where(array('id'=>$id))->find();
        $this->assign('group_data',$group_data);
        $this->display();
    }

    /**
     * 删除用户组
     */
    public function delete_group(){
        $id=I('get.id');
        $map=array(
            'id'=>$id
        );
        $result=D('AuthGroup')->deleteData($map);
        if ($result) {
            $this->success('删除成功',U('AdminRole/group'));
        }else{
            $this->error('删除失败');
        }
    }

//*****************权限-用户组*****************
    /**
     * 分配权限
     */
    public function rule_group(){
        if(IS_POST){
            $data=I('post.');
            $map=array(
                'id'=>$data['id']
            );
            $data['rules']=implode(',', $data['rule_ids']);
            $result=D('AuthGroup')->editData($map,$data);
            if ($result) {
                $this->success('操作成功',U('AdminRole/group'));
            }else{
                $this->error('操作失败');
            }
        }else{
            $id=I('get.id');
            // 获取用户组数据
            $group_data=M('Auth_group')->where(array('id'=>$id))->find();
            $group_data['rules']=explode(',', $group_data['rules']);
            // 获取规则数据
            $rule_data=D('AuthRule')->getTreeData('level','id','title');
            $assign=array(
                'group_data'=>$group_data,
                'rule_data'=>$rule_data
            );
            $this->assign($assign);
            $this->display();
        }

    }
//******************用户-用户组*******************
    /**
     * 添加成员
     */
    public function check_user(){
        $username=I('get.username','');
        $group_id=I('get.group_id');
        $group_name=M('Auth_group')->getFieldById($group_id,'title');
        $uids=D('AuthGroupAccess')->getUidsByGroupId($group_id);
        // 判断用户名是否为空
        if(empty($username)){
            $user_data='';
        }else{
            $user_data=M('Users')->where(array('username'=>$username))->select();
        }
        $assign=array(
            'group_name'=>$group_name,
            'uids'=>$uids,
            'user_data'=>$user_data,
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加用户到用户组
     */
    public function add_user_to_group(){
        $data=I('get.');
        $map=array(
            'uid'=>$data['uid'],
            'group_id'=>$data['group_id']
        );
        $count=M('AuthGroupAccess')->where($map)->count();
        if($count==0){
            D('AuthGroupAccess')->addData($data);
        }
        $this->success('操作成功',U('AdminRole/check_user',array('group_id'=>$data['group_id'],'username'=>$data['username'])));
    }

    /**
     * 将用户移除用户组
     */
    public function delete_user_from_group(){
        $map=I('get.');
        $result=D('AuthGroupAccess')->deleteData($map);
        if ($result) {
            $this->success('操作成功',U('AdminRole/admin_user_list'));
        }else{
            $this->error('操作失败');
        }
    }
}
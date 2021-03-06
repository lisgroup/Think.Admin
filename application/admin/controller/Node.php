<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\Node as NodeModel;
use controller\BasicAdmin;
use library\Data;
use library\Tools;

/**
 * 系统功能节点管理
 * Class Node
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:13
 */
class Node extends BasicAdmin {

    /**
     * 指定当前默认模型
     * @var string
     */
    protected $table = 'SystemNode';

    /**
     * 显示节点列表
     */
    public function index() {
        $alert = [
            'type'    => 'danger',
            'title'   => '安全警告',
            'content' => '结构为系统自动生成，状态数据请勿随意修改！'
        ];
        $this->assign('alert', $alert);
        $this->assign('title', '系统节点管理');
        $this->assign('nodes', Tools::arr2table(NodeModel::get(), 'node', 'pnode'));
        return view();
    }

    /**
     * 保存节点变更
     */
    public function save() {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (isset($post['name']) && isset($post['value'])) {
                $nameattr = explode('.', $post['name']);
                $field = array_shift($nameattr);
                $data = ['node' => join(',', $nameattr), $field => $post['value']];
                Data::save($this->table, $data, 'node');
                $this->success('参数保存成功！', '');
            }
        } else {
            $this->error('访问异常，请重新进入...');
        }
    }

}

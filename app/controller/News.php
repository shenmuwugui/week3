<?php

namespace app\controller;

use app\model\News as NewsModel;
use app\validate\NewsValidate;
use think\exception\ValidateException;
use think\facade\Cache;
use think\facade\Log;

class News extends Base
{
    /**
    * 获取列表
    */
    public function getList()
    {
        if (request()->isPost()) {

            $limit  = input('post.limit');
            $where = [];

            $NewsModel = new NewsModel();
            $list = $NewsModel->getNewsList($where, $limit);

            return json(pageReturn($list));
        }
    }

    /**
    * 添加
    */
    public function add()
    {
        if (request()->isPost()) {
            $param  = input('post.');

            // 检验完整性
            try {
                validate(NewsValidate::class)->check($param);
            } catch (ValidateException $e) {
                return jsonReturn(-1, $e->getError());
            }

            $NewsModel = new NewsModel();
            $res = $NewsModel->addNews($param);

            return json($res);
        }
    }

    /**
    * 查询信息
    */
    public function read()
    {
        $id = input('param.id');
        $uis = $id;
        Cache::inc('clickNum'.$id);
        $clickNum = Cache::get('click_num',$id);
        $NewsModel = new NewsModel();
        $info = $NewsModel->getNewsById($id);
        $info['data']['clickNum'] = $clickNum;
        Log::info(json_encode([
            'id'=>$uis,
            'staus'=>'read',
            'pageid'=>$id
        ]));
        return json($info);
    }

    /**
    * 编辑
    */
    public function edit()
    {
         if (request()->isPost()) {

            $param = input('post.');

            // 检验完整性
            try {
                validate(NewsValidate::class)->check($param);
            } catch (ValidateException $e) {
                return jsonReturn(-1, $e->getError());
            }

            $NewsModel = new NewsModel();
            $res = $NewsModel->editNews($param);

            return json($res);
         }
    }

    /**
    * 删除
    */
    public function del()
    {
        $id = input('param.id');

        $NewsModel = new NewsModel();
        $info = $NewsModel->delNewsById($id);

        return json($info);
   }
}

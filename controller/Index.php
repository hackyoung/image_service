<?php
namespace Controller;

class Index extends \Leno\Controller
{
    /**
     * @description 获取图片
     * @param uuid id 图片的ID
     * @param int _GET['w'] 需要的图片宽度
     * @param int _GET['h'] 需要的图片高度
     * @return image
     */
    public function index($id)
    {
        try {
            (new \Leno\Validator(['type' => 'uuid'], 'image_id'))->check($id);
        } catch(\Exception $e) {
            throw new \Leno\Http\Exception(400, $e->getMessage());
        }
        $opt = $this->inputs([
            'w' => ['type' => 'int', 'required' => false, 'extra' => ['min' => 0]],
            'h' => ['type' => 'int', 'required' => false, 'extra' => ['min' => 0]],
        ]);
        $image = \Model\Entity\Image::findOrFail($id);
        return $this->response->withHeader(
            'Content-Type', $image->getType()
        )->write($image->resize($opt['w'], $opt['h']));
    }

    /**
     * @description 上传图片
     * @param uuid _POST['app_id'] 上传图片的应用ID
     * @param files _FILES 上传的文件
     * @param uuid id 可以访问该图片的ID
     */
    public function add()
    {
        $appid = $this->input('app_id', ['type' => 'uuid']);
        try {
            $app = $this->getService('user.app.verify')
                ->setAppId($appid)
                ->execute();
        } catch(\Exception $e) {
            throw new \Leno\Http\Exception(405);
        }
        try {
            foreach($_FILES as $file) {
                $id = (new \Model\Entity\Image)->addNew($appid, $file);
            }
        } catch(\Exception $ex) {
            echo $ex->getMessage();
        }
        return $this->response
            ->withHeader('Access-Control-Allow-Origin', $app['url'])  
            ->withHeader('Access-Control-Allow-Methods', 'POST')
            ->withHeader('Access-Control-Allow-Headers', 'x-requested-with,content-type')
            ->write($id);
    }
}

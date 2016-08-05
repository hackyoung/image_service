<?php
namespace Controller;

use Leno\Type\Mysql\UuidType;

class IndexController extends \Leno\Controller
{

    public function initialize()
    {
        logger()->err('here');
    }

    /**
     * @description 获取图片
     *
     * @param uuid id 图片的ID
     * @param int _GET['w'] 需要的图片宽度
     * @param int _GET['h'] 需要的图片高度
     *
     * @return image
     */
    public function index($id)
    {
        try {
            (new UuidType)->check($id);
        } catch(\Exception $e) {
            throw new \Leno\Http\Exception(400, $e->getMessage());
        }
        $rule = ['type' => 'int', 'required' => false, 'extra' => [
            'min' => 0
        ]];
        $width = $this->input('w', $rule);
        $height = $this->input('h', $rule);
        $image = \Model\Entity\Image::findOrFail($id);
        return $this->response->withHeader(
            'Content-Type', $image->getType()
        )->write($image->resize($width, $height));
    }

    /**
     * @description 上传图片
     *
     * @param uuid _POST['app_id'] 上传图片的应用ID
     * @param files _FILES 上传的文件
     *
     * @return uuid id 可以访问该图片的ID
     */
    public function add()
    {
        try {
            foreach($_FILES as $file) {
                $image = (new \Model\Entity\Image)->getFromFile($file);
            }
        } catch(\Exception $ex) {
            return $this->response->withHeader('Access-Control-Allow-Origin', '*')  
                ->withStatus(500)
                ->withHeader('Access-Control-Allow-Methods', 'POST')
                ->withHeader('Access-Control-Allow-Headers', 'x-requested-with,content-type')
                ->write($ex->getMessage());
        }
        return $this->response->withHeader('Access-Control-Allow-Origin', '*')  
            ->withHeader('Access-Control-Allow-Methods', 'POST')
            ->withHeader('Access-Control-Allow-Headers', 'x-requested-with,content-type')
            ->write(json_encode($image));
    }
}

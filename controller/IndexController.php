<?php
namespace Controller;

use Leno\Type\Mysql\UuidType;
use Model\Entity\Image;
use Leno\Http\Exception as HttpException;
use Leno\Database\Row\Selector as RowSelector;

class IndexController extends \Leno\Controller
{
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
            throw new HttpException(404);
        }
        $rule = ['type' => 'int', 'required' => false, 'extra' => [
            'min' => 0
        ]];
        $width = $this->input('w', $rule);
        $height = $this->input('h', $rule);
        try {
            $image = \Model\Entity\Image::findOrFail($id);
        } catch (\Leno\Exception $ex) {
            throw new HttpException(404);
        }
        return $this->response->withHeader( 'Content-Type', $image->getType())
            ->write($image->resize($width, $height));
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
        $response = $this->response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST')
            ->withHeader('Access-Control-Allow-Headers', 'x-requested-with,content-type');
        $images = [];
        RowSelector::beginTransaction();
        try {
            foreach($_FILES as $file) {
                $images[] = Image::getFromFile($file)->save();
            }
            RowSelector::commitTransaction();
        } catch(\Exception $ex) {
            RowSelector::rollback();
            return $response->withStatus(500)->write($ex->getMessage());
        }
        return $response->write(json_encode(count($images) == 1 ? $images[0] : $images));
    }
}

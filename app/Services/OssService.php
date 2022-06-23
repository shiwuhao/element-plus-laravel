<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class OssService
 * @package App\Services
 */
class OssService
{
    /**
     * @var mixed
     */
    protected $accessId;
    /**
     * @var mixed
     */
    protected $accessKey;
    /**
     * @var string
     */
    protected $host;


    /**
     * OssService constructor.
     */
    public function __construct()
    {
        $config = config('filesystems.disks.oss');
        $this->accessId = $config['access_id'];
        $this->accessKey = $config['access_key'];
        $this->host = 'https://' . $config['cdnDomain'];
        $this->host = 'https://run-hub.oss-cn-beijing.aliyuncs.com';
    }

    /**
     * @param $dir
     * @param $callBackUrl
     * @return array
     */
    public function getSign($dir, $callBackUrl = '')
    {
        $callbackParam = [
            'callbackUrl' => $callBackUrl,
            'callbackBody' => 'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}',
            'callbackBodyType' => "application/x-www-form-urlencoded"
        ];
        $callbackString = json_encode($callbackParam);

        $base64CallbackBody = base64_encode($callbackString);
        $endCarbon = Carbon::now()->addSeconds(300);
        $expiration = $endCarbon->toIso8601ZuluString();// 设置该policy超时时间是30s

        //最大文件大小.用户可以自己设置
        $condition = [0 => 'content-length-range', 1 => 0, 2 => 1048576000];
        // 表示用户上传的数据，必须是以$dir开始，不然上传会失败，这一步不是必须项，只是为了安全起见，防止用户通过policy上传到别人的目录。
        $start = [0 => 'starts-with', 1 => '$key', 2 => $dir];

        $conditions = [$condition, $start];
        $arr = [
            'expiration' => $expiration,
            'conditions' => $conditions
        ];
        $policy = json_encode($arr);
        $base64Policy = base64_encode($policy);
        $stringToSign = $base64Policy;
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, $this->accessKey, true));

        return [
            'accessid' => $this->accessId,
            'host' => $this->host,
            'policy' => $base64Policy,
            'signature' => $signature,
            'expire' => $endCarbon->timestamp,
            'callback' => $base64CallbackBody,
            'dir' => $dir,
        ];
    }

    /**
     * 获取回调响应信息
     * @param Request $request
     * @return array
     */
    public function getCallback(Request $request)
    {
        return array_merge($request->all(), [
            'url' => $this->host . '/' . $request->get('filename')
        ]);
    }
}

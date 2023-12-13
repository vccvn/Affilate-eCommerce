<?php

namespace App\Services\Styles;

use App\Repositories\Files\FileRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Services\Service;

use Illuminate\Http\Request;
use Gomee\Helpers\Arr;

/**
 * @property MetadataRepository $metadataRepository
 */
class StyleConfigService extends Service
{

    protected $defaultData = [
        'name' => '',

        'width' => 340,
        'height' => 500

    ];

    /**
     * Create a new Service instance.
     *
     * @return void
     */
    public function __construct(MetadataRepository $metadataRepository)
    {
        $this->metadataRepository = $metadataRepository;
        $this->init();
    }

    public function getData()
    {
        if ($config = $this->metadataRepository->getJson('style_set_config')) {
            if (array_key_exists('avatar_id', $config) && $config['avatar_id'] && $file = app(FileRepository::class)->mode('mask')->detail(['id' => $config['avatar_id']])) {
                $config['avatar_url'] = $file->url;
            } else {
                $config['avatar_id'] = 0;
                $config['avatar_url'] = asset('static/images/default.png');
            }
        } else {
            $config = $this->defaultData;
            $config['avatar_id'] = 0;
            $config['avatar_url'] = asset('static/images/default.png');
        }
        return $config;
    }

    public function saveData($data)
    {
        $p = array_merge($this->defaultData, $data);
        return $this->metadataRepository->saveJson('style_set_config', $p);
    }
}

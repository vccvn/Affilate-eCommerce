<?php

namespace App\Http\Controllers\Clients;

# use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Gomee\Helpers\Arr;

use App\Repositories\Products\CollectionRepository;

class ProductCollectionController extends ClientController
{
    protected $module = 'collections';

    protected $moduleName = 'Bộ sưu tập';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var CollectionRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CollectionRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    public function getCollections(Request $request)
    {
        # code...
    }

}

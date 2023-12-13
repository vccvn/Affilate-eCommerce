<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\Ecommerce\ProductController;
use App\Http\Controllers\Admin\General\DashboardController;
use App\Masks\Products\CategoryCollection;
use App\Models\Category;
use Illuminate\Console\Command;

class TestSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test Hệ thống';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Test:...");
        try {
            $result = arr_combine_list([
                [1, 2, 3],
                [4, 5, 6],
                [7, 8]
            ]);
            print_r($result);
            // $c = app(ProductController::class);
            // dd($c->getList(request())->render());
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
        return 0;
    }
}

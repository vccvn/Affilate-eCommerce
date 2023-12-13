<?php

namespace App\Providers;

use App\Repositories\Permissions\ModuleRepository;
use Gomee\Html\Input;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @param Input $input
         */
        Input::addTemplate('checktree', ['checkbox', 'checktree'], function($input){
            // do st 
            // $input->optio

        });

        Input::addTemplate('module-table', ['checklist', 'checkbox', 'moduletable', 'module-table'], function(Input $input){
            $input->addClass('module-table permision-matrix');
            $input->hiddenData('modules', app(ModuleRepository::class)->getModuleMatrix());
            $input->hidden('__id__', $input->getParamFromString("#hidden_id"));
        });

        Input::addTemplate('coloris', ['coloris', 'color', 'text'], function(Input $input){
            // $input->addClass('coloris');
            $input->addClass('coloris');

        });
        add_js_data('coloris_swatches', [
            '#264653',
            '#2a9d8f',
            '#e9c46a',
            '#f4a261',
            '#e76f51',
            '#d62828',
            '#023e8a',
            '#0077b6',
            '#0096c7',
            '#00b4d8',
            '#48cae4'
        ]);

        Input::addTemplate('style-item-preview-config', ['style-item-preview-config', 'array'], function(Input $input){
            //
            // $input->addClass('preview-config');
        });


        

        Input::addTemplate('post-config', ['post-config', 'textarea'], function(Input $input){
            $input->addClass('post-config-wrapper');
        });


        

        // Input::addTemplate('specification', ['specification', 'textarea'], function(Input $input){
        //     $input->addClass('specification');
        // });
        // specification

    }
}

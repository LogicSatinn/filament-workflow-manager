<?php

namespace Heloufir\FilamentWorkflowManager;

use Heloufir\FilamentWorkflowManager\Http\Livewire\WorkflowManagerAdd;
use Heloufir\FilamentWorkflowManager\Http\Livewire\WorkflowManagerAddStatus;
use Heloufir\FilamentWorkflowManager\Http\Livewire\WorkflowManagerDelete;
use Heloufir\FilamentWorkflowManager\Http\Livewire\WorkflowManagerEdit;
use Filament\PluginServiceProvider;
use Heloufir\FilamentWorkflowManager\Resources\UserResource\WorkflowPermissions;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Livewire\Livewire;

class FilamentWorkflowManagerServiceProvider extends PackageServiceProvider
{

    public function configurePackage(Package $package): void
    {
        // Package name
        $package->name('filament-workflow-manager');

        // Config file
        $package->hasConfigFile('filament-workflow-manager');

        // Migrations
        $package->hasMigrations([
            '2022_07_01_120846_create_workflow_statuses_table',
            '2022_07_01_120850_create_workflows_table',
            '2022_07_01_120853_create_workflow_models_table',
            '2022_07_01_214028_create_workflow_model_statuses_table',
            '2022_07_05_105319_create_workflow_histories_table',
            '2022_07_07_084149_add_is_end_to_workflow_status',
            '2022_07_07_101352_create_workflow_permissions_table',
            '2022_07_07_101358_create_workflow_user_permissions_table',
        ]);
        $package->runsMigrations();

        // Translations
        $package->hasTranslations();

        // Views
        $package->hasViews();

        // Helpers file
        if (file_exists($file = __DIR__ . '/../src/helpers.php')) {
            require $file;
        }
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        foreach ([
                     WorkflowManagerAdd::class,
                     WorkflowManagerEdit::class,
                     WorkflowManagerDelete::class,
                     WorkflowManagerAddStatus::class,
                     WorkflowPermissions::class
                 ] as $component) {
            Livewire::component($component::getName(), $component);
        }
    }

    protected function getResources(): array
    {
        return config('filament-workflow-manager.resources');
    }

    protected function getPages(): array
    {
        return config('filament-workflow-manager.pages');
    }

    protected function getStyles(): array
    {
        return array_merge([
            __DIR__ . '/../dist/app.css'
        ], config('filament-workflow-manager.styles'));
    }

}

<?php

namespace App\Providers\Filament;

use App\Filament\Commands\FileGenerators\ClusterClassGenerator;
use App\Filament\Commands\FileGenerators\Resources\Pages\ResourceCreateRecordPageClassGenerator;
use App\Filament\Commands\FileGenerators\Resources\Pages\ResourceEditRecordPageClassGenerator;
use App\Filament\Commands\FileGenerators\Resources\Pages\ResourceListRecordsPageClassGenerator;
use App\Filament\Commands\FileGenerators\Resources\Pages\ResourceViewRecordPageClassGenerator;
use App\Filament\Commands\FileGenerators\Resources\ResourceClassGenerator;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\RequestPasswordReset;
use App\Filament\Pages\Dashboard;
use App\Filament\Tables\Columns\UserstampColumn;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Commands\FileGenerators\ClusterClassGenerator as FilamentClusterClassGenerator;
use Filament\Commands\FileGenerators\Resources\Pages\ResourceCreateRecordPageClassGenerator as FilamentResourceCreateRecordPageClassGenerator;
use Filament\Commands\FileGenerators\Resources\Pages\ResourceEditRecordPageClassGenerator as FilamentResourceEditRecordPageClassGenerator;
use Filament\Commands\FileGenerators\Resources\Pages\ResourceListRecordsPageClassGenerator as FilamentResourceListRecordsPageClassGenerator;
use Filament\Commands\FileGenerators\Resources\Pages\ResourceViewRecordPageClassGenerator as FilamentResourceViewRecordPageClassGenerator;
use Filament\Commands\FileGenerators\Resources\ResourceClassGenerator as FilamentResourceClassGenerator;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Infolists\Components\Entry;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\Column;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jenishev\Filament\Forms\Components\DescriptionTextarea;
use Jenishev\Filament\Forms\Components\NameInput;

class AdminPanelProvider extends PanelProvider
{
    public array $bindings = [
        FilamentClusterClassGenerator::class => ClusterClassGenerator::class,
        FilamentResourceClassGenerator::class => ResourceClassGenerator::class,
        FilamentResourceCreateRecordPageClassGenerator::class => ResourceCreateRecordPageClassGenerator::class,
        FilamentResourceEditRecordPageClassGenerator::class => ResourceEditRecordPageClassGenerator::class,
        FilamentResourceListRecordsPageClassGenerator::class => ResourceListRecordsPageClassGenerator::class,
        FilamentResourceViewRecordPageClassGenerator::class => ResourceViewRecordPageClassGenerator::class,
    ];

    public function boot(): void
    {
        $this->configureActions();
        $this->configureFormInputs();
        $this->configurePlaceholder();
        $this->configureTable();
        $this->registerMacros();
    }

    protected function configureActions(): void
    {
        // defaults
        Action::configureUsing(function (Action $action) {
            $action
                ->iconSize(IconSize::Small)
                ->modalWidth(Width::ExtraLarge);
        });

        AssociateAction::configureUsing(function (AssociateAction $action) {
            $action->icon('fas-link');
        });

        DissociateAction::configureUsing(function (DissociateAction $action) {
            $action->icon('fas-link-slash');
        });

        AttachAction::configureUsing(function (AttachAction $action) {
            $action->icon('fas-paperclip');
        });

        DetachAction::configureUsing(function (DetachAction $action) {
            $action->icon('fas-xmark');
        });

        ExportAction::configureUsing(function (ExportAction $action) {
            $action
                ->label(__('Export to Excel'))
                ->color('gray')
                ->icon('fas-file-excel');
        });

        CreateAction::configureUsing(function (CreateAction $action) {
            $action
                ->icon('fas-plus')
                ->createAnother(false);
        });

        EditAction::configureUsing(function (EditAction $action) {
            $action->icon('fas-pen-to-square');
        });

        ViewAction::configureUsing(function (ViewAction $action) {
            $action->icon('fas-eye');
        });

        DeleteAction::configureUsing(function (DeleteAction $action) {
            $action->icon('fas-trash-can');
        });

        ForceDeleteAction::configureUsing(function (ForceDeleteAction $action) {
            $action->icon('fas-trash');
        });

        RestoreAction::configureUsing(function (RestoreAction $action) {
            $action->icon('fas-arrow-rotate-left');
        });
    }

    protected function configureFormInputs(): void
    {
        DescriptionTextarea::configureUsing(function (DescriptionTextarea $component) {
            $component->live(true);
            $component->rows(3);
            $component->maxLength(200);
            $component->hint(__('Maximum length is 200 characters.'));
            $component->afterStateUpdated(function (Set $set, $state) {
                $set('description', str($state ?? '')->trim()->value());
            });
        });

        NameInput::configureUsing(function (NameInput $component) {
            $component->afterStateUpdated(function (Set $set, $state) use ($component) {
                $set($component->getName(), str($state ?? '')->trim()->ucfirst()->value());
            });
        });

        SpatieMediaLibraryFileUpload::configureUsing(function (SpatieMediaLibraryFileUpload $component) {
            $component
                ->acceptedFileTypes([
                    'image/jpeg',
                    'image/png',
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ])
                ->maxSize(10240) // 10Mb
                ->multiple()
                ->maxFiles(5)
                ->minFiles(0)
                ->disk('local')
                ->downloadable()
                ->openable()
                ->deletable(false)
                ->previewable(false)
                ->reorderable(false);
        });
    }

    protected function configurePlaceholder(): void
    {
        $modifyUsing = function ($component) {
            /** @var Column|Entry $component */
            $component->placeholder('—');
        };

        Column::configureUsing($modifyUsing);
        Entry::configureUsing($modifyUsing);
    }

    protected function configureTable(): void
    {
        Table::configureUsing(function (Table $table) {
            $table
                ->filtersLayout(FiltersLayout::Modal)
                ->recordActions([
                    ViewAction::make()->iconButton(),
                    EditAction::make()->iconButton(),
                ])
                ->recordActionsAlignment('start');
        });
    }

    protected function registerMacros(): void
    {
        Table::macro('userstampColumns', function () {
            /** @var Table $this */ // @phpstan-ignore varTag.nativeType
            $modelClass = $this->getModel();
            $attribute = 'display_label';

            $columns = [
                UserstampColumn::make("creator.$attribute")
                    ->label(__('Created By')),
                UserstampColumn::make("editor.$attribute")
                    ->label(__('Updated By')),
            ];

            if (method_exists($modelClass, 'isSoftDeletable') && $modelClass::isSoftDeletable()) {
                $columns[] = UserstampColumn::make("destroyer.$attribute")
                    ->label(__('Deleted By'));
            }

            return $this->pushColumns($columns);
        });
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->passwordReset(RequestPasswordReset::class)
            ->emailChangeVerification()
            ->emailVerification()
            ->multiFactorAuthentication([
                EmailAuthentication::make(),
            ])
            ->strictAuthorization()
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->globalSearch(false)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('15rem')
            ->maxContentWidth('full')
            /** @link https://filamentphp.com/docs/5.x/resources/managing-relationships#read-only-mode */
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\Filament\Clusters')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->navigationGroups($this->getPanelNavigationGroups())
            ->pages($this->getPanelPages())
            ->widgets($this->getPanelWidgets())
            ->middleware($this->getPanelMiddlewares())
            ->authMiddleware($this->getPanelAuthMiddlewares())
            ->plugins($this->getPanelPlugins());
    }

    protected function getPanelNavigationGroups(): array
    {
        return [
            NavigationGroup::make(__('Administration'))
                ->icon('fas-gear'),
        ];
    }

    protected function getPanelPages(): array
    {
        return [
            Dashboard::class,
        ];
    }

    protected function getPanelWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }

    protected function getPanelPlugins(): array
    {
        return [
            FilamentShieldPlugin::make()
                ->navigationGroup(__('Administration')),
        ];
    }

    protected function getPanelMiddlewares(): array
    {
        return [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            PreventRequestForgery::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ];
    }

    protected function getPanelAuthMiddlewares(): array
    {
        return [
            Authenticate::class,
        ];
    }
}

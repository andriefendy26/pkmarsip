<?php

namespace App\Providers\Filament;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Caresome\FilamentNeobrutalism\NeobrutalismeTheme;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\ArchiveStatsOverview;
use App\Filament\Widgets\ArchiveStatsChart;
use App\Filament\Widgets\ArchiveCategoryChart;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// File Manager
use MWGuerra\FileManager\Filament\Pages\FileManager;
use MWGuerra\FileManager\Filament\Resources\FileSystemItemResource;
use MWGuerra\FileManager\FileManagerPlugin;
use Nette\Utils\FileSystem;
// use MWGuerra\FileManager\Filament\Resources\SchemaExample;
// use MWGuerra\FileManager\Filament\Pages\SchemaExample;

use App\Filament\Pages\Auth\Login;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->registration()
            ->colors([
                'primary' => Color::Amber,
            ]) 
            ->brandName("Archive Puskesmas Pantai Amal")
            ->brandLogo(asset('images/logo-puskesmas.png'))
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                // FilamentInfoWidget::class,
                ArchiveStatsOverview::class,
                ArchiveStatsChart::class,
                ArchiveCategoryChart::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                NeobrutalismeTheme::make(),
                FileManagerPlugin::make([
                        // FileManager::class,
                        // SchemaExample::class,    
                ])->fileManagerPageSidebar(false)

            ]) 
            ->topNavigation()
            ->navigationGroups([
                NavigationGroup::make('Arsip Dokumen')
                    ->icon('heroicon-o-archive-box')
                    ->collapsed(),
                NavigationGroup::make('Fisik')
                    ->icon('heroicon-o-archive-box')
                    ->collapsed(),
                NavigationGroup::make('User Management')
                    ->icon('heroicon-o-users')
                    ->collapsed(),
                NavigationGroup::make('Pengelolaan Dokumen')
                    ->icon('heroicon-o-archive-box')
                    ->collapsed(),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

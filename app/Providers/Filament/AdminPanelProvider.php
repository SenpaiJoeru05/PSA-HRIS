<?php

namespace App\Providers\Filament;

use App\Filament\Pages\CustomRegistration;
use App\Filament\Pages\Settings;
use App\Filament\Pages\Statistics;
use App\Filament\Widgets\EmployeeAgeDistributionWidget;
use App\Filament\Widgets\EmployeeGenderWidget;
use App\Filament\Widgets\EmployeeTenureWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('hris')
            ->login()
            ->registration(CustomRegistration::class)
            ->colors([
                'primary' => Color::Blue,
                'danger' => Color::Red,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
                'info' => Color::Teal,
                'gray' => Color::Slate
            ])
            ->collapsibleNavigationGroups(false)
            ->sidebarCollapsibleOnDesktop()
            ->brandLogo(asset('images\Black.png'))
            ->darkModeBrandLogo(asset('images\White.png'))
            ->brandLogoHeight('3.6rem')
            ->brandName('HRIS')
            ->favicon(asset('images\PSA-FAVCON.png'))
            ->font('Poppins')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                Statistics::class,
                
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,

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
            ])
            ->renderHook(
                'panels::body.end',
                fn () => view('customFooter')
            );
    }
}

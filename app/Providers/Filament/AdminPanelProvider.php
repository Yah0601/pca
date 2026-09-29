<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use App\Filament\Pages\Auth\Login;
use Filament\Navigation\NavigationGroup;
use Filament\Support\Icons\Heroicon;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Arr;
use Filament\Support\Enums\Width;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->globalSearch(false)
            ->path('secours-crm') // ← à changer selon ta réponse
            ->favicon(asset('images/favicon.ico'))
            ->brandName('CRM SECOURS')
            ->brandLogo(asset('images/crm-secours-logo.svg'))
            ->brandLogoHeight('48px')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(Login::class)
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => '
                    <link rel="icon" type="image/png" sizes="32x32" href="' . asset('images/favicon-32x32.png') . '">
                    <link rel="icon" type="image/png" sizes="16x16" href="' . asset('images/favicon-16x16.png') . '">
                    <link rel="apple-touch-icon" sizes="180x180" href="' . asset('images/apple-touch-icon.png') . '">
                '
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn () => Blade::render('
                    <footer class="fi-app-footer">
                        <p>© 2026 TCC Mali — CRM Secours</p>
                        <p>Application de continuité de service</p>
                    </footer>
                ')
            )
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Administrer')
                    ->icon(Heroicon::OutlinedWrenchScrewdriver)
                    ->extraTopbarAttributes([
                        'class' => 'crm-administrer',
                    ]),
            ])
            ->topNavigation()
            ->darkMode(false)
            ->homeUrl(fn () => \App\Filament\Pages\Accueil::getUrl())
            ->colors([
                'primary' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Models\Komponen;
use App\Models\PengajuanSparepart;
use App\Observers\KomponenObserver;
use App\Models\Sparepart;
use App\Models\StokMasuk;
use App\Observers\SparepartObserver;
use App\Observers\StokMasukObserver;
use App\Policies\PengajuanSparepartPolicy;
use App\Models\SuratJalan;
use App\Observers\SuratJalanObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Komponen::observe(KomponenObserver::class);
        Sparepart::observe(SparepartObserver::class);
        StokMasuk::observe(StokMasukObserver::class);
        SuratJalan::observe(SuratJalanObserver::class);
    }
}

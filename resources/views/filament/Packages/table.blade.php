
<x-filament-widgets::widgets :widgets="[
    \App\Filament\Admin\Resources\PackageResource\Widgets\ClientStats::class,
    \App\Filament\Admin\Resources\PackagesResource\Widgets\ClientsTable::class
]" :data="[
    'record' => $record
]" style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(1, minmax(0, 1fr));"/>

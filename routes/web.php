<?php

use App\Http\Controllers\Assets\AssetsController;
use App\Models\Asset;
use App\Models\Setting;
use App\View\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('admin/labels/create', function() {
    $settings = Setting::getSettings();

    $nextAssetTag    = Asset::autoincrement_asset();
    $nextAssetNumber = $settings->next_auto_tag_base;

    return view('create-labels', [
        'setting'         => $settings,
        'nextAssetTag'    => $nextAssetTag,
        'nextAssetNumber' => $nextAssetNumber,
    ]);
})->name('settings.labels.create');

Route::post('admin/labels/create', function(Request $request) {
    $request->validate([
        'count'    => ['required', 'integer', 'gte:1'],
        'start_at' => ['required', 'integer', 'gte:1'],
    ]);

    $settings = Setting::getSettings();


    if (empty($settings->label2_enable)) {
        throw ValidationException::withMessages([
            'settings' => 'The new label engine setting must be enabled',
        ]);
    }

    if (!in_array($settings->label2_2d_target, $targets = ['ht_tag', 'plain_asset_tag'])) {
        throw ValidationException::withMessages([
            'settings' => 'The 2d label target setting must be one of ' . implode(', ', $targets),
        ]);
    }


    $startAt = $request->integer('start_at');
    $count   = $request->integer('count');

    $assets = collect();

    for($i = $startAt; $i < $startAt + $count; $i++) {
        $assets->push(Asset::make([
            'asset_tag' => Asset::autoincrement_asset($i - $startAt),
        ]));
    }

    return (new Label)
        ->with('assets', $assets)
        ->with('settings', Setting::getSettings())
        ->with('bulkedit', true)
        ->with('count', 0);

})->name('settings.labels.create');

app()->booted(function() {

    Route::get('ht/{any?}', function(Request $request, $tag = null) {
        $response = (new AssetsController)->getAssetByTag($request, $tag);

        if ($response instanceof RedirectResponse && $response->getSession()->get('warning')) {
            // Go to the new page
            return redirect()->route('asset.quick-create');
        }

        return $response;
    }
    )->where('any', '.*')->name('ht/assetTag');

});

<?php

namespace App\Filament\Pages;

use App\Support\SettingsDefaults;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ImageSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Images';

    protected static ?string $title = 'Images';

    protected static ?int $navigationSort = 9;

    public static function group(): string
    {
        return 'images';
    }

    public static function defaultValues(): array
    {
        return SettingsDefaults::images();
    }

    protected function formSchema(): array
    {
        return [
            Section::make('Branding')
                ->description('Leave empty to use the built-in brand marks extracted from the original design.')
                ->columns(2)
                ->schema([
                    $this->upload('logo', 'Logo (blue on light)'),
                    $this->upload('hero_logo', 'Hero logo (white on blue)'),
                    $this->upload('og', 'Social share image (OG)'),
                ]),
        ];
    }

    private function upload(string $key, string $label): FileUpload
    {
        return FileUpload::make($key)
            ->label($label)
            ->image()
            ->disk('public')
            ->directory('images/uploads')
            ->visibility('public')
            ->helperText('Leave empty to use the built-in default.');
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Support\SiteContent;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

/**
 * Base for the singleton "settings group" pages. Each subclass declares its
 * group name, its default values (sourced from SettingsDefaults so the
 * dashboard starts pre-filled), and its form fields. Values are stored in the
 * settings table as group/key pairs and read back through SiteContent.
 */
abstract class SettingsPage extends Page
{
    protected string $view = 'filament.pages.settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    /** @var array<string, mixed> */
    public ?array $data = [];

    /** The settings `group` these fields belong to. */
    abstract public static function group(): string;

    /**
     * Default values keyed by setting key (used as fallbacks and for seeding).
     *
     * @return array<string, mixed>
     */
    abstract public static function defaultValues(): array;

    /**
     * Form components for this group.
     *
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    abstract protected function formSchema(): array;

    public function mount(): void
    {
        $group = static::group();

        $values = [];
        foreach (static::defaultValues() as $key => $default) {
            $values[$key] = setting("{$group}.{$key}", $default);
        }

        $this->form->fill($values);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->formSchema())
            ->statePath('data');
    }

    public function save(): void
    {
        $group = static::group();

        foreach ($this->form->getState() as $key => $value) {
            Setting::updateOrCreate(
                ['group' => $group, 'key' => $key],
                ['value' => $value],
            );
        }

        app(SiteContent::class)->flush();

        Notification::make()->title('Settings saved')->success()->send();
    }
}

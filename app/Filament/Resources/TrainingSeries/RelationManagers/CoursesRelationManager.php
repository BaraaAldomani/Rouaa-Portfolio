<?php

namespace App\Filament\Resources\TrainingSeries\RelationManagers;

use App\Models\Course;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static ?string $title = 'Courses';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('icon')->label('Icon (emoji)')->maxLength(8),
                Select::make('level')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                    ])
                    ->required()
                    ->native(false)
                    ->default('beginner'),
                TextInput::make('title_ar')->label('Title (Arabic)')->required(),
                TextInput::make('title_en')->label('Title (English)')->required(),
                Textarea::make('description_ar')->label('Description (Arabic)')->required()->rows(3),
                Textarea::make('description_en')->label('Description (English)')->required()->rows(3),
                TextInput::make('sort_order')->numeric()->default(0)->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_en')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('icon')->label('')->size('lg'),
                TextColumn::make('title_en')
                    ->label('Course')
                    ->description(fn (Course $record): string => $record->title_ar)
                    ->searchable(),
                TextColumn::make('level')->badge()->color(fn (string $state): string => match ($state) {
                    'beginner' => 'success',
                    'intermediate' => 'info',
                    'advanced' => 'gray',
                    default => 'gray',
                }),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

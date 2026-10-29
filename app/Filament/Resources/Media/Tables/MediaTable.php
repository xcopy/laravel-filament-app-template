<?php

namespace App\Filament\Resources\Media\Tables;

use App\Filament\Forms\Components\SpatieMediaLibraryFileUploads;
use App\Filament\RelationManagers\MediaRelationManager;
use App\Models\Contracts\HasMedia;
use App\Models\Media;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Jenishev\Filament\Tables\Columns\IdColumn;
use Jenishev\Filament\Tables\Columns\NameColumn;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;

class MediaTable
{
    public static function configure(Table $table): Table
    {
        /** @var MediaRelationManager $relationManager */
        $relationManager = $table->getLivewire();

        /** @var Model&HasMedia $ownerRecord */
        $ownerRecord = $relationManager->getOwnerRecord();

        return $table
            ->columns([
                IdColumn::make(),
                NameColumn::make()
                    ->limit()
                    ->tooltip(function (Media $record) {
                        $name = $record->name;

                        return str($name)->length() > 100 ? $name : null;
                    })
                    ->grow(),
                TextColumn::make('mime_type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn (Media $record) => sprintf('%s (%s)', str($record->extension)->upper(), str($record->mime_type)->limit(20)))
                    ->sortable(),
                TextColumn::make('size')
                    ->label(__('Size'))
                    ->formatStateUsing(fn (Media $record) => $record->human_readable_size)
                    ->sortable(),
                TextColumn::make('collection_name')
                    ->label(__('Collection'))
                    ->formatStateUsing(fn (Media $record) => __(str($record->collection_name)->headline()->value()))
                    ->sortable(),
            ])
            ->userstampColumns()
            ->timestampColumns()
            ->filters([
                SelectFilter::make('collection_name')
                    ->label(__('Collection'))
                    ->options(
                        $ownerRecord
                            ->getRegisteredMediaCollections()
                            ->mapWithKeys(function (MediaCollection $mediaCollection) {
                                $name = $mediaCollection->name;

                                return [$name => __(str($name)->headline()->value())];
                            })
                            ->all()
                    ),
            ])
            ->groups([
                Group::make('collection_name')
                    ->label(__('Collection'))
                    ->collapsible()
                    ->getTitleFromRecordUsing(fn (Media $record) => __(str($record->collection_name)->headline()->value())),
            ])
            ->headerActions([
                Action::make('upload')
                    ->label(__('Create'))
                    ->icon('fas-plus')
                    ->authorize('create')
                    ->modalHeading('') // empty string
                    ->schema(
                        collect(SpatieMediaLibraryFileUploads::make(get_class($ownerRecord)))
                            ->map(fn (SpatieMediaLibraryFileUpload $fileUpload) => $fileUpload
                                ->model($ownerRecord)
                                ->filterMediaUsing(fn () => Collection::make())
                            )
                            ->all()
                    )
                    ->successNotificationTitle(__('Upload successful'))
                    ->failureNotificationTitle(__('Upload failed')),
            ])
            ->recordActions([
                DeleteAction::make()->iconButton(),
            ])
            ->recordUrl(
                fn (Media $record) => $record->disk === 'public'
                    ? $record->getUrl()
                    : $record->getTemporaryUrl(),
                true
            );
    }
}

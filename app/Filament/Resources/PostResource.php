<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Imports\PostImporter;

class PostResource extends Resource
{
    use \App\Traits\HasNavigationBadge;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationIcon = 'heroicon-s-rocket-launch';

    protected static ?string $model = Post::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('views')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('views')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tombol untuk ekspor ke PDF per item
                Tables\Actions\Action::make('printItem')
                ->label('Print PDF')
                ->button()
                ->color('gray')
                ->icon('heroicon-o-printer')
                ->action(function (Post $record) {
                    $pdf = Pdf::loadView('pdf.print-post-item', [
                        'post' => $record,
                    ]);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->stream();
                    }, 'post-' . $record->id . '-' . now()->format('Y-m-d_H-i-s') . '.pdf');
                }),
                Tables\Actions\ActionGroup::make(
                    [
                        Tables\Actions\EditAction::make()
                            ->color('gray'),
                        Tables\Actions\DeleteAction::make(),
                    ]
                ),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                // Tombol untuk ekspor ke Excel
                Tables\Actions\ExportAction::make()
                    ->label('Export Excel')
                    ->fileDisk('public')
                    ->color('success')
                    ->icon('heroicon-o-document-text')
                    ->exporter(\App\Filament\Exports\PostExporter::class),

                // Tombol untuk ekspor ke CSV
                Tables\Actions\ExportAction::make('exportCsv')
                    ->label('Export CSV')
                    ->fileDisk('public')
                    ->color('warning')
                    ->icon('heroicon-o-document')
                    ->exporter(\App\Filament\Exports\PostExporter::class),

                // Tombol untuk ekspor ke PDF
                Tables\Actions\Action::make('print')
                    ->label('Export PDF')
                    ->button()
                    ->icon('heroicon-o-document-text')
                    ->color('danger')
                    ->action(function () {
                        $posts = Post::paginate(10); // Adjust the pagination as needed
                        // dd($posts); // Debugging purpose

                        $pdf = Pdf::loadView('pdf.print-post', [
                            'posts' => $posts,
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->stream();
                        }, 'posts-' . now()->format('Y-m-d_H-i-s') . '.pdf');
                    }),
                    Tables\Actions\ImportAction::make()
                        ->label('Import Post')
                        ->color('info')
                        ->button()
                        ->icon('heroicon-o-document-arrow-down')
                        ->importer(PostImporter::class),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePosts::route('/'),
        ];
    }
}

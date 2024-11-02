<?php

namespace App\Filament\Pages;

use App\Models\Absence;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\View\View;
use Livewire\Component;
class ReportAbsence extends Page
{

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'Report Absence';
    protected static ?string $navigationLabel = 'Report Absence';
    protected static string $view = 'filament.pages.report-absence';

}

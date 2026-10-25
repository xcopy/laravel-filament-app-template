<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Resource;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\User;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

// __('User')
// __('Users')
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = 'fas-users';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Administration');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'view' => ViewUser::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var User */
        $user = Auth::user();

        if (! $user->isSuperAdmin()) {
            $query->whereNot('email', config('filament.superadmin.email'));
        }

        return $query;
    }
}

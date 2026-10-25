<?php

namespace App\Filament\Clusters\AccessControl\Resources\Users;

use App\Filament\Clusters\AccessControl\AccessControlCluster;
use App\Filament\Clusters\AccessControl\Resources\Users\Pages\ListUsers;
use App\Filament\Clusters\AccessControl\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

// __('User')
// __('Users')
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = AccessControlCluster::class;

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

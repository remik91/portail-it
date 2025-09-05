@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Tableau de Bord</h1>

    <div class="row">
        <!-- Stat Card: Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['userCount'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card: Applications -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Applications</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['applicationCount'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rocket fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card: Categories -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Catégories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['categoryCount'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card: Entities -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Entités</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['entityCount'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sitemap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vous pouvez ajouter d'autres informations ici, comme les dernières applications ajoutées, etc. -->

    <style>
        .card.border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .card.border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .card.border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .card.border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .text-gray-300 {
            color: #dddfeb !important;
        }
    </style>
@endsection

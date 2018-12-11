@php
function buttonTypeByStatusCode($statusCode) : String {
	$buttonTypes = [
		'0' => 'danger',
		'1' => 'success',
		'2' => 'warning'
	];

	return isset($buttonTypes[$statusCode]) ? $buttonTypes[$statusCode] : 'dark';
}
@endphp

@extends('layouts.dashboard', ['pageTitle' => 'Dispositifs', 'pageCode' => 'device'])

@section('content')
	@forelse($devices as $device)
	<div class="border-bottom">
		<div class="alert alert-{{ buttonTypeByStatusCode($device->lastStatus->status_code) }} d-flex justify-content-between" role="alert">
			<div>
		       	<strong class="align-middle">{{ $device->device_name }} - {{ $device->lastStatus->status_name }}</strong>
		    </div>

		    <div class="btn-toolbar mb-2 mb-md-0">
				<button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#device-disabling">
					<span data-feather="power"></span>Désactiver
				</button>

			    <div class="dropdown">
			        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="vehicles-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span data-feather="truck"></span>{{ !empty($device->associatedVehicle) ? $device->associatedVehicle->vehicle_name : 'Associer un véhicule' }}
					</button>
					    
					<div class="dropdown-menu" aria-labelledby="vehicles-list">
						@forelse($vehicles as $vehicle)
						@empty
						<a class="dropdown-item" href="{{ route('dashboard-vehicle') }}">Aucun véhicule enregistré</a>
						@endforelse
						<a class="dropdown-item" href="{{ route('device-vehicle-association', ["device_id" => $device->device_id, "vehicle_id" => $vehicle->vehicle_id]) }}">{{ $vehicle->vehicle_name }}</a>
					</div>
			    </div>            
			</div>
		</div>
	</div>

	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">Ajouter un dispositif</button>
    </div>
	@empty
	Vous n'avez pas encore enregistré de dispositif.
	@endforelse
@endsection
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
				@if($device->lastStatus->status_code == "0")
					<button class="btn btn-sm btn-outline-secondary" data-target-id="device-enable-form-{{ $device->device_id }}"
							onclick="event.preventDefault(); document.getElementById(this.getAttribute('data-target-id')).submit();">
						<span data-feather="power"></span>Activer
					</button>

					<form id="device-enable-form-{{ $device->device_id }}" action="{{ route('device-enable', ['id' => $device->device_id]) }}" method="POST">
						@csrf
					</form>
				@elseif($device->lastStatus->status_code == "1")
					<button class="btn btn-sm btn-outline-secondary"  data-target-id="device-disable-form-{{ $device->device_id }}"
							onclick="event.preventDefault(); document.getElementById(this.getAttribute('data-target-id')).submit();">
						<span data-feather="power"></span>Désactiver
					</button>

					<form id="device-disable-form-{{ $device->device_id }}" action="{{ route('device-disable', ['id' => $device->device_id]) }}" method="POST">
						@csrf
					</form>
				@elseif($device->lastStatus->status_code == "2")
					<button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#device-disabling-activation-form-{{ $device->device_id }}-container">
						<span data-feather="power"></span>Valider la désactivation
					</button>

					<div class="modal fade" id="device-disabling-activation-form-{{ $device->device_id }}-container" tabindex="-1" role="dialog" aria-labelledby="device-disabling-activation-form-{{ $device->device_id }}-container-label" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="device-disabling-activation-form-{{ $device->device_id }}-container-label">Valider la désactivation</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="modal-body">
									<form id="device-disabling-activation-form-{{ $device->device_id }}" method="POST" action="{{ route('device-disabling', ['id' => $device->device_id]) }}">
										@csrf
										<div class="form-group row">
											<label for="code_code" class="col-sm-2 col-form-label">Code de désactivation*</label>
											<div class="col-sm-6">
												<input class="form-control" id="code_code" name="code_code" placeholder="Code à 5 caractères" minlength="5" maxlength="5">
											</div>
										</div>
									</form>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
									<button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('device-disabling-activation-form-{{ $device->device_id }}').submit()">Enregistrer</button>
								</div>
							</div>
						</div>
					</div>
				@endif

			    <div class="dropdown">
			        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="vehicles-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span data-feather="truck"></span>{{ !empty($device->associatedVehicle) ? $device->associatedVehicle->vehicle_name : 'Associer un véhicule' }}
					</button>
					    
					<div class="dropdown-menu" aria-labelledby="vehicles-list">
						@if(!empty($device->associatedVehicle))
							<a href="#" class="dropdown-item" data-target-id="dissociate-vehicle-{{ $device->device_id }}"
							   onclick="event.preventDefault(); document.getElementById(this.getAttribute('data-target-id')).submit()">Dissocier</a>

							<form id="dissociate-vehicle-{{ $device->device_id }}" action="#" method="POST">
								@csrf
							</form>

							<div class="dropdown-divider"></div>
						@endif

						@forelse($vehicles as $vehicle)
						@empty
						<a class="dropdown-item" href="{{ route('dashboard-vehicle') }}">Aucun véhicule enregistré</a>
						@else
						<a class="dropdown-item" href="#" data-target-id="associate-vehicle-form-{{ $vehicle->vehicle_id }}"
						   onclick="event.preventDefault(); document.getElementById(this.getAttribute('data-target-id')).submit()">{{ $vehicle->vehicle_name }}</a>

						<form id="associate-vehicle-form-{{ $vehicle->vehicle_id }}" method="POST" action="{{ route('device-vehicle-association', ["device_id" => $device->device_id, "vehicle_id" => $vehicle->vehicle_id]) }}">
							@csrf
						</form>
						@endforelse
					</div>
			    </div>            
			</div>
		</div>
	</div>
	@empty
	Vous n'avez pas encore enregistré de dispositif.
	@endforelse

	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
		<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#add-device-form-container">Ajouter un dispositif</button>
	</div>

	<div class="modal fade" id="add-device-form-container" tabindex="-1" role="dialog" aria-labelledby="add-device-form-container-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="add-device-form-container-label">Ajouter un dispositif</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<form id="add-device-form" method="POST" action="{{ route('device-add') }}">
						@csrf
						<div class="form-group row">
							<label for="device_serial_number_part_1" class="col-sm-2 col-form-label">Clef*</label>
							<div class="col-sm-10 d-flex">
								<input class="form-control col-sm-3" id="device_serial_number_part_1" name="device_serial_number_part_1" minlength="4" maxlength="4"><pre> </pre>
								<input class="form-control col-sm-3" id="device_serial_number_part_2" name="device_serial_number_part_2" minlength="4" maxlength="4"><pre> </pre>
								<input class="form-control col-sm-3" id="device_serial_number_part_3" name="device_serial_number_part_3" minlength="4" maxlength="4">
							</div>
						</div>
						<div class="form-group row">
							<label for="nom" class="col-sm-2 col-form-label">Nom*</label>
							<div class="col-sm-10">
								<input class="form-control" id="device_name" name="device_name" placeholder="Nom du dispositif" minlength="1" maxlength="50">
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('add-device-form').submit()">Enregistrer</button>
				</div>
			</div>
		</div>
	</div>
@endsection
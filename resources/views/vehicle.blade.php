@php
    function buttonTypeByStatusCode($statusCode) : String {
        $buttonTypes = [
            '3' => 'warning',
            '4' => 'danger',
            '5' => 'success'
        ];

        return isset($buttonTypes[$statusCode]) ? $buttonTypes[$statusCode] : 'dark';
    }
@endphp

@extends('layouts.dashboard', ['pageTitle' => 'Véhicules', 'pageCode' => 'vehicle'])

@section('content')
    {{--@if($errors->any())--}}
        {{--{{ dd($errors) }}--}}
    {{--@endif--}}
    <div class="border-bottom">
        @forelse($vehicles as $vehicle)
            <div class="alert alert-{{ buttonTypeByStatusCode($vehicle->lastStatus->status_code) }} d-flex justify-content-between" role="alert">
                <div>
                    <strong style="vertical-align: middle">{{ $vehicle->vehicle_name }}</strong>
                </div>

                <div class="btn-toolbar mb-2 mb-md-0">
                    @if($vehicle->lastStatus->status_code == '4')
                        <button class="btn btn-sm btn-outline-secondary">
                            <span data-feather="phone"></span>
                            Contacter autorités
                        </button>
                    @endif

                    <button class="btn btn-sm btn-outline-secondary">
                        <span data-feather="map-pin"></span>
                        Localiser
                    </button>

                    <button class="btn btn-sm btn-outline-secondary">
                        <span data-feather="edit"></span>
                        Modifier
                    </button>

                    <button class="btn btn-sm btn-danger">
                        <span data-feather="x"></span>
                    </button>
                </div>
            </div>
        @empty
            <p>
                Vous n'avez pas de véhicule enregistré.
            </p>
        @endforelse
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#add-vehicle-form-container">Ajouter un véhicule</button>
    </div>

    <div class="modal fade" id="add-vehicle-form-container" tabindex="-1" role="dialog" aria-labelledby="add-vehicle-form-container-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-vehicle-form-container-label">Enregistrer un véhicule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-vehicle-form" method="POST" action="{{ route('vehicle-add') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-2 col-form-label">Libelle<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input class="form-control" id="vehicle_name" name="vehicle_name" placeholder="Libelle" required>
                            </div>
                        </div>

                        @if($errors->has('vehicle_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('vehicle_name') }}</strong>
                            </span>
                        @endif

                        <div class="form-group row">
                            <label for="vehicle_brand" class="col-sm-2 col-form-label">Marque<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input class="form-control" id="vehicle_brand" name="vehicle_brand" placeholder="Marque" required>
                            </div>
                        </div>

                        @if($errors->has('vehicle_brand'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('vehicle_brand') }}</strong>
                            </span>
                        @endif

                        <div class="form-group row">
                            <label for="vehicle_model" class="col-sm-2 col-form-label">Modèle</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="vehicle_model" name="vehicle_model" placeholder="Modèle">
                            </div>
                        </div>

                        @if($errors->has('vehicle_model'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('vehicle_model') }}</strong>
                            </span>
                        @endif

                        <div class="form-group row">
                            <div>
                                <label class="col-sm-12 col-form-label" aria-describedby="vehicle_numberplate_description">Plaque d'immatriculation</label>

                                <div class="col-12">
                                    <small id="vehicle_numberplate_description">Renseigenr la plaque d'immatriculation du véhicule n'est pas obligatoire mais permet d'augmenter les chances de le retrouver en cas de vol.</small>
                                </div>
                            </div>

                            <div class="col-sm-10 d-flex">
                                <input class="form-control col-sm-2" id="vehicle_numberplate_part1" name="vehicle_numberplate_part1" placeholder="AB" min="2" max="2" onkeyup="if(this.value.length >= 2) {document.getElementById('vehicle_numberplate_part2').focus();} this.value = this.value.toUpperCase();"><pre> </pre>
                                <input class="form-control col-sm-3" id="vehicle_numberplate_part2" name="vehicle_numberplate_part2" placeholder="123" min="3" max="3" onkeyup="if(this.value.length >= 3) {document.getElementById('vehicle_numberplate_part3').focus();}"><pre> </pre>
                                <input class="form-control col-sm-2" id="vehicle_numberplate_part3" name="vehicle_numberplate_part3" placeholder="CD" min="2" max="2" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vehicle_type" class="col-sm-2 col-form-label">Type<span class="required">*</span></label>
                            <div class="col-sm-5">
                                <select class="form-control" id="vehicle_type" name="vehicle_type" required>
                                    <option value="Voiture" selected>Voiture</option>
                                    <option value="Scooter">Scooter</option>
                                    <option value="Moto">Moto</option>
                                    <option value="VTT">VTT</option>
                                    <option value="VTC">VTC</option>
                                    <option value="Vélo de ville">Vélo de ville</option>
                                    <option value="Camion">Camion</option>
                                </select>
                            </div>
                        </div>

                        @if($errors->has('vehicle_type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('vehicle_type') }}</strong>
                            </span>
                        @endif

                        <div class="form-group row">
                            <label for="vehicle_color" class="col-sm-2 col-form-label">Couleur<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input class="form-control" id="vehicle_color" name="vehicle_color" placeholder="Couleur" required>
                            </div>
                        </div>

                        @if($errors->has('vehicle_color'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('vehicle_color') }}</strong>
                            </span>
                        @endif

                        <input id="add-vehicle-form-submit-button" style="display: none;" type="submit">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary"
                            onclick="event.preventDefault(); document.getElementById('add-vehicle-form-submit-button').click();">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
@endsection